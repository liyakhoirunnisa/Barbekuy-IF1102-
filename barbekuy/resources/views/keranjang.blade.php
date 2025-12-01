<!DOCTYPE html> <!-- Deklarasi tipe dokumen HTML5 -->
<html lang="id"> <!-- HTML dengan bahasa Indonesia -->

<head>
  <meta charset="UTF-8"> <!-- Set karakter encoding ke UTF-8 -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Supaya responsif di perangkat mobile -->
  <title>Keranjang | Barbekuy</title> <!-- Judul tab browser -->

  {{-- Bootstrap & Icons --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> <!-- Import CSS Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"> <!-- Import Bootstrap Icons -->

  {{-- Google Font --}}
  <!-- Import font Poppins dari Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
    /* Mulai CSS internal */
    * {
      font-family: 'Poppins', sans-serif;
      /* Pakai font Poppins untuk semua elemen */
      box-sizing: border-box;
      /* Termasuk padding & border dalam perhitungan width/height */
    }

    html,
    body {
      margin: 0;
      /* Hilangkan margin default */
      padding: 0;
      /* Hilangkan padding default */
    }

    body {
      background-color: #f9f9f9;
      /* Warna latar belakang utama */
      color: #1a1a1a;
      /* Warna teks utama */
      overflow-x: hidden;
      /* Hilangkan scroll horizontal */
    }

    /* Navbar*/
    .navbar {
      background-color: #fff;
      /* Navbar putih */
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
      /* Sedikit bayangan bawah */
    }

    .nav-link {
      color: #1a1a1a !important;
      /* Warna link navbar */
      font-weight: 500;
      /* Tebal sedang */
    }

    .nav-link:hover {
      color: #751A25 !important;
      /* Warna link saat hover */
    }

    /* =======================
    KERANJANG – MOBILE FIRST
    ======================= */

    .cart-container {
      padding: 32px 0 48px 0;
      /* Padding atas dan bawah konten keranjang */
      min-height: 75vh;
      /* Minimal tinggi 75% layar */
    }

    /* Card item */
    .item-keranjang {
      background-color: #ffffff;
      /* Latar belakang putih untuk card item */
      border-radius: 14px;
      /* Sudut membulat */
      padding: 14px 16px;
      /* Spasi dalam card */
      margin-bottom: 16px;
      /* Jarak antar item */
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
      /* Bayangan halus */
      border: 1px solid #f0f0f0;
      /* Garis pinggir tipis */
      display: flex;
      /* Layout fleksibel */
      flex-wrap: wrap;
      /* Boleh turun ke baris berikutnya jika sempit */
      gap: 14px;
      /* Jarak antar elemen di dalamnya */
    }

    /* BLOK KIRI: checkbox + nama + gambar (HP: vertikal) */
    .left-block {
      display: flex;
      /* Gunakan flexbox */
      flex-direction: column;
      /* Susunan vertikal (atas-bawah) di HP */
      gap: 8px;
      /* Jarak antar elemen */
    }

    .title-row {
      display: flex;
      /* Baris judul dengan flex */
      align-items: center;
      /* Vertikal sejajar */
      gap: 8px;
      /* Jarak antara checkbox dan teks */
    }

    .item-keranjang .checkbox,
    #selectAll {
      flex: 0 0 auto;
      /* Lebar tidak melar */
      cursor: pointer;
      /* Kursor jadi tangan */
      accent-color: #751A25;
      /* Warna centang untuk checkbox (browser yang support) */
      width: 1.2rem;
      /* Lebar checkbox */
      height: 1.2rem;
      /* Tinggi checkbox */
    }

    .nama-produk {
      font-weight: 600;
      /* Teks nama produk lebih tebal */
      font-size: 1rem;
      /* Ukuran font nama produk */
      color: #1a1a1a;
      /* Warna teks */
    }

    .nama-mobile {
      display: inline;
      /* Nama untuk tampilan mobile ditampilkan */
      /* default: tampil di HP */
    }

    .nama-desktop {
      display: none;
      /* Nama versi desktop disembunyikan di HP */
      /* default: sembunyi di HP */
    }

    .product-img {
      width: 90px;
      /* Lebar gambar produk di HP */
      height: 90px;
      /* Tinggi gambar produk di HP */
      border-radius: 10px;
      /* Sudut gambar membulat */
      object-fit: cover;
      /* Crop gambar agar memenuhi kotak */
    }

    /* BLOK KANAN: tanggal + qty + harga */
    .detail-item {
      flex: 1 1 180px;
      /* Bisa melebar, minimal lebar 180px */
      min-width: 0;
      /* Supaya flex tidak memaksa lebar minimum besar */
      display: flex;
      /* Gunakan flexbox */
      flex-direction: column;
      /* Susunan vertikal */
      gap: 8px;
      /* Jarak antar baris detail */
    }

    .info-sewa {
      display: flex;
      /* Baris info sewa dengan flexbox */
      align-items: center;
      /* Tengah vertikal */
      gap: 6px;
      /* Jarak antar elemen */
      flex-wrap: nowrap;
      /* Default tidak turun baris */
      overflow: hidden;
      /* Potong jika kepanjangan */
    }

    .info-sewa .form-control {
      width: 110px;
      /* Lebar input tanggal awalnya */
      max-width: 40vw;
      /* Maksimal 40% lebar viewport */
      min-width: 85px;
      /* Minimum lebar input */
      font-size: 0.8rem;
      /* Ukuran font input lebih kecil */
      padding-inline: 6px;
      /* Padding kiri-kanan kecil */
    }

    .info-sewa span {
      font-size: 1rem;
      /* Ukuran teks kecil (misal "sampai") */
    }

    .status-simpan {
      font-size: 0.75rem;
      /* Teks status kecil (misal "Belum disimpan") */
      margin-top: 2px;
      /* Jarak dari elemen di atas */
      display: none;
      /* Default disembunyikan, nanti ditampilkan via JS */
    }

    /* Baris qty + harga (HP: harga di bawah qty) */
    .bottom-row {
      margin-top: 4px;
      /* Jarak dari elemen atasnya */
      display: flex;
      /* Flex container */
      flex-direction: column;
      /* Di HP susun vertikal */
      /* HP: vertikal */
      align-items: flex-end;
      /* Elemen rata ke kanan */
      gap: 10px;
      /* Jarak antara qty dan harga */
    }

    .kontrol-jumlah {
      display: flex;
      /* Baris kontrol jumlah (minus, input, plus) */
      align-items: center;
      /* Tengah vertikal */
      gap: 8px;
      /* Jarak antar tombol dan input */
    }

    .kontrol-jumlah button {
      background: none;
      /* Tombol tanpa background */
      border: none;
      /* Tanpa border */
      font-size: 1.3rem;
      /* Ukuran ikon + / - */
      color: #777;
      /* Warna abu-abu tombol */
      transition: 0.2s;
      /* Transisi untuk hover */
      line-height: 1;
      /* Tinggi baris normal */
    }

    .kontrol-jumlah button:hover {
      color: #751A25;
      /* Warna saat hover */
    }

    .kontrol-jumlah input {
      width: 40px;
      /* Lebar input jumlah */
      text-align: center;
      /* Angka di tengah */
      border: 1px solid #ccc;
      /* Border abu muda */
      border-radius: 5px;
      /* Sudut membulat */
      font-size: 0.9rem;
      /* Ukuran font */
      padding: 2px 4px;
      /* Padding dalam input */
      background-color: #fff;
      /* Latar putih */
    }

    .harga-item {
      font-weight: 700;
      /* Harga tebal */
      font-size: 1.05rem;
      /* Ukuran font harga */
      color: #751A25;
      /* Warna harga */
      text-align: right;
      /* Rata kanan */
    }

    /* Checkbox “Semua” & total */
    .bagian-total {
      background-color: #fafafa;
      /* Latar belakang bagian total */
      border-radius: 16px;
      /* Sudut membulat */
      padding: 25px 35px;
      /* Spasi dalam box total */
      display: flex;
      /* Flex untuk susun kiri-kanan */
      justify-content: space-between;
      /* Jarak antara kiri (checkbox) dan kanan (total) */
      align-items: center;
      /* Tengah vertikal */
      font-weight: 600;
      /* Teks agak tebal */
      margin-top: 40px;
      /* Jarak dari item paling atas */
      font-size: 1.2rem;
      /* Ukuran font umum */
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
      /* Bayangan halus */
    }

    .bagian-total .form-check {
      margin: 0;
      /* Hilangkan margin default bootstrap */
      display: flex;
      /* Flex supaya checkbox dan label sejajar */
      align-items: center;
      /* Tengah vertikal */
      gap: 6px;
      /* Jarak antara checkbox dan label */
      padding-left: 0;
      /* Hapus padding kiri bawaan Bootstrap */
      /* ⬅️ hapus padding bawaan Bootstrap */
    }

    /* deretan total + ikon hapus + tombol di kanan, lebih rapat */
    .bagian-total .d-flex.align-items-center.gap-3 {
      justify-content: flex-end;
      /* Semua elemen kanan ngumpul di kanan */
      /* ikon & tombol ngumpul di kanan */
      width: auto;
      /* Lebarnya mengikuti konten */
      gap: 12px;
      /* Jarak antar elemen dikurangi */
      /* jarak antar elemen lebih dekat */
    }

    /* kasih jarak sedikit antara teks "Semua" dan Rp... */
    #totalHarga {
      margin-left: 8px;
      /* Jarak kiri dari teks sebelumnya */
    }

    /* Tombol Checkout */
    .btn-primary-custom {
      background-color: #751A25;
      /* Warna utama tombol */
      color: #fff !important;
      /* Teks putih */
      border: none;
      /* Tanpa border */
      border-radius: 8px;
      /* Sudut membulat */
      transition: background-color .2s, transform .1s;
      /* Animasi saat hover/klik */
      font-weight: 600;
      /* Teks agak tebal */
      box-shadow: none !important;
      /* Hilangkan shadow default Bootstrap */
      outline: none !important;
      /* Hilangkan outline focus */
      font-size: 0.95rem;
      /* Ukuran font */
    }

    .btn-disabled {
      background-color: #ccc !important;
      /* Warna tombol jika disabled */
      color: #666 !important;
      /* Teks abu-abu */
      pointer-events: none;
      /* Tidak bisa diklik */
      cursor: not-allowed;
      /* Kursor tanda dilarang */
    }

    .btn-primary-custom:hover {
      background-color: #751A25;
      /* Tetap warna utama saat hover */
      color: #fff !important;
      /* Teks tetap putih */
    }

    .btn-primary-custom:focus,
    .btn-primary-custom:active,
    .btn-primary-custom:focus-visible {
      outline: none !important;
      /* Hilangkan outline saat aktif/fokus */
      color: #fff !important;
      /* Teks putih */
    }

    .btn-primary-custom.bold-active {
      background-color: #751A25;
      /* Warna tombol saat status aktif */
      font-weight: 700;
      /* Lebih tebal */
      box-shadow: none !important;
      /* Tanpa bayangan tambahan */
      color: #fff !important;
      /* Teks putih */
    }

    .btn-primary-custom.bold-active:hover,
    .btn-primary-custom.bold-active:active,
    .btn-primary-custom.bold-active:focus,
    .btn-primary-custom.bold-active:focus-visible {
      background-color: #a00000 !important;
      /* Warna lebih gelap saat hover/aktif */
      box-shadow: none !important;
      /* Tanpa bayangan */
      outline: none !important;
      /* Tanpa outline */
      color: #fff !important;
      /* Teks putih */
    }

    .btn-delete-custom {
      color: #751A25;
      /* Warna tombol delete (ikon) */
    }

    .btn-delete-custom i {
      color: #751A25;
      /* Warna ikon delete */
      line-height: 1;
      /* Tinggi baris normal */
    }

    /* =========================
       Tambahan style pindahan dari inline
       ========================= */

    #totalSection {
      display: none;
      /* Bagian total disembunyikan awalnya, nanti dimunculkan via JS */
    }

    #bulkDeleteBtn {
      display: none;
      /* Tombol hapus massal disembunyikan awalnya, sama seperti inline sebelumnya */
    }

    #confirmDeleteModal .modal-content {
      border-radius: 16px;
      /* Samakan radius modal dengan inline style sebelumnya */
    }

    #confirmDeleteBtn {
      background-color: #751A25;
      /* Warna background tombol hapus di modal, sebelumnya inline */
    }

    #bulkDeleteBtn i {
      font-size: 2rem;
      /* Ukuran ikon trash default di desktop (sebelum override di media query) */
    }

    /* =========================
           Padding responsif container
           ========================= */
    @media (max-width: 992px) {

      /* Aturan untuk layar <= 992px (tablet & HP besar) */
      .cart-container {
        padding-left: 18px !important;
        /* Kurangi padding kiri */
        padding-right: 18px !important;
        /* Kurangi padding kanan */
      }
    }

    /* ≥ 576px – sedikit longgar untuk tablet kecil */
    @media (min-width: 576px) {

      /* Aturan untuk layar >= 576px */
      .info-sewa {
        flex-direction: row;
        /* Susun kembali jadi baris */
        flex-wrap: wrap;
        /* Boleh turun baris jika penuh */
        align-items: center;
        /* Tengah vertikal */
      }

      .info-sewa .form-control {
        width: auto !important;
        /* Biarkan lebar otomatis */
        max-width: 180px;
        /* Maksimal lebar input */
        display: inline-block;
        /* Tampilkan seperti inline block */
      }
    }

    /* =======================================================
           ≥ 768px (DESKTOP) – SAMA SEPERTI TAMPILAN KODE KEDUA
           ======================================================= */
    @media (min-width: 768px) {

      /* Aturan untuk layar >= 768px (desktop kecil ke atas) */
      body {
        background-color: #fff;
        /* Ubah latar belakang jadi putih di desktop */
      }

      .cart-container {
        padding: 25px 0;
        /* Sesuaikan padding atas-bawah */
      }

      .item-keranjang {
        background-color: transparent;
        /* Hilangkan latar putih, ikut background body */
        border-radius: 0;
        /* Sudut tidak membulat */
        box-shadow: none;
        /* Hilangkan bayangan */
        border: 0;
        /* Tanpa border kotak */
        border-bottom: 1px solid #eaeaea;
        /* Garis bawah sebagai pemisah item */
        margin-bottom: 0;
        /* Hilangkan margin bawah */

        display: flex;
        /* Tetap flex */
        align-items: center;
        /* Tengah vertikal */
        padding: 25px 0;
        /* Padding atas-bawah item */
        gap: 15px;
        /* Jarak antar bagian */

        /* ✅ supaya bottom-row bisa diposisikan di kanan */
        position: relative;
        /* Supaya bottom-row bisa di-posisi absolut */
        padding-right: 190px;
        /* Sediakan ruang di kanan untuk qty + harga */
        /* ruang buat qty + harga di kanan */
      }

      /* kiri: checkbox + gambar sejajar */
      .left-block {
        flex-direction: row;
        /* Di desktop susun horizontal */
        align-items: center;
        /* Tengah vertikal */
        gap: 15px;
        /* Jarak antara checkbox, gambar, dan nama */
      }

      .title-row {
        display: flex;
        /* Tetap gunakan flex */
        align-items: center;
        /* Tengah vertikal */
        gap: 8px;
        /* Jarak antar elemen */
      }

      .product-img {
        width: 120px;
        /* Gambar lebih besar di desktop */
        height: auto;
        /* Tinggi menyesuaikan proporsi */
        border-radius: 12px;
        /* Sudut lebih membulat sedikit */
        object-fit: cover;
        /* Crop gambar agar penuh */
      }

      .nama-mobile {
        display: none;
        /* Sembunyikan nama versi mobile di desktop */
      }

      .nama-desktop {
        display: block;
        /* Tampilkan nama produk versi desktop */
        margin-bottom: 2px;
        /* Jarak bawah kecil */
        /* 🔁 tadinya 4px */
        font-weight: 600;
        /* Teks tebal */
        font-size: 1rem;
        /* Ukuran font normal */
        color: #1a1a1a;
        /* Warna teks */
      }

      .detail-item {
        flex: 1;
        /* Ambil ruang yang tersisa */
        margin-left: 20px;
        /* Jarak dari blok kiri */
        gap: 4px;
        /* Jarak antar elemen detail */
        /* biar teks tidak ketimpa bottom-row */
        padding-right: 10px;
        /* Jarak kanan agar tidak mentok bottom-row */
      }

      .info-sewa {
        font-size: 0.9rem;
        /* Ukuran font sedikit kecil */
        color: #666;
        /* Warna teks abu */
        display: flex;
        /* Flex untuk info sewa */
        align-items: center;
        /* Tengah vertikal */
        gap: 10px;
        /* Jarak antar elemen */
        margin-top: 0px;
        /* Hilangkan margin atas */
      }

      .info-sewa i {
        color: #751A25;
        /* Warna ikon pada info sewa */
      }

      .kontrol-jumlah {
        display: flex;
        /* Tetap flex */
        align-items: center;
        /* Tengah vertikal */
        gap: 8px;
        /* Jarak antar elemen */
        /* ❌ hapus margin-right besar */
        margin-right: 0;
        /* Hapus margin kanan besar */
      }

      .kontrol-jumlah input {
        width: 35px;
        /* Sedikit lebih kecil di desktop */
      }

      /* ✅ qty + harga sejajar & berada di tengah baris item */
      .bottom-row {
        margin-top: 0;
        /* Hilangkan margin atas */
        display: flex;
        /* Flex container */
        flex-direction: row;
        /* Susun horizontal di desktop */
        align-items: center;
        /* Tengah vertikal */
        justify-content: flex-end;
        /* Rata kanan */
        gap: 24px;
        /* Jarak antara qty dan harga */

        position: absolute;
        /* Posisi absolut terhadap item-keranjang */
        right: 0;
        /* Menempel di sisi kanan */
        top: 50%;
        /* Tengah vertikal */
        transform: translateY(-50%);
        /* Benar-benar di tengah item */
      }

      .harga-item {
        font-weight: 700;
        /* Harga tebal */
        font-size: 1.1rem;
        /* Sedikit lebih besar di desktop */
        color: #751A25;
        /* Warna harga */
        text-align: right;
        /* Rata kanan */
        min-width: 130px;
        /* Lebar minimal agar angka tidak terpotong */
      }
    }

    /* PHONE KECIL < 480px */
    @media (max-width: 480px) {

      /* Aturan untuk HP kecil */
      .nama-produk {
        font-size: 0.95rem;
        /* Kecilkan font nama produk */
      }

      .harga-item {
        font-size: 1rem;
        /* Kecilkan font harga */
      }

      .cart-container {
        padding-top: 24px;
        /* Sedikit kurangi padding atas */
      }
    }

    /* === KHUSUS TAMPILAN TOTAL DI HP === */
    @media (max-width: 768px) {

      /* Aturan untuk HP & tablet kecil */
      .bagian-total {
        padding: 14px 18px;
        /* Kurangi padding di HP */
        display: flex;
        /* Flex layout */
        flex-direction: row;
        /* Susun horizontal */
        align-items: center;
        /* Tengah vertikal */
        justify-content: space-between;
        /* Checkbox di kiri, total di kanan */
        gap: 10px;
        /* Jarak antar blok */
        flex-wrap: nowrap;
        /* Tetap satu baris, jangan turun */
        /* ⬅️ semua tetap di satu baris */
      }

      .bagian-total .form-check {
        margin: 0;
        /* Hilangkan margin */
        display: flex;
        /* Flex untuk checkbox + label */
        align-items: center;
        /* Tengah vertikal */
        gap: 6px;
        /* Jarak antara checkbox dan label */
        flex: 0 0 auto;
        /* Lebar secukupnya di kiri */
        /* ⬅️ lebar secukupnya di kiri */
      }

      /* kecilkan tulisan "Semua" */
      .bagian-total .form-check-label {
        font-size: 0.85rem !important;
        /* Font label dibuat lebih kecil */
      }

      /* kanan: total + icon + tombol, segaris */
      .bagian-total .d-flex.align-items-center.gap-3 {
        flex: 1 1 auto;
        /* Ambil sisa ruang di kanan */
        /* ⬅️ ambil sisa ruang di kanan */
        justify-content: flex-end;
        /* Rata kanan */
        gap: 6px;
        /* Jarak lebih rapat antar elemen */
        flex-wrap: nowrap;
        /* Jangan turun baris */
        /* ⬅️ jangan turun baris */
      }

      #totalHarga {
        margin-left: 10px;
        /* Jarak kiri dari teks sebelumnya */
        font-size: 0.9rem;
        /* Perkecil font total harga */
      }

      #bulkDeleteBtn {
        padding: 0;
        /* Buat tombol hapus lebih kecil */
      }

      #bulkDeleteBtn i {
        font-size: 1rem !important;
        /* Ukuran ikon hapus di HP (override 2rem) */
      }

      .bagian-total .btn-primary-custom {
        font-size: 0.85rem;
        /* Kecilkan font tombol pesan */
        padding: 4px 12px !important;
        /* Perkecil padding tombol */
        white-space: nowrap;
        /* Jangan pecah ke bawah */
        flex-shrink: 0;
        /* Jangan mengecil saat sempit */
      }
    }
  </style> <!-- Akhir CSS internal -->
