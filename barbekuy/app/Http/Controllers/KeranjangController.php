<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Produk;
use Carbon\Carbon;

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
        $tanggalMulai   = $request->input('tanggal_mulai', now()->toDateString());
        $tanggalSelesai = $request->input('tanggal_selesai', now()->toDateString());
        $key = $id . '_' . $tanggalMulai . '_' . $tanggalSelesai;

        // jika sudah ada entri yang sama persis (produk + tanggal), tambahkan jumlah
        if (isset($keranjang[$key])) {
            $keranjang[$key]['jumlah'] += (int)$request->input('jumlah', 1);
        } else {
            // jika belum ada, tambahkan item baru
            $keranjang[$key] = [
                'produk_id'       => $produk->id_produk,
                'tanggal_mulai'   => $tanggalMulai,
                'tanggal_selesai' => $tanggalSelesai,
                'jumlah'          => (int)$request->input('jumlah', 1),
                'added_at'        => now()->timestamp, // untuk urutan terbaru
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
        $tanggalMulai   = $data['tanggal_mulai'] ?? now()->toDateString();
        $tanggalSelesai = $data['tanggal_selesai'] ?? now()->toDateString();
        $key = $id . '_' . $tanggalMulai . '_' . $tanggalSelesai;

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

        $produk = \App\Models\Produk::where('id_produk', $id)->firstOrFail();
        $subtotal = (int)$produk->harga * (int)$keranjang[$key]['jumlah'];

        return response()->json([
            'success' => true,
            'subtotal' => number_format($subtotal, 0, ',', '.'),
            'jumlah' => $keranjang[$key]['jumlah'],
        ]);
    }

    // ❌ Hapus produk dari keranjang
    public function hapus($id)
    {
        $keranjang = session()->get('keranjang', []);

        foreach ($keranjang as $k => $item) {
            if ((int)($item['produk_id'] ?? 0) === (int)$id) {
                unset($keranjang[$k]); // jaga key asosiatif tetap konsisten
            }
        }

        session()->put('keranjang', $keranjang);

        // hitung ulang total
        $total = 0;
        foreach ($keranjang as $row) $total += (int)($row['jumlah'] ?? 1);

        return response()->json([
            'success' => true,
            'message' => 'Produk dihapus dari keranjang.',
            'count'   => $total, // opsional, biar badge langsung update
        ]);
    }
}
