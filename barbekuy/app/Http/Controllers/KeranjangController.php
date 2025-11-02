<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Produk;
use Carbon\Carbon;

class KeranjangController extends Controller
{
    // 🛒 Tampilkan halaman keranjang + search ?q=
    public function index(Request $request)
    {
        $q = trim($request->query('q', '')); // ambil kata kunci dari navbar
        $keranjang = session()->get('keranjang', []);

        if (!is_array($keranjang)) $keranjang = [];

        // 🔎 Filter kalau ada q (cari di nama/kategori — sesuaikan key sesuai struktur item di session)
        if ($q !== '') {
            $qLower = mb_strtolower($q);
            $keranjang = array_values(array_filter($keranjang, function ($row) use ($qLower) {
                $nama     = mb_strtolower((string)($row['nama_produk'] ?? $row['nama'] ?? $row['title'] ?? ''));
                $kategori = mb_strtolower((string)($row['kategori'] ?? ''));
                return str_contains($nama, $qLower) || str_contains($kategori, $qLower);
            }));
        }

        // 🧭 Urutkan berdasarkan waktu terbaru (added_at)
        uasort($keranjang, function ($a, $b) {
            return ($b['added_at'] ?? 0) <=> ($a['added_at'] ?? 0);
        });

        // (opsional) total ringkas buat ditampilkan
        $totalItem = 0; $totalHarga = 0;
        foreach ($keranjang as $row) {
            $j = (int)($row['jumlah'] ?? 1);
            $h = (int)($row['harga'] ?? 0);
            $totalItem  += $j;
            $totalHarga += $j * $h;
        }

        // kirim juga $q agar bisa tampil "Hasil untuk ..."
        return view('keranjang', compact('keranjang', 'q', 'totalItem', 'totalHarga'));
    }

    public function count()
    {
        $keranjang = session()->get('keranjang', []);
        $total = 0;
        foreach ($keranjang as $item) {
            $total += (int)($item['jumlah'] ?? 1);
        }
        return response()->json([
            'success' => true,
            'count'   => $total,
        ]);
    }

    // ➕ Tambah produk ke keranjang
    public function tambah(Request $request, $id)
    {
        $produk = Produk::where('id_produk', $id)->firstOrFail();

        // ambil session keranjang
        $keranjang = session()->get('keranjang', []);

        // buat key unik berdasarkan produk + tanggal sewa
        $tanggalMulai        = $request->input('tanggal_mulai', now()->toDateString());
        $tanggalPengembalian = $request->input('tanggal_pengembalian', now()->toDateString());
        $key = $id . '_' . $tanggalMulai . '_' . $tanggalPengembalian;

        // jika sudah ada entri yang sama persis (produk + tanggal), tambahkan jumlah
        if (isset($keranjang[$key])) {
            $keranjang[$key]['jumlah'] = (int)($keranjang[$key]['jumlah'] ?? 0) + (int)$request->input('jumlah', 1);
        } else {
            // jika belum ada, tambahkan item baru
            $keranjang[$key] = [
                'produk_id'            => $produk->id_produk,
                'nama_produk'          => $produk->nama_produk ?? ($produk->nama ?? null), // opsional: simpan nama utk search di keranjang
                'kategori'             => $produk->kategori ?? null,                         // opsional: simpan kategori utk search
                'harga'                => (int)($produk->harga ?? 0),                        // opsional: simpan harga utk ringkasan
                'tanggal_mulai'        => $tanggalMulai,
                'tanggal_pengembalian' => $tanggalPengembalian,
                'jumlah'               => (int)$request->input('jumlah', 1),
                'added_at'             => now()->timestamp, // untuk urutan terbaru
            ];
        }

        session()->put('keranjang', $keranjang);
        $total = 0;
        foreach ($keranjang as $row) $total += (int)($row['jumlah'] ?? 1);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang.',
            'count'   => $total, // <— penting untuk update badge
        ]);
    }

    // ✏️ Ubah jumlah atau tanggal sewa produk — dipanggil tombol +/− & Simpan
    public function ubah(Request $request, $id)
    {
        $data = $request->json()->all() ?: $request->all();
        $tanggalMulai        = $data['tanggal_mulai']        ?? now()->toDateString();
        $tanggalPengembalian = $data['tanggal_pengembalian'] ?? now()->toDateString();
        $key = $id . '_' . $tanggalMulai . '_' . $tanggalPengembalian;

        $keranjang = session()->get('keranjang', []);

        if (!isset($keranjang[$key])) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan di keranjang.',
            ]);
        }

        // Update jumlah
        if (isset($data['jumlah'])) {
            $keranjang[$key]['jumlah'] = max(1, (int)$data['jumlah']);
        }

        session()->put('keranjang', $keranjang);

        $produk = Produk::where('id_produk', $id)->firstOrFail();
        $hargaUnit = (int)($produk->harga ?? ($keranjang[$key]['harga'] ?? 0));
        $subtotal = $hargaUnit * (int)$keranjang[$key]['jumlah'];

        return response()->json([
            'success'  => true,
            'subtotal' => number_format($subtotal, 0, ',', '.'),
            'jumlah'   => $keranjang[$key]['jumlah'],
        ]);
    }

    // ❌ Hapus produk (BY KEY, bukan by produk_id)
    public function hapusByKey($key)
    {
        $keranjang = session()->get('keranjang', []);
        if (isset($keranjang[$key])) {
            unset($keranjang[$key]);
            session()->put('keranjang', $keranjang);
        }

        // hitung ulang total badge
        $total = 0;
        foreach ($keranjang as $row) $total += (int)($row['jumlah'] ?? 1);

        return response()->json([
            'success'      => true,
            'message'      => 'Produk dihapus dari keranjang.',
            'count'        => $total,
            'removed_keys' => [$key],
        ]);
    }

    // ❌❌ Hapus banyak produk (selected) by keys
    public function hapusBanyak(Request $request)
    {
        $keys = $request->input('keys', []); // array of composite keys
        if (!is_array($keys)) $keys = [];

        $keranjang = session()->get('keranjang', []);

        $removed = [];
        foreach ($keys as $k) {
            if (isset($keranjang[$k])) {
                unset($keranjang[$k]);
                $removed[] = $k;
            }
        }

        session()->put('keranjang', $keranjang);

        // hitung ulang total badge
        $total = 0;
        foreach ($keranjang as $row) $total += (int)($row['jumlah'] ?? 1);

        return response()->json([
            'success'      => true,
            'message'      => 'Produk terpilih dihapus dari keranjang.',
            'count'        => $total,
            'removed_keys' => $removed,
        ]);
    }
}
