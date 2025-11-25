<?php

namespace App\Http\Controllers;

use App\Models\DetailPemesanan;
use App\Models\Pemesanan;
use App\Models\Produk;
use App\Models\User;
use App\Notifications\NotifikasiPemesanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Midtrans\Config;
use Midtrans\Snap;

class PemesananController extends Controller
{
    // ======================
    // TAMPILKAN HALAMAN PEMESANAN (SINGLE ITEM)
    // ======================
    public function show($id, Request $request)
    {
        $tanggalMulaiSewa = $request->query('tanggal_mulai_sewa');
        $tanggalPengembalian = $request->query('tanggal_pengembalian') ?? $request->query('tanggal_selesai');
        $jumlah = max(1, (int) $request->query('jumlah', 1));

        $produk = Produk::where('id_produk', $id)->first();
        if (! $produk) {
            abort(404, 'Produk tidak ditemukan');
        }

        $durasi = 1;
        if ($tanggalMulaiSewa && $tanggalPengembalian) {
            $mulai = Carbon::parse($tanggalMulaiSewa);
            $seles = Carbon::parse($tanggalPengembalian);
            $durasi = max(1, $mulai->diffInDays($seles));
        }

        $harga = (int) $produk->harga;
        $subtotal = $harga * $jumlah * $durasi;

        $items = [[
            'id_produk' => $produk->id_produk,
            'nama' => $produk->nama_produk,
            'gambar' => $produk->gambar ?? 'produk/placeholder.png',
            'jumlah' => $jumlah,
            'harga' => $harga,
            'mulai' => $tanggalMulaiSewa,
            'akhir' => $tanggalPengembalian,
            'durasi' => $durasi,
            'subtotal' => $subtotal,
        ]];

        $total = $subtotal;

        return view('pemesanan', [
            'produk' => $produk,
            'items' => $items,
            'total' => $total,
            'tanggalMulaiSewa' => $tanggalMulaiSewa,
            'tanggalPengembalian' => $tanggalPengembalian,
            'jumlah' => $jumlah,
            'durasi' => $durasi,
        ]);
    }

