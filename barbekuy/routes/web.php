<?php
// Tag pembuka PHP wajib untuk file route Laravel

use App\Http\Controllers\AuthController; // Import controller untuk autentikasi user
use App\Http\Controllers\LupaSandiController;
use App\Http\Controllers\BerandaController; // Controller untuk halaman beranda customer & admin
use App\Http\Controllers\KeranjangController; // Controller untuk fitur keranjang pelanggan
use App\Http\Controllers\MidtransController; // Controller untuk integrasi pembayaran Midtrans
use App\Http\Controllers\NotifikasiController; // Controller untuk notifikasi admin
use App\Http\Controllers\PemesananController; // Controller untuk pemesanan / checkout / riwayat user
use App\Http\Controllers\PengaturanController as AdminPengaturanController; // Controller untuk pengaturan profil admin
use App\Http\Controllers\PengaturanUserController; // Controller untuk pengaturan profil user (pelanggan)
use App\Http\Controllers\ProdukController; // Controller untuk data produk
use App\Http\Controllers\TransaksiController; // Controller untuk transaksi admin
use App\Http\Controllers\UlasanController; // Controller untuk ulasan & rating pelanggan
use Illuminate\Http\Request; // Import dependency Request untuk menangani input HTTP
use Illuminate\Support\Facades\Route; // Import fungsi Route untuk definisi routing Laravel
use Illuminate\Support\Facades\Session; // Import Session untuk akses data session

/*
|--------------------------------------------------------------------------
| 🔄 Redirect Dasar
|--------------------------------------------------------------------------
| Bagian ini mengatur arah redirect ketika user membuka URL root '/'
| dan mengarahkannya sesuai status login dan role pengguna.
*/

Route::get('/', function () { // Route utama pada root domain, pakai closure function
    if (auth()->check()) { // Cek apakah user sedang login
        return auth()->user()->role === 'admin' // Cek apakah role user adalah admin
            ? redirect()->route('admin.beranda') // Jika admin → redirect ke dashboard admin
            : redirect()->route('beranda');      // Jika pelanggan → redirect ke beranda pelanggan
    }

    return redirect()->route('beranda'); // Jika belum login (guest) → tetap arahkan ke beranda pelanggan
});

/*
|--------------------------------------------------------------------------
| 🔐 Autentikasi (AuthController)
|--------------------------------------------------------------------------
| Mengatur proses login, register, & logout untuk user & admin.
*/
Route::controller(AuthController::class)->group(function () { // Group route untuk AuthController
    Route::get('/login', 'showLoginForm')->name('login'); // Tampilkan halaman form login
    Route::post('/login', 'login')->name('login.process'); // Proses login

    Route::get('/daftar', 'showRegisterForm')->name('daftar.form'); // Tampilkan form daftar user
    Route::post('/daftar', 'register')->name('daftar.process'); // Proses daftar user

    Route::get('/daftar-admin', 'showRegisterForm')->name('admin.daftar.form'); // Form daftar admin (opsional)
    Route::post('/daftar-admin', 'registerAdmin')->name('admin.daftar'); // Proses daftar admin

    Route::post('/logout', 'logout')->name('logout'); // Proses logout pengguna
});

// 🔑 Lupa kata sandi & reset password (pakai LupaSandiController)
Route::get('/lupa-sandi', [LupaSandiController::class, 'showLinkRequestForm'])
    ->name('password.request');

Route::post('/lupa-sandi', [LupaSandiController::class, 'sendResetLinkEmail'])
    ->name('password.email');

Route::get('/reset-password/{token}', [LupaSandiController::class, 'showResetForm'])
    ->name('password.reset');

Route::post('/reset-password', [LupaSandiController::class, 'resetPassword'])
    ->name('password.update');
    
// 🌐 Login dengan Google (OAuth)
Route::get('/auth/google/redirect', [AuthController::class, 'redirectToGoogle']) // Arahkan user ke halaman login Google
    ->name('auth.google.redirect');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']) // Callback setelah login via Google
    ->name('auth.google.callback');

/*
|--------------------------------------------------------------------------
| 🌐 Halaman Umum
|--------------------------------------------------------------------------
| Bagian ini bisa diakses siapa saja (user login maupun guest)
*/
Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda'); // Halaman beranda untuk pelanggan
Route::get('/menu', [ProdukController::class, 'index'])->name('menu'); // Halaman daftar produk
Route::get('/search', [ProdukController::class, 'search'])->name('produk.search'); // Pencarian produk
Route::get('/ulasan', [UlasanController::class, 'index'])->name('ulasan.index'); // Halaman daftar ulasan & rating (publik)

