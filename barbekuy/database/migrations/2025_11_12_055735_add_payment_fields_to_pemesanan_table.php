<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pemesanan', function (Blueprint $table) {
            $table->string('metode_pembayaran', 20)->nullable()->after('total_harga');
            $table->string('payment_channel', 50)->nullable()->after('metode_pembayaran');
        });
    }

    public function down()
    {
        Schema::table('pemesanan', function (Blueprint $table) {
            $table->dropColumn(['metode_pembayaran', 'payment_channel']);
        });
    }
};
