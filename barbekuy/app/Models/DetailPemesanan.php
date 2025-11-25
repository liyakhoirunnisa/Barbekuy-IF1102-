<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPemesanan extends Model
{
    protected $table = 'detail_pemesanan';

    // ⬇️ GANTI ini
    // protected $primaryKey = 'id_detail_pesanan';
    protected $primaryKey = 'id_detail';   // <- sesuai migration

    public $timestamps = true;

    protected $keyType = 'int';

    public $incrementing = true;

    protected $fillable = [
        'id_pesanan',
        'id_produk',
        'jumlah_sewa',
        'durasi_hari',
        'subtotal',
    ];

    protected $casts = [
        'jumlah_sewa' => 'integer',
        'durasi_hari' => 'integer',
        'subtotal' => 'integer',
    ];

    // ===== RELATIONS =====

    public function pesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'id_pesanan', 'id_pesanan');
    }

    // Nama relasi asli (Indonesia) - tetap dipertahankan
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    // Alias relasi untuk konsistensi dengan controller/view: details.product
    public function product()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    public function ulasan()
    {
        return $this->hasOne(Ulasan::class, 'id_detail', 'id_detail');
    }
}
