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
        // Pastikan bisa parsing JSON body
        $data = $request->json()->all() ?: $request->all();

        $produk    = Produk::where('id_produk', $id)->firstOrFail();
        $keranjang = session()->get('keranjang', []);

        $foundIndex = null;
        foreach ($keranjang as $i => $item) {
            if ((int)$item['produk_id'] === (int)$id) { 
                $foundIndex = $i; 
                break; 
            }
        }

        if ($foundIndex === null) {
            $keranjang[] = [
                'produk_id'       => (int)$id,
                'jumlah'          => 1,
                'tanggal_mulai'   => Carbon::now()->toDateString(),
                'tanggal_selesai' => Carbon::now()->toDateString(),
            ];
            $foundIndex = array_key_last($keranjang);
        }

        // 🔧 ambil dari $data, bukan langsung $request
        if (isset($data['jumlah'])) {
            $keranjang[$foundIndex]['jumlah'] = max(1, (int)$data['jumlah']);
        }

        if (!empty($data['tanggal_mulai'])) {
            $keranjang[$foundIndex]['tanggal_mulai'] = $data['tanggal_mulai'];
        }

        if (!empty($data['tanggal_selesai'])) {
            $keranjang[$foundIndex]['tanggal_selesai'] = $data['tanggal_selesai'];
        }

        session()->put('keranjang', $keranjang);

        $jumlah   = (int)$keranjang[$foundIndex]['jumlah'];
        $subtotal = (int)$produk->harga * $jumlah;

        return response()->json([
            'berhasil' => true,
            'subtotal' => $subtotal,
            'jumlah'   => $jumlah,
            'item'     => $keranjang[$foundIndex],
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
