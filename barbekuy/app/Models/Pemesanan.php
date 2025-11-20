<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pemesanan extends Model
{
    protected $table = 'pemesanan';
    protected $primaryKey = 'id_pesanan';
    public $incrementing = true;
    protected $keyType = 'int';

    // ✅ Sesuai kolom di migration terbaru
    protected $fillable = [
        'id_user',
        'no_pesanan',
        'nama_penerima',
        'tanggal_sewa',
        'tanggal_pengembalian',
        'total_harga',
        'catatan_tambahan',
        'status_pesanan',
        'ktp_path',

        // ⬇️ tambahkan ini
        'metode_pembayaran',
        'payment_channel',
    ];

    // ✅ Casting tanggal ke Carbon
    protected $casts = [
        'tanggal_sewa'         => 'date',
        'tanggal_pengembalian' => 'date',
    ];

    /* ========================
     |  Auto generate no_pesanan
     |  Format: BRYYYYMMDD-XXX
     |  Reset urutan setiap hari
     =========================*/
    public static function generateNoPesanan(): string
    {
        return DB::transaction(function () {
            $today  = now()->timezone(config('app.timezone', 'Asia/Jakarta'))->format('Ymd');
            $prefix = 'BR' . $today . '-';

            // lockForUpdate mencegah race condition
            $last = static::where('no_pesanan', 'like', $prefix . '%')
                ->lockForUpdate()
                ->orderByDesc('id_pesanan')
                ->first();

            $next = 1;
            if ($last && preg_match('/-(\d{3,})$/', $last->no_pesanan, $m)) {
                $next = (int) $m[1] + 1;
            }

            return $prefix . str_pad((string) $next, 3, '0', STR_PAD_LEFT);
        }, 3);
    }

    // ✅ Auto-set no_pesanan saat creating jika belum diisi
    protected static function booted()
    {
        static::creating(function (self $p) {
            if (empty($p->no_pesanan)) {
                $p->no_pesanan = self::generateNoPesanan();
            }
        });
    }

    /* ============
     |  RELATIONS
     ============*/
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function details()
    {
        return $this->hasMany(DetailPemesanan::class, 'id_pesanan', 'id_pesanan');
    }
}
