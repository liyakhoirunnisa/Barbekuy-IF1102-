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
        return view('keranjang', compact('keranjang'));
    }

    public function count()
    {
        $keranjang = session()->get('keranjang', []);
        $total = count($keranjang);
        return response()->json(['count' => $total]);
    }

    // ➕ Tambah produk ke keranjang
    public function tambah(Request $request, $id)
    {
        $produk = Produk::where('id_produk', $id)->firstOrFail();

        // ambil session keranjang
        $keranjang = session()->get('keranjang', []);

        // jadikan key-nya id produk
        if (isset($keranjang[$id])) {
            $keranjang[$id]['jumlah'] += (int)$request->input('jumlah', 1);
        } else {
            $keranjang[$id] = [
                'produk_id'       => $produk->id_produk,
                'tanggal_mulai'   => $request->input('tanggal_mulai', now()->toDateString()),
                'tanggal_selesai' => $request->input('tanggal_selesai', now()->toDateString()),
                'jumlah'          => (int)$request->input('jumlah', 1),
            ];
        }

        session()->put('keranjang', $keranjang);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang.',
        ]);
    }

    // ✏️ Ubah jumlah atau tanggal sewa produk — dipanggil tombol +/− & Simpan
    public function ubah(Request $request, $id)
    {
        $data = $request->json()->all() ?: $request->all();

        $produk = \App\Models\Produk::where('id_produk', $id)->firstOrFail();
        $keranjang = session()->get('keranjang', []);

        if (!isset($keranjang[$id])) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan di keranjang.',
            ]);
        }

        // Update jumlah (pastikan minimal 1)
        if (isset($data['jumlah'])) {
            $keranjang[$id]['jumlah'] = max(1, (int)$data['jumlah']);
        }

        // Update tanggal kalau dikirim
        if (!empty($data['tanggal_mulai'])) {
            $keranjang[$id]['tanggal_mulai'] = $data['tanggal_mulai'];
        }
        if (!empty($data['tanggal_selesai'])) {
            $keranjang[$id]['tanggal_selesai'] = $data['tanggal_selesai'];
        }

        session()->put('keranjang', $keranjang);

        $subtotal = (int)$produk->harga * (int)$keranjang[$id]['jumlah'];

        return response()->json([
            'success' => true,
            'subtotal' => number_format($subtotal, 0, ',', '.'),
            'jumlah' => $keranjang[$id]['jumlah'],
        ]);
    }

    // ❌ Hapus produk dari keranjang
    public function hapus($id)
    {
        $keranjang = session()->get('keranjang', []);

        $baru = array_values(array_filter($keranjang, fn($item) => (int)$item['produk_id'] !== (int)$id));

        session()->put('keranjang', $baru);

        return response()->json([
            'success' => true,              // konsisten dengan frontend
            'message'    => 'Produk dihapus dari keranjang.',
        ]);
    }
}
