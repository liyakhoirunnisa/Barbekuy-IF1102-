<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_pemesanan', function (Blueprint $table) {
            $table->bigIncrements('id_detail');

            // relasi ke tabel pemesanan
            $table->foreignId('id_pesanan')
                ->constrained('pemesanan', 'id_pesanan')
                ->cascadeOnDelete();

            // relasi ke tabel produk (produk.id_produk = string)
            $table->string('id_produk', 20); // samakan panjangnya dengan kolom di tabel produk
            $table->foreign('id_produk')
                ->references('id_produk')
                ->on('produk')
                ->cascadeOnDelete();

            // detail sewa
            $table->unsignedInteger('jumlah_sewa');
            $table->unsignedInteger('durasi_hari');
            $table->integer('harga_satuan');
            $table->integer('subtotal');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pemesanan');
    }
};
