<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /*
    |--------------------------------------------------------------------------
    | Kolom yang boleh diisi massal (mass assignable)
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'name', 'email', 'password', 'role',
        'first_name', 'last_name', 'phone', 'gender',
        'national_id', 'address', 'avatar_path',
        'notif_email', 'notif_message', 'notif_payment',
    ];

    /*
    |--------------------------------------------------------------------------
    | Kolom yang disembunyikan saat serialisasi (JSON, array, dsb)
    |--------------------------------------------------------------------------
    */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /*
    |--------------------------------------------------------------------------
    | Casting tipe data
    |--------------------------------------------------------------------------
    */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'notif_email'   => 'boolean',
        'notif_message' => 'boolean',
        'notif_payment' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Mutator password (otomatis hash bila belum di-hash)
    |--------------------------------------------------------------------------
    */
    public function setPasswordAttribute($value)
    {
        if ($value && strlen($value) < 60) {
            $this->attributes['password'] = bcrypt($value);
        } else {
            $this->attributes['password'] = $value;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Accessor: full_name (gabungan nama depan + belakang)
    |--------------------------------------------------------------------------
    */
    public function getFullNameAttribute(): string
    {
        $full = trim(($this->first_name ?? '') . ' ' . ($this->last_name ?? ''));
        return $full !== '' ? $full : (string) ($this->name ?? '');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessor: label gender (L / P → teks)
    |--------------------------------------------------------------------------
    */
    public function getGenderLabelAttribute(): ?string
    {
        return $this->gender === 'L'
            ? 'Laki-laki'
            : ($this->gender === 'P' ? 'Perempuan' : null);
    }
}
