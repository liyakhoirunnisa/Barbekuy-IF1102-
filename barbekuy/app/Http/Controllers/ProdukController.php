<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage; // ⬅️ WAJIB: dipakai oleh cekStok()

class ProdukController extends Controller
{
    /**
     * Halaman produk admin
     */
    public function adminIndex()
    {
        $produk = DB::table('produk')->get();

        return view('admin.produk', compact('produk'));
    }

    /**
     * Halaman menu (user)
     */
    public function index()
    {
        $produk = DB::table('produk')->get();

        return view('menu', compact('produk'));
    }

    /**
     * Cek stok real dari DB (dipanggil oleh menu.blade.js)
     */
    public function cekStok(Request $request, string $id)
    {
        $data = $request->validate([
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_pengembalian' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
            'jumlah' => ['required', 'integer', 'min:1'],
        ]);

        $produk = Produk::find($id); // ⬅️ pastikan import model di atas
        if (! $produk) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan.'], 404);
        }

        // Versi dasar: stok_tersedia = stok di tabel produk
        // (kalau sudah ada tabel booking/pesanan, hitung sisa = stok - jumlah_terbooking_di_rentang)
        $stokTersedia = (int) ($produk->stok ?? 0);

        return response()->json([
            'success' => true,
            'stok' => (int) $produk->stok,
            'stok_tersedia' => $stokTersedia,
            'bisa_dipesan' => $stokTersedia >= (int) $data['jumlah'],
        ]);
    }

    /**
     * Tambah produk baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:100',
            'kategori' => 'required|string|max:50',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'required|string',
            'harga' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Generate ID baru (PR001, PR002, dst)
        $lastProduct = DB::table('produk')->orderBy('id_produk', 'desc')->first();
        $newNumber = $lastProduct ? intval(substr($lastProduct->id_produk, 2)) + 1 : 1;
        $newId = 'PR'.str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        // Upload gambar dengan nama file = id_produk
        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $fileName = $newId.'.'.$file->getClientOriginalExtension();
            $gambarPath = $file->storeAs('produk', $fileName, 'public');
        }

        // Konsistenkan status
        // Konsistenkan status
        $status = $request->stok > 0 ? 'tersedia' : 'tidak_tersedia';

        // Simpan ke database
        DB::table('produk')->insert([
            'id_produk' => $newId,
            'nama_produk' => $request->nama_produk,
            'kategori' => $request->kategori,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'gambar' => $gambarPath,
            'status_ketersediaan' => $status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:100',
            'kategori' => 'required|string|max:50',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'required|string',
            'harga' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $produk = DB::table('produk')->where('id_produk', $id)->first();
        if (! $produk) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        $gambarPath = $produk->gambar;
        if ($request->hasFile('gambar')) {
            if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
                Storage::disk('public')->delete($produk->gambar);
            }
            $file = $request->file('gambar');
            $fileName = $id.'.'.$file->getClientOriginalExtension();
            $gambarPath = $file->storeAs('produk', $fileName, 'public');
        }

        // Konsistenkan status
        // Konsistenkan status
        $status = $request->stok > 0 ? 'tersedia' : 'tidak_tersedia';

        DB::table('produk')->where('id_produk', $id)->update([
            'nama_produk' => $request->nama_produk,
            'kategori' => $request->kategori,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'gambar' => $gambarPath,
            'status_ketersediaan' => $status,
            'updated_at' => now(),
        ]);

        if ($request->ajax() || $request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Produk berhasil diperbarui']);
        }

        return redirect()->back()->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Hapus produk
     */
    public function destroy($id)
    {
        $produk = DB::table('produk')->where('id_produk', $id)->first();

        if (! $produk) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan.'], 404);
        }

        // Hapus gambar jika ada
        if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
            Storage::disk('public')->delete($produk->gambar);
        }

        // Hapus data dari database
        DB::table('produk')->where('id_produk', $id)->delete();

        return response()->json(['success' => true, 'message' => 'Produk berhasil dihapus.']);
    }
}
