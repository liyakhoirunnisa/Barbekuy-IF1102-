<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\PemesananController;

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

    // routes/web.php
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});

/*
|--------------------------------------------------------------------------
| 🧑‍💼 Area Customer
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->get('/keranjang/count', function () {
    $keranjang = session('keranjang', []);
    $count = 0;
    if (is_array($keranjang)) {
        foreach ($keranjang as $row) {
            $count += (int)($row['jumlah'] ?? 1); // jumlah total item
        }
    }
    return response()->json(['count' => $count]);
})->name('keranjang.count');

Route::get('/', function () {
    return view('beranda'); // Beranda publik
})->name('beranda');

Route::get('/menu', [ProdukController::class, 'index'])->name('menu');

Route::middleware(['auth', 'role:user'])->group(function () {

    Route::get('/pemesanan', fn() => view('pemesanan'))->name('pemesanan');
    Route::post('/pemesanan', [PemesananController::class, 'store'])->name('pemesanan.store');
    Route::get('/pemesanan/{id}', [PemesananController::class, 'show'])->name('pemesanan.show');

    Route::view('/riwayat/semua', 'riwayat.semua')->name('riwayat.semua');
    Route::view('/riwayat/proses', 'riwayat.proses')->name('riwayat.proses');
    Route::view('/riwayat/siap', 'riwayat.siap')->name('riwayat.siap');
    Route::view('/riwayat/sewa', 'riwayat.sewa')->name('riwayat.sewa');
    Route::view('/riwayat/selesai', 'riwayat.selesai')->name('riwayat.selesai');
    Route::view('/riwayat/batal', 'riwayat.batal')->name('riwayat.batal');

    // 💬 Chat dummy
    Route::get('/chat', function (Request $request) {
        $messages = $request->session()->get('chat_messages', []);
        return view('chat', [
            'messages' => $messages,
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

    // 🛒 Keranjang (pakai Controller)
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/tambah/{id}', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
    Route::post('/keranjang/ubah/{id}', [KeranjangController::class, 'ubah'])->name('keranjang.ubah');
    Route::post('/keranjang/hapus-banyak', [KeranjangController::class, 'hapusBanyak'])->name('keranjang.hapusBanyak');
    Route::delete('/keranjang/hapus/{key}', [KeranjangController::class, 'hapusByKey'])->name('keranjang.hapusByKey');
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
    Route::view('/pengaturan', 'admin.pengaturan')->name('admin.pengaturan');
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
