<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TransaksiController extends Controller
{
    // ✅ daftar status resmi
    public const STATUSES = [
        'Belum Bayar',
        'Sedang Proses',
        'Disiapkan',
        'Disewa',
        'Selesai',
        'Dibatalkan',
    ];

    public function index()
    {
        $orders = Pemesanan::with(['details.product', 'user'])
            ->orderByDesc('created_at')
            ->paginate(20);

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
