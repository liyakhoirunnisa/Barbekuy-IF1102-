<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Support\Facades\Log;
use Carbon\Carbon; 

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
            'tanggal_mulai'         => ['required', 'date'],
            'tanggal_pengembalian'  => ['required', 'date', 'after_or_equal:tanggal_mulai'],
            'jumlah'                => ['required', 'integer', 'min:1'],
        ]);

        $produk = Produk::find($id);
        if (! $produk) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan.',
            ], 404);
        }

        // Normalisasi tanggal ke format Y-m-d
        $mulaiSql   = Carbon::parse($data['tanggal_mulai'])->format('Y-m-d');
        $selesaiSql = Carbon::parse($data['tanggal_pengembalian'])->format('Y-m-d');

        // ============================
        // HITUNG JUMLAH YANG SUDAH DIPESAN DI RENTANG TANGGAL
        // (hanya dari tabel pemesanan, BUKAN dari keranjang)
        // ============================
        $dipakai = DB::table('detail_pemesanan')
            ->join('pemesanan', 'detail_pemesanan.id_pesanan', '=', 'pemesanan.id_pesanan')
            ->where('detail_pemesanan.id_produk', $id)
            ->whereIn('pemesanan.status_pesanan', [
                'Belum Bayar',
                'Menunggu Konfirmasi',
                'Diproses',
                'Disewa',
            ])
            ->where(function ($q) use ($mulaiSql, $selesaiSql) {
                // overlap tanggal sewa
                $q->whereBetween('pemesanan.tanggal_sewa', [$mulaiSql, $selesaiSql])
                    ->orWhereBetween('pemesanan.tanggal_pengembalian', [$mulaiSql, $selesaiSql])
                    ->orWhere(function ($qq) use ($mulaiSql, $selesaiSql) {
                        $qq->where('pemesanan.tanggal_sewa', '<=', $mulaiSql)
                            ->where('pemesanan.tanggal_pengembalian', '>=', $selesaiSql);
                    });
            })
            ->sum('detail_pemesanan.jumlah_sewa');

        $stokTotal   = (int) ($produk->stok ?? 0);
        $stokSisa    = max(0, $stokTotal - (int) $dipakai);
        $diminta     = (int) $data['jumlah'];
        $bisaDipesan = $stokSisa >= $diminta;

        return response()->json([
            'success'        => true,
            'stok_total'     => $stokTotal,
            'dipakai'        => (int) $dipakai,
            'stok_tersedia'  => $stokSisa,
            'bisa_dipesan'   => $bisaDipesan,
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

    public function search(Request $request)
    {
        $q = trim($request->input('q', ''));

        // Kalau kotak search kosong, balik ke halaman menu biasa
        if ($q === '') {
            return redirect()->route('menu');
        }

        // Cari berdasarkan nama, kategori, atau deskripsi
        $produk = DB::table('produk')
            ->where(function ($query) use ($q) {
                $query->where('nama_produk', 'like', "%{$q}%")
                    ->orWhere('kategori', 'like', "%{$q}%")
                    ->orWhere('deskripsi', 'like', "%{$q}%");
            })
            ->get();

        // Kirim hasil + keyword ke view 'menu'
        return view('menu', [
            'produk' => $produk,
            'search' => $q,
        ]);
    }

    public function cekKetersediaanTanggal($id, Request $request)
    {
        $mulaiRaw   = $request->query('mulai');
        $selesaiRaw = $request->query('selesai');

        try {
            // === Normalisasi format tanggal ke Y-m-d ===
            $mulai = $this->parseTanggal($mulaiRaw);
            $selesai = $this->parseTanggal($selesaiRaw);

            if (! $mulai || ! $selesai) {
                return response()->json([
                    'success' => false,
                    'message' => 'Format tanggal tidak valid.',
                ]);
            }

            $mulaiSql   = $mulai->format('Y-m-d');
            $selesaiSql = $selesai->format('Y-m-d');

            if ($mulaiSql > $selesaiSql) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tanggal mulai tidak boleh lebih besar dari tanggal selesai.',
                ]);
            }

            // Ambil produk
            $produk = DB::table('produk')->where('id_produk', $id)->first();
            if (! $produk) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produk tidak ditemukan.',
                ]);
            }

            // Hitung jumlah unit yang dipakai
            $dipakai = DB::table('detail_pemesanan')
                ->join('pemesanan', 'detail_pemesanan.id_pesanan', '=', 'pemesanan.id_pesanan')
                // ⬆️ kalau di tabelmu nama kolomnya "id_pemesanan", ganti di sini
                ->where('detail_pemesanan.id_produk', $id)
                ->whereIn('pemesanan.status_pesanan', [
                    'Belum Bayar',
                    'Diproses',
                    'Disewa',
                    'Menunggu Konfirmasi',
                ])
                ->where(function ($q) use ($mulaiSql, $selesaiSql) {
                    $q->whereBetween('pemesanan.tanggal_sewa', [$mulaiSql, $selesaiSql])
                        ->orWhereBetween('pemesanan.tanggal_pengembalian', [$mulaiSql, $selesaiSql])
                        ->orWhere(function ($qq) use ($mulaiSql, $selesaiSql) {
                            $qq->where('pemesanan.tanggal_sewa', '<=', $mulaiSql)
                                ->where('pemesanan.tanggal_pengembalian', '>=', $selesaiSql);
                        });
                })
                ->sum('detail_pemesanan.jumlah_sewa');

            $stokTotal = (int) ($produk->stok ?? 0);
            $stokSisa  = max(0, $stokTotal - (int) $dipakai);

            return response()->json([
                'success'    => true,
                'stok_total' => $stokTotal,
                'dipakai'    => (int) $dipakai,
                'stok_sisa'  => $stokSisa,
            ]);
        } catch (\Throwable $e) {
            Log::error('Error cekKetersediaanTanggal', [
                'id_produk' => $id,
                'mulai'     => $mulaiRaw,
                'selesai'   => $selesaiRaw,
                'error'     => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat membaca data stok.',
            ]);
        }
    }

    private function parseTanggal(?string $tanggal): ?Carbon
    {
        if (! $tanggal) {
            return null;
        }

        // Coba format Y-m-d (standar HTML date input)
        try {
            return Carbon::createFromFormat('Y-m-d', $tanggal);
        } catch (\Exception $e) {
        }

        // Coba format d/m/Y (seperti di screenshot)
        try {
            return Carbon::createFromFormat('d/m/Y', $tanggal);
        } catch (\Exception $e) {
        }

        return null;
    }
}
