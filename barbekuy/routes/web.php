<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MenuController;

/*
|--------------------------------------------------------------------------
| 🌐 WEB ROUTES - BARBEKUY
|--------------------------------------------------------------------------
| File ini berisi semua route halaman Barbekuy:
| - Autentikasi (Login, Daftar, Reset Password)
| - Halaman utama (Beranda, Menu, Welcome)
| - Pemesanan dan Riwayat Pemesanan
| - Ulasan pelanggan
| - Chat pelanggan
|--------------------------------------------------------------------------
*/


/* =========================================================
| 🔄 REDIRECT DASAR
|========================================================= */

// 👉 Redirect root URL ke beranda
Route::get('/', fn () => redirect()->route('beranda'));


/* =========================================================
| 🔐 AUTENTIKASI
|========================================================= */

// 👉 Halaman login
Route::get('/login', fn () => view('auth.login'))->name('login.form');

// 👉 Proses login (dummy)
Route::post('/login', function (Request $request) {
    $email = $request->input('email');
    $password = $request->input('password');

    $validEmail = 'user@barbekuy.com';
    $validPassword = '123456';

    if ($email === $validEmail && $password === $validPassword) {
        return redirect()->route('beranda')->with('success', 'Login berhasil!');
    }

    return redirect()->route('login.form')
        ->with('error', 'Email atau kata sandi salah')
        ->withInput();
})->name('login.process');

// 👉 Halaman daftar
Route::get('/daftar', fn () => view('auth.daftar'))->name('register.form');

// 👉 Proses daftar
Route::post('/daftar', function (Request $request) {
    $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
    ], [
        'email.unique' => 'Email ini sudah terdaftar. Silakan gunakan email lain.',
    ]);

    DB::table('users')->insert([
        'name'       => $request->input('name'),
        'email'      => $request->input('email'),
        'password'   => Hash::make($request->input('password')),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('login.form')->with('success', 'Akun berhasil dibuat! Silakan masuk.');
})->name('register.process');

// 👉 Lupa kata sandi
Route::get('/forgot-password', fn () => view('auth.forgot-password'))->name('password.request');

// 👉 Proses kirim email reset kata sandi (dummy)
Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);
    return back()->with('status', 'Link reset kata sandi telah dikirim ke email Anda.');
})->name('password.email');


/* =========================================================
| 🏠 HALAMAN UTAMA
|========================================================= */

Route::get('/beranda', fn () => view('beranda'))->name('beranda');

// 👉 Halaman menu
Route::get('/menu', fn () => view('menu'))->name('menu');

// Keranjang 
Route::get('/keranjang', function () {
    return view('keranjang');
})->name('keranjang');

// 👉 Halaman welcome (opsional)
Route::get('/welcome', fn () => view('welcome'))->name('home');



/* =========================================================
| 📦 RIWAYAT PEMESANAN
|========================================================= */

Route::get('/riwayatSemua', fn () => view('riwayatSemua'))->name('riwayat.semua');
Route::get('/riwayatProses', fn () => view('riwayatProses'))->name('riwayat.proses');
Route::get('/riwayatSelesai', fn () => view('riwayatSelesai'))->name('riwayat.selesai');
Route::get('/riwayatBatal', fn () => view('riwayatBatal'))->name('riwayat.batal');


/* =========================================================
| 🧾 HALAMAN PEMESANAN
|========================================================= */

Route::get('/pemesanan', fn () => view('pemesanan'))->name('pemesanan');

Route::post('/pemesanan', function (Request $request) {
    $request->validate([
        'metode_pembayaran' => 'required',
    ], [
        'metode_pembayaran.required' => 'Pilih metode pembayaran terlebih dahulu.',
    ]);

    return redirect()->route('riwayat.semua')->with('success', 'Pesanan berhasil dibuat!');
})->name('pemesanan.proses');


/* =========================================================
| ⭐ ULASAN (Dummy data)
|========================================================= */

