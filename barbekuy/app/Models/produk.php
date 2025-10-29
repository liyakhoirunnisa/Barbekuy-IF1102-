<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    public $incrementing = false; // Nonaktifkan auto increment
    protected $keyType = 'string'; // Primary key tipe string

    protected $fillable = [
        'id_produk',
        'nama_produk',
        'kategori', // langsung nama kategori
        'harga',
        'stok',
        'status_ketersediaan',
        'deskripsi',
        'gambar'
    ];
}