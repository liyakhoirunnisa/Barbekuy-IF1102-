<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'notif_email')) {
                $table->boolean('notif_email')->default(true)->after('avatar_path');
            }
            if (! Schema::hasColumn('users', 'notif_message')) {
                $table->boolean('notif_message')->default(false)->after('notif_email');
            }
            if (! Schema::hasColumn('users', 'notif_payment')) {
                $table->boolean('notif_payment')->default(true)->after('notif_message');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'notif_email')) {
                $table->dropColumn('notif_email');
            }
            if (Schema::hasColumn('users', 'notif_message')) {
                $table->dropColumn('notif_message');
            }
            if (Schema::hasColumn('users', 'notif_payment')) {
                $table->dropColumn('notif_payment');
            }
        });
    }
};
