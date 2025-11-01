<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\PemesananController;

// ⚙️ Pengaturan (ADMIN lama = PengaturanController, USER = PengaturanUserController)
use App\Http\Controllers\PengaturanController as AdminPengaturanController;
use App\Http\Controllers\PengaturanUserController;

/*
|--------------------------------------------------------------------------
| 🔄 Redirect Dasar
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.beranda')
            : redirect()->route('beranda');
    }
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| 🔐 Autentikasi (AuthController)
|--------------------------------------------------------------------------
*/
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login')->name('login.process');

    Route::get('/daftar', 'showRegisterForm')->name('daftar.form');
    Route::post('/daftar', 'register')->name('daftar.process');

    // 🧑‍💻 (Opsional) Register Admin
    Route::get('/daftar-admin', 'showRegisterForm')->name('admin.daftar.form');
    Route::post('/daftar-admin', 'registerAdmin')->name('admin.daftar');

    // ✅ logout cukup refer ke method 'logout' di controller ini
    Route::post('/logout', 'logout')->name('logout');
});

/*
|--------------------------------------------------------------------------
| 🌐 Halaman Umum
|--------------------------------------------------------------------------
*/
// ✅ Beranda publik dipindah ke /beranda agar tidak bentrok dengan '/'
Route::get('/beranda', function () {
    return view('beranda');
})->name('beranda');

Route::get('/menu', [ProdukController::class, 'index'])->name('menu');

/*
|--------------------------------------------------------------------------
| 🧑‍💼 Area Customer
|--------------------------------------------------------------------------
*/
// 🔢 Badge jumlah keranjang (AJAX)
Route::middleware(['auth'])->get('/keranjang/count', function () {
    $keranjang = session('keranjang', []);
    $count = 0;
    if (is_array($keranjang)) {
        foreach ($keranjang as $row) {
            $count += (int)($row['jumlah'] ?? 1);
        }
    }
    return response()->json(['count' => $count]);
})->name('keranjang.count');

// 🛒 Keranjang (Controller) – setelah login user
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/tambah/{id}', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
    Route::post('/keranjang/ubah/{id}', [KeranjangController::class, 'ubah'])->name('keranjang.ubah');
    Route::post('/keranjang/hapus-banyak', [KeranjangController::class, 'hapusBanyak'])->name('keranjang.hapusBanyak');
    Route::delete('/keranjang/hapus/{key}', [KeranjangController::class, 'hapusByKey'])->name('keranjang.hapusByKey');

    // ✅ Riwayat Pesanan — dipakai navbar: route('riwayat.semua')
    Route::get('/riwayat', [PemesananController::class, 'riwayat'])->name('riwayat.semua');

    // ♻️ Alias lama (kalau ada view lama pakai 'pemesanan.riwayat')
    Route::get('/riwayat/pesanan', function () {
        return redirect()->route('riwayat.semua');
    })->name('pemesanan.riwayat');
});

// 💬 Chat (dummy, simpan di session) – auth + role:user
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/chat', function (Request $request) {
        $messages = $request->session()->get('chat_messages', []);
        return view('chat', [
            'messages'     => $messages,
            'customerName' => auth()->user()->name,
        ]);
    })->name('chat.index');

    Route::post('/chat/send', function (Request $request) {
        $data = $request->validate(['body' => 'required|string|max:5000']);

        $messages = $request->session()->get('chat_messages', []);
        $messages[] = [
            'sender' => 'customer',
            'time'   => now()->format('H:i'),
            'body'   => $data['body'],
        ];
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
});

/*
|--------------------------------------------------------------------------
| ⚙️ Settings USER (siapa pun yang login)
|--------------------------------------------------------------------------
*/
// ✅ Halaman pengaturan (GET) – cocok dengan route('pengaturan') di navbar
Route::middleware(['auth'])->get('/pengaturan', function () {
    return view('pengaturan'); // resources/views/pengaturan.blade.php
})->name('pengaturan');

// ✅ Aksi simpan (POST)
Route::middleware(['auth'])->group(function () {
    Route::post('/pengaturan/profile', [PengaturanUserController::class, 'updateProfile'])->name('pengaturan.profile.update');
    Route::post('/pengaturan/password', [PengaturanUserController::class, 'updatePassword'])->name('pengaturan.password.update');
    Route::post('/pengaturan/notif',   [PengaturanUserController::class, 'updateNotif'])->name('pengaturan.notif.update');
    Route::post('/pengaturan/verify',  [PengaturanUserController::class, 'verify'])->name('pengaturan.verify');
});

/*
|--------------------------------------------------------------------------
| 🧑‍💻 Area Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/beranda', [BerandaController::class, 'admin'])->name('admin.beranda');

    Route::get('/produk', [ProdukController::class, 'adminIndex'])->name('admin.produk');
    Route::post('/produk/tambah', [ProdukController::class, 'store'])->name('produk.store');
    Route::post('/produk/update/{id}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/delete/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');

    Route::view('/notifikasi', 'admin.notifikasi')->name('admin.notifikasi');
    Route::view('/transaksi', 'admin.transaksi')->name('admin.transaksi');
    Route::view('/pembayaran', 'admin.pembayaran')->name('admin.pembayaran');
    Route::view('/pesan', 'admin.pesan')->name('admin.pesan');

    // Halaman view pengaturan admin
    Route::view('/pengaturan', 'admin.pengaturan')->name('admin.pengaturan');

    // ⚙️ SETTINGS ADMIN → admin.settings.*
    Route::prefix('settings')->as('admin.settings.')->group(function () {
        Route::post('/profile',  [AdminPengaturanController::class, 'updateProfile'])->name('profile.update');
        Route::post('/password', [AdminPengaturanController::class, 'updatePassword'])->name('password.update');
        Route::post('/notif',    [AdminPengaturanController::class, 'updateNotif'])->name('notif.update');

        // (Opsional) kalau view admin kamu butuh verifikasi
        // Route::post('/verify',   [AdminPengaturanController::class, 'verify'])->name('verify');
    });
});

/*
|--------------------------------------------------------------------------
| ⭐ Halaman Ulasan (Terbuka)
|--------------------------------------------------------------------------
*/
Route::get('/ulasan', function () {
    $reviews = [
        (object)[
            'user_name'    => 'Theresa Jordan',
            'review_text'  => 'Pas banget buat BBQ kecil-kecilan bareng temen! Dagingnya fresh, bumbunya lengkap, dan porsinya pas.',
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
    ];

    return view('ulasan', compact('reviews'));
})->name('ulasan.index');