    // ======================
    // SIMPAN PESANAN BARU (SINGLE ITEM)
    // ======================
    public function store(Request $request)
    {
        if (! auth()->check()) {
            return back()->with('error', 'Silakan login terlebih dahulu.');
        }

        $validated = $request->validate([
            'id_produk' => 'required|exists:produk,id_produk',
            'tanggal_mulai_sewa' => 'required|date',
            'tanggal_pengembalian' => 'required|date|after_or_equal:tanggal_mulai_sewa',
            'nama_penerima' => 'required|string|max:100',
            'jumlah_sewa' => 'required|integer|min:1',
            'catatan_tambahan' => 'nullable|string|max:255',
            'metode_pembayaran' => 'required|string|in:cod,midtrans',
            // boleh tetap divalidasi walaupun tidak disimpan ke DB
            'lokasi_pengambilan' => 'nullable|string|max:255',
            'ktp' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $mulai = Carbon::parse($validated['tanggal_mulai_sewa']);
        $akhir = Carbon::parse($validated['tanggal_pengembalian']);
        $durasi = max(1, $mulai->diffInDays($akhir));

        $produk = Produk::where('id_produk', $validated['id_produk'])->firstOrFail();
        $hargaSatuan = (int) $produk->harga;
        $subtotal = $hargaSatuan * (int) $validated['jumlah_sewa'] * $durasi;

        $biayaLayanan = 1000;
        $totalBayar = $subtotal + $biayaLayanan;

        $ktpPath = $request->file('ktp')->store('ktp', 'public');

        DB::beginTransaction();
        try {
            // buat pemesanan + detail (belum commit)
            $p = Pemesanan::create([
                'id_user' => Auth::id(),
                'nama_penerima' => $validated['nama_penerima'],
                'tanggal_sewa' => $mulai->toDateString(),
                'tanggal_pengembalian' => $akhir->toDateString(),
                'total_harga' => $subtotal, // subtotal saja
                'catatan_tambahan' => $validated['catatan_tambahan'] ?? null,
                'status_pesanan' => 'Belum Bayar',
                'ktp_path' => $ktpPath,
                'metode_pembayaran' => $validated['metode_pembayaran'],
            ]);

            DetailPemesanan::create([
                'id_pesanan' => $p->id_pesanan,
                'id_produk' => $produk->id_produk,
                'jumlah_sewa' => (int) $validated['jumlah_sewa'],
                'durasi_hari' => $durasi,
                'subtotal' => $subtotal,
            ]);

            // CABANG: COD vs MIDTRANS
            if ($validated['metode_pembayaran'] === 'cod') {
                // COD → langsung diproses, pembayaran di tempat
                $p->update([
                    'status_pesanan' => 'Diproses',
                ]);

                DB::commit();
                $this->notifyAdmins($p);

                return redirect()
                    ->route('riwayat.semua')
                    ->with(
                        'success',
                        "Pesanan COD {$p->no_pesanan} berhasil dibuat. Total yang perlu dibayar: Rp".
                            number_format($totalBayar, 0, ',', '.')
                    );
            } else {
                // MIDTRANS
                Config::$serverKey = config('midtrans.server_key');
                Config::$isProduction = config('midtrans.is_production');
                Config::$isSanitized = config('midtrans.is_sanitized');
                Config::$is3ds = config('midtrans.is_3ds');

                $params = [
                    'transaction_details' => [
                        'order_id' => $p->id_pesanan,
                        'gross_amount' => $totalBayar,
                    ],
                    'item_details' => [
                        [
                            'id' => 'produk',
                            'price' => $subtotal,
                            'quantity' => 1,
                            'name' => 'Total Sewa',
                        ],
                        [
                            'id' => 'layanan',
                            'price' => $biayaLayanan,
                            'quantity' => 1,
                            'name' => 'Biaya Layanan',
                        ],
                    ],
                    'customer_details' => [
                        'first_name' => $p->nama_penerima,
                        'email' => auth()->user()->email ?? 'noemail@example.com',
                    ],
                    'callbacks' => [
                        'finish' => route('midtrans.finish'),
                    ],
                ];

                // kalau error di sini → langsung ke catch dan di-rollback
                $snap = Snap::createTransaction($params);

                $p->update([
                    'snap_token' => $snap->token ?? null,
                    // status tetap "Belum Bayar" sampai pembayaran sukses
                ]);

                DB::commit();
                $this->notifyAdmins($p);

                return redirect()->away($snap->redirect_url);
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);

            // Saat dev, kalau mau lihat pesan asli:
            // return back()->with('error', 'Gagal membuat pesanan: ' . $e->getMessage());

            return back()->with('error', 'Gagal membuat pesanan, coba lagi.');
        }
    }

    // ======================
    // PREPARE DARI KERANJANG
    // ======================
    public function prepare(Request $request)
    {
        $data = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id_produk' => 'required|string',
            'items.*.jumlah_sewa' => 'required|integer|min:1',
            'items.*.tanggal_mulai_sewa' => 'required|date',
            'items.*.tanggal_pengembalian' => 'required|date|after_or_equal:items.*.tanggal_mulai_sewa',
        ]);

        $request->session()->put('checkout_items', $data['items']);

        return response()->json([
            'ok' => true,
            'redirect' => route('pemesanan.create'),
        ]);
    }

    // ======================
    // TAMPILKAN PEMESANAN (MULTI ITEM)
    // ======================
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
            if (! $p) {
                continue;
            }

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
        $tanggalMulaiSewa = $first['mulai'] ?? null;
        $tanggalPengembalian = $first['akhir'] ?? null;
        $jumlah = $first['jumlah'] ?? null;
        $durasi = $first['durasi'] ?? null;

