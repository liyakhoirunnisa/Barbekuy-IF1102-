<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class KeranjangController extends Controller
{
    // 🛒 Tampilkan halaman keranjang
    public function index()
    {
        $keranjang = session()->get('keranjang', []);

        // 🧭 Urutkan berdasarkan waktu terbaru (created_at)
        uasort($keranjang, function ($a, $b) {
            return ($b['added_at'] ?? 0) <=> ($a['added_at'] ?? 0);
        });

        return view('keranjang', compact('keranjang'));
    }

    public function count()
    {
        $keranjang = session()->get('keranjang', []);
        $total = 0;
        foreach ($keranjang as $item) {
            $total += (int) ($item['jumlah'] ?? 1);
        }

        return response()->json([
            'success' => true,
            'count' => $total,
        ]);
    }

    // ➕ Tambah produk ke keranjang
    public function tambah(Request $request, $id)
    {
        $produk = Produk::where('id_produk', $id)->firstOrFail();

        // ambil session keranjang
        $keranjang = session()->get('keranjang', []);

        // buat key unik berdasarkan produk + tanggal sewa
        $tanggalMulai = $request->input('tanggal_mulai', now()->toDateString());
        $tanggalPengembalian = $request->input('tanggal_pengembalian', now()->toDateString());
        $key = $id.'_'.$tanggalMulai.'_'.$tanggalPengembalian;

        // jika sudah ada entri yang sama persis (produk + tanggal), tambahkan jumlah
        if (isset($keranjang[$key])) {
            $keranjang[$key]['jumlah'] += (int) $request->input('jumlah', 1);
        } else {
            // jika belum ada, tambahkan item baru
            $keranjang[$key] = [
                'produk_id' => $produk->id_produk,
                'tanggal_mulai' => $tanggalMulai,
                'tanggal_pengembalian' => $tanggalPengembalian,
                'jumlah' => (int) $request->input('jumlah', 1),
                'added_at' => now()->timestamp, // untuk urutan terbaru
            ];
        }

        session()->put('keranjang', $keranjang);
        $total = 0;
        foreach ($keranjang as $row) {
            $total += (int) ($row['jumlah'] ?? 1);
        }

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang.',
            'count' => $total, // <— penting untuk update badge
        ]);
    }

    // ✏️ Ubah jumlah atau tanggal sewa produk — dipanggil tombol +/− & Simpan
    public function ubah(Request $request, $id)
    {
        $data = $request->json()->all() ?: $request->all();

        $tanggalMulai = $data['tanggal_mulai'] ?? now()->toDateString();
        $tanggalPengembalian = $data['tanggal_pengembalian'] ?? now()->toDateString();

        $oldKey = $data['key'] ?? null;                    // ⬅️ key lama dari client
        $newKey = $id.'_'.$tanggalMulai.'_'.$tanggalPengembalian;

        $keranjang = session()->get('keranjang', []);

        // 1) Temukan item di key lama; kalau tidak ada, fallback cari di key baru
        if ($oldKey && isset($keranjang[$oldKey])) {
            $row = $keranjang[$oldKey];
        } elseif (isset($keranjang[$newKey])) {
            $row = $keranjang[$newKey];
            $oldKey = $newKey; // supaya variabel konsisten
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan di keranjang.',
            ]);
        }

        // 2) Update field
        $row['tanggal_mulai'] = $tanggalMulai;
        $row['tanggal_pengembalian'] = $tanggalPengembalian;

        if (isset($data['jumlah'])) {
            $row['jumlah'] = max(1, (int) $data['jumlah']);
        }

        // 3) Jika key berubah (tanggal berubah) → migrasi entry
        $newKeyCreated = null;
        if ($oldKey !== $newKey) {
            $keranjang[$newKey] = $row;
            unset($keranjang[$oldKey]);
            $newKeyCreated = $newKey;                      // ⬅️ akan dikirim ke client
        } else {
            $keranjang[$oldKey] = $row;
        }

        session()->put('keranjang', $keranjang);

        $produk = \App\Models\Produk::where('id_produk', $id)->firstOrFail();
        $subtotal = (int) $produk->harga * (int) $row['jumlah'];

        return response()->json([
            'success' => true,
            'subtotal' => number_format($subtotal, 0, ',', '.'),
            'jumlah' => $row['jumlah'],
            'new_key' => $newKeyCreated,                // ⬅️ null kalau tidak berubah
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
        foreach ($keranjang as $row) {
            $total += (int) ($row['jumlah'] ?? 1);
        }

        return response()->json([
            'success' => true,
            'message' => 'Produk dihapus dari keranjang.',
            'count' => $total,
            'removed_keys' => [$key],
        ]);
    }

    // ❌❌ Hapus banyak produk (selected) by keys
    public function hapusBanyak(Request $request)
    {
        $keys = $request->input('keys', []); // array of composite keys
        if (! is_array($keys)) {
            $keys = [];
        }

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
        foreach ($keranjang as $row) {
            $total += (int) ($row['jumlah'] ?? 1);
        }

        return response()->json([
            'success' => true,
            'message' => 'Produk terpilih dihapus dari keranjang.',
            'count' => $total,
            'removed_keys' => $removed,
        ]);
    }
}
