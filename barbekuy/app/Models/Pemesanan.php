<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanan';
    protected $primaryKey = 'id_pesanan';

    protected $fillable = [
        'id_user',
        'no_pesanan',
        'id_detail_pesanan',
        'id_produk',
        'nama_penerima',
        'jumlah_sewa',
        'durasi_hari',
        'tanggal_mulai_sewa',
        'tanggal_selesai_sewa',
        'total_harga',
        'catatan',
        'metode_pembayaran',
        'lokasi_pengambilan',
        'foto_ktp',
        'status_pesanan',
    ];

    public function detailPemesanan()
    {
        return $this->hasMany(\App\Models\DetailPemesanan::class, 'id_pesanan', 'id_pesanan');
    }

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    // Relasi ke detail pesanan
    public function detail()
    {
        return $this->hasMany(DetailPemesanan::class, 'id_pesanan', 'id_pesanan');
    }
}
