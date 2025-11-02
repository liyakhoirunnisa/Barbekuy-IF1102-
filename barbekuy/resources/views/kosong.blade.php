web.php

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
| Jika sudah login: arahkan sesuai role. Jika belum: ke login.
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

    Route::post('/logout', 'logout')->name('logout');
});

/*
|--------------------------------------------------------------------------
| 🧑‍💼 Area Customer (Publik & User)
|--------------------------------------------------------------------------
*/

// ✅ Beranda publik di /beranda
Route::get('/beranda', function () {
    return view('beranda');
})->name('beranda');

Route::get('/menu', [ProdukController::class, 'index'])->name('menu');

// Hanya user login dengan role:user
Route::middleware(['auth', 'role:user'])->group(function () {

    // 🧾 Pemesanan
    Route::get('/pemesanan', fn () => view('pemesanan'))->name('pemesanan');
    Route::post('/pemesanan', [PemesananController::class, 'store'])->name('pemesanan.store');
    Route::get('/pemesanan/{id}', [PemesananController::class, 'show'])->name('pemesanan.show');

    // 🗂️ Riwayat
    Route::view('/riwayat/semua', 'riwayat.semua')->name('riwayat.semua');
    Route::view('/riwayat/proses', 'riwayat.proses')->name('riwayat.proses');
    Route::view('/riwayat/siap', 'riwayat.siap')->name('riwayat.siap');
    Route::view('/riwayat/sewa', 'riwayat.sewa')->name('riwayat.sewa');
    Route::view('/riwayat/selesai', 'riwayat.selesai')->name('riwayat.selesai');
    Route::view('/riwayat/batal', 'riwayat.batal')->name('riwayat.batal');

    // 💬 Chat dummy (session)
    Route::get('/chat', function (Request $request) {
        $messages = $request->session()->get('chat_messages', []);
        return view('chat', [
            'messages' => $messages,
            // pakai first_name/last_name kalau ada:
            // 'customerName' => trim((auth()->user()->first_name ?? '').' '.(auth()->user()->last_name ?? '')),
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

    // 🛒 Keranjang
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/tambah/{id}', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
    Route::post('/keranjang/ubah/{id}', [KeranjangController::class, 'ubah'])->name('keranjang.ubah');
    Route::delete('/keranjang/hapus/{id}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');
});

/*
|--------------------------------------------------------------------------
| ⚙️ Settings USER (siapa pun yang login)
|--------------------------------------------------------------------------
*/
// ✅ Tampilkan halaman Pengaturan (GET) → untuk tombol di navbar
Route::middleware(['auth'])->get('/pengaturan', function () {
    return view('pengaturan'); // resources/views/pengaturan.blade.php
})->name('pengaturan');

// ✅ Aksi simpan (POST) → ke PengaturanUserController
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
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/beranda', [BerandaController::class, 'admin'])->name('beranda');

    Route::get('/produk', [ProdukController::class, 'adminIndex'])->name('produk');
    Route::post('/produk/tambah', [ProdukController::class, 'store'])->name('produk.store');
    Route::post('/produk/update/{id}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/delete/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');

    Route::view('/notifikasi', 'admin.notifikasi')->name('notifikasi');
    Route::view('/transaksi', 'admin.transaksi')->name('transaksi');
    Route::view('/pembayaran', 'admin.pembayaran')->name('pembayaran');
    Route::view('/pesan', 'admin.pesan')->name('pesan');
    Route::view('/pengaturan', 'admin.pengaturan')->name('pengaturan');

    // ⚙️ Settings ADMIN (pakai controller admin lama yang kamu punya)
    Route::post('/pengaturan/profile',  [AdminPengaturanController::class, 'updateProfile'])->name('pengaturan.profile.update');
    Route::post('/pengaturan/password', [AdminPengaturanController::class, 'updatePassword'])->name('pengaturan.password.update');
    Route::post('/pengaturan/notif',    [AdminPengaturanController::class, 'updateNotif'])->name('pengaturan.notif.update');
    Route::post('/pengaturan/verify',   [AdminPengaturanController::class, 'verify'])->name('pengaturan.verify');
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