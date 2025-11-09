<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ulasan', function (Blueprint $table) {
            $table->id();

            // FK ke users.id (bigint unsigned)
            $table->unsignedBigInteger('id_user');

            // FK ke produk.id_produk (varchar(10) persis sama dgn tabel produk)
            $table->string('id_produk', 10);

            // FK ke detail_pemesanan.id_detail (bigint unsigned)
            $table->unsignedBigInteger('id_detail');

            $table->tinyInteger('rating')->default(0);
            $table->text('komentar')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_user')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('id_produk')
                ->references('id_produk')->on('produk')
                ->onDelete('cascade');

            $table->foreign('id_detail')
                ->references('id_detail')->on('detail_pemesanan')
                ->onDelete('cascade');

            // Index bantu (opsional tapi bagus buat query)
            $table->index(['id_user']);
            $table->index(['id_produk']);
            $table->index(['id_detail']);
        });
    }

    public function down(): void
    {
        // Kalau sering rollback/refresh, amanin dengan matiin FK check
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('ulasan');
        Schema::enableForeignKeyConstraints();
    }
};
