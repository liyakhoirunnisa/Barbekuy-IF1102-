<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UlasanController extends Controller
{
    public function index()
    {
        // Ambil ulasan + nama user + nama produk
        $reviews = DB::table('ulasan as u')
            ->join('users as us', 'us.id', '=', 'u.id_user')
            ->join('produk as p', 'p.id_produk', '=', 'u.id_produk')
            ->select([
                'u.id',
                'u.rating',
                'u.komentar',                 // <-- dipakai di Blade: $r->komentar
                'u.created_at',
                DB::raw('us.name as user_name'),      // <-- $r->user_name
                DB::raw('p.nama_produk as product_name'), // <-- $r->product_name
            ])
            ->orderByDesc('u.created_at')
            ->paginate(12);

        return view('ulasan', compact('reviews'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_detail_id' => ['required', 'integer', 'exists:detail_pemesanan,id_detail'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['required', 'string', 'max:1000'],
        ]);

        $userId = Auth::id();

        // Pastikan detail ini memang milik user yang login
        $detail = DB::table('detail_pemesanan as dp')
            ->join('pemesanan as p', 'p.id_pesanan', '=', 'dp.id_pesanan')
            ->where('dp.id_detail', $request->order_detail_id)
            ->where('p.id_user', $userId)
            ->select('dp.id_detail', 'dp.id_produk')
            ->first();

        if (! $detail) {
            return back()->withErrors('Detail pesanan tidak ditemukan / bukan milik akun ini.');
        }

        // (Opsional) Cegah ulasan ganda untuk satu detail
        $sudahAda = DB::table('ulasan')
            ->where('id_user', $userId)
            ->where('id_detail', $detail->id_detail)
            ->exists();

        if ($sudahAda) {
            return back()->withErrors('Kamu sudah memberi ulasan untuk item ini.');
        }

        DB::table('ulasan')->insert([
            'id_user' => $userId,
            'id_produk' => $detail->id_produk,           // ambil dari detail
            'id_detail' => $detail->id_detail,           // relasi ke detail_pemesanan
            'rating' => $request->rating,
            'komentar' => $request->comment,            // map dari textarea "comment"
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('ulasan.index')->with('success', 'Terima kasih! Ulasan kamu sudah terkirim.');
    }
}
