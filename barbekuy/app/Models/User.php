<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory; // ⬅️ WAJIB ADA

class User extends Authenticatable
{
    use HasFactory, Notifiable; // ⬅️ WAJIB ADA

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',

        // 🌟 Profil
        'first_name',
        'last_name',
        'phone',
        'gender',
        'address',
        'avatar_path',

        // 🌟 Verifikasi
        'verification_code',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
