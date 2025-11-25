<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pemesanan', function (Blueprint $table) {
            if (! Schema::hasColumn('pemesanan', 'metode_pembayaran')) {
                $table->string('metode_pembayaran', 20)->nullable()->after('total_harga');
            }

            if (! Schema::hasColumn('pemesanan', 'payment_channel')) {
                $table->string('payment_channel', 50)->nullable()->after('metode_pembayaran');
            }

            if (! Schema::hasColumn('pemesanan', 'snap_token')) {
                $table->string('snap_token')->nullable()->after('payment_channel');
            }
        });
    }

    public function down()
    {
        // Drop satu-satu supaya aman di semua driver DB
        if (Schema::hasColumn('pemesanan', 'metode_pembayaran')) {
            Schema::table('pemesanan', function (Blueprint $table) {
                $table->dropColumn('metode_pembayaran');
            });
        }

        if (Schema::hasColumn('pemesanan', 'payment_channel')) {
            Schema::table('pemesanan', function (Blueprint $table) {
                $table->dropColumn('payment_channel');
            });
        }

        if (Schema::hasColumn('pemesanan', 'snap_token')) {
            Schema::table('pemesanan', function (Blueprint $table) {
                $table->dropColumn('snap_token');
            });
        }
    }
};
