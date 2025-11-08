<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransController extends Controller
{
    public function getSnapToken(Request $request)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        // Contoh: Ambil data order dari request atau database kamu
        // Untuk uji coba, kita pakai nilai dummy dulu
        $params = [
            'transaction_details' => [
                'order_id' => 'order-' . rand(),
                'gross_amount' => 10000, // ganti sesuai total belanja kamu
            ],
            'customer_details' => [
                'first_name' => 'Pelanggan Barbekuy',
                'email' => 'pelanggan@example.com',
                'phone' => '08123456789',
            ],
        ];

        // Dapatkan Snap Token
        $snapToken = Snap::getSnapToken($params);

        // Kirim token ke frontend
        return response()->json(['token' => $snapToken]);
    }

    public function finish(Request $request)
    {
        // Di sandbox, Midtrans akan mengembalikan query seperti order_id, status_code, transaction_status, dll
        // Kalau mau, kamu bisa simpan ke log atau tampilkan flash message
        // contoh: session()->flash('success', 'Pembayaran diproses: '.$request->query('transaction_status'));
        return redirect()->route('riwayat.semua')
            ->with('success', 'Pembayaran diproses. Cek statusnya di Riwayat.');
    }

    public function notificationHandler(Request $request)
    {
        $notif = new \Midtrans\Notification();
        $status = $notif->transaction_status;
        $orderId = $notif->order_id;

        $order = Pemesanan::where('id_pesanan', $orderId)->first();
        if (!$order) return response()->json(['error' => 'not found'], 404);

        if ($status == 'settlement') {
            $order->status_pesanan = 'Lunas';
        } elseif ($status == 'pending') {
            $order->status_pesanan = 'Menunggu Pembayaran';
        } elseif ($status == 'expire') {
            $order->status_pesanan = 'Kadaluarsa';
        } elseif ($status == 'cancel') {
            $order->status_pesanan = 'Dibatalkan';
        }
        $order->save();

        return response()->json(['success' => true]);
    }
}
