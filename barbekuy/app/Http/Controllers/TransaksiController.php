<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TransaksiController extends Controller
{
    // ✅ daftar status resmi (SUDAH DISESUAIKAN)
    public const STATUSES = [
        'Belum Bayar',
        'Diproses',
        'Siap Diambil',
        'Disewa',
        'Selesai',
        'Dibatalkan',
    ];

    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $status = $request->query('status');
        $from = $request->query('from');
        $to = $request->query('to');

        $orders = Pemesanan::with(['details.product', 'user'])
            ->when($status && in_array($status, self::STATUSES, true), function ($qb) use ($status) {
                $qb->where('status_pesanan', $status);
            })
            ->when($from, function ($qb) use ($from) {
                // filter dari tanggal (created_at)
                $qb->whereDate('created_at', '>=', $from);
            })
            ->when($to, function ($qb) use ($to) {
                $qb->whereDate('created_at', '<=', $to);
            })
            ->when($q !== '', function ($qb) use ($q) {
                // cari di no_pesanan, nama_penerima, atau user.name
                $qb->where(function ($w) use ($q) {
                    $w->where('no_pesanan', 'like', "%{$q}%")
                        ->orWhere('nama_penerima', 'like', "%{$q}%")
                        ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$q}%"));
                });
            })
            ->orderByDesc('created_at')
            ->paginate(20)
            ->appends($request->query()); // penting agar pagination mempertahankan filter

        $statuses = self::STATUSES;

        return view('admin.transaksi', compact('orders', 'statuses'));
    }

    public function updateStatus(Request $request, Pemesanan $pemesanan)
    {
        $request->validate([
            'status_pesanan' => ['required', Rule::in(self::STATUSES)],
        ]);

        $pemesanan->status_pesanan = $request->status_pesanan;
        $pemesanan->save();

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function export(Request $request)
    {
        $q      = trim((string) $request->query('q', ''));
        $status = $request->query('status');
        $from   = $request->query('from');
        $to     = $request->query('to');

        // Query sama persis dengan index(), tapi pakai ->get()
        $orders = Pemesanan::with(['details.product', 'user'])
            ->when($status && in_array($status, self::STATUSES, true), function ($qb) use ($status) {
                $qb->where('status_pesanan', $status);
            })
            ->when($from, function ($qb) use ($from) {
                $qb->whereDate('created_at', '>=', $from);
            })
            ->when($to, function ($qb) use ($to) {
                $qb->whereDate('created_at', '<=', $to);
            })
            ->when($q !== '', function ($qb) use ($q) {
                $qb->where(function ($w) use ($q) {
                    $w->where('no_pesanan', 'like', "%{$q}%")
                        ->orWhere('nama_penerima', 'like', "%{$q}%")
                        ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$q}%"));
                });
            })
            ->orderByDesc('created_at')
            ->get();

        $fileName = 'transaksi_' . now()->format('Ymd_His') . '.csv';

        // 📌 Bikin file CSV di memory
        $handle = fopen('php://temp', 'r+');

        // 🧾 Header kolom (DITAMBAH TANGGAL SEWA & PENGEMBALIAN)
        fputcsv($handle, [
            'No',
            'No Pesanan',
            'Nama',
            'Tanggal Pemesanan',
            'Tanggal Sewa',
            'Tanggal Pengembalian',
            'Nama',
            'Status',
            'Total (Rp)',
            'Item (Produk x Qty)',
        ]);

        $no = 1;
        foreach ($orders as $order) {
            $items = $order->details->map(function ($d) {
                $nama  = optional($d->product)->nama_produk ?? 'Produk';
                $qty   = (int) ($d->jumlah ?? 1);

                return "{$nama} x {$qty}";
            })->implode(' | ');

            $tglPesan   = optional($order->created_at)?->format('d/m/Y');
            $tglSewa    = optional($order->tanggal_sewa)?->format('d/m/Y');
            $tglKembali = optional($order->tanggal_pengembalian)?->format('d/m/Y');

            fputcsv($handle, [
                $no++,
                $order->no_pesanan,
                $order->nama_penerima ?? optional($order->user)->name ?? '-',
                $tglPesan,
                $tglSewa,
                $tglKembali,
                $order->nama_penerima ?? optional($order->user)->name ?? '-',
                $order->status_pesanan,
                (int) ($order->total_harga ?? 0),
                $items,
            ]);
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        // Tambah BOM biar Excel baca UTF-8 dengan benar
        $csv = "\xEF\xBB\xBF" . $csv;

        return response($csv)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }
}
