<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
                DB::raw("COALESCE(NULLIF(TRIM(CONCAT(COALESCE(users.first_name, ''), ' ', COALESCE(users.last_name, ''))), ''), users.name) as nama_user"),
                DB::raw('users.avatar_path as avatar_path'),
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

        // =========================
        // 📦 STAT BOX = DATA BULAN INI
        // =========================
        $now = Carbon::now();

        // Pesanan bulan ini (kecuali dibatalkan)
        $pesananTotal = DB::table('pemesanan')
            ->where('status_pesanan', '!=', 'Dibatalkan')
            ->whereYear('tanggal_sewa', $now->year)
            ->whereMonth('tanggal_sewa', $now->month)
            ->count();

        // Pelanggan baru bulan ini
        $pelangganTotal = DB::table('users')
            ->where('role', 'user')
            ->whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->count();

        // Pendapatan bulan ini (hanya pesanan selesai)
        $pendapatanTotal = (int) DB::table('pemesanan')
            ->where('status_pesanan', 'Selesai')
            ->whereYear('tanggal_sewa', $now->year)
            ->whereMonth('tanggal_sewa', $now->month)
            ->sum('total_harga'); // atau total_bayar kalau kolommu itu

        // =========================
        // 📊 DATA GRAFIK 6 BULAN TERAKHIR
        // =========================
        $labels           = [];
        $chartPesanan     = [];
        $chartPelanggan   = [];
        $chartPendapatan  = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);

            $labels[] = $date->format('M'); // Jan, Feb, dst

            // Pesanan per bulan (kecuali dibatalkan)
            $chartPesanan[] = DB::table('pemesanan')
                ->where('status_pesanan', '!=', 'Dibatalkan')
                ->whereYear('tanggal_sewa', $date->year)
                ->whereMonth('tanggal_sewa', $date->month)
                ->count();

            // Pelanggan baru per bulan
            $chartPelanggan[] = DB::table('users')
                ->where('role', 'user')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            // Pendapatan per bulan (hanya pesanan selesai)
            $chartPendapatan[] = (int) DB::table('pemesanan')
                ->where('status_pesanan', 'Selesai')
                ->whereYear('tanggal_sewa', $date->year)
                ->whereMonth('tanggal_sewa', $date->month)
                ->sum('total_harga'); // atau total_bayar
        }

        $chartLabels = $labels;

        return view('admin.beranda', compact(
            'bestSellers',
            'outOfStock',
            'pesananTotal',     // sekarang = bulan ini
            'pelangganTotal',   // sekarang = bulan ini
            'pendapatanTotal',  // sekarang = bulan ini
            'chartLabels',
            'chartPesanan',
            'chartPelanggan',
            'chartPendapatan'
        ));
    }
}
