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
}