/*
|--------------------------------------------------------------------------
| 🧑‍💼 Area Customer
|--------------------------------------------------------------------------
| Semua route dalam bagian ini hanya dapat diakses setelah login
| khusus untuk user dengan role "user" (pelanggan).
*/
Route::post('/produk/{id}/stok-tersedia', [\App\Http\Controllers\ProdukController::class, 'cekStok'])
    ->name('produk.cekStok'); // Cek stok produk via AJAX saat pelanggan memilih tanggal sewa

// 🔢 Badge jumlah keranjang (AJAX) — hanya bisa dipanggil setelah login
Route::middleware(['auth'])->get('/keranjang/count', function () { // Menghitung total item dalam keranjang user
    $keranjang = session('keranjang', []); // Ambil data keranjang dari session
    $count = 0; // Inisialisasi jumlah item
    if (is_array($keranjang)) { // Cek apakah data keranjang berupa array
        foreach ($keranjang as $row) { // Loop semua item keranjang
            $count += (int) ($row['jumlah'] ?? 1); // Tambahkan jumlah setiap produk
        }
    }
    return response()->json(['count' => $count]); // Kembalikan hasil dalam format JSON
})->name('keranjang.count');

// 🛒 Semua fitur keranjang & pemesanan — hanya untuk user login dengan role "user"
Route::middleware(['auth', 'role:user'])->group(function () { // Group fitur privat untuk pelanggan

    // 📌 Keranjang
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index'); // Halaman keranjang
    Route::post('/keranjang/tambah/{id}', [KeranjangController::class, 'tambah'])->name('keranjang.tambah'); // Tambah produk ke keranjang
    Route::post('/keranjang/ubah/{id}', [KeranjangController::class, 'ubah'])->name('keranjang.ubah'); // Ubah jumlah sewa produk
    Route::post('/keranjang/hapus-banyak', [KeranjangController::class, 'hapusBanyak'])->name('keranjang.hapusBanyak'); // Hapus beberapa produk sekaligus
    Route::delete('/keranjang/hapus/{key}', [KeranjangController::class, 'hapusByKey'])->name('keranjang.hapusByKey'); // Hapus 1 produk dari keranjang

    // 📌 Pemesanan & Checkout
    Route::get('/pemesanan/{id}', [PemesananController::class, 'show'])->name('pemesanan.show'); // Halaman pemesanan untuk 1 produk
    Route::post('/pemesanan', [PemesananController::class, 'store'])->name('pemesanan.store'); // Simpan pemesanan saat checkout
    Route::post('/pemesanan/confirm', [PemesananController::class, 'confirm'])->name('pemesanan.confirm'); // Konfirmasi pembayaran COD
    Route::post('/pemesanan/invoice', [PemesananController::class, 'storeInvoice'])->name('pemesanan.invoice.store'); // Checkout banyak item sekaligus (invoice)

    Route::post('/pemesanan/prepare', [\App\Http\Controllers\PemesananController::class, 'prepare'])
        ->name('pemesanan.prepare'); // Simpan data ke session sebelum masuk halaman pemesanan.blade.php

    Route::get('/pemesanan', [\App\Http\Controllers\PemesananController::class, 'create'])
        ->name('pemesanan.create'); // Halaman create checkout (selalu render pemesanan.blade.php)

    Route::patch('/pemesanan/{id}/batalkan', [PemesananController::class, 'batalkan'])
        ->name('pemesanan.batalkan');

    // 📌 Riwayat Pesanan
    Route::get('/riwayat', [PemesananController::class, 'riwayat'])->name('riwayat.semua'); // Halaman daftar riwayat pesanan user
    Route::get('/riwayat/pesanan', function () {
        return redirect()->route('riwayat.semua'); // Redirect untuk kompatibilitas (route lama → baru)
    })->name('pemesanan.riwayat');

    // 📌 Tambah ulasan produk (wajib login)
    Route::post('/ulasan', [UlasanController::class, 'store'])->name('ulasan.store'); // Proses penyimpanan ulasan
});

/*
|--------------------------------------------------------------------------
| ⚙️ Settings USER
|--------------------------------------------------------------------------
| Fitur pengaturan profil & password pelanggan. Hanya untuk user login.
*/
Route::middleware(['auth', 'role:user'])->group(function () { // Hanya untuk user yang sudah login
    Route::get('/pengaturan', [PengaturanUserController::class, 'index'])->name('pengaturan'); // Halaman pengaturan akun
    Route::post('/pengaturan/profil', [PengaturanUserController::class, 'updateProfile'])->name('pengaturan.profil.update'); // Update profil user
    Route::post('/pengaturan/password', [PengaturanUserController::class, 'updatePassword'])->name('pengaturan.password.update'); // Update password user
});

