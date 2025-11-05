<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Pemesanan;
use App\Models\DetailPemesanan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PemesananController extends Controller
{
    // ======================
    // TAMPILKAN HALAMAN PEMESANAN
    // ======================
    public function show($id, Request $request)
    {
        $tanggalMulaiSewa    = $request->query('tanggal_mulai_sewa');
        $tanggalPengembalian = $request->query('tanggal_pengembalian') ?? $request->query('tanggal_selesai');
        $jumlah              = max(1, (int) $request->query('jumlah', 1));

        // Ambil produk via kolom id_produk (aman meski primaryKey model belum diset)
        $produk = Produk::where('id_produk', $id)->first();
        if (!$produk) abort(404, 'Produk tidak ditemukan');

        // durasi min 1 hari
        $durasi = 1;
        if ($tanggalMulaiSewa && $tanggalPengembalian) {
            $mulai = \Carbon\Carbon::parse($tanggalMulaiSewa);
            $seles = \Carbon\Carbon::parse($tanggalPengembalian);
            $durasi = max(1, $mulai->diffInDays($seles));
        }

        $harga    = (int) $produk->harga;
        $subtotal = $harga * $jumlah * $durasi;

        $items = [[
            'id_produk' => $produk->id_produk,
            'nama'      => $produk->nama_produk,
            'gambar'    => $produk->gambar ?? 'produk/placeholder.png',
            'jumlah'    => $jumlah,
            'harga'     => $harga,
            'mulai'     => $tanggalMulaiSewa,
            'akhir'     => $tanggalPengembalian,
            'durasi'    => $durasi,
            'subtotal'  => $subtotal,
        ]];

        $total = $subtotal;

        // ⬇️ KUNCI PERBAIKAN: kirim juga $produk ke view
        return view('pemesanan', [
            'produk'               => $produk,
            'items'                => $items,
            'total'                => $total,
            'tanggalMulaiSewa'     => $tanggalMulaiSewa,      // ⬅️ tambah
            'tanggalPengembalian'  => $tanggalPengembalian,   // ⬅️ tambah
            'jumlah'               => $jumlah,                // opsional kalau dipakai di Blade
            'durasi'               => $durasi,                // opsional
        ]);
    }

    // ======================
    // SIMPAN PESANAN BARU
    // ======================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_produk'            => 'required|exists:produk,id_produk',
            'tanggal_sewa'         => 'required|date',
            'tanggal_pengembalian' => 'required|date|after_or_equal:tanggal_sewa',
            'nama_penerima'        => 'required|string|max:100',
            'jumlah_sewa'          => 'required|integer|min:1',
            'catatan_tambahan'     => 'nullable|string|max:255',
        ]);

        $mulai  = Carbon::parse($validated['tanggal_sewa']);
        $akhir  = Carbon::parse($validated['tanggal_pengembalian']);
        $durasi = max(1, $mulai->diffInDays($akhir));

        $produk       = Produk::findOrFail($validated['id_produk']);
        $hargaSatuan  = (int) $produk->harga;
        $subtotal     = $hargaSatuan * (int)$validated['jumlah_sewa'] * $durasi;

        DB::beginTransaction();
        try {
            // Header (no_pesanan otomatis dari Model)
            $p = Pemesanan::create([
                'id_user'             => Auth::id(),
                'nama_penerima'       => $validated['nama_penerima'],
                'tanggal_sewa'        => $mulai->toDateString(),
                'tanggal_pengembalian' => $akhir->toDateString(),
                'total_harga'         => $subtotal,                 // tanpa biaya_layanan sesuai skema baru
                'catatan_tambahan'    => $validated['catatan_tambahan'] ?? null,
                'status_pesanan'      => 'Belum Bayar',
            ]);

            // Detail
            DetailPemesanan::create([
                'id_pesanan'   => $p->id_pesanan,
                'id_produk'    => $produk->id_produk,
                'jumlah_sewa'  => (int)$validated['jumlah_sewa'],
                'durasi_hari'  => $durasi,
                'harga_satuan' => $hargaSatuan,
                'subtotal'     => $subtotal,
            ]);

            DB::commit();
            return response()->json([
                'success'   => true,
                'message'   => 'Pesanan berhasil dibuat!',
                'no_pesanan' => $p->no_pesanan,
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return response()->json(['success' => false, 'message' => 'Gagal membuat pesanan'], 500);
        }
    }

    public function prepare(Request $request)
    {
        // menerima data checkout dari keranjang
        $data = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id_produk' => 'required|string',
            'items.*.jumlah_sewa' => 'required|integer|min:1',
            'items.*.tanggal_mulai_sewa' => 'required|date',
            'items.*.tanggal_pengembalian' => 'required|date|after_or_equal:items.*.tanggal_mulai_sewa',
        ]);

        // simpan ke session supaya bisa dibaca di pemesanan.blade.php
        $request->session()->put('checkout_items', $data['items']);

        return response()->json([
            'ok' => true,
            'redirect' => route('pemesanan.create'),
        ]);
    }

    public function create(Request $request)
    {
        $items = $request->session()->get('checkout_items', []);
        if (empty($items)) {
            return redirect()->route('keranjang.index')->with('error', 'Tidak ada produk untuk checkout.');
        }

        $produkMap = Produk::whereIn('id_produk', collect($items)->pluck('id_produk'))->get()->keyBy('id_produk');

        $ringkasan = [];
        $total = 0;

        foreach ($items as $it) {
            $p = $produkMap[$it['id_produk']] ?? null;
            if (!$p) continue;

            $mulai = Carbon::parse($it['tanggal_mulai_sewa']);
            $akhir = Carbon::parse($it['tanggal_pengembalian']);
            $durasi = max(1, $mulai->diffInDays($akhir));

            $harga = (int) $p->harga;
            $subtotal = $harga * $it['jumlah_sewa'] * $durasi;

            $total += $subtotal;

            $ringkasan[] = [
                'id_produk' => $p->id_produk,
                'nama' => $p->nama_produk,
                'gambar' => $p->gambar,
                'jumlah' => $it['jumlah_sewa'],
                'harga' => $harga,
                'mulai' => $mulai->toDateString(),
                'akhir' => $akhir->toDateString(),
                'durasi' => $durasi,
                'subtotal' => $subtotal,
            ];
        }

        $first = $ringkasan[0] ?? null;
        $tanggalMulaiSewa    = $first['mulai'] ?? null;
        $tanggalPengembalian = $first['akhir'] ?? null;
        $jumlah              = $first['jumlah'] ?? null;
        $durasi              = $first['durasi'] ?? null;
        
        return view('pemesanan', [
            'items'               => $ringkasan,
            'total'               => $total,
            'tanggalMulaiSewa'    => $tanggalMulaiSewa,     // ⬅️ tambah
            'tanggalPengembalian' => $tanggalPengembalian,  // ⬅️ tambah
            'jumlah'              => $jumlah,               // opsional
            'durasi'              => $durasi,               // opsional
        ]);
    }

    public function confirm(Request $request)
    {
        $validated = $request->validate([
            'items'               => 'required|array|min:1',
            'items.*.id_produk'   => 'required|exists:produk,id_produk',
            'items.*.jumlah'      => 'required|integer|min:1',
            'items.*.mulai'       => 'required|date',
            'items.*.akhir'       => 'required|date|after_or_equal:items.*.mulai',
            'nama_penerima'       => 'required|string|max:100',
            'catatan_tambahan'    => 'nullable|string|max:255',
        ]);

        $subtotalAll = 0;

        DB::beginTransaction();
        try {
            // Ambil ringkasan tanggal dari item pertama
            $mulai = Carbon::parse($validated['items'][0]['mulai']);
            $akhir = Carbon::parse($validated['items'][0]['akhir']);

            // Header (no_pesanan otomatis)
            $p = Pemesanan::create([
                'id_user'              => auth()->id(),
                'nama_penerima'        => $validated['nama_penerima'],
                'tanggal_sewa'         => $mulai->toDateString(),
                'tanggal_pengembalian' => $akhir->toDateString(),
                'total_harga'          => 0, // isi setelah loop
                'catatan_tambahan'     => $validated['catatan_tambahan'] ?? null,
                'status_pesanan'       => 'Belum Bayar',
            ]);

            foreach ($validated['items'] as $it) {
                $produk = Produk::findOrFail($it['id_produk']);
                $m = Carbon::parse($it['mulai']);
                $a = Carbon::parse($it['akhir']);
                $durasi = max(1, $m->diffInDays($a));

                $harga   = (int) $produk->harga;
                $jumlah  = (int) $it['jumlah'];
                $subtotal = $harga * $jumlah * $durasi;

                DetailPemesanan::create([
                    'id_pesanan'   => $p->id_pesanan,
                    'id_produk'    => $produk->id_produk,
                    'jumlah_sewa'  => $jumlah,
                    'durasi_hari'  => $durasi,
                    'harga_satuan' => $harga,
                    'subtotal'     => $subtotal,
                ]);

                $subtotalAll += $subtotal;
            }

            $p->update(['total_harga' => $subtotalAll]);

            // beresin session checkout
            $request->session()->forget('checkout_items');

            DB::commit();
            return redirect()->route('riwayat.semua')
                ->with('success', "Pesanan {$p->no_pesanan} berhasil dibuat.");
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return back()->with('error', 'Gagal membuat pesanan, coba lagi.');
        }
    }

    public function storeInvoice(Request $request)
    {
        $validated = $request->validate([
            'items'                              => 'required|array|min:1',
            'items.*.id_produk'                  => 'required|exists:produk,id_produk',
            'items.*.tanggal_mulai_sewa'         => 'required|date',
            'items.*.tanggal_pengembalian'       => 'required|date|after_or_equal:items.*.tanggal_mulai_sewa',
            'items.*.jumlah_sewa'                => 'required|integer|min:1',
            'nama_penerima'                      => 'nullable|string|max:100',
            'catatan_tambahan'                   => 'nullable|string|max:255',
        ]);

        $subtotalAll = 0;
        $detailRows  = [];

        foreach ($validated['items'] as $it) {
            $mulai  = Carbon::parse($it['tanggal_mulai_sewa']);
            $akhir  = Carbon::parse($it['tanggal_pengembalian']);
            $durasi = max(1, $mulai->diffInDays($akhir));

            $produk   = Produk::findOrFail($it['id_produk']);
            $harga    = (int) $produk->harga;
            $jumlah   = (int) $it['jumlah_sewa'];
            $subtotal = $harga * $jumlah * $durasi;

            $subtotalAll += $subtotal;
            $detailRows[] = compact('produk', 'harga', 'jumlah', 'durasi', 'subtotal', 'mulai', 'akhir');
        }

        DB::beginTransaction();
        try {
            $firstMulai = $detailRows[0]['mulai']->toDateString();
            $firstAkhir = $detailRows[0]['akhir']->toDateString();

            $p = Pemesanan::create([
                'id_user'              => auth()->id(),
                'nama_penerima'        => $validated['nama_penerima'] ?? '-',
                'tanggal_sewa'         => $firstMulai,
                'tanggal_pengembalian' => $firstAkhir,
                'total_harga'          => $subtotalAll,
                'catatan_tambahan'     => $validated['catatan_tambahan'] ?? null,
                'status_pesanan'       => 'Belum Bayar', // atau 'Draft' kalau kamu perlukan
            ]);

            foreach ($detailRows as $row) {
                DetailPemesanan::create([
                    'id_pesanan'   => $p->id_pesanan,
                    'id_produk'    => $row['produk']->id_produk,
                    'jumlah_sewa'  => $row['jumlah'],
                    'durasi_hari'  => $row['durasi'],
                    'harga_satuan' => $row['harga'],
                    'subtotal'     => $row['subtotal'],
                ]);
            }

            DB::commit();
            return response()->json([
                'success'     => true,
                'message'     => 'Draft pesanan dibuat.',
                'no_pesanan'  => $p->no_pesanan,
                'total'       => $p->total_harga,
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return response()->json(['success' => false, 'message' => 'Gagal membuat draft'], 500);
        }
    }

    public function riwayat()
    {
        $pemesanan = Pemesanan::where('id_user', auth()->id())
            ->orderByDesc('created_at')
            ->with('details') // ⬅️ ganti dari detailPemesanan
            ->get();

        return view('riwayat', compact('pemesanan'));
    }
}
