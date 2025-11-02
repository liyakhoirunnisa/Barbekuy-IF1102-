<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Produk;

class ProdukController extends Controller
{
    /**
     * Halaman produk admin
     */
    public function adminIndex()
    {
        // admin tabel biasanya enak kalau paginate
        $produk = DB::table('produk')->orderBy('nama_produk')->paginate(15);
        return view('admin.produk', compact('produk'));
    }

    /**
     * Halaman menu (user) + search ?q=
     */
    public function index(Request $request)
    {
        $q = trim($request->query('q', ''));

        $produk = DB::table('produk')
            ->when($q !== '', function ($qr) use ($q) {
                $qr->where(function ($w) use ($q) {
                    $w->where('nama_produk', 'like', "%{$q}%")
                      ->orWhere('kategori', 'like', "%{$q}%")
                      ->orWhere('deskripsi', 'like', "%{$q}%");
                });
            })
            ->orderBy('nama_produk')
            ->paginate(12)
            ->appends(['q' => $q]);

        return view('menu', ['produk' => $produk, 'q' => $q]);
    }

    /**
     * Cek stok real dari DB (dipanggil oleh menu)
     * Route: POST /produk/{id}/stok-tersedia  (id = id_produk seperti PR001)
     */
    public function cekStok(Request $request, string $id)
    {
        $data = $request->validate([
            'tanggal_mulai'        => ['required', 'date'],
            'tanggal_pengembalian' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
            'jumlah'               => ['required', 'integer', 'min:1'],
        ]);

        // Aman untuk dua skenario: model sudah/ belum di-set primaryKey-nya
        $produk = Produk::where('id_produk', $id)->first() ?: Produk::find($id);
        if (!$produk) {
            // fallback murni query builder jika model belum beres
            $produk = DB::table('produk')->where('id_produk', $id)->first();
        }
        if (!$produk) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan.'], 404);
        }

        $stok = (int) (is_array($produk) ? $produk['stok'] ?? 0 : $produk->stok ?? 0);
        $stokTersedia = $stok; // TODO: kurangi stok terbooking jika sudah ada tabel booking

        return response()->json([
            'success'       => true,
            'stok'          => $stok,
            'stok_tersedia' => $stokTersedia,
            'bisa_dipesan'  => $stokTersedia >= (int)$data['jumlah'],
        ]);
    }

    /**
     * Tambah produk baru (ADMIN)
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:100',
            'kategori'    => 'required|string|max:50',
            'stok'        => 'required|integer|min:0',
            'deskripsi'   => 'required|string',
            'harga'       => 'required|integer|min:0',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        DB::beginTransaction();
        try {
            // Generate ID baru aman (PR001, PR002, ...)
            $num = (int) DB::table('produk')
                ->select(DB::raw("MAX(CAST(SUBSTRING(id_produk, 3) AS UNSIGNED)) as maxnum"))
                ->value('maxnum');
            $num++;

            // pastikan unik
            do {
                $newId = 'PR' . str_pad($num, 3, '0', STR_PAD_LEFT);
                $exists = DB::table('produk')->where('id_produk', $newId)->exists();
                if ($exists) $num++;
            } while ($exists);

            // Upload gambar dengan nama file = id_produk
            $gambarPath = null;
            if ($request->hasFile('gambar')) {
                $ext = $request->file('gambar')->getClientOriginalExtension();
                $fileName = $newId . '.' . $ext;
                $gambarPath = $request->file('gambar')->storeAs('produk', $fileName, 'public');
            }

            // status
            $status = $request->integer('stok') > 0 ? 'tersedia' : 'habis';

            DB::table('produk')->insert([
                'id_produk'           => $newId,
                'nama_produk'         => $request->nama_produk,
                'kategori'            => $request->kategori,
                'stok'                => $request->integer('stok'),
                'deskripsi'           => $request->deskripsi,
                'harga'               => $request->integer('harga'),
                'gambar'              => $gambarPath,
                'status_ketersediaan' => $status,
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');
        } catch (\Throwable $e) {
            DB::rollBack();
            // bersihkan file kalau sudah sempat terupload (jarang terjadi karena storeAs setelah ID fix)
            if (!empty($gambarPath) && Storage::disk('public')->exists($gambarPath)) {
                Storage::disk('public')->delete($gambarPath);
            }
            return redirect()->back()->with('error', 'Gagal menambah produk: ' . $e->getMessage());
        }
    }

    /**
     * Update produk (ADMIN)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:100',
            'kategori'    => 'required|string|max:50',
            'stok'        => 'required|integer|min:0',
            'deskripsi'   => 'required|string',
            'harga'       => 'required|integer|min:0',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        DB::beginTransaction();
        try {
            $produk = DB::table('produk')->where('id_produk', $id)->first();
            if (!$produk) {
                DB::rollBack();
                return $request->ajax() || $request->expectsJson()
                    ? response()->json(['success' => false, 'message' => 'Produk tidak ditemukan.'], 404)
                    : redirect()->back()->with('error', 'Produk tidak ditemukan.');
            }

            $gambarPath = $produk->gambar;
            if ($request->hasFile('gambar')) {
                // hapus lama
                if ($gambarPath && Storage::disk('public')->exists($gambarPath)) {
                    Storage::disk('public')->delete($gambarPath);
                }
                // simpan baru
                $ext = $request->file('gambar')->getClientOriginalExtension();
                $fileName = $id . '.' . $ext;
                $gambarPath = $request->file('gambar')->storeAs('produk', $fileName, 'public');
            }

            $status = $request->integer('stok') > 0 ? 'tersedia' : 'habis';

            DB::table('produk')->where('id_produk', $id)->update([
                'nama_produk'         => $request->nama_produk,
                'kategori'            => $request->kategori,
                'stok'                => $request->integer('stok'),
                'deskripsi'           => $request->deskripsi,
                'harga'               => $request->integer('harga'),
                'gambar'              => $gambarPath,
                'status_ketersediaan' => $status,
                'updated_at'          => now(),
            ]);

            DB::commit();

            if ($request->ajax() || $request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Produk berhasil diperbarui']);
            }
            return redirect()->back()->with('success', 'Produk berhasil diperbarui!');
        } catch (\Throwable $e) {
            DB::rollBack();
            return $request->ajax() || $request->expectsJson()
                ? response()->json(['success' => false, 'message' => 'Gagal update: '.$e->getMessage()], 500)
                : redirect()->back()->with('error', 'Gagal update: '.$e->getMessage());
        }
    }

    /**
     * Hapus produk (ADMIN)
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $produk = DB::table('produk')->where('id_produk', $id)->first();
            if (!$produk) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan.'], 404);
            }

            if ($produk->gambar && Storage::disk('public')->exists($produk->gambar)) {
                Storage::disk('public')->delete($produk->gambar);
            }

            DB::table('produk')->where('id_produk', $id)->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Produk berhasil dihapus.']);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Gagal menghapus: '.$e->getMessage()], 500);
        }
    }
}
