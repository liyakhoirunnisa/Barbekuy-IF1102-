<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\NotifikasiController;

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

// 🌐 Login dengan Google
Route::get('/auth/google/redirect', [AuthController::class, 'redirectToGoogle'])
    ->name('auth.google.redirect');

Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])
    ->name('auth.google.callback');


/*
|--------------------------------------------------------------------------
| 🌐 Halaman Umum
|--------------------------------------------------------------------------
*/
// ✅ Beranda publik dipindah ke /beranda agar tidak bentrok dengan '/'
Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');

Route::get('/menu', [ProdukController::class, 'index'])->name('menu');

/*
|--------------------------------------------------------------------------
| 🧑‍💼 Area Customer
|--------------------------------------------------------------------------
*/
Route::post('/produk/{id}/stok-tersedia', [\App\Http\Controllers\ProdukController::class, 'cekStok'])
    ->name('produk.cekStok');

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

    Route::get('/pemesanan/{id}', [PemesananController::class, 'show'])->name('pemesanan.show');
    Route::post('/pemesanan',      [PemesananController::class, 'store'])->name('pemesanan.store');
    Route::post('/pemesanan/confirm', [PemesananController::class, 'confirm'])
        ->name('pemesanan.confirm');
    // 💳 Multi-checkout (banyak produk sekaligus)
    Route::post('/pemesanan/invoice', [PemesananController::class, 'storeInvoice'])
        ->name('pemesanan.invoice.store');

    // Siapkan data checkout (single/multi) ke session, lalu redirect ke halaman pemesanan.blade.php
    Route::post('/pemesanan/prepare', [\App\Http\Controllers\PemesananController::class, 'prepare'])
        ->name('pemesanan.prepare');

    // Halaman konfirmasi pemesanan (SELALU render pemesanan.blade.php)
    Route::get('/pemesanan', [\App\Http\Controllers\PemesananController::class, 'create'])
        ->name('pemesanan.create');

    // ✅ Riwayat Pesanan — dipakai navbar: route('riwayat.semua')
    Route::get('/riwayat', [PemesananController::class, 'riwayat'])->name('riwayat.semua');

    // ♻️ Alias lama (kalau ada view lama pakai 'pemesanan.riwayat')
    Route::get('/riwayat/pesanan', function () {
        return redirect()->route('riwayat.semua');
    })->name('pemesanan.riwayat');


    Route::get('/ulasan', [UlasanController::class, 'index'])->name('ulasan.index');
    Route::post('/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');
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
| ⚙️ Settings USER 
|--------------------------------------------------------------------------
*/

// ✅ Aksi simpan (POST)
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/pengaturan', [PengaturanUserController::class, 'index'])->name('pengaturan');
    Route::post('/pengaturan/profil', [PengaturanUserController::class, 'updateProfile'])->name('pengaturan.profil.update');
    Route::post('/pengaturan/password', [PengaturanUserController::class, 'updatePassword'])->name('pengaturan.password.update');
});


/*
|--------------------------------------------------------------------------
| 🧑‍💻 Area Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/beranda', [BerandaController::class, 'admin'])->name('admin.beranda');
    
    Route::get('/transaksi', [TransaksiController::class, 'index'])
        ->name('admin.transaksi');
    Route::patch('/transaksi/{pemesanan}/status', [TransaksiController::class, 'updateStatus'])
        ->name('admin.transaksi.updateStatus');

    Route::get('/produk', [ProdukController::class, 'adminIndex'])->name('admin.produk');
    Route::post('/produk/tambah', [ProdukController::class, 'store'])->name('produk.store');
    Route::post('/produk/update/{id}', [ProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/delete/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy');

    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('admin.notifikasi.index');
    Route::post('/notifikasi/{id}/read', [NotifikasiController::class, 'markRead'])->name('admin.notifikasi.read');
    Route::post('/notifikasi/read-all', [NotifikasiController::class, 'markAllRead'])->name('admin.notifikasi.readAll');
    Route::delete('/notifikasi/{id}', [NotifikasiController::class, 'destroy'])->name('admin.notifikasi.destroy');
    Route::delete('/notifikasi', [NotifikasiController::class, 'bulkDestroy'])->name('admin.notifikasi.bulkDestroy');
    
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
| 💳 Midtrans Payment Routes
|--------------------------------------------------------------------------
*/
Route::get('/midtrans/token', [MidtransController::class, 'getSnapToken'])->name('midtrans.token');
Route::view('/payment', 'payment')->name('payment');
Route::get('/midtrans/finish', [MidtransController::class, 'finish'])->name('midtrans.finish');
Route::post('/midtrans/notification', [MidtransController::class, 'notificationHandler'])
    ->name('midtrans.notification');
