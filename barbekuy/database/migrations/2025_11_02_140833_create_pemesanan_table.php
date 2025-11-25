<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->bigIncrements('id_pesanan');                // PK
            $table->foreignId('id_user')                         // FK -> users.id
                ->constrained('users', 'id')
                ->cascadeOnDelete();

            $table->string('no_pesanan', 30)->unique();          // BRYYYYMMDD-XXX
            $table->string('nama_penerima', 100);                // Naya, Zahra

            $table->date('tanggal_sewa');                        // 02/10/2025
            $table->date('tanggal_pengembalian');                // 03/10/2025

            $table->integer('total_harga');                      // 126000, 91000
            $table->string('catatan_tambahan')->nullable();      // ambil siang/pagi
            $table->string('status_pesanan')->default('Belum Bayar'); // Belum Bayar / Selesai

            // 🆕 Tambahkan kolom untuk path file KTP
            $table->string('ktp_path', 255)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};
