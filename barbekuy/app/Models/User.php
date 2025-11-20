<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

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
