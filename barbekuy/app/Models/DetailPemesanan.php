<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPemesanan extends Model
{
    protected $table = 'detail_pemesanan';
    protected $primaryKey = 'id_detail_pesanan';
    public $timestamps = true;

    protected $fillable = [
        'id_pesanan',
        'id_produk',
        'jumlah_sewa',
        'durasi_hari',
        'harga_satuan',
        'subtotal',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'id_pesanan', 'id_pesanan');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}