        return view('pemesanan', [
            'items' => $ringkasan,
            'total' => $total,
            'tanggalMulaiSewa' => $tanggalMulaiSewa,
            'tanggalPengembalian' => $tanggalPengembalian,
            'jumlah' => $jumlah,
            'durasi' => $durasi,
        ]);
    }

    // ======================
    // SIMPAN PEMESANAN MULTI ITEM
    // ======================
    public function confirm(Request $request)
    {
        if (! auth()->check()) {
            return back()->with('error', 'Silakan login terlebih dahulu.');
        }

        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id_produk' => 'required|exists:produk,id_produk',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.mulai' => 'required|date',
            'items.*.akhir' => 'required|date|after_or_equal:items.*.mulai',
            'nama_penerima' => 'required|string|max:100',
            'catatan_tambahan' => 'nullable|string|max:255',
            'metode_pembayaran' => 'required|string|in:cod,midtrans',
            'lokasi_pengambilan' => 'nullable|string|max:255',
            'ktp' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $ktpPath = $request->file('ktp')->store('ktp', 'public');

        $subtotalAll = 0;

        DB::beginTransaction();
        try {
            $mulai = Carbon::parse($validated['items'][0]['mulai']);
            $akhir = Carbon::parse($validated['items'][0]['akhir']);

            $p = Pemesanan::create([
                'id_user' => auth()->id(),
                'nama_penerima' => $validated['nama_penerima'],
                'tanggal_sewa' => $mulai->toDateString(),
                'tanggal_pengembalian' => $akhir->toDateString(),
                'total_harga' => 0, // diupdate setelah loop
                'catatan_tambahan' => $validated['catatan_tambahan'] ?? null,
                'status_pesanan' => 'Belum Bayar',
                'ktp_path' => $ktpPath,
                'metode_pembayaran' => $validated['metode_pembayaran'],
            ]);

            foreach ($validated['items'] as $it) {
                $produk = Produk::where('id_produk', $it['id_produk'])->firstOrFail();
                $m = Carbon::parse($it['mulai']);
                $a = Carbon::parse($it['akhir']);
                $durasi = max(1, $m->diffInDays($a));
                $harga = (int) $produk->harga;
                $jumlah = (int) $it['jumlah'];
                $subtotal = $harga * $jumlah * $durasi;

                DetailPemesanan::create([
                    'id_pesanan' => $p->id_pesanan,
                    'id_produk' => $produk->id_produk,
                    'jumlah_sewa' => $jumlah,
                    'durasi_hari' => $durasi,
                    'subtotal' => $subtotal,
                ]);

                $subtotalAll += $subtotal;
            }

            $p->update(['total_harga' => $subtotalAll]);

            $biayaLayanan = 1000;
            $totalBayar = $subtotalAll + $biayaLayanan;

            $request->session()->forget('checkout_items');

            // CABANG METODE PEMBAYARAN
            if ($validated['metode_pembayaran'] === 'cod') {
                $p->update([
                    'status_pesanan' => 'Sedang Proses',
                ]);

                DB::commit();
                $this->notifyAdmins($p);

                return redirect()
                    ->route('riwayat.semua')
                    ->with(
                        'success',
                        "Pesanan COD {$p->no_pesanan} berhasil dibuat. Total yang perlu dibayar: Rp".
                            number_format($totalBayar, 0, ',', '.')
                    );
            } else {
                // MIDTRANS
                Config::$serverKey = config('midtrans.server_key');
                Config::$isProduction = config('midtrans.is_production');
                Config::$isSanitized = config('midtrans.is_sanitized');
                Config::$is3ds = config('midtrans.is_3ds');

                $params = [
                    'transaction_details' => [
                        'order_id' => $p->id_pesanan,
                        'gross_amount' => $totalBayar,
                    ],
                    'item_details' => [
                        [
                            'id' => 'produk',
                            'price' => $subtotalAll,
                            'quantity' => 1,
                            'name' => 'Total Sewa',
                        ],
                        [
                            'id' => 'layanan',
                            'price' => $biayaLayanan,
                            'quantity' => 1,
                            'name' => 'Biaya Layanan',
                        ],
                    ],
                    'customer_details' => [
                        'first_name' => $p->nama_penerima,
                        'email' => auth()->user()->email ?? 'noemail@example.com',
                    ],
                    'callbacks' => [
                        'finish' => route('midtrans.finish'),
                    ],
                ];

                $snap = Snap::createTransaction($params);

                $p->update([
                    'snap_token' => $snap->token ?? null,
                    // status tetap "Belum Bayar"
                ]);

                DB::commit();
                $this->notifyAdmins($p);

                return redirect()->away($snap->redirect_url);
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);

            // sementara untuk debug lebih enak:
            // return back()->with('error', 'Gagal membuat pesanan: ' . $e->getMessage());

            return back()->with('error', 'Gagal membuat pesanan, coba lagi.');
        }
    }

    // ======================
    // SIMPAN DRAFT / INVOICE
    // ======================
    public function storeInvoice(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id_produk' => 'required|exists:produk,id_produk',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.mulai' => 'required|date',
            'items.*.akhir' => 'required|date|after_or_equal:items.*.mulai',
            'nama_penerima' => 'required|string|max:100',
            'catatan_tambahan' => 'nullable|string|max:255',
            'ktp' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $ktpPath = $request->file('ktp')->store('ktp', 'public');

        $subtotalAll = 0;
        $detailRows = [];

        foreach ($validated['items'] as $it) {
            $mulai = Carbon::parse($it['mulai']);
            $akhir = Carbon::parse($it['akhir']);
            $durasi = max(1, $mulai->diffInDays($akhir));

            $produk = Produk::where('id_produk', $it['id_produk'])->firstOrFail();
            $harga = (int) $produk->harga;
            $jumlah = (int) $it['jumlah'];
            $subtotal = $harga * $jumlah * $durasi;

            $subtotalAll += $subtotal;
            $detailRows[] = compact('produk', 'harga', 'jumlah', 'durasi', 'subtotal', 'mulai', 'akhir');
        }

        DB::beginTransaction();
        try {
            $firstMulai = $detailRows[0]['mulai']->toDateString();
            $firstAkhir = $detailRows[0]['akhir']->toDateString();

            $p = Pemesanan::create([
                'id_user' => auth()->id(),
                'nama_penerima' => $validated['nama_penerima'],
                'tanggal_sewa' => $firstMulai,
                'tanggal_pengembalian' => $firstAkhir,
                'total_harga' => $subtotalAll,
                'catatan_tambahan' => $validated['catatan_tambahan'] ?? null,
                'status_pesanan' => 'Belum Bayar',
                'ktp_path' => $ktpPath,
            ]);

            foreach ($detailRows as $row) {
                DetailPemesanan::create([
                    'id_pesanan' => $p->id_pesanan,
                    'id_produk' => $row['produk']->id_produk,
                    'jumlah_sewa' => $row['jumlah'],
                    'durasi_hari' => $row['durasi'],
                    'subtotal' => $row['subtotal'],
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Draft pesanan dibuat.',
                'no_pesanan' => $p->no_pesanan,
                'total' => $p->total_harga,
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);

            return response()->json(['success' => false, 'message' => 'Gagal membuat draft'], 500);
        }
    }

    // ======================
    // RIWAYAT
    // ======================
    public function riwayat()
    {
        $pemesanan = Pemesanan::where('id_user', auth()->id())
            ->orderByDesc('created_at')
            ->with(['details.product', 'details.ulasan'])
            ->get();

        // $reviewMap nggak dipakai, jadi sebenarnya bisa dihapus
        // tapi kalau nanti mau dipakai di view, boleh disiapkan:
        // $ulasan = DB::table('ulasan')
        //     ->where('id_user', auth()->id())
        //     ->get(['id_detail', 'id']);
        // $reviewMap = $ulasan->pluck('id', 'id_detail')->toArray();

        return view('riwayat', compact('pemesanan'));
    }

    /**
     * Kirim notifikasi ke semua admin bahwa ada pemesanan baru.
     */
    private function notifyAdmins($order, ?string $explicitName = null): void
    {
        try {
            $customer = Auth::user();
            $nama = $explicitName
                ?? ($customer?->name ?? $customer?->nama ?? $order->nama_penerima ?? 'Pelanggan');

            $nomor = $order->no_pesanan ?? (string) ($order->id_pesanan ?? $order->id);
            $pesan = "{$nama} melakukan pemesanan #{$nomor}";

            $admins = User::where('role', 'admin')->get();
            if ($admins->isEmpty()) {
                return;
            }

            Notification::send(
                $admins,
                new NotifikasiPemesanan($nama, $pesan, $nomor)
            );
        } catch (\Throwable $e) {
            report($e);
        }
    }
}
