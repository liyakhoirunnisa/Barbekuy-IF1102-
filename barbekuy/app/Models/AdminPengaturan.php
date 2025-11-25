<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminSetting extends Model
{
    protected $fillable = [
        'user_id', 'notif_email', 'notif_inbox', 'notif_payment',
        'force_2fa', 'login_alert', 'rate_limit',
        'maintenance', 'backup_schedule',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
