<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;   // ⬅️ tambah

// ⬅️ opsional (kalau mau format waktu di blade)

class BerandaController extends Controller
{
    public function index()
    {
        // admin diarahkan ke beranda admin
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.beranda');
        }

        // --- 3 ulasan terbaru ---
        $ulasanTerbaru = DB::table('ulasan')
            ->join('users', 'ulasan.id_user', '=', 'users.id')
            ->join('detail_pemesanan', 'ulasan.id_detail', '=', 'detail_pemesanan.id_detail')
            ->join('produk', 'detail_pemesanan.id_produk', '=', 'produk.id_produk')
            ->select(
                'ulasan.id',
                'ulasan.rating',
                'ulasan.komentar',
                'ulasan.created_at',
                DB::raw('users.name as nama_user'),
                DB::raw('produk.nama_produk as nama_produk')
            )
            ->orderByDesc('ulasan.created_at')
            ->limit(3)
            ->get();

        // --- 3 produk paling sering dibeli (best seller) ---
        // hitung total jumlah_sewa per produk; kalau mau hanya pesanan "Selesai", uncomment where status
        $bestSellers = DB::table('detail_pemesanan as d')
            ->join('produk as p', 'd.id_produk', '=', 'p.id_produk')
            ->join('pemesanan as o', 'd.id_pesanan', '=', 'o.id_pesanan')
            ->when(true, function ($q) {
                // filter hanya pesanan selesai (hapus block ini jika ingin semua status)
                $q->where('o.status_pesanan', 'Selesai');
            })
            ->groupBy('p.id_produk', 'p.nama_produk', 'p.gambar', 'p.harga')
            ->select(
                'p.id_produk',
                'p.nama_produk',
                'p.gambar',
                // sesuaikan kolom harga di tabel produk kamu (harga / harga_satuan / dll)
                DB::raw('COALESCE(p.harga, 0) as harga'),
                DB::raw('SUM(d.jumlah_sewa) as total_terjual')
            )
            ->orderByDesc('total_terjual')
            ->limit(3)
            ->get();

        return view('beranda', compact('ulasanTerbaru', 'bestSellers'));
    }

    public function admin()
    {
        if (Auth::check() && Auth::user()->role === 'user') {
            return redirect()->route('beranda');
        }

        // 3 produk paling laris (dari pesanan Selesai)
        $bestSellers = DB::table('detail_pemesanan as d')
            ->join('produk as p', 'd.id_produk', '=', 'p.id_produk')
            ->join('pemesanan as o', 'd.id_pesanan', '=', 'o.id_pesanan')
            ->where('o.status_pesanan', 'Selesai')
            ->select(
                'p.id_produk',
                'p.nama_produk',
                'p.gambar',
                DB::raw('SUM(d.jumlah_sewa) as total_terjual'),
                DB::raw('p.harga as harga_tampil')
            )
            ->groupBy('p.id_produk', 'p.nama_produk', 'p.gambar', 'p.harga')
            ->orderByDesc('total_terjual')
            ->limit(3)
            ->get();

        // produk stok kosong (≤ 0)
        $outOfStock = DB::table('produk')
            ->select('id_produk', 'nama_produk', 'gambar', 'stok', 'updated_at')
            ->where(function ($q) {
                $q->whereNull('stok')->orWhere('stok', '<=', 0);
            })
            ->orderByDesc('updated_at')
            ->limit(10)
            ->get();

        // STAT DINAMIS
        $pesananTotal = DB::table('pemesanan')
            ->where('status_pesanan', '!=', 'Dibatalkan')
            ->count();

        $pelangganTotal = DB::table('users')
            ->where('role', 'user')
            ->count();

        // ⬇️ ganti ke total_bayar kalau itu kolom yang benar di tabelmu
        $pendapatanTotal = (int) DB::table('pemesanan')
            ->where('status_pesanan', 'Selesai')
            ->sum('total_harga');

        return view('admin.beranda', compact(
            'bestSellers',
            'outOfStock',      // ⬅️ sekarang dikirim ke view
            'pesananTotal',
            'pelangganTotal',
            'pendapatanTotal'
        ));
    }
}
