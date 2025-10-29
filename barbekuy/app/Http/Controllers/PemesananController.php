<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PemesananController extends Controller
{
    // ======================
    // TAMPILKAN HALAMAN PEMESANAN
    // ======================
    public function show($id, Request $request)
    {
        $tanggalMulaiSewa = $request->query('tanggal_mulai_sewa');
        $tanggalSelesai   = $request->query('tanggal_selesai');

        $produk = Produk::find($id);
        if (!$produk) {
            abort(404, 'Produk tidak ditemukan');
        }

        $produk = (object) [
            'id_produk'     => $produk->id_produk,
            'nama_produk'   => $produk->nama_produk,
            'gambar'        => $produk->gambar ?? 'produk/placeholder.png',
            'harga'         => $produk->harga,
            'status'        => $produk->status ?? 'Tersedia',
            'jumlah'        => 1,
        ];

        $biaya_layanan    = 1000;
        $total_produk     = $produk->harga * $produk->jumlah;
        $total_pembayaran = $total_produk + $biaya_layanan;

        return view('pemesanan', compact(
            'produk',
            'tanggalMulaiSewa',
            'tanggalSelesai',
            'total_produk',
            'biaya_layanan',
            'total_pembayaran'
        ));
    }

    // ======================
    // SIMPAN PESANAN BARU
    // ======================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_produk' => 'required|exists:produk,id_produk',
            'tanggal_mulai_sewa' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'metode_pembayaran' => 'required|string',
            'pesan' => 'nullable|string|max:255',
            'ktp' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'nama_penerima' => 'required|string|max:255',
            'jumlah_sewa' => 'required|integer|min:1',
            'lokasi_pengambilan' => 'required|string',
        ]);

        if (Carbon::parse($validated['tanggal_selesai'])->lt(Carbon::parse($validated['tanggal_mulai_sewa']))) {
            return response()->json([
                'success' => false,
                'message' => 'Tanggal selesai tidak boleh lebih awal dari tanggal mulai sewa.',
            ], 400);
        }

        // ===============================
        // GENERATE NO PESANAN OTOMATIS
        // ===============================
        $lastPesanan = Pemesanan::orderBy('id_pesanan', 'desc')->first();

        if ($lastPesanan) {
            $lastNo = (int) str_replace('PSN', '', $lastPesanan->no_pesanan);
            $noPesanan = 'PSN' . str_pad($lastNo + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $noPesanan = 'PSN0001';
        }

        // ===============================
        // HITUNG DURASI HARI
        // ===============================
        $durasi = Carbon::parse($validated['tanggal_mulai_sewa'])
            ->diffInDays(Carbon::parse($validated['tanggal_selesai'])) + 1;

        // ===============================
        // HITUNG TOTAL HARGA
        // ===============================
        $produk = Produk::find($validated['id_produk']);
        $hargaPerHari = $produk->harga;
        $totalHarga = ($hargaPerHari * $validated['jumlah_sewa'] * $durasi) + 1000;

        // ===============================
        // UPLOAD KTP (jika ada)
        // ===============================
        $ktpPath = null;
        if ($request->hasFile('ktp')) {
            $ktpPath = $request->file('ktp')->store('ktp', 'public');
        }

        // ===============================
        // SIMPAN PEMESANAN
        // ===============================
        $pemesanan = Pemesanan::create([
            'id_user' => Auth::id(),
            'no_pesanan' => $noPesanan,
            'id_detail_pesanan' => null,
            'id_produk' => $validated['id_produk'],
            'nama_penerima' => $validated['nama_penerima'],
            'jumlah_sewa' => $validated['jumlah_sewa'],
            'durasi_hari' => $durasi,
            'tanggal_mulai_sewa' => $validated['tanggal_mulai_sewa'],
            'tanggal_selesai_sewa' => $validated['tanggal_selesai'],
            'total_harga' => $totalHarga,
            'catatan' => $validated['pesan'] ?? null,
            'metode_pembayaran' => $validated['metode_pembayaran'],
            'lokasi_pengambilan' => $validated['lokasi_pengambilan'],
            'foto_ktp' => $ktpPath,
            'status_pesanan' => 'Menunggu Konfirmasi',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil dibuat!',
            'pemesanan' => $pemesanan,
        ]);
    }
}