</head> <!-- Akhir bagian head -->

<body> <!-- Awal body halaman -->
  @include('layouts.navbar') <!-- Menyertakan file navbar dari folder layouts (navbar tampil di atas) -->

  {{-- Section utama untuk isi keranjang, pakai class cart-container + container Bootstrap --}}
  <section class="cart-container container">
    {{-- Loop setiap item keranjang; kalau kosong nanti masuk ke @empty --}}
    @forelse ($keranjang as $key => $barang)


    @php // Mulai blok PHP untuk hitung data tiap item keranjang
    // Ambil data produk dari database berdasarkan id_produk yang ada di keranjang
    $produk = \App\Models\Produk::where('id_produk', $barang['produk_id'])->first();

    $mulai = $barang['tanggal_mulai'] ?? null; //Ambil tanggal mulai sewa dari data keranjang (jika ada), kalau tidak ada nilainya null

    // Ambil tanggal pengembalian sewa dari data keranjang (jika ada), kalau tidak ada nilainya null
    $akhir = $barang['tanggal_pengembalian'] ?? null;

    $diffSec = 0; // Inisialisasi selisih waktu dalam detik

    if ($mulai && $akhir) { // Jika kedua tanggal (mulai & akhir) terisi
    $diffSec = max(0, strtotime($akhir) - strtotime($mulai)); // Hitung selisih detik antara akhir dan mulai, pastikan minimal 0
    }

    $durasiAwal = max(1, (int) floor($diffSec / 86400)); // Konversi selisih detik ke jumlah hari (86400 detik = 1 hari), minimal 1 hari
    $subtotalAwal = ($produk->harga ?? 0) * ($barang['jumlah'] ?? 1) * $durasiAwal; // Hitung subtotal dengan default 0/1 jika data tidak ada
    @endphp

    <div class="item-keranjang"
      data-id="{{ $barang['produk_id'] }}" {{-- Simpan ID produk di atribut data-id (untuk JS) --}}
      data-key="{{ $key }}" {{-- Simpan index item keranjang --}}
      data-harga="{{ $produk->harga }}" {{-- Simpan harga satuan produk (untuk perhitungan JS) --}}
      data-durasi="{{ $durasiAwal }}"> {{-- Simpan durasi awal sewa (hari) --}}

      {{-- BLOK KIRI: checkbox + nama (HP) + gambar --}}
      <div class="left-block"> <!-- Blok kiri: checkbox + nama (versi mobile) + gambar -->
        <div class="title-row"> <!-- Baris judul: checkbox + nama -->
          <input type="checkbox" class="checkbox" value="{{ $key }}"> <!-- Checkbox untuk pilih item keranjang -->
          <span class="nama-produk nama-mobile">{{ $produk->nama_produk }}</span> <!-- Nama produk tampil di HP -->
        </div>

        {{-- Gambar produk dari storage --}}
        <img src="{{ asset('storage/' . $produk->gambar) }}"
          alt="{{ $produk->nama_produk }}"
          class="product-img">
      </div>

      {{-- BLOK KANAN: nama (desktop) + tanggal + qty + harga --}}
      <div class="detail-item"> <!-- Blok kanan: detail sewa, qty, dan harga -->
        <div class="nama-produk nama-desktop"> <!-- Nama produk versi desktop (disembunyikan di HP) -->
          {{ $produk->nama_produk }}
        </div>

        <div class="info-sewa"> <!-- Baris info sewa: icon kalender + 2 tanggal -->
          <i class="bi bi-calendar"></i> <!-- Icon kalender Bootstrap Icons -->
          <!-- Input tanggal mulai, kecil & inline, Isi default tanggal mulai dari keranjang -->
          <input type="date"
            class="form-control form-control-sm d-inline-block w-auto"
            value="{{ $barang['tanggal_mulai'] }}"
            name="tanggal_mulai"> <!-- Name untuk identifikasi di JS / form -->
          <span>–</span> <!-- Tanda strip di antara dua tanggal -->
          <!-- Input tanggal pengembalian, Isi default tanggal pengembalian -->
          <input type="date"
            class="form-control form-control-sm d-inline-block w-auto"
            value="{{ $barang['tanggal_pengembalian'] }}"
            name="tanggal_pengembalian">

          <small class="status-simpan ms-2 text-muted">Menyimpan…</small> <!-- Teks kecil untuk status "Menyimpan…" (default hidden via CSS) -->
        </div>

        <div class="bottom-row"> <!-- Baris bawah: kontrol jumlah & subtotal harga -->
          <div class="kontrol-jumlah"> <!-- Kontrol jumlah (minus, input, plus) -->
            <button class="kurang">−</button> <!-- Tombol kurang jumlah -->
            <input type="text" value="{{ $barang['jumlah'] }}" readonly> <!-- Tampilkan jumlah sewa (readonly) -->
            <button class="tambah">+</button> <!-- Tombol tambah jumlah -->
          </div>

          <div class="harga-item"> <!-- Area tampilan subtotal per item -->
            Rp{{ number_format($subtotalAwal, 0, ',', '.') }} <!-- Subtotal: harga×jumlah×durasi, diformat rupiah -->
          </div>
        </div>
      </div>
    </div>
    {{-- Jika $keranjang kosong (tidak ada item) --}}
    @empty
    <p class="text-center text-muted mt-5">Keranjang Anda masih kosong 🛒</p>
    {{-- Pesan keranjang kosong --}}
    @endforelse
    {{-- Akhir loop @forelse --}}

    {{-- Bagian Total --}}
    <div id="totalSection" class="bagian-total">
      <!-- ✅ Select All -->
      <div class="form-check m-0 d-flex align-items-center gap-2"> <!-- Checkbox "Semua" + label sejajar -->
        <input type="checkbox" id="selectAll"> <!-- Checkbox untuk pilih semua item keranjang -->
        <label class="form-check-label" for="selectAll" style="user-select:none;">Semua</label> <!-- Label "Semua" -->
      </div>
      <div class="d-flex align-items-center gap-3"> <!-- Kanan: total harga + tombol hapus + tombol pesan -->
        <span id="totalHarga">Rp0</span> <!-- Tempat menampilkan total harga semua item terpilih -->

        {{-- tombol hapus massal: hanya muncul saat ada item terpilih --}}
        <button id="bulkDeleteBtn" type="button"
          class="btn btn-delete-custom px-1 py-1 d-inline-flex align-items-center">
          <i class="bi bi-trash"></i> <!-- Ikon trash besar untuk hapus massal (ukuran diatur via CSS) -->
        </button>

        <a href="#" id="checkoutBtn" class="btn btn-primary-custom px-4 py-2">Pesan</a> <!-- Tombol lanjut ke proses pesan/checkout -->
      </div>
    </div>

    <!-- 🗑️ Modal Konfirmasi Hapus -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered"> <!-- Modal di tengah layar -->
        <div class="modal-content border-0 shadow-sm rounded-4">
          <div class="modal-body text-center p-4"> <!-- Isi modal rata tengah -->
            <h5 class="fw-semibold text-danger mb-3" style="color:#751A25 !important;">
              Konfirmasi Hapus Produk <!-- Judul modal -->
            </h5>
            <p class="text-secondary mb-4" id="deleteConfirmText">
              Apakah kamu yakin ingin menghapus produk ini? <!-- Pesan konfirmasi (bisa diubah JS untuk single/mass delete) -->
            </p>

            <div class="d-flex justify-content-center gap-3"> <!-- Baris tombol di dalam modal -->
              <button type="button" class="btn btn-outline-secondary px-4 py-2 rounded-3"
                data-bs-dismiss="modal">Batal</button> <!-- Tombol batal, menutup modal -->
              <button type="button" id="confirmDeleteBtn"
                class="btn px-4 py-2 rounded-3 text-white">Hapus</button> <!-- Tombol konfirmasi hapus (aksi di-handle JS) -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </section> <!-- Akhir section cart-container -->

  {{-- Script --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> <!-- JS Bootstrap (modal dll) -->
  <script>
    const tombolCheckout = document.getElementById('checkoutBtn'); // Tombol "Pesan"
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn'); // Tombol hapus massal

    if (bulkDeleteBtn) { // Kalau elemen tombol hapus massal ada
      bulkDeleteBtn.classList.add('d-none'); // Sembunyikan dengan class Bootstrap
      bulkDeleteBtn.style.display = 'none'; // Sekalian display:none
      bulkDeleteBtn.setAttribute('aria-hidden', 'true'); // Tandai tidak terlihat untuk accessibility
    }

    // ==== Helpers ====
    const toDateUTC = (yyyyMMdd) => new Date(yyyyMMdd + 'T00:00:00Z'); // Ubah string 'YYYY-MM-DD' jadi Date UTC
    const rupiah = (n) => `Rp${(Number(n) || 0).toLocaleString('id-ID')}`; // Format angka ke Rupiah dengan locale id-ID

    const hitungDurasiHari = (mulaiRaw, akhirRaw) => { // Hitung selisih hari antara tanggal mulai & selesai
      if (!mulaiRaw || !akhirRaw) return 1; // Kalau salah satu kosong, pakai default 1 hari
      const start = toDateUTC(mulaiRaw); // Tanggal mulai
      const end = toDateUTC(akhirRaw); // Tanggal akhir
      const MS = 24 * 60 * 60 * 1000; // Jumlah ms dalam 1 hari
      const diff = (end - start) / MS; // Selisih dalam hari
      return Math.max(1, Math.round(diff)); // Minimal 1 hari, dibulatkan
    };

    function clampQty(v) { // Pastikan qty selalu angka >= 1
      const n = parseInt(String(v).replace(/[^\d]/g, ''), 10); // Ambil digit saja lalu parseInt
      return Math.max(1, isNaN(n) ? 1 : n); // Kalau bukan angka, pakai 1
    }

    function debounce(fn, delay = 500) { // Helper untuk tunda eksekusi (debounce)
      let t; // Timer internal
      return (...args) => { // Kembalikan fungsi baru
        clearTimeout(t); // Reset timer setiap dipanggil
        t = setTimeout(() => fn(...args), delay); // Jalanin fn setelah delay
      };
    }

    // === FIX 1: Helper fetch aman JSON/non-JSON + kirim cookie & CSRF ===
    async function fetchJSON(url, { // Wrapper fetch dengan handling JSON + CSRF
      method = 'GET',
      body,
      headers = {}
    } = {}) {
      const finalHeaders = { // Gabung header default + custom
        'Accept': 'application/json', // Minta respons berupa JSON
        'Content-Type': 'application/json', // Kirim data JSON
        'X-CSRF-TOKEN': '{{ csrf_token() }}', // Kirim token CSRF Laravel
        ...headers // Override jika ada header custom
      };

      let res;
      try {
        res = await fetch(url, { // Panggil fetch ke server
          method,
          headers: finalHeaders,
          body,
          credentials: 'same-origin', // penting untuk bawa cookie sesi
        });
      } catch (e) {
        return { // Kalau network error, balikin objek error standar
          ok: false,
          networkError: true,
          status: 0,
          data: null,
          text: 'Network error'
        };
      }

      // Coba parse JSON; jika gagal, fallback ke text agar tidak melempar
      let data = null,
        text = null;
      const ct = res.headers.get('content-type') || ''; // Ambil content-type respons
      if (ct.includes('application/json')) { // Kalau JSON
        try {
          data = await res.json(); // Parse JSON
        } catch {
          data = null;
        }
      } else { // Kalau bukan JSON
        try {
          text = await res.text(); // Baca sebagai teks biasa
        } catch {
          text = null;
        }
      }

      return { // Kembalikan bentuk seragam
        ok: res.ok,
        status: res.status,
        data,
        text
      };
    }

    // === CEK STOK KE SERVER ===
    async function cekStokItem(id, tanggalMulai, tanggalPengembalian, jumlah) {
      const resp = await fetchJSON(
        `{{ url('/produk') }}/${encodeURIComponent(id)}/stok-tersedia`, {
          method: 'POST',
          body: JSON.stringify({
            tanggal_mulai: tanggalMulai,
            tanggal_pengembalian: tanggalPengembalian,
            jumlah: jumlah
          })
        }
      );

      if (!resp.ok || !resp.data) {
        return {
          ok: false,
          bisa: false,
          stokTersedia: null,
          message: 'Gagal mengecek stok.'
        };
      }

      const d = resp.data;
      return {
        ok: true,
        bisa: d.bisa_dipesan !== false,
        stokTersedia: d.stok_tersedia ?? null,
        message: d.message
      };
    }

    async function updateQtyOnServer(item, id, jumlah, tanggalMulai, tanggalPengembalian) {
      const key = item.dataset.key; // Ambil key item dari atribut data-key
      const resp = await fetchJSON(`/keranjang/ubah/${encodeURIComponent(id)}`, { // Panggil endpoint update keranjang
        method: 'POST',
        body: JSON.stringify({ // Kirim data ke server untuk update keranjang
          key,
          jumlah,
          tanggal_mulai: tanggalMulai,
          tanggal_pengembalian: tanggalPengembalian
        })
      });

      if (resp.data && resp.data.new_key) { // Kalau server kirim key baru
        item.dataset.key = resp.data.new_key; // sinkron key baru ke DOM
        const cb = item.querySelector('.checkbox'); // Update value checkbox juga
        if (cb) cb.value = resp.data.new_key;
      }
      return resp; // ← consistent: { ok, status, data }
    }

    function updateTotalSelected() { // Hitung total harga dari item yang dicentang
      let total = 0;
      const checked = Array.from(document.querySelectorAll('.checkbox:checked')); // Ambil semua checkbox terpilih
      checked.forEach(cb => {
        const item = cb.closest('.item-keranjang'); // Ambil card item keranjang
        const sub = parseInt(item.querySelector('.harga-item').innerText.replace(/[^\d]/g, '')) || 0; // Ambil angka dari teks harga
        total += sub; // Tambahkan ke total
      });

      document.getElementById('totalHarga').innerText = rupiah(total); // Tampilkan total dalam format Rupiah

      const anySelected = checked.length > 0; // Apakah ada item yang terpilih?

      // === Tampilkan/sembunyikan kotak total secara keseluruhan ===
      const totalSection = document.getElementById('totalSection');
      if (totalSection) {
        totalSection.style.display = anySelected ? 'flex' : 'none'; // Muncul hanya jika ada item terpilih
      }

      // Tombol Checkout
      tombolCheckout.classList.toggle('bold-active', anySelected); // Aktifkan style bold-active jika ada pilihan
      tombolCheckout.classList.toggle('btn-disabled', !anySelected); // Nonaktifkan jika tidak ada pilihan
      tombolCheckout.setAttribute('aria-disabled', String(!anySelected)); // Untuk accessibility

      // Tombol hapus massal
      if (bulkDeleteBtn) {
        bulkDeleteBtn.classList.toggle('d-none', !anySelected); // Sembunyikan/ tampilkan
        bulkDeleteBtn.style.display = anySelected ? 'inline-flex' : 'none'; // Atur display
        bulkDeleteBtn.setAttribute('aria-hidden', String(!anySelected)); // Flag ARIA
        bulkDeleteBtn.disabled = !anySelected; // Disable secara fungsional
      }
    }

    // ===== Checkbox listener =====
    document.querySelectorAll('.checkbox').forEach(cb => {
      cb.addEventListener('change', updateTotalSelected); // Setiap centang berubah, hitung ulang total
    });

    // ===== Qty (+ / −) dan ketik manual =====
    const debouncedTypeUpdate = debounce(async (item, id, jumlah) => { // Handler qty yang diketik manual (debounce)
      const tanggalMulai = item.querySelector('input[name="tanggal_mulai"]').value; // Ambil tanggal mulai
      const tanggalPengembalian = item.querySelector('input[name="tanggal_pengembalian"]').value; // Ambil tanggal kembali
      const qtyInput = item.querySelector('.kontrol-jumlah input'); // Input qty untuk item ini

      // 🧮 Cek stok dulu ke server
      const stokInfo = await cekStokItem(id, tanggalMulai, tanggalPengembalian, jumlah);
      if (!stokInfo.ok) {
        alert(stokInfo.message || 'Gagal mengecek stok.');
        return;
      }
      if (!stokInfo.bisa) {
        const maxQty = stokInfo.stokTersedia ?? jumlah;
        alert(stokInfo.message || `Stok tidak mencukupi. Maksimal ${maxQty} unit.`);
        qtyInput.value = maxQty;
        jumlah = maxQty;
      }

      // Optimistic subtotal
      const harga = Number(item.dataset.harga || 0); // Harga satuan dari data attribute
      const durasi = hitungDurasiHari(tanggalMulai, tanggalPengembalian); // Hitung durasi hari
      const subLoc = harga * durasi * jumlah; // Subtotal lokal (sementara)
      item.querySelector('.harga-item').innerText = rupiah(subLoc); // Tampilkan subtotal sementara
      updateTotalSelected(); // Update total global

      const resp = await updateQtyOnServer(item, id, jumlah, tanggalMulai, tanggalPengembalian); // Kirim ke server
      if (!resp.ok) return; // diam, biar user coba lagi
      const {
        data
      } = resp;
      if (data && data.success) { // Kalau server konfirmasi sukses
        const sub = (typeof data.subtotal === 'number') ? data.subtotal : subLoc; // Pakai subtotal dari server jika ada
        item.querySelector('.harga-item').innerText = rupiah(sub); // Update subtotal dengan nilai final
        updateTotalSelected(); // Hitung ulang total
        window.dispatchEvent(new Event('cart:updated')); // Trigger event global (misal untuk navbar badge)
      }
    }, 450);


    document.querySelectorAll('.item-keranjang').forEach(item => { // Untuk setiap item keranjang
      const id = item.dataset.id; // ID produk
      const btnMinus = item.querySelector('.kurang'); // Tombol minus
      const btnPlus = item.querySelector('.tambah'); // Tombol plus
      const qtyInput = item.querySelector('.kontrol-jumlah input'); // Input jumlah

      if (qtyInput && qtyInput.hasAttribute('readonly')) qtyInput.removeAttribute('readonly'); // Boleh diketik manual
      qtyInput.value = clampQty(qtyInput.value); // Normalisasi nilai awal qty

      btnPlus.addEventListener('click', async () => { // Klik tombol +
        const current = clampQty(qtyInput.value); // Qty sekarang
        const next = current + 1; // Qty setelah ditambah 1

        const tanggalMulai = item.querySelector('input[name="tanggal_mulai"]').value; // Ambil tgl mulai
        const tanggalPengembalian = item.querySelector('input[name="tanggal_pengembalian"]').value; // Ambil tgl kembali

        // 🧮 Cek stok dulu sebelum benar-benar nambah
        const stokInfo = await cekStokItem(id, tanggalMulai, tanggalPengembalian, next);
        if (!stokInfo.ok) {
          alert(stokInfo.message || 'Gagal mengecek stok.');
          return;
        }
        if (!stokInfo.bisa) {
          const maxQty = stokInfo.stokTersedia ?? current;
          alert(stokInfo.message || `Stok tidak mencukupi. Maksimal ${maxQty} unit.`);
          qtyInput.value = maxQty;
          return;
        }

        qtyInput.value = next; // Tampilkan qty baru ke input

        const harga = Number(item.dataset.harga || 0); // Ambil harga dari dataset
        const durasi = hitungDurasiHari(tanggalMulai, tanggalPengembalian); // Hitung durasi hari
        const subLoc = harga * durasi * next; // Subtotal lokal setelah tambah
        item.querySelector('.harga-item').innerText = rupiah(subLoc); // Tampilkan subtotal lokal
        updateTotalSelected(); // Update total keseluruhan (client side)

        const resp = await updateQtyOnServer(item, id, next, tanggalMulai, tanggalPengembalian); // Update server
        if (!resp.ok) { // Jika gagal respons server
          if (resp.status === 419) alert('Sesi kadaluarsa. Silakan muat ulang halaman.'); // Token/CSRF expired
          return; // Stop
        }
        const {
          data
        } = resp; // Ambil data respons
        if (data && data.success) { // Jika update berhasil
          const sub = (typeof data.subtotal === 'number') ? data.subtotal : subLoc; // Tentukan subtotal final
          item.querySelector('.harga-item').innerText = rupiah(sub); // Subtotal final
          updateTotalSelected(); // Update total lagi
          window.dispatchEvent(new Event('cart:updated')); // Beritahu bagian lain kalau cart berubah
        }
      });

      btnMinus.addEventListener('click', async () => { // Klik tombol −
        const current = clampQty(qtyInput.value); // Nilai sekarang
        const next = Math.max(1, current - 1); // Kurangi, minimal 1
        if (next === current) return; // Kalau sudah 1, jangan lanjut
        qtyInput.value = next; // Tampilkan jumlah baru di input

        const tanggalMulai = item.querySelector('input[name="tanggal_mulai"]').value; // Ambil tanggal mulai
        const tanggalPengembalian = item.querySelector('input[name="tanggal_pengembalian"]').value; // Ambil tanggal akhir

        const harga = Number(item.dataset.harga || 0); // Harga produk
        const durasi = hitungDurasiHari(tanggalMulai, tanggalPengembalian); // Hitung selisih hari
        const subLoc = harga * durasi * next; // Subtotal lokal baru
        item.querySelector('.harga-item').innerText = rupiah(subLoc); // Update subtotal langsung (optimistic UI)
        updateTotalSelected(); // Hitung ulang total bagian bawah

        const resp = await updateQtyOnServer(item, id, next, tanggalMulai, tanggalPengembalian); // Update server
        if (!resp.ok) { // Jika server balas error
          if (resp.status === 419) alert('Sesi kadaluarsa. Silakan muat ulang halaman.'); // Jika CSRF/session expired
          return; // Stop proses
        }
        const {
          data
        } = resp; // Ambil data JSON dari server
        if (data && data.success) { // Jika server konfirmasi sukses
          const sub = (typeof data.subtotal === 'number') ? data.subtotal : subLoc; // Gunakan subtotal final dari server
          item.querySelector('.harga-item').innerText = rupiah(sub); // Tampilkan subtotal final
          updateTotalSelected(); // Update total keseluruhan
          window.dispatchEvent(new Event('cart:updated')); // Kirim event global untuk update badge keranjang
        }
      });

      // Ketik manual + sinkron debounce (satu versi saja, hapus duplikat blur lama)
      qtyInput.addEventListener('input', () => { // Saat user mengetik di input
        const jumlah = clampQty(qtyInput.value); // Bersihkan & pastikan >=1
        debouncedTypeUpdate(item, id, jumlah); // Kirim update ke server (dengan debounce)
      });
      qtyInput.addEventListener('blur', () => { // Saat input kehilangan fokus
        qtyInput.value = clampQty(qtyInput.value); // Pastikan nilainya tertata rapi
      });
    });

    // ===== FIX 2: Simpan tanggal (AJAX) aman & informatif =====
    async function saveDatesForItem(itemEl) { // Simpan tanggal sewa untuk 1 item
      const id = itemEl.dataset.id; // ID produk
      const tanggalMulai = itemEl.querySelector('input[name="tanggal_mulai"]').value; // Ambil nilai tanggal mulai dari input
      const tanggalPengembalian = itemEl.querySelector('input[name="tanggal_pengembalian"]').value; // Ambil nilai tanggal pengembalian
      const status = itemEl.querySelector('.status-simpan'); // Elemen teks status (Menyimpan / Tersimpan)

      if (!tanggalMulai || !tanggalPengembalian) { // Kalau tanggal belum lengkap
        if (status) {
          status.style.display = 'inline'; // Tampilkan teks status
          status.textContent = 'Tanggal belum lengkap'; // Pesan error untuk user
        }
        setTimeout(() => { // Sembunyikan setelah 1.2 detik
          if (status) status.style.display = 'none';
        }, 1200);
        return; // Stop proses penyimpanan
      }
      if (toDateUTC(tanggalPengembalian) < toDateUTC(tanggalMulai)) { // Jika tanggal akhir < tanggal mulai
        if (status) {
          status.style.display = 'inline'; // Tampilkan teks status
          status.textContent = 'Tanggal tidak valid'; // Tampilkan pesan error
        }
        setTimeout(() => { // Sembunyikan pesan setelah 1.2 detik
          if (status) status.style.display = 'none';
        }, 1200);
        return; // Stop proses penyimpanan
      }

      const harga = Number(itemEl.dataset.harga || 0); // Harga satuan
      const qty = clampQty(itemEl.querySelector('.kontrol-jumlah input').value); // Qty saat ini
      const durasi = hitungDurasiHari(tanggalMulai, tanggalPengembalian); // Durasi hari
      const subLoc = harga * durasi * qty; // Subtotal lokal

      // Optimistic UI
      itemEl.querySelector('.harga-item').innerText = rupiah(subLoc); // Update subtotal segera
      updateTotalSelected(); // → Hitung ulang total keseluruhan berdasarkan tampilan terbaru

      if (status) {
        status.style.display = 'inline';
        status.textContent = 'Menyimpan…'; // Tampilkan status menyimpan
      }

      const resp = await fetchJSON(`/keranjang/ubah/${encodeURIComponent(id)}`, {
        method: 'POST',
        body: JSON.stringify({
          key: itemEl.dataset.key, // Key item di keranjang
          tanggal_mulai: tanggalMulai, // Tanggal mulai sewa
          tanggal_pengembalian: tanggalPengembalian, // Tanggal pengembalian
          jumlah: qty, // Jumlah barang
          lama_hari: durasi // Durasi sewa (hari)
        })
      });

      if (!resp.ok) { // Kalau respons gagal
        if (status) {
          status.textContent =
            resp.status === 419 ? 'Sesi kadaluarsa' : // Error khusus Laravel CSRF/session expired
            resp.status === 422 ? 'Input tidak valid' : // Error validasi input
            resp.networkError ? 'Gagal koneksi' : // Jika fetchJSON mendeteksi network error
            `Gagal (${resp.status})`; // Fallback: tampilkan status code server
        }
        setTimeout(() => {
          if (status) status.style.display = 'none'; // Sembunyikan pesan setelah 1.5 detik
        }, 1500);
        return; // Hentikan proses, jangan lanjut ke update sukses
      }

      const {
        data
      } = resp; // Ambil properti "data" dari respons fetchJSON (berisi hasil dari server)
      if (data && data.success) { // Kalau sukses dari server
        // Gunakan subtotal dari server jika tersedia, kalau tidak pakai subtotal lokal
        const sub = (typeof data.subtotal === 'number') ? data.subtotal : subLoc;
        itemEl.querySelector('.harga-item').innerText = rupiah(sub); // Update subtotal final
        updateTotalSelected(); // Hitung ulang total keseluruhan pada bagian bawah halaman
        if (data.new_key) { // Kalau key diganti di server
          itemEl.dataset.key = data.new_key; // Update data-key pada elemen item
          const cb = itemEl.querySelector('.checkbox');
          if (cb) cb.value = data.new_key; // Sinkronkan nilai checkbox agar tetap cocok
        }
        if (status) status.textContent = 'Tersimpan'; // Tampilkan pesan tersimpan
        setTimeout(() => { // Hilangkan pesan setelah 900 ms
          if (status) status.style.display = 'none';
        }, 900);
      } else {
        if (status) status.textContent = 'Gagal menyimpan'; // Kalau server balas gagal
        setTimeout(() => { // Hilangkan pesan setelah 1500 ms
          if (status) status.style.display = 'none';
        }, 1500);
      }
    }

    const debouncedSaveDates = debounce((e) => { // Debounce penyimpanan tanggal
      const item = e.target.closest('.item-keranjang'); // Cari card item terdekat
      if (item) saveDatesForItem(item); // Simpan tanggal untuk item tersebut
    }, 600);

    document.querySelectorAll('.item-keranjang').forEach(item => { // Untuk setiap item keranjang
      item.querySelectorAll('input[name="tanggal_mulai"], input[name="tanggal_pengembalian"]').forEach(inp => {
        inp.addEventListener('input', debouncedSaveDates); // Saat user mengubah input
        inp.addEventListener('change', debouncedSaveDates); // Saat input selesai di
      });
    });

    // ===== Checkout redirect ke halaman pemesanan =====
    tombolCheckout.addEventListener('click', async (e) => { // Saat tombol "Pesan" diklik
      e.preventDefault(); // Cegah behaviour default <a href="#">

      const checked = Array.from(document.querySelectorAll('.checkbox:checked')); // Ambil semua item yang dicentang
      if (checked.length === 0) { // Kalau belum ada yang dipilih
        alert('Pilih minimal 1 item untuk checkout.');
        return;
      }

      // === Kalau hanya 1 item → redirect ke halaman pemesanan tunggal (lama)
      if (checked.length === 1) { // Logika khusus untuk 1 produk
        const item = checked[0].closest('.item-keranjang'); // Card item-nya
        const id = item?.dataset.id; // ID produk dari data-id
        const mulai = item?.querySelector('input[name="tanggal_mulai"]')?.value; // Tanggal mulai sewa
        const akhir = item?.querySelector('input[name="tanggal_pengembalian"]')?.value; // Tanggal pengembalian
        const qtyRaw = item?.querySelector('.kontrol-jumlah input')?.value || '1'; // Qty dalam text
        const qty = Math.max(1, parseInt(String(qtyRaw).replace(/[^\d]/g, ''), 10) || 1); // Bersihin & minimal 1

        if (!id || !mulai || !akhir) { // Validasi tanggal dan id
          alert('Tanggal belum lengkap.');
          return;
        }

        const base = `{{ url('/pemesanan') }}`; // Base URL untuk pemesanan tunggal
        const url = `${base}/${encodeURIComponent(id)}` + // Tambah id produk di path
          `?tanggal_mulai_sewa=${encodeURIComponent(mulai)}` + // Query param tanggal mulai
          `&tanggal_pengembalian=${encodeURIComponent(akhir)}` + // Query param tanggal pengembalian
          `&jumlah=${encodeURIComponent(qty)}`; // Query param jumlah
        window.location.href = url; // Redirect ke halaman pemesanan tunggal
        return;
      }

      // === Kalau lebih dari 1 item → multi-checkout (LEWAT HALAMAN PEMESANAN)
      const items = checked.map(cb => { // Bentuk array data dari semua item terpilih
        const el = cb.closest('.item-keranjang'); // Card item
        const id = el.dataset.id; // ID produk
        const jumlah = clampQty(el.querySelector('.kontrol-jumlah input').value); // Qty yang sudah di-clamp
        const mulai = el.querySelector('input[name="tanggal_mulai"]').value; // Tanggal mulai
        const akhir = el.querySelector('input[name="tanggal_pengembalian"]').value; // Tanggal akhir

        return { // Struktur data dikirim ke server
          id_produk: id,
          jumlah_sewa: jumlah,
          tanggal_mulai_sewa: mulai,
          tanggal_pengembalian: akhir
        };
      });

      // Validasi tanggal semua produk
      const invalid = items.some(it => !it.tanggal_mulai_sewa || !it.tanggal_pengembalian); // Cek ada yang kosong
      if (invalid) {
        alert('Pastikan semua produk memiliki tanggal sewa lengkap.');
        return;
      }

      // 🔁 Kirim ke controller untuk disimpan di SESSION → redirect ke halaman pemesanan
      try {
        const resp = await fetch("{{ route('pemesanan.prepare') }}", { // Panggil route untuk persiapan multi-checkout
          method: "POST",
          headers: {
            "Content-Type": "application/json", // Kirim JSON
            "X-CSRF-TOKEN": "{{ csrf_token() }}" // Sertakan CSRF token
          },
          body: JSON.stringify({
            items // Kirim array items
          })
        });

        // aman untuk JSON/non-JSON
        let data = null;
        const ct = resp.headers.get('content-type') || ''; // Cek content-type respons
        if (ct.includes('application/json')) { // Kalau JSON
          data = await resp.json(); // Parse JSON
        }

        if (resp.ok && data?.ok && data?.redirect) { // Kalau sukses dan ada URL redirect
          window.location.href = data.redirect; // -> route('pemesanan.create')
        } else {
          alert((data && data.message) || 'Gagal menyiapkan checkout.'); // Pesan error fallback
        }
      } catch (err) {
        console.error(err); // Log error ke console
        alert('Terjadi kesalahan saat menyiapkan checkout.'); // Pesan error umum ke user
      }


    });

    // ===== Hapus massal (tetap sama dengan punyamu, disingkat) =====
    if (bulkDeleteBtn) { // Hanya jalan kalau tombol hapus massal ada
      const modalEl = document.getElementById('confirmDeleteModal'); // Elemen modal konfirmasi
      const confirmBtn = document.getElementById('confirmDeleteBtn'); // Tombol "Hapus" di modal
      const deleteText = document.getElementById('deleteConfirmText'); // Teks konfirmasi di modal
      const bsModal = new bootstrap.Modal(modalEl); // Inisialisasi modal Bootstrap

      let selectedItems = []; // Menyimpan checkbox yang terpilih saat hendak dihapus

      bulkDeleteBtn.addEventListener('click', () => { // Klik ikon trash massal
        selectedItems = Array.from(document.querySelectorAll('.checkbox:checked')); // Ambil semua checkbox terpilih
        if (selectedItems.length === 0) return; // Kalau tidak ada, keluar
        deleteText.innerHTML = `Apakah kamu yakin ingin menghapus <b>${selectedItems.length}</b> produk dari keranjang?`; // Update teks
        bsModal.show(); // Tampilkan modal konfirmasi
      });

      confirmBtn.addEventListener('click', async () => { // Saat user menekan "Hapus" di modal
        bsModal.hide(); // Tutup modal
        // Ambil key dari checkbox / data-ke, Buang yang null/undefined
        const keys = selectedItems.map(cb => cb.value || cb.closest('.item-keranjang')?.dataset.key).filter(Boolean);
        const resp = await fetchJSON(`/keranjang/hapus-banyak`, { // Panggil endpoint hapus banyak
          method: 'POST',
          body: JSON.stringify({
            keys // Kirim array key
          })
        });
        if (!resp.ok || !resp.data?.success) return; // Kalau gagal, hentikan

        const removed = Array.isArray(resp.data.removed_keys) ? resp.data.removed_keys : keys; // Pakai removed_keys dari server kalau ada
        removed.forEach(k => {
          const el = document.querySelector(`.item-keranjang[data-key="${CSS.escape(k)}"]`); // Cari card dengan data-key tsb
          if (el) el.remove(); // Hapus dari DOM
        });

        if (document.querySelectorAll('.item-keranjang').length === 0) { // Kalau sudah tidak ada item keranjang
          const container = document.querySelector('.cart-container'); // Ambil elemen utama keranjang untuk tempat menempelkan pesan kosong
          if (!document.getElementById('emptyCartMsg')) { // Pastikan pesan kosong hanya dibuat sekali
            const emptyMsg = document.createElement('p'); // Buat elemen <p> baru untuk pesan keranjang kosong
            emptyMsg.id = 'emptyCartMsg'; // Set ID agar bisa dicek di masa depan
            emptyMsg.className = 'text-center text-muted mt-5'; // Tambahkan styling tulisan agar terlihat seperti pesan default
            emptyMsg.textContent = 'Keranjang Anda masih kosong 🛒'; // Isi teks pesannya
            container.appendChild(emptyMsg); // Tambahkan pesan ke container
          }
          const totalSection = document.getElementById('totalSection'); // Ambil elemen bagian total harga
          if (totalSection) totalSection.style.display = 'none'; // Sembunyikan bagian total
        }

        if (typeof resp.data.count === 'number') { // Kalau server kirim jumlah item keranjang baru
          const badge = document.getElementById('cart-badge'); // Badge keranjang di navbar
          if (badge) {
            badge.textContent = resp.data.count; // Update angkanya
            badge.style.display = resp.data.count > 0 ? 'inline-block' : 'none'; // Sembunyikan jika 0
          }
        }

        selectedItems = []; // Reset list terpilih
        updateTotalSelected(); // Hitung ulang total
      });
    }

    // === LOGIKA PILIH SEMUA === 
    const selectAllEl = document.getElementById('selectAll'); // Checkbox "Semua"

    // Fungsi bantu: ambil semua checkbox item
    function getItemCheckboxes() {
      return Array.from(document.querySelectorAll('.item-keranjang .checkbox')); // Semua checkbox per-item
    }

    // Saat "Pilih Semua" diubah → centang / uncentang semua item
    if (selectAllEl) {
      selectAllEl.addEventListener('change', (e) => { // Event saat checkbox "Semua" diklik
        const checked = e.target.checked; // Status centang
        getItemCheckboxes().forEach(cb => cb.checked = checked); // Terapkan ke semua item
        updateTotalSelected(); // Hitung ulang total
      });
    }

    // Modifikasi fungsi updateTotalSelected agar sinkron dengan "Pilih Semua"
    const oldUpdate = updateTotalSelected; // Simpan referensi fungsi lama
    updateTotalSelected = function() { // Override fungsi dengan wrapper baru
      oldUpdate(); // Jalankan logika lama (hitung total, toggle tombol, dll)

      const items = getItemCheckboxes(); // Ambil semua checkbox item
      const allChecked = items.length > 0 && items.every(cb => cb.checked); // Semua tercentang?
      const someChecked = items.some(cb => cb.checked); // Minimal ada satu yang tercentang?

      if (selectAllEl) {
        selectAllEl.checked = allChecked; // Kalau semua dicentang, tandai "Semua" ikut centang
        selectAllEl.indeterminate = !allChecked && someChecked; // Kalau sebagian saja, jadi status semi-centang
      }
    };

    // Init
    updateTotalSelected(); // Panggil sekali di awal untuk sync tampilan (total, tombol, dan "Pilih Semua")

    // ===============================
    // 🔍 FILTER SEARCH DI HALAMAN KERANJANG
    // ===============================
    document.addEventListener("DOMContentLoaded", () => {
      // Hanya aktif di halaman /keranjang
      if (!window.location.pathname.startsWith("/keranjang")) return;

      // Ambil SEMUA form di navbar yang punya input name="q" (desktop + mobile)
      const searchForms = document.querySelectorAll('nav form');

      function filterCart(keywordRaw) { // Fungsi untuk mem-filter item keranjang berdasarkan kata kunci
        const keyword = (keywordRaw || "").trim().toLowerCase(); // Normalisasi keyword: kalau null → "", trim spasi, lalu ke huruf kecil
        const items = document.querySelectorAll(".item-keranjang"); // Ambil semua elemen card item keranjang
        let anyVisible = false; // Flag untuk cek apakah masih ada item yang tampil

        items.forEach(item => { // Loop setiap item keranjang
          const nameEl = item.querySelector(".nama-produk"); // Cari elemen yang berisi nama produk
          const name = (nameEl ? nameEl.innerText : "").toLowerCase(); // Ambil teks nama produk (kalau ada), lalu ke huruf kecil

          const match = !keyword || name.includes(keyword); // match = true jika keyword kosong atau nama mengandung keyword
          item.style.display = match ? "" : "none"; // Jika cocok → tampilkan, kalau tidak cocok → sembunyikan

          if (match) anyVisible = true; // Jika ada minimal satu item yang cocok, set flag anyVisible = true
        });

        // Pesan jika tidak ada hasil
        let msg = document.getElementById("emptyCartSearchMsg"); // Cari elemen pesan "tidak ada hasil" kalau sudah pernah dibuat

        if (!anyVisible && keyword) { // Jika tidak ada item yang tampil dan keyword tidak kosong
          if (!msg) { // Kalau pesan belum ada, buat baru
            msg = document.createElement("p"); // Buat elemen paragraf
            msg.id = "emptyCartSearchMsg"; // Set ID supaya bisa dicari lagi nanti
            msg.className = "text-center text-muted mt-4"; // Tambahkan class untuk styling (tengah & grey)
            msg.textContent = "Tidak ada item di keranjang yang cocok dengan pencarian."; // Isi teks pesan
            document.querySelector(".cart-container").appendChild(msg); // Tempel pesan di dalam container keranjang
          }
        } else {
          if (msg) msg.remove(); // Jika ada item yang cocok atau keyword kosong → hapus pesan "tidak ada hasil" kalau ada
        }
      }

      searchForms.forEach(form => { // Loop ke semua form search yang ada di navbar (desktop & mobile)
        const input = form.querySelector('input[name="q"]'); // Ambil elemen input text yang punya name="q"
        if (!input) return; // Kalau form ini bukan form search (tidak punya input q) → skip

        // Cegah submit ke server → filter dilakukan secara lokal saja
        form.addEventListener("submit", (e) => { // Saat user menekan Enter di field search
          e.preventDefault(); // Mencegah reload page / request ke server
          filterCart(input.value); // Jalankan pencarian lokal berdasarkan kata kunci
        });

        // Live filter saat user mengetik
        input.addEventListener("input", () => { // Event ketika karakter berubah saat diketik
          const val = input.value; // Ambil nilai input saat ini

          if (!val.trim()) { // Jika input kosong atau hanya spasi
            // tampilkan ulang semua item keranjang
            document.querySelectorAll(".item-keranjang").forEach(item => {
              item.style.display = ""; // Reset display ke semula (tampilkan)
            });

            const msg = document.getElementById("emptyCartSearchMsg"); // Cari pesan "tidak ada hasil" jika ada
            if (msg) msg.remove(); // Hapus pesan karena pencarian kosong
          } else {
            filterCart(val); // Jika ada keyword → jalankan filter untuk menyembunyikan/menampilkan item
          }
        });
      });
    });
  </script>
</body>

</html>