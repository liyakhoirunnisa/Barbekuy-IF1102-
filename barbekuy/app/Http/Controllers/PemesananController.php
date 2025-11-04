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
            'id_produk'             => 'required|exists:produk,id_produk',
            'tanggal_mulai_sewa'    => 'required|date',
            'tanggal_pengembalian'  => 'required|date',
            'metode_pembayaran'     => 'required|string',
            'pesan'                 => 'nullable|string|max:255',
            'ktp'                   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'nama_penerima'         => 'required|string|max:255',
            'jumlah_sewa'           => 'required|integer|min:1',
            'lokasi_pengambilan'    => 'required|string',
        ]);

        if (Carbon::parse($validated['tanggal_pengembalian'])
            ->lt(Carbon::parse($validated['tanggal_mulai_sewa']))
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Tanggal pengembalian tidak boleh sebelum tanggal mulai.',
            ], 400);
        }

        // nomor pesanan
        $last = Pemesanan::orderBy('id_pesanan', 'desc')->first();
        $noPesanan = 'PSN' . str_pad($last ? ((int) str_replace('PSN', '', $last->no_pesanan) + 1) : 1, 4, '0', STR_PAD_LEFT);

        $durasi = max(1, Carbon::parse($validated['tanggal_mulai_sewa'])
            ->diffInDays(Carbon::parse($validated['tanggal_pengembalian'])));

        $produk = Produk::findOrFail($validated['id_produk']);
        $hargaPerHari = (int) $produk->harga;
        $subtotalProduk = $hargaPerHari * (int)$validated['jumlah_sewa'] * $durasi;
        $biayaLayanan  = 1000;
        $totalHarga    = $subtotalProduk + $biayaLayanan;

        $ktpPath = $request->hasFile('ktp')
            ? $request->file('ktp')->store('ktp', 'public')
            : null;

        $pemesanan = Pemesanan::create([
            'id_user'                    => Auth::id(),
            'no_pesanan'                 => $noPesanan,
            'id_produk'                  => $validated['id_produk'], // fallback single item
            'jumlah_sewa'                => (int)$validated['jumlah_sewa'],
            'durasi_hari'                => $durasi,
            'tanggal_mulai_sewa'         => $validated['tanggal_mulai_sewa'],
            'tanggal_pengembalian_sewa'  => $validated['tanggal_pengembalian'],
            'subtotal_produk'            => $subtotalProduk,
            'biaya_layanan'              => $biayaLayanan,
            'total_harga'                => $totalHarga,
            'nama_penerima'              => $validated['nama_penerima'],
            'catatan'                    => $validated['pesan'] ?? null,
            'metode_pembayaran'          => $validated['metode_pembayaran'],
            'lokasi_pengambilan'         => $validated['lokasi_pengambilan'],
            'foto_ktp'                   => $ktpPath,
            'status_pesanan'             => 'Menunggu Konfirmasi',
        ]);

        return response()->json([
            'success'   => true,
            'message'   => 'Pesanan berhasil dibuat!',
            'pemesanan' => $pemesanan,
        ]);
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
            'items'                                => 'required|array|min:1',
            'items.*.id_produk'                    => 'required|exists:produk,id_produk',
            'items.*.jumlah'                       => 'required|integer|min:1',
            'items.*.mulai'                        => 'required|date',
            'items.*.akhir'                        => 'required|date|after_or_equal:items.*.mulai',
            'nama_penerima'                        => 'required|string|max:255',
            'metode_pembayaran'                    => 'required|string',
            'lokasi_pengambilan'                   => 'required|string',
            'catatan'                              => 'nullable|string|max:255',
            'foto_ktp'                             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // nomor pesanan
        $last = Pemesanan::orderBy('id_pesanan', 'desc')->first();
        $noPesanan = 'PSN' . str_pad($last ? ((int) str_replace('PSN', '', $last->no_pesanan) + 1) : 1, 4, '0', STR_PAD_LEFT);

        $subtotalProduk = 0;
        $biayaLayanan  = 1000;

        DB::beginTransaction();
        try {
            $pemesanan = Pemesanan::create([
                'id_user'                    => auth()->id(),
                'no_pesanan'                 => $noPesanan,
                'subtotal_produk'            => 0,
                'biaya_layanan'              => $biayaLayanan,
                'total_harga'                => 0,
                'tanggal_mulai_sewa'         => Carbon::parse($validated['items'][0]['mulai']),
                'tanggal_pengembalian_sewa'  => Carbon::parse($validated['items'][0]['akhir']),
                'nama_penerima'              => $validated['nama_penerima'],
                'metode_pembayaran'          => $validated['metode_pembayaran'],
                'lokasi_pengambilan'         => $validated['lokasi_pengambilan'],
                'catatan'                    => $validated['catatan'] ?? null,
                'foto_ktp'                   => $request->hasFile('foto_ktp')
                    ? $request->file('foto_ktp')->store('ktp', 'public')
                    : null,
                'status_pesanan'             => 'Menunggu Konfirmasi',
            ]);

            foreach ($validated['items'] as $it) {
                $produk = Produk::findOrFail($it['id_produk']);
                $mulai  = Carbon::parse($it['mulai']);
                $akhir  = Carbon::parse($it['akhir']);
                $durasi = max(1, $mulai->diffInDays($akhir));

                $harga    = (int)$produk->harga;
                $jumlah   = (int)$it['jumlah'];
                $subtotal = $harga * $jumlah * $durasi;

                DetailPemesanan::create([
                    'id_pesanan'   => $pemesanan->id_pesanan,
                    'id_produk'    => $produk->id_produk,
                    'jumlah_sewa'  => $jumlah,
                    'durasi_hari'  => $durasi,
                    'harga_satuan' => $harga,
                    'subtotal'     => $subtotal,
                ]);

                $subtotalProduk += $subtotal;
            }

            $pemesanan->update([
                'subtotal_produk' => $subtotalProduk,
                'total_harga'     => $subtotalProduk + $biayaLayanan,
            ]);

            // beresin session checkout
            $request->session()->forget('checkout_items');

            DB::commit();
            return redirect()->route('riwayat.semua')->with('success', "Pesanan {$noPesanan} berhasil dibuat.");
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return back()->with('error', 'Gagal membuat pesanan, coba lagi.');
        }
    }

    public function storeInvoice(Request $request)
    {
        // 1) Validasi minimal: hanya items
        $validated = $request->validate([
            'items'                              => 'required|array|min:1',
            'items.*.id_produk'                  => 'required|exists:produk,id_produk',
            'items.*.tanggal_mulai_sewa'         => 'required|date',
            'items.*.tanggal_pengembalian'       => 'required|date',
            'items.*.jumlah_sewa'                => 'required|integer|min:1',
            // Field berikut TIDAK wajib (akan diisi di halaman pemesanan/checkout)
            'nama_penerima'                      => 'nullable|string|max:255',
            'metode_pembayaran'                  => 'nullable|string',
            'lokasi_pengambilan'                 => 'nullable|string',
            'pesan'                              => 'nullable|string|max:255',
        ]);

        // 2) Generate nomor pesanan
        $last = Pemesanan::orderBy('id_pesanan', 'desc')->first();
        $noPesanan = 'PSN' . str_pad($last ? ((int) str_replace('PSN', '', $last->no_pesanan) + 1) : 1, 4, '0', STR_PAD_LEFT);

        // 3) Hitung subtotal per item
        $subtotalProduk = 0;
        $detailData = [];

        foreach ($validated['items'] as $item) {
            $mulai  = \Carbon\Carbon::parse($item['tanggal_mulai_sewa']);
            $seles  = \Carbon\Carbon::parse($item['tanggal_pengembalian']);
            $durasi = max(1, $mulai->diffInDays($seles));

            $produk   = Produk::findOrFail($item['id_produk']);
            $harga    = $produk->harga;
            $jumlah   = (int) $item['jumlah_sewa'];
            $subtotal = $harga * $jumlah * $durasi;

            $subtotalProduk += $subtotal;

            $detailData[] = [
                'id_produk'    => $produk->id_produk,
                'jumlah_sewa'  => $jumlah,
                'durasi_hari'  => $durasi,
                'harga_satuan' => $harga,
                'subtotal'     => $subtotal,
            ];
        }

        $biayaLayanan = 1000;
        $totalHarga   = $subtotalProduk + $biayaLayanan;

        // 4) Simpan header "draft" (nama penerima & lain-lain boleh null, diisi nanti)
        $pemesanan = Pemesanan::create([
            'id_user'                   => auth()->id(),
            'no_pesanan'                => $noPesanan,
            'subtotal_produk'           => $subtotalProduk,
            'biaya_layanan'             => $biayaLayanan,
            'total_harga'               => $totalHarga,

            'nama_penerima'             => $validated['nama_penerima'] ?? null,
            'catatan'                   => $validated['pesan'] ?? null,
            'metode_pembayaran'         => $validated['metode_pembayaran'] ?? null,
            'lokasi_pengambilan'        => $validated['lokasi_pengambilan'] ?? null,

            // ambil tanggal pertama sebagai ringkasan header (opsional)
            'tanggal_mulai_sewa'        => \Carbon\Carbon::parse($validated['items'][0]['tanggal_mulai_sewa']),
            'tanggal_pengembalian_sewa' => \Carbon\Carbon::parse($validated['items'][0]['tanggal_pengembalian']),

            'status_pesanan'            => 'Draft', // nanti berubah saat user submit di halaman pemesanan
        ]);

        // 5) Simpan detail
        foreach ($detailData as $detail) {
            DetailPemesanan::create(array_merge($detail, [
                'id_pesanan' => $pemesanan->id_pesanan
            ]));
        }

        return response()->json([
            'success'     => true,
            'message'     => 'Draft pesanan dibuat.',
            'no_pesanan'  => $noPesanan,
            'total'       => $totalHarga,
            // kalau mau langsung arahkan ke halaman pengisian detail, kirimkan url:
            // 'redirect' => route('riwayat.semua') // atau route('pemesanan.edit', $pemesanan->id_pesanan)
        ]);
    }

    public function riwayat()
    {
        // Ambil semua pesanan milik user yang sedang login
        $pemesanan = \App\Models\Pemesanan::where('id_user', auth()->id())
            ->orderByDesc('created_at')
            ->with('detailPemesanan') // kalau kamu sudah buat relasi
            ->get();

        return view('riwayat', compact('pemesanan'));
    }
}
