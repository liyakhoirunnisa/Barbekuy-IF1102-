<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NotifikasiPemesanan extends Notification
{
    use Queueable; // TIDAK implements ShouldQueue

    public function __construct(
        public string $namaPengguna,
        public string $pesan,
        public ?string $idPesanan = null
    ) {}

    /** Notifikasi disimpan ke database */
    public function via($notifiable): array
    {
        return ['database'];
    }

    /** Payload yang disimpan di kolom `data` tabel notifications */
    public function toDatabase($notifiable): array
    {
        $nomor = $this->idPesanan; // sekarang berisi no_pesanan

        return [
            'nama_pengguna' => $this->namaPengguna,
            'pesan'         => $this->pesan,            // contoh: "Zahra melakukan pemesanan #BR2025..."
            'no_pesanan'    => $nomor,                  // <- utamanya ini
            'id_pesanan'    => $nomor,                  // <- fallback utk kode lama yang baca 'id_pesanan'
            'url'           => route('admin.transaksi', ['order' => $nomor]),
        ];
    }
}
