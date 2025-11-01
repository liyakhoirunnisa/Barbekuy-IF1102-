<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // === Profil ===
            if (!Schema::hasColumn('users', 'first_name')) {
                $table->string('first_name', 100)->nullable()->after('name');
            }
            if (!Schema::hasColumn('users', 'last_name')) {
                $table->string('last_name', 100)->nullable()->after('first_name');
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone', 30)->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'gender')) {
                $table->string('gender', 1)->nullable()->after('phone'); // L/P
            }
            if (!Schema::hasColumn('users', 'national_id')) {
                $table->string('national_id', 50)->nullable()->after('gender');
            }
            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable()->after('national_id');
            }
            if (!Schema::hasColumn('users', 'avatar_path')) {
                $table->string('avatar_path')->nullable()->after('address');
            }

            // === Notifikasi ===
            if (!Schema::hasColumn('users', 'notif_email')) {
                $table->boolean('notif_email')->default(true)->after('avatar_path');
            }
            if (!Schema::hasColumn('users', 'notif_message')) {
                $table->boolean('notif_message')->default(true)->after('notif_email');
            }
            if (!Schema::hasColumn('users', 'notif_payment')) {
                $table->boolean('notif_payment')->default(true)->after('notif_message');
            }

            // === Verifikasi ===
            if (!Schema::hasColumn('users', 'email_verified_at')) {
                $table->timestamp('email_verified_at')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'verification_code')) {
                $table->string('verification_code', 6)->nullable()->after('remember_token');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $cols = [
                'first_name',
                'last_name',
                'phone',
                'gender',
                'national_id',
                'address',
                'avatar_path',
                'notif_email',
                'notif_message',
                'notif_payment',
                'verification_code',
                'email_verified_at',
            ];
            foreach ($cols as $col) {
                if (Schema::hasColumn('users', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
