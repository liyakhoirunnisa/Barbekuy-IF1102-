<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            // Notifikasi
            $table->boolean('notif_email')->default(true);
            $table->boolean('notif_inbox')->default(false);
            $table->boolean('notif_payment')->default(true);

            // Keamanan
            $table->boolean('force_2fa')->default(false);
            $table->boolean('login_alert')->default(false);
            $table->unsignedTinyInteger('rate_limit')->default(5); // batas percobaan login

            // Sistem
            $table->boolean('maintenance')->default(false);
            $table->enum('backup_schedule', ['daily', 'weekly', 'monthly'])->default('weekly');

            $table->timestamps();
            $table->unique('user_id'); // satu row per admin
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_settings');
    }
};