Route::get('/ulasan', function () {
    $reviews = [
        (object)[
            'user_name'    => 'Theresa Jordan',
            'review_text'  => 'Pas banget buat BBQ kecil-kecilan bareng temen! Dagingnya fresh, bumbunya lengkap, dan porsinya pas. Tinggal panggang aja!',
            'product_name' => 'Paket Slice Ber-4 Xtra',
            'rating'       => 5,
        ],
        (object)[
            'user_name'    => 'Daniel Smith',
            'review_text'  => 'Pelayanannya cepat dan ramah, cocok buat acara keluarga.',
            'product_name' => 'Paket Premium Grill',
            'rating'       => 5,
        ],
        (object)[
            'user_name'    => 'Alicia Tan',
            'review_text'  => 'Daging segar tapi sausnya agak kurang banyak. Tetap mantap!',
            'product_name' => 'Paket Slice Duo',
            'rating'       => 4,
        ],
        (object)[
            'user_name'    => 'Randy Kusuma',
            'review_text'  => 'Suka banget sama konsep BBQ-nya, praktis dan lengkap!',
            'product_name' => 'Paket Hemat 3 Orang',
            'rating'       => 5,
        ],
        (object)[
            'user_name'    => 'Maya Sari',
            'review_text'  => 'Cita rasa oke, tapi pengiriman sedikit terlambat.',
            'product_name' => 'Paket Grill Party',
            'rating'       => 4,
        ],
        (object)[
            'user_name'    => 'Kevin Hartono',
            'review_text'  => 'Kualitas top! Bakalan order lagi buat weekend nanti.',
            'product_name' => 'Paket Komplit BBQ',
            'rating'       => 5,
        ],
    ];

    return view('ulasan', ['reviews' => $reviews]);
})->name('ulasan.index');


/* =========================================================
| 💬 CHAT SEDERHANA (Session)
|========================================================= */

Route::get('/chat', function (Request $request) {
    $messages = $request->session()->get('chat_messages', []);
    return view('chat', [
        'messages'     => $messages,
        'customerName' => 'Naya Putwi',
    ]);
})->name('chat.index');

Route::post('/chat/send', function (Request $request) {
    $data = $request->validate([
        'body' => 'required|string|max:5000',
    ]);

    $messages = $request->session()->get('chat_messages', []);
    $messages[] = [
        'sender' => 'customer',
        'time'   => now()->format('H:i'),
        'body'   => $data['body'],
    ];
    // Auto-reply dari admin
    $messages[] = [
        'sender' => 'admin',
        'time'   => now()->format('H:i'),
        'body'   => 'Baik kak, pesanan akan kami proses ya 🙏',
    ];

    $request->session()->put('chat_messages', $messages);

    return redirect()->route('chat.index');
})->name('chat.send');

Route::get('/chat/reset', function (Request $request) {
    $request->session()->forget('chat_messages');
    return redirect()->route('chat.index')->with('status', 'Chat telah direset.');
})->name('chat.reset');

Route::post('/keranjang/tambah', function (Request $request) {
    // ambil data yang dikirim dari fetch
    $item = $request->input('item');
    $tanggal = $request->input('tanggal');

    // sementara kita respon sukses saja dulu
    return response()->json([
        'success' => true,
        'item' => $item,
        'tanggal' => $tanggal
    ]);
});

Route::get('/admin/notifikasi', function () {
    return view('admin.notifikasi'); 
})->name('notifikasi');

Route::get('/admin/beranda', function () {
    return view('admin.beranda');
})->name('beranda');

Route::get('/admin/transaksi', function () {
    return view('admin.transaksi'); 
})->name('transaksi');

Route::get('/admin/produk', function () {
    return view('admin.produk'); 
})->name('produk');

Route::get('/admin/pembayaran', function () {
    return view('admin.pembayaran'); 
})->name('pembayaran');

Route::get('/admin/pesan', function () {
    return view('admin.pesan');
})->name('pesan');

Route::get('/admin/pengaturan', function () {
    return view('admin.pengaturan'); 
})->name('pengaturan');