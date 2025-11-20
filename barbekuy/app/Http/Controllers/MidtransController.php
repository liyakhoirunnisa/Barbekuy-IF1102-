<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    public function getSnapToken(Request $request)
    {
        // Konfigurasi Midtrans
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = config('midtrans.is_sanitized');
        Config::$is3ds        = config('midtrans.is_3ds');

        // Contoh: masih dummy, sekarang kamu sebenarnya sudah buat transaksi dari PemesananController
        $params = [
            'transaction_details' => [
                'order_id'     => 'order-' . rand(),
                'gross_amount' => 10000,
            ],
            'customer_details' => [
                'first_name' => 'Pelanggan Barbekuy',
                'email'      => 'pelanggan@example.com',
                'phone'      => '08123456789',
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return response()->json(['token' => $snapToken]);
    }

    public function finish(Request $request)
    {
        // Setelah user selesai bayar di Midtrans (sandbox),
        // mereka akan diarahkan ke URL ini (callbacks.finish)
        return redirect()
            ->route('riwayat.semua')
            ->with('success', 'Pembayaran diproses. Cek statusnya di Riwayat.');
    }

    public function notificationHandler(Request $request)
    {
        // set config
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = config('midtrans.is_sanitized');
        Config::$is3ds        = config('midtrans.is_3ds');

        $notif = new Notification();

        $status     = $notif->transaction_status;
        $orderId    = $notif->order_id;
        $paymentType = $notif->payment_type ?? null;

        $order = Pemesanan::where('id_pesanan', $orderId)->first();
        if (!$order) {
            return response()->json(['error' => 'not found'], 404);
        }

        // ====== TENTUKAN PAYMENT CHANNEL YANG DITAMPILKAN DI RIWAYAT ======
        $channel = null;

        if ($paymentType === 'bank_transfer') {
            // VA BCA/BNI/BRI, dll
            $bank = $notif->va_numbers[0]->bank ?? null;   // contoh: "bca"
            if ($bank) {
                $channel = strtoupper($bank) . ' VA';      // → "BCA VA"
            }
        } elseif ($paymentType === 'echannel') {
            // Mandiri bill payment
            $channel = 'Mandiri Bill';
        } elseif ($paymentType === 'gopay') {
            $channel = 'GoPay';
        } elseif ($paymentType === 'qris') {
            $channel = 'QRIS';
        } elseif ($paymentType === 'cstore') {
            // Indomaret / Alfamart
            $store = $notif->store ?? null;               // contoh: "indomaret"
            if ($store) {
                $channel = ucfirst($store);               // → "Indomaret"
            }
        }

        // simpan metode pembayaran & channel
        $order->metode_pembayaran = 'midtrans';
        if ($channel) {
            $order->payment_channel = $channel;
        }

        // ====== UPDATE STATUS PESANAN ======
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
