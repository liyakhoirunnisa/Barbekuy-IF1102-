<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('detail_pemesanan', function (Blueprint $table) {
            $table->bigIncrements('id_detail');                  // PK detail

            // FK -> pemesanan.id_pesanan
            $table->foreignId('id_pesanan')
                ->constrained('pemesanan', 'id_pesanan')
                ->cascadeOnDelete();

            // FK -> produk.id_produk (string)
            $table->string('id_produk', 20);
            $table->foreign('id_produk')
                ->references('id_produk')->on('produk')
                ->cascadeOnDelete();

            // Kolom detail item
            $table->unsignedInteger('jumlah_sewa');              // 1, 2, dst
            $table->unsignedInteger('durasi_hari');              // 1 hari, dst
            $table->integer('subtotal');                         // harga_satuan * jumlah * durasi

            $table->timestamps();

            // Index bantu
            $table->index(['id_pesanan']);
            $table->index(['id_produk']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pemesanan');
    }
};