/*
|--------------------------------------------------------------------------
| 🧑‍💻 Area Admin
|--------------------------------------------------------------------------
| Semua route untuk admin, menggunakan prefix /admin dan role 'admin'.
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () { // Group khusus admin dengan prefix /admin

    Route::get('/beranda', [BerandaController::class, 'admin'])->name('admin.beranda'); // Dashboard admin

    // 📌 Manajemen transaksi
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('admin.transaksi'); // Halaman daftar transaksi
    Route::patch('/transaksi/{pemesanan}/status', [TransaksiController::class, 'updateStatus'])->name('admin.transaksi.updateStatus'); // Update status transaksi
    Route::get('/transaksi/export', [TransaksiController::class, 'export'])->name('admin.transaksi.export'); // Export data transaksi ke Excel

    // 📌 Manajemen produk
    Route::get('/produk', [ProdukController::class, 'adminIndex'])->name('admin.produk'); // Halaman kelola produk
    Route::post('/produk/tambah', [ProdukController::class, 'store'])->name('produk.store'); // Tambah produk baru
    Route::post('/produk/update/{id}', [ProdukController::class, 'update'])->name('produk.update'); // Update produk
    Route::delete('/produk/delete/{id}', [ProdukController::class, 'destroy'])->name('produk.destroy'); // Hapus produk
    Route::get('/produk/{id}/ketersediaan', [ProdukController::class, 'cekKetersediaanTanggal']) // 🔍 Cek stok per rentang tanggal
        ->name('admin.produk.ketersediaan');

    // 📌 Notifikasi pelanggan masuk
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('admin.notifikasi.index'); // Halaman notifikasi
    Route::post('/notifikasi/{id}/read', [NotifikasiController::class, 'markRead'])->name('admin.notifikasi.read'); // Tandai satu notifikasi terbaca
    Route::post('/notifikasi/read-all', [NotifikasiController::class, 'markAllRead'])->name('admin.notifikasi.readAll'); // Tandai semua notifikasi terbaca
    Route::post('/notifikasi/unread-all', [NotifikasiController::class, 'markAllUnread'])->name('admin.notifikasi.unreadAll'); // Tandai semua belum dibaca
    Route::delete('/notifikasi/{id}', [NotifikasiController::class, 'destroy'])->name('admin.notifikasi.destroy'); // Hapus satu notifikasi
    Route::delete('/notifikasi', [NotifikasiController::class, 'bulkDestroy'])->name('admin.notifikasi.bulkDestroy'); // Hapus banyak notifikasi sekaligus

    // 📌 Halaman statis pada panel admin
    Route::view('/pembayaran', 'admin.pembayaran')->name('admin.pembayaran'); // Halaman panduan pembayaran
    Route::view('/pesan', 'admin.pesan')->name('admin.pesan'); // Halaman pesan pesan khusus admin
    Route::view('/pengaturan', 'admin.pengaturan')->name('admin.pengaturan'); // Halaman pengaturan akun admin (tampilan)

    // 📌 Update data profil & password admin
    Route::prefix('settings')->as('admin.settings.')->group(function () { // Prefix admin/settings/*
        Route::post('/profile', [AdminPengaturanController::class, 'updateProfile'])->name('profile.update'); // Update profil admin
        Route::post('/password', [AdminPengaturanController::class, 'updatePassword'])->name('password.update'); // Update password admin
    });
});

/*
|--------------------------------------------------------------------------
| 💳 Midtrans Payment Routes
|--------------------------------------------------------------------------
| Digunakan untuk proses pembayaran Midtrans dan wajib dibiarkan publik
| agar Midtrans dapat mengirim webhook dan callback ke sistem.
*/
Route::get('/midtrans/token', [MidtransController::class, 'getSnapToken'])->name('midtrans.token'); // Mengambil Snap Token untuk mulai pembayaran
Route::view('/payment', 'payment')->name('payment'); // Tampilan halaman pembayaran
Route::get('/midtrans/finish', [MidtransController::class, 'finish'])->name('midtrans.finish'); // Callback setelah pembayaran berhasil/gagal
Route::post('/midtrans/notification', [MidtransController::class, 'notificationHandler'])
    ->name('midtrans.notification'); // Webhook notifikasi status pembayaran dari Midtrans