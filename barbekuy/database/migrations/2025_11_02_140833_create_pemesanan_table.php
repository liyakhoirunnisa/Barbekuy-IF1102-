<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->bigIncrements('id_pesanan');

            // FK user
            $table->foreignId('id_user')
                ->constrained('users', 'id')
                ->cascadeOnDelete();

            // Nomor & ringkasan harga (untuk multi-checkout)
            $table->string('no_pesanan')->unique();
            $table->integer('subtotal_produk')->nullable();
            $table->integer('biaya_layanan')->nullable();
            $table->integer('total_harga')->nullable();

            // Ringkasan tanggal (opsional)
            $table->date('tanggal_mulai_sewa')->nullable();
            $table->date('tanggal_pengembalian_sewa')->nullable(); // <- samakan dgn controller

            // Data penerima & pembayaran (boleh diisi di halaman pemesanan)
            $table->string('nama_penerima')->nullable();
            $table->string('metode_pembayaran')->nullable();
            $table->string('lokasi_pengambilan')->nullable();
            $table->string('foto_ktp')->nullable();
            $table->text('catatan')->nullable();

            $table->string('status_pesanan')->default('Menunggu Konfirmasi');

            // ===== Fallback SINGLE ITEM (alurnya method store() lama) =====
            // pakai tipe & panjang yang sama dengan produk.id_produk
            $table->string('id_produk', 20)->nullable();
            $table->unsignedInteger('jumlah_sewa')->nullable();
            $table->unsignedInteger('durasi_hari')->nullable();

            $table->timestamps();

            // FK opsional ke produk (karena id_produk adalah string PK di tabel produk)
            $table->foreign('id_produk')
                ->references('id_produk')
                ->on('produk')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};
