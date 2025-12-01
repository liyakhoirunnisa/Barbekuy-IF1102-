<!DOCTYPE html> <!-- Deklarasi tipe dokumen HTML5 -->
<html lang="id"> <!-- Bahasa dokumen diset ke Indonesia -->

<head> <!-- Tag pembuka head: area metadata, link stylesheet, dan style internal untuk halaman -->
  <meta charset="UTF-8" /> <!-- Menetapkan encoding karakter ke UTF-8 untuk mendukung berbagai karakter internasional -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0" /> <!-- Mengatur viewport agar layout responsif pada perangkat mobile -->
  <title>Manajemen Produk | Barbekuy</title> <!-- Judul halaman yang ditampilkan pada tab browser -->
  <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Meta tag berisi CSRF token Laravel untuk keamanan form/request -->
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}"> <!-- Mengatur favicon menggunakan asset Laravel -->

  {{-- ICONS (Font Awesome) --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" /> <!-- Memuat Font Awesome dari CDN untuk ikon -->

  {{-- Google Font --}}
  <!-- Import font Poppins dari Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
    /* Awal blok CSS internal yang berisi styling halaman */
    * {
      /* Selector universal: pengaturan dasar untuk semua elemen */
      margin: 0;
      /* Menghapus margin default browser untuk konsistensi layout */
      padding: 0;
      /* Menghapus padding default browser untuk konsistensi layout */
      box-sizing: border-box;
      /* Memastikan padding dan border masuk dalam perhitungan width/height */
      font-family: 'Poppins', sans-serif
        /* Menetapkan font default halaman; catatan: pastikan memuat Google Font Poppins bila perlu */
    }

    html,
    /* Selector untuk elemen root HTML */
    body {
      /* Selector untuk elemen body */
      height: 100%
        /* Menetapkan tinggi 100% pada html & body agar layout fleksibel dapat mengisi viewport */
    }

    body {
      /* Styling utama untuk elemen body */
      display: flex;
      /* Menggunakan flexbox untuk layout utama */
      min-height: 100vh;
      /* Menjamin body minimal setinggi viewport */
      background: #f5f6fa;
      /* Warna latar belakang keseluruhan halaman */
      color: #1f1f1f;
      /* Warna teks default */
      overflow-x: hidden
        /* Menonaktifkan scroll horizontal yang tidak diinginkan */
    }

    /* === KONTEN PRODUK === */
    /* Komentar penanda blok CSS untuk bagian konten produk */

    .content {
      flex: 1;
      padding: 25px 30px;
      overflow: hidden;
      /* halaman abu-abu tidak scroll */
      display: flex;
      /* biar .content-box bisa di-flex */
    }

    .content-box {
      background: #fff;
      border-radius: 12px;
      padding: 25px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
      display: flex;
      flex-direction: column;
      flex: 1;
      /* ⬅️ kotak putih ikut melebar penuh */
      width: 100%;
      max-height: calc(100vh - 40px);
      /* ⬅️ bikin lebih tinggi dari sebelumnya */
    }

    .content-header {
      /* Baris header di dalam content-box (judul + aksi) */
      display: flex;
      /* Mengatur layout header menggunakan flexbox */
      justify-content: space-between;
      /* Menjaga jarak antar elemen header (kiri-kanan) */
      align-items: center;
      /* Meratakan elemen header secara vertikal */
      margin-bottom: 25px;
      /* Jarak bawah header ke konten berikutnya */
      flex-wrap: wrap;
      /* Memungkinkan isi header membungkus jika ruang sempit */
      gap: 10px;
      /* Jarak antar item dalam header */
    }

    .content-header h2 {
      /* Styling title h2 pada header konten */
      font-size: 20px;
      /* Ukuran font judul */
      font-weight: 600;
      /* Ketebalan font judul */
      color: #333
        /* Warna teks judul */
    }

    .header-actions {
      /* Container untuk tombol/tindakan di header */
      display: flex;
      /* Menyusun tombol dalam satu baris */
      gap: 10px;
      /* Jarak antar tombol */
      flex-wrap: wrap;
      /* Membungkus tombol ke baris baru bila perlu */
    }

    .btn {
      /* Gaya dasar untuk semua tombol yang memakai kelas .btn */
      border: none;
      /* Menghilangkan border default tombol */
      padding: 9px 16px;
      /* Padding vertikal 9px dan horizontal 16px */
      border-radius: 6px;
      /* Sudut tombol membulat */
      font-size: 14px;
      /* Ukuran font tombol */
      cursor: pointer;
      /* Menampilkan kursor pointer saat hover */
      font-weight: 500;
      /* Ketebalan tulisan tombol */
      transition: 0.3s
        /* Transisi halus untuk efek hover/transform */
    }

    .btn-primary {
      /* Varian tombol utama (primary) */
      background: #751A25;
      /* Warna latar tombol primary */
      color: #fff
        /* Warna teks tombol primary */
    }

    .btn-primary:hover {
      /* Efek hover untuk tombol primary */
      background: #3d030a
        /* Warna lebih gelap saat kursor di atas tombol */
    }

    .btn-secondary {
      /* Varian tombol sekunder */
      background: #fff;
      /* Latar putih untuk sekunder */
      border: 1px solid #ccc;
      /* Border tipis abu */
      color: #333
        /* Warna teks tombol sekunder */
    }

    .filters {
      /* Container grup filter & pencarian */
      display: flex;
      /* Mengatur filter secara horizontal */
      justify-content: space-between;
      /* Menyebarkan elemen filter ke kiri & kanan */
      align-items: center;
      /* Meratakan elemen filter secara vertikal */
      gap: 10px;
      /* Jarak antar elemen filter */
      margin-bottom: 25px;
      /* Jarak bawah dari konten berikutnya */
      flex-wrap: wrap;
      /* Membungkus elemen bila ruang sempit */
    }

    .filter-group {
      /* Grup internal untuk beberapa filter */
      display: flex;
      /* Horizontal layout untuk elemen di dalamnya */
      gap: 10px;
      /* Jarak antar elemen dalam group */
      flex: 1;
      /* Menjadikan group fleksibel mengambil ruang */
      flex-wrap: wrap;
      /* Membungkus internal jika perlu */
    }

    .filters select,
    /* Selector gabungan untuk elemen select dalam .filters */
    .filters input {
      /* Selector gabungan untuk elemen input dalam .filters */
      padding: 9px 12px;
      /* Padding dalam elemen form */
      border-radius: 6px;
      /* Sudut membulat */
      border: 1px solid #dcdcdc;
      /* Border abu tipis */
      font-size: 13px;
      /* Ukuran font input/select */
      outline: none;
      /* Menghilangkan outline default fokus */
      background: #fff;
      /* Latar putih elemen form */
    }

    .filters input {
      /* Aturan khusus untuk input dalam .filters (mis. search) */
      flex: 1;
      /* Mengizinkan input mengisi ruang yang tersedia */
      min-width: 160px;
      /* Lebar minimum input supaya tidak mengecil terlalu banyak */
    }

    .icon-actions {
      /* Container untuk ikon aksi (edit/delete dsb) */
      display: flex;
      /* Menyusun ikon secara horizontal */
      gap: 12px;
      /* Jarak antar ikon */
      align-items: center;
      /* Meratakan ikon secara vertikal */
    }

    .icon-actions i {
      /* Styling untuk elemen ikon di dalam .icon-actions */
      font-size: 18px;
      /* Ukuran ikon */
      cursor: pointer;
      /* Menunjukkan ikon dapat diklik */
      transition: 0.3s;
      /* Transisi untuk efek hover */
      color: #751A25
        /* Warna ikon sesuai tema */
    }

    .icon-actions i:hover {
      /* Efek hover untuk ikon */
      transform: scale(1.1)
        /* Memperbesar ikon sedikit saat hover untuk feedback */
    }

    .table-container {
      flex: 1;
      /* ⬅️ ambil sisa tinggi di dalam .content-box */
      overflow-y: auto;
      /* ⬅️ scroll vertikal di sini */
      overflow-x: auto;
      /* ⬅️ tetap bisa scroll horizontal kalau tabel kepanjangan */
    }

    table {
      /* Styling dasar tabel */
      width: 100%;
      /* Lebar tabel 100% container */
      border-collapse: collapse;
      /* Menggabungkan border sel agar rapih */
      min-width: 900px;
      /* Lebar minimal tabel agar layout kolom tidak terpotong */
    }

    th,
    /* Selector header cell tabel */
    td {
      /* Selector data cell tabel */
      text-align: left;
      /* Perataan teks ke kiri */
      padding: 12px 10px;
      /* Padding sel: 12px vertikal, 10px horizontal */
      border-bottom: 1px solid #eee;
      /* Border bawah tipis antar baris */
      font-size: 14px;
      /* Ukuran font sel tabel */
      white-space: nowrap;
      /* Mencegah teks membungkus ke baris baru */
    }

    /* Kolom deskripsi boleh bungkus teks */
    th.col-deskripsi,
    td.col-deskripsi {
      white-space: normal;
      /* teks boleh turun ke bawah */
      max-width: 280px;
      /* batasi lebar kolom deskripsi */
      word-wrap: break-word;
      /* kata panjang dipecah */
      word-break: break-word;
      /* jaga supaya tidak bikin scroll ke samping */
    }

    th {
      /* Styling khusus untuk header tabel */
      color: #555;
      /* Warna teks header */
      font-weight: 500
        /* Ketebalan teks header */
    }

    td strong {
      /* Styling untuk elemen <strong> di dalam td */
      color: #000
        /* Menetapkan warna teks bold menjadi hitam */
    }

    .status {
      /* Badge status kecil (aktif/nonaktif) */
      padding: 4px 10px;
      /* Padding badge */
      border-radius: 6px;
      /* Sudut badge membulat */
      font-size: 12px;
      /* Ukuran font badge */
      font-weight: 500;
      /* Ketebalan teks badge */
      display: inline-block
        /* Menjadikan badge inline-block agar padding bekerja */
    }

    .status.active {
      /* Variasi gaya untuk status aktif */
      background: #d2f7d0;
      /* Latar hijau muda */
      color: #2e7d32
        /* Teks hijau gelap */
    }

    .status.inactive {
      /* Variasi gaya untuk status nonaktif */
      background: #f9d2d0;
      /* Latar merah muda */
      color: #b71c1c
        /* Teks merah gelap */
    }

    td a {
      /* Styling untuk link di dalam tabel */
      color: #751A25;
      /* Warna link sesuai tema */
      text-decoration: none;
      /* Menghilangkan garis bawah default pada link */
      font-weight: 500;
      /* Ketebalan font link */
      cursor: pointer
        /* Menunjukkan link dapat diklik */
    }

    td a:hover {
      /* Efek hover untuk link di tabel */
      text-decoration: underline
        /* Menambahkan garis bawah saat hover untuk indikasi interaksi */
    }

    table tbody tr:hover {
      /* Efek hover pada baris tabel */
      background-color: rgba(211, 47, 47, 0.08);
      /* Latar baris sedikit berwarna saat hover */
      transform: scale(1.01)
        /* Sedikit memperbesar baris saat hover untuk efek interaktif */
    }

    /* POPUP UMUM */
    /* Penanda blok CSS untuk komponen popup/modal */

    .popup {
      /* Wrapper overlay popup */
      display: none;
      /* Default sembunyi, ditampilkan via JS saat dibutuhkan */
      position: fixed;
      /* Menempel pada viewport */
      top: 0;
      /* Posisi atas 0 */
      left: 0;
      /* Posisi kiri 0 */
      width: 100%;
      /* Lebar penuh viewport */
      height: 100%;
      /* Tinggi penuh viewport */
      background: rgba(0, 0, 0, 0.6);
      /* Latar gelap semi-transparan untuk overlay */
      justify-content: center;
      /* Pusatkan konten popup secara horizontal */
      align-items: center;
      /* Pusatkan konten popup secara vertikal */
      z-index: 999;
      /* Pastikan overlay berada di atas elemen lain */
      padding: 15px;
      /* Padding agar konten tidak menempel di tepi layar */
    }

    .popup-content {
      /* Kontainer isi popup */
      background: #fff;
      /* Latar putih untuk konten popup */
      border-radius: 12px;
      /* Sudut membulat */
      width: 600px;
      /* Lebar dasar popup */
      max-width: 95%;
      /* Lebar maksimal 95% viewport untuk responsif */
      padding: 25px 30px;
      /* Padding internal popup */
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
      /* Bayangan untuk menonjolkan popup */
      overflow-y: auto;
      /* Scroll vertikal jika konten melebihi tinggi popup */
      max-height: 90vh;
      /* Maksimum tinggi 90% viewport agar tetap terlihat */
    }

    .popup-header {
      /* Header popup (judul + tombol close) */
      display: flex;
      /* Menggunakan flex untuk mengatur layout header */
      justify-content: space-between;
      /* Menempatkan judul kiri dan tombol kanan */
      align-items: center;
      /* Meratakan elemen header secara vertikal */
      margin-bottom: 20px
        /* Jarak bawah header ke isi popup */
    }

    .popup-header h3 {
      /* Styling judul (h3) dalam popup */
      font-size: 18px;
      /* Ukuran font judul popup */
      color: #751A25
        /* Warna teks judul sesuai tema */
    }

    .close-btn {
      /* Tombol tutup popup */
      background: none;
      /* Tanpa latar */
      border: none;
      /* Tanpa border */
      font-size: 20px;
      /* Ukuran ikon/tulisan close */
      cursor: pointer;
      /* Kursor pointer menandakan dapat diklik */
      color: #751A25
        /* Warna tombol sesuai tema */
    }

    .popup-footer {
      /* Footer popup (tempat tombol aksi) */
      margin-top: 15px;
      /* Jarak atas footer dari isi popup */
      display: flex;
      /* Layout tombol footer menggunakan flex */
      justify-content: flex-end;
      /* Tombol ditempatkan ke kanan */
      gap: 10px;
      /* Jarak antar tombol footer */
      flex-wrap: wrap;
      /* Membungkus bila ruang sempit */
    }

    /* FORM TAMBAH & EDIT PRODUK */
    /* Penanda blok CSS untuk form tambah/edit produk */

    form label {
      /* Styling label form */
      display: block;
      /* Label tampil sebagai blok agar berada di atas input */
      font-weight: 600;
      /* Ketebalan font label */
      color: #751A25;
      /* Warna label sesuai tema */
      margin-bottom: 6px;
      /* Jarak bawah label ke input */
      font-size: 14px;
      /* Ukuran font label */
    }

    form input,
    /* Selector untuk input dalam form */
    form select,
    /* Selector untuk select dalam form */
    form textarea {
      /* Selector untuk textarea dalam form */
      width: 100%;
      /* Lebar elemen form 100% container */
      padding: 10px 12px;
      /* Padding internal elemen form */
      border: 1px solid #ccc;
      /* Border abu tipis */
      border-radius: 8px;
      /* Sudut membulat */
      font-size: 14px;
      /* Ukuran font input */
      outline: none;
      /* Menghilangkan outline default fokus */
      background: #fff;
      /* Latar putih elemen form */
      transition: all 0.3s ease;
      /* Transisi halus pada perubahan (focus, hover) */
    }

    form input:focus,
    /* Aturan saat elemen input fokus */
    form select:focus,
    /* Aturan saat select fokus */
    form textarea:focus {
      /* Aturan saat textarea fokus */
      border-color: #751A25;
      /* Mengubah warna border saat fokus sesuai tema */
      box-shadow: 0 0 4px rgba(117, 26, 37, 0.25);
      /* Efek bayangan halus saat fokus */
    }

    form textarea {
      /* Aturan khusus textarea */
      min-height: 90px;
      /* Tinggi minimum textarea */
      resize: vertical;
      /* Hanya mengizinkan resize vertical */
    }

    .popup-footer .btn {
      /* Styling tombol di footer popup (turunan .btn) */
      font-size: 14px;
      /* Ukuran font tombol */
      padding: 9px 16px;
      /* Padding tombol */
      border-radius: 6px;
      /* Sudut tombol */
      font-weight: 500;
      /* Ketebalan teks tombol */
      transition: 0.3s;
      /* Transisi interaksi */
    }

    .popup-footer .btn-primary {
      /* Tombol primary di footer popup */
      background: #751A25;
      /* Latar tombol primary */
      color: #fff;
      /* Warna teks tombol */
    }

    .popup-footer .btn-primary:hover {
      /* Hover untuk tombol primary di popup */
      background: #3d030a;
      /* Warna lebih gelap saat hover */
    }

    .popup-footer .btn-secondary {
      /* Tombol sekunder di footer popup */
      background: #fff;
      /* Latar putih */
      border: 1px solid #ccc;
      /* Border tipis */
      color: #333;
      /* Warna teks */
    }

    .popup-footer .btn-secondary:hover {
      /* Hover untuk tombol sekunder di popup */
      background: #f7f7f7;
      /* Latar sedikit abu saat hover */
    }

    /* ==== RESPONSIVE FILTER (HP) ==== */
    @media (max-width: 600px) {
      /* Media query untuk device dengan lebar <= 600px */

      /* Container filter dibuat horizontal scroll */
      /* Penjelasan singkat blok di bawah */
      .filters {
        /* Aturan responsive untuk .filters */
        flex-wrap: nowrap;
        /* Memaksa item filter tetap dalam satu baris (scrollable) */
        overflow-x: auto;
        /* Mengizinkan scroll horizontal */
        padding-bottom: 5px;
        /* Ruang bawah tambahan untuk scrollbar */
        scrollbar-width: thin;
        /* Mengatur ketebalan scrollbar (Firefox) */
      }

      /* Group filter dibuat deretan horizontal */
      .filter-group {
        /* Aturan responsive untuk .filter-group */
        flex-wrap: nowrap;
        /* Menghindari membungkus elemen internal */
        display: flex;
        /* Menyusun item secara horizontal */
        gap: 10px;
        /* Jarak antar item */
      }

      /* Semua elemen filter wajib tidak membesar */
      .filters select,
      /* Selector gabungan responsive */
      .filters input,
      /* Selector gabungan responsive */
      .filter-group>div {
        /* Selector gabungan responsive */
        flex: 0 0 auto;
        /* Mencegah elemen tumbuh atau menyusut */
        white-space: nowrap;
        /* Mencegah teks membungkus */
      }

      /* Input cari + icon reset */
      .filter-group>div {
        /* Aturan untuk wrapper input + icon */
        display: flex !important;
        /* Memaksa layout horizontal */
        align-items: center;
        /* Meratakan vertikal isi wrapper */
        gap: 8px;
        /* Jarak antar elemen di wrapper */
        width: auto !important;
        /* Memastikan lebar otomatis sesuai isi */
      }

      /* Icon actions (edit + delete) tetap sejajar kanan */
      .icon-actions {
        /* Aturan responsive untuk icon-actions */
        flex: 0 0 auto;
        /* Mencegah ikon mengisi ruang lebih */
      }
    }
  </style> <!-- Penutup blok CSS internal -->
</head> <!-- Penutup tag head -->

<body> <!-- Tag pembuka body: seluruh konten halaman berada di sini -->
  {{-- 🔹 Sidebar + Topbar --}} <!-- Blade comment: penanda bahwa sidebar & topbar disertakan -->
  @include('layouts.navbarAdmin') <!-- Blade directive: menyertakan partial navbarAdmin (sidebar + topbar) -->

  <!-- MAIN --> <!-- Komentar HTML: menandai awalan bagian utama halaman -->
  <main class="main-content"> <!-- Elemen utama konten dengan kelas untuk styling/layout -->
    <div class="content"> <!-- Wrapper .content (sisi kanan konten utama) -->
      <div class="content-box"> <!-- Kotak putih utama yang menampung semua isi produk -->

        <div class="content-header"> <!-- Header konten: judul + aksi -->
          <h2>Manajemen Produk Penyewaan</h2> <!-- Judul halaman internal -->
          <div class="header-actions"> <!-- Container untuk tombol aksi di header -->
            <button class="btn btn-primary" onclick="openPopup('popupTambah')">Tambah Produk</button> <!-- Tombol utama: buka popup tambah produk -->
          </div> <!-- Tutup .header-actions -->
        </div> <!-- Tutup .content-header -->

        <div class="filters"> <!-- Wrapper untuk filter (kategori, status, pencarian) -->
          <div class="filter-group"> <!-- Grup filter: susunan dropdown + input pencarian -->
            <select name="kategori"> <!-- Dropdown filter kategori -->
              <option value="">Filter Kategori</option> <!-- Option default (kosong) -->
              <option value="Paket Slice">Paket Slice</option> <!-- Option kategori: Paket Slice -->
              <option value="Paket Alat">Paket Alat</option> <!-- Option kategori: Paket Alat -->
            </select> <!-- Tutup select kategori -->

            <select name="status"> <!-- Dropdown filter status ketersediaan -->
              <option value="">Filter Status</option> <!-- Option default (kosong) -->
              <option value="tersedia">Tersedia</option> <!-- Option status tersedia -->
              <option value="tidak tersedia">Tidak Tersedia</option> <!-- Option status tidak tersedia -->
            </select> <!-- Tutup select status -->

            <div style="display:flex;align-items:center;gap:8px;flex:1;"> <!-- Wrapper inline untuk search + reset icon -->
              <input type="text" placeholder="Cari Produk..." style="flex:1;"> <!-- Input pencarian produk -->
              <i id="resetFilter" class="fa-solid fa-rotate-right"
                title="Reset Filter"
                style="cursor:pointer;font-size:18px;color:#751A25;transition:0.3s;"></i> <!-- Ikon reset filter dengan id untuk event listener -->
            </div> <!-- Tutup wrapper search -->
          </div> <!-- Tutup .filter-group -->

          <div class="icon-actions"> <!-- Container icon action (edit + delete) -->
            <i class="fa-solid fa-pen-to-square" title="Edit" id="iconEdit"></i> <!-- Ikon edit dengan id iconEdit -->
            <i class="fa-solid fa-trash" title="Hapus" id="iconDelete" onclick="triggerDelete()"></i> <!-- Ikon delete memanggil triggerDelete() saat diklik -->
          </div> <!-- Tutup .icon-actions -->
        </div> <!-- Tutup .filters -->

        <div class="table-container"> <!-- Container yang memungkinkan scroll horizontal untuk tabel -->
          <table> <!-- Tabel menampilkan daftar produk -->
            <thead> <!-- Header tabel -->
              <tr> <!-- Baris header -->
                <th><input type="checkbox" id="checkAll"></th> <!-- Checkbox untuk select all baris -->
                <th>ID Produk</th> <!-- Kolom ID Produk -->
                <th>Nama Produk</th> <!-- Kolom Nama Produk -->
                <th>Kategori</th> <!-- Kolom Kategori -->
                <th>Stok</th> <!-- Kolom Stok -->
                <th class="col-deskripsi">Deskripsi Singkat</th> <!-- Kolom Deskripsi Singkat -->
                <th>Harga Sewa/Hari</th> <!-- Kolom Harga per hari -->
                <th>Status</th> <!-- Kolom Status ketersediaan -->
                <th>Aksi</th> <!-- Kolom Aksi (detail, edit, hapus) -->
              </tr> <!-- Tutup baris header -->
            </thead> <!-- Tutup thead -->
            <tbody> <!-- Body tabel: baris produk di-loop oleh Blade -->
              @foreach($produk as $item) <!-- Blade loop: iterasi setiap produk -->
              <tr data-gambar="{{ asset('storage/' . $item->gambar) }}"> <!-- Baris produk, menyimpan path gambar di data attribute -->
                <td><input type="checkbox" class="rowCheck"></td> <!-- Checkbox per baris untuk seleksi -->
                <td><strong>{{ $item->id_produk }}</strong></td> <!-- Menampilkan id_produk dalam tag strong -->
                <td>{{ $item->nama_produk }}</td> <!-- Menampilkan nama produk -->
                <td>{{ $item->kategori }}</td> <!-- Menampilkan kategori -->
                <td>{{ $item->stok }}</td> <!-- Menampilkan stok -->
                <td class="col-deskripsi">{{ Str::limit($item->deskripsi, 1000) }}</td> <!-- Menampilkan deskripsi yang dilimit (Str::limit Blade helper) -->
                <td>Rp{{ number_format($item->harga, 0, ',', '.') }}</td> <!-- Menampilkan harga dengan format rupiah -->
                <td> <!-- Kolom status dengan conditional -->
                  @if ($item->status_ketersediaan == 'tersedia') <!-- Jika status tersedia -->
                  <span class="status active">Tersedia</span> <!-- Badge status aktif -->
                  @else <!-- Jika bukan tersedia -->
                  <span class="status inactive">Tidak tersedia</span> <!-- Badge status nonaktif -->
                  @endif <!-- Tutup conditional -->
                </td> <!-- Tutup kolom status -->
                <td><a onclick="openDetail('{{ $item->id_produk }}')">Detail</a></td> <!-- Link aksi: memanggil openDetail dengan id produk -->
              </tr> <!-- Tutup baris produk -->
              @endforeach <!-- Akhir loop produk -->
            </tbody> <!-- Tutup tbody -->
          </table> <!-- Tutup tabel -->
        </div> <!-- Tutup .table-container -->

        <!-- POPUPS (Detail, Tambah, Edit, Hapus) -->

        <!-- === POPUP DETAIL PRODUK === -->
        <div class="popup" id="popupDetail">
          <div class="popup-content">
            <div class="popup-header">
              <h3>Detail Produk</h3>
              <button class="close-btn" onclick="closePopup('popupDetail')">&times;</button>
            </div>

            <img id="detailGambar" src="" alt="Gambar Produk"
              style="width:180px; height:180px; align-items: center; object-fit:cover; border-radius:10px; margin: 0 auto 15px auto; display:block; border:1px solid #ccc;">

            <p><b>ID Produk:</b> <span id="detailID"></span></p>
            <p><b>Nama Produk:</b> <span id="detailNama"></span></p>
            <p><b>Kategori:</b> <span id="detailKategori"></span></p>
            <p><b>Stok:</b> <span id="detailStok"></span></p>
            <p><b>Deskripsi:</b> <span id="detailDeskripsi" style="white-space: pre-wrap; word-wrap: break-word;"></span></p>
            <p><b>Harga:</b> <span id="detailHarga"></span>/hari</p>

            <hr style="margin: 15px 0; border: none; border-top: 1px solid #eee;">

            <div style="margin-top: 5px;">
              <h4 style="font-size: 14px; color:#751A25; margin-bottom: 8px;">
                Monitor Stok per Tanggal
              </h4>

              <label for="cekMulai" style="font-size: 13px; font-weight:500; color:#555;">Tanggal Mulai Sewa</label>
              <input type="date" id="cekMulai" style="width:100%; padding:8px 10px; border-radius:6px; border:1px solid #ccc; margin-bottom:8px;">

              <label for="cekSelesai" style="font-size: 13px; font-weight:500; color:#555;">Tanggal Selesai Sewa</label>
              <input type="date" id="cekSelesai" style="width:100%; padding:8px 10px; border-radius:6px; border:1px solid #ccc; margin-bottom:10px;">

              <button type="button"
                id="btnCekStokTanggal"
                class="btn btn-primary"
                style="font-size: 13px; padding:7px 14px; margin-bottom:8px;">
                Cek Ketersediaan di Rentang Tanggal Ini
              </button>

              <div id="hasilCekStokTanggal"
                style="font-size: 13px; color:#333; margin-top:5px;">
                <!-- Hasil cek stok per tanggal akan muncul di sini -->
              </div>
            </div>
          </div>
        </div>
        <!-- === END POPUP DETAIL === -->

        <!-- === POPUP TAMBAH PRODUK === -->
        <div class="popup" id="popupTambah">
          <div class="popup-content">
            <div class="popup-header">
              <h3>Tambah Produk</h3>
            </div>

            <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
              @csrf

              <label>Gambar Produk</label>
              <input type="file" name="gambar" accept="image/*" required>

              <label>Nama Produk</label>
              <input type="text" name="nama_produk" required>

              <label>Kategori</label>
              <select name="kategori" required>
                <option value="Paket Slice">Paket Slice</option>
                <option value="Paket Alat">Paket Alat</option>
              </select>

              <label>Stok</label>
              <input type="number" name="stok" required>

              <label>Deskripsi Singkat</label>
              <textarea name="deskripsi" required></textarea>

              <label>Harga Sewa/Hari</label>
              <input type="number" name="harga" required>

              <div class="popup-footer">
                <button type="button" class="btn btn-secondary" onclick="closePopup('popupTambah')">Batal</button>
                <button type="submit" class="btn btn-primary">Tambah Produk</button>
              </div>
            </form>
          </div>
        </div>

        <!-- === POPUP EDIT PRODUK === -->
        <div class="popup" id="popupEdit">
          <div class="popup-content">
            <div class="popup-header">
              <h3>Edit Produk</h3>
            </div>
            <form></form>
          </div>
        </div>

        <!-- === POPUP HAPUS PRODUK === -->
        <div class="popup popup-hapus" id="popupHapus">
          <div class="popup-content">
            <div class="popup-header">
              <h3>Konfirmasi Hapus Produk</h3>
            </div>
            <p>Apakah kamu yakin ingin menghapus produk ini?</p>
            <div class="popup-footer" style="justify-content:center;">
              <button class="btn btn-secondary" onclick="closePopup('popupHapus')">Batal</button>
              <button class="btn btn-primary" onclick="confirmDelete()">Hapus</button>
            </div>
          </div>
        </div>

        <!-- === END OF ORIGINAL PRODUCT CONTENT === -->
      </div> <!-- Tutup .content-box -->
    </div> <!-- Tutup .content -->
  </main>


  <script>
    // Awal blok JavaScript; komentar ditulis menggunakan // pada setiap baris JS
    function toggleSidebar() { // Fungsi toggle untuk sidebar (menambah/menhapus kelas 'active')
      document.getElementById('sidebar').classList.toggle('active'); // Toggle kelas active pada elemen dengan id sidebar
    } // Tutup fungsi toggleSidebar

    function openPopup(id) { // Fungsi membuka popup berdasarkan id
      document.getElementById(id).style.display = 'flex'; // Set display ke flex agar popup terlihat dan center
    } // Tutup fungsi openPopup

    function closePopup(id) { // Fungsi menutup popup berdasarkan id
      document.getElementById(id).style.display = 'none'; // Sembunyikan popup dengan display none
    } // Tutup fungsi closePopup

    // === DETAIL PRODUK === // Penanda awal blok detail produk
    function openDetail(id) { // Fungsi membuka popup detail dan mengisi data dari baris tabel
      const row = [...document.querySelectorAll('table tbody tr')] // Ambil semua baris tabel sebagai array
        .find(r => r.querySelector('td strong').innerText === id); // Cari baris yang memiliki <strong> dengan text id yang sama
      if (!row) return; // Jika tidak ditemukan, hentikan eksekusi
      const cells = row.querySelectorAll('td'); // Ambil semua cell pada baris tersebut
      document.getElementById('detailID').innerText = cells[1].innerText; // Isi elemen detailID dengan isi kolom ID
      document.getElementById('detailNama').innerText = cells[2].innerText; // Isi nama produk
      document.getElementById('detailKategori').innerText = cells[3].innerText; // Isi kategori
      document.getElementById('detailStok').innerText = cells[4].innerText; // Isi stok
      document.getElementById('detailDeskripsi').innerText = cells[5].innerText; // Isi deskripsi (text dari kolom)
      document.getElementById('detailHarga').innerText = cells[6].innerText; // Isi harga
      document.getElementById('detailGambar').src = row.getAttribute('data-gambar'); // Set src gambar dari atribut data-gambar
      openPopup('popupDetail'); // Tampilkan popup detail
    } // Tutup fungsi openDetail

    // === CEK STOK PER TANGGAL DI POPUP DETAIL ===
    async function cekStokPerTanggal() {
      const id = document.getElementById('detailID').innerText.trim(); // ambil ID produk dari popup detail
      const mulai = document.getElementById('cekMulai').value;
      const selesai = document.getElementById('cekSelesai').value;
      const hasilBox = document.getElementById('hasilCekStokTanggal');

      if (!mulai || !selesai) {
        hasilBox.style.color = '#b71c1c';
        hasilBox.innerText = 'Silakan pilih tanggal mulai dan tanggal selesai dulu.';
        return;
      }

      if (mulai > selesai) {
        hasilBox.style.color = '#b71c1c';
        hasilBox.innerText = 'Tanggal mulai tidak boleh lebih besar dari tanggal selesai.';
        return;
      }

      try {
        const res = await fetch(`{{ url('/admin/produk') }}/${id}/ketersediaan?mulai=${mulai}&selesai=${selesai}`, {
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
          }
        });

        if (!res.ok) {
          hasilBox.style.color = '#b71c1c';
          hasilBox.innerText = 'Gagal mengecek ketersediaan. Coba lagi.';
          return;
        }

        const data = await res.json();

        if (!data.success) {
          hasilBox.style.color = '#b71c1c';
          hasilBox.innerText = data.message || 'Terjadi kesalahan saat cek stok.';
          return;
        }

        const total = data.stok_total ?? 0;
        const dipakai = data.dipakai ?? 0;
        const sisa = data.stok_sisa ?? 0;

        if (sisa <= 0) {
          hasilBox.style.color = '#b71c1c';
          hasilBox.innerText =
            `PENUH di rentang tanggal ini. (${dipakai}/${total} unit sudah dibooking)`;
        } else {
          hasilBox.style.color = '#2e7d32';
          hasilBox.innerText =
            `Masih tersedia ${sisa} dari ${total} unit (terpakai ${dipakai} unit) di rentang tanggal tersebut.`;
        }

      } catch (e) {
        hasilBox.style.color = '#b71c1c';
        hasilBox.innerText = 'Terjadi kesalahan koneksi saat cek stok.';
      }
    }

    // Pasang event listener untuk tombol cek stok di popup detail
    document.addEventListener('DOMContentLoaded', () => {
      const btnCek = document.getElementById('btnCekStokTanggal');
      if (btnCek) {
        btnCek.addEventListener('click', cekStokPerTanggal);
      }
    });

    // === CHECK ALL === // Penanda fungsi select all
    document.getElementById('checkAll').addEventListener('change', function() { // Event listener untuk checkbox checkAll
      document.querySelectorAll('.rowCheck').forEach(c => c.checked = this.checked); // Set semua checkbox baris mengikuti nilai checkAll
    }); // Tutup event listener

    // === HAPUS PRODUK === // Penanda blok hapus produk
    let rowsToDelete = []; // Array global menampung row yang dipilih untuk dihapus

    function triggerDelete() { // Fungsi pemicu sebelum konfirmasi hapus
      rowsToDelete = [...document.querySelectorAll('.rowCheck:checked')].map(c => c.closest('tr')); // Ambil baris terpilih
      if (rowsToDelete.length === 0) { // Jika tidak ada yang dipilih
        alert('Pilih produk yang ingin dihapus!'); // Tampilkan alert ke user
        return; // Akhiri fungsi
      }
      openPopup('popupHapus'); // Tampilkan popup konfirmasi hapus
    } // Tutup fungsi triggerDelete

    function confirmDelete() { // Fungsi konfirmasi hapus yang melakukan request ke server
      const promises = rowsToDelete.map(row => { // Map setiap row terpilih ke fetch DELETE request (menghasilkan array promise)
        const id = row.querySelector('td strong').innerText; // Ambil id produk dari cell strong

        return fetch(`{{ url('/admin/produk/delete') }}/${id}`, { // Fetch ke route delete (menggunakan id)
            method: 'DELETE', // Metode HTTP DELETE
            headers: { // Header request
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, // CSRF token dari meta tag
              'X-Requested-With': 'XMLHttpRequest', // Menandakan request ini adalah AJAX
              'Accept': 'application/json' // Mengharapkan JSON response
            }
          })
          .then(res => res.json()) // Parse response sebagai JSON
          .then(data => { // Tangani data hasil delete
            if (data.success) { // Jika sukses
              row.remove(); // Hapus baris dari DOM
            } else { // Jika tidak sukses
              alert(data.message || 'Gagal menghapus produk.'); // Tampilkan pesan error
            }
          })
          .catch(() => alert('Terjadi kesalahan koneksi.')); // Tangani error koneksi
      }); // Tutup map

      // Setelah semua fetch selesai → tutup popup
      Promise.all(promises).then(() => { // Tunggu semua promise selesai
        closePopup('popupHapus'); // Tutup popup konfirmasi hapus
      });
    } // Tutup fungsi confirmDelete

    // === FILTER (Kategori, Status, Pencarian) === // Penanda blok filter
    const kategoriSelect = document.querySelector('select[name="kategori"]'); // Elemen select kategori
    const statusSelect = document.querySelector('select[name="status"]'); // Elemen select status
    const searchInput = document.querySelector('input[placeholder="Cari Produk..."]'); // Elemen input pencarian
    const resetBtn = document.getElementById('resetFilter'); // Elemen ikon reset filter

    kategoriSelect.addEventListener('change', filterProduk); // Pasang event change pada kategoriSelect
    statusSelect.addEventListener('change', filterProduk); // Pasang event change pada statusSelect
    searchInput.addEventListener('input', filterProduk); // Pasang event input pada searchInput
    resetBtn.addEventListener('click', resetFilter); // Pasang click event pada tombol reset

    function filterProduk() { // Fungsi filter produk berdasarkan nilai filter saat ini
      const kategoriValue = kategoriSelect.value.toLowerCase(); // Ambil value kategori dan ubah ke lowercase
      const statusValue = statusSelect.value.toLowerCase(); // Ambil value status dan ubah ke lowercase
      const searchValue = searchInput.value.toLowerCase(); // Ambil nilai pencarian dan ubah ke lowercase

      const rows = document.querySelectorAll('table tbody tr'); // Ambil semua baris produk
      let visibleCount = 0; // Counter baris yang terlihat setelah filter

      rows.forEach(row => { // Iterasi setiap baris
        const kategori = row.children[3].innerText.toLowerCase(); // Ambil teks kolom kategori pada baris (index 3)
        const status = row.querySelector('.status').innerText.toLowerCase().trim(); // Ambil teks status (dari badge)
        const nama = row.children[2].innerText.toLowerCase(); // Ambil nama produk (index 2)

        const matchKategori = (kategoriValue === '' || kategori === kategoriValue); // Cek kecocokan kategori (kosong = semua)
        const matchStatus = (statusValue === '' || status === statusValue); // Cek kecocokan status
        const matchSearch = (searchValue === '' || nama.includes(searchValue)); // Cek kecocokan pencarian pada nama

        const visible = matchKategori && matchStatus && matchSearch; // Baris terlihat hanya jika semua match
        row.style.display = visible ? '' : 'none'; // Tampilkan atau sembunyikan baris
        if (visible) visibleCount++; // Tambah counter bila terlihat
      });

      updateEmptyRow(visibleCount); // Update row kosong/pesan bila tidak ada data yang tampil
    } // Tutup fungsi filterProduk

    function resetFilter() { // Fungsi mereset semua filter ke default dan animasi reset
      // Reset semua nilai filter
      kategoriSelect.value = ''; // Set kategori ke kosong
      statusSelect.value = ''; // Set status ke kosong
      searchInput.value = ''; // Kosongkan input pencarian

      // Tampilkan semua baris produk
      const rows = document.querySelectorAll('table tbody tr'); // Ambil semua baris
      rows.forEach(row => {
        row.style.display = ''; // Tampilkan setiap baris
      });

      // Hapus baris "Tidak ada produk ditemukan" kalau ada
      const emptyRow = document.getElementById('emptyRow'); // Ambil elemen emptyRow bila ada
      if (emptyRow) {
        emptyRow.remove(); // Hapus elemen emptyRow
      }

      // Animasi kecil untuk icon reset
      resetBtn.style.transform = 'rotate(360deg)'; // Putar icon 360deg
      setTimeout(() => { // Setelah 400ms balikkan rotasi
        resetBtn.style.transform = 'rotate(0deg)';
      }, 400);
    } // Tutup fungsi resetFilter

    // Pastikan baris "Tidak ada produk ditemukan" hilang kalau tabel punya data
    document.addEventListener('DOMContentLoaded', () => { // Jalankan saat DOM load selesai
      const tbody = document.querySelector('table tbody'); // Ambil tbody tabel
      const emptyRow = document.getElementById('emptyRow'); // Ambil elemen emptyRow bila ada

      // Cek apakah tabel berisi baris produk (yang punya <strong>)
      const hasProducts = [...tbody.querySelectorAll('tr')].some(
        tr => tr.querySelector('td strong')
      ); // Boolean: true jika ada baris dengan <strong> (menandakan data produk)

      // Jika ada produk, hapus pesan kosong
      if (hasProducts && emptyRow) {
        emptyRow.remove(); // Hapus row kosong jika ada produk
      }

      // Tambahan ekstra keamanan: jalankan ulang setelah 300ms
      // (kadang Blade render belum sepenuhnya selesai saat onload)
      setTimeout(() => {
        const emptyRowCheck = document.getElementById('emptyRow'); // Cek lagi
        const hasProductsNow = [...tbody.querySelectorAll('tr')].some(
          tr => tr.querySelector('td strong')
        ); // Cek apakah sekarang ada produk
        if (hasProductsNow && emptyRowCheck) {
          emptyRowCheck.remove(); // Hapus jika ditemukan
        }
      }, 300); // Delay 300ms
    }); // Tutup DOMContentLoaded listener

    function updateEmptyRow(visibleCount) { // Fungsi menampilkan/hapus row "Tidak ada produk ditemukan"
      const tbody = document.querySelector('table tbody'); // Ambil tbody
      const emptyRow = document.getElementById('emptyRow'); // Ambil elemen emptyRow bila ada

      // kalau ada produk yang tampil → pastikan baris kosong dihapus
      if (visibleCount > 0) {
        if (emptyRow) emptyRow.remove(); // Hapus emptyRow jika ada
      }
      // kalau tidak ada produk → tampilkan pesan
      else {
        if (!emptyRow) { // Jika belum ada emptyRow, buat baru
          const row = document.createElement('tr'); // Buat elemen tr
          row.id = 'emptyRow'; // Set id untuk referensi
          row.innerHTML = `
          <td colspan="9" style="text-align:center; padding:20px; color:#888;">
            Tidak ada produk ditemukan
          </td>`; // HTML konten row kosong (tetap utuh agar kode tidak berubah)
          tbody.appendChild(row); // Tambahkan row ke tbody
        }
      }
    } // Tutup fungsi updateEmptyRow

    // === EDIT PRODUK === // Penanda blok edit produk
    const editIcon = document.getElementById('iconEdit'); // Ambil elemen iconEdit
    if (editIcon) { // Jika elemen iconEdit ada di DOM
      editIcon.addEventListener('click', () => { // Pasang event click untuk memulai proses edit
        const selected = [...document.querySelectorAll('.rowCheck:checked')]; // Ambil checkbox terpilih
        if (selected.length === 0) { // Jika tidak ada yang dipilih
          alert('Pilih produk yang ingin diedit!'); // Tampilkan alert
          return; // Hentikan eksekusi
        }
        if (selected.length > 1) { // Jika lebih dari 1 dipilih
          alert('Hanya bisa mengedit satu produk!'); // Tampilkan alert
          return; // Hentikan eksekusi
        }

        const row = selected[0].closest('tr'); // Ambil baris yang dipilih
        const id = row.querySelector('td strong').innerText; // Ambil id produk
        const cells = row.querySelectorAll('td'); // Ambil semua cell baris
        const popup = document.getElementById('popupEdit'); // Ambil popup edit
        const form = popup.querySelector('form'); // Ambil form di popup edit

        form.innerHTML = `
        <label>Gambar Produk</label>
        <input type="file" name="gambar" id="editGambarProduk" accept="image/*">

        <label>Nama Produk</label>
        <input type="text" name="nama_produk" value="${cells[2].innerText}" required>

        <label>Kategori</label>
        <select name="kategori" required>
          <option value="Paket Slice" ${cells[3].innerText==='Paket Slice'?'selected':''}>Paket Slice</option>
          <option value="Paket Alat"  ${cells[3].innerText==='Paket Alat' ?'selected':''}>Paket Alat</option>
        </select>

        <label>Stok</label>
        <input type="number" name="stok" value="${cells[4].innerText}" required>

        <label>Deskripsi</label>
        <textarea name="deskripsi" required>${cells[5].innerText}</textarea>

        <label>Harga</label>
        <input type="number" name="harga" value="${cells[6].innerText.replace(/\D/g,'')}" required>

        <div class="popup-footer">
          <button type="button" class="btn btn-secondary" onclick="closePopup('popupEdit')">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      `; // Penutup assignment form.innerHTML — string HTML asli tetap utuh (tanpa komentar di dalam string)

        form.onsubmit = async (ev) => { // Handler submit form edit (menggunakan AJAX fetch)
          ev.preventDefault(); // Mencegah submit form tradisional

          const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content'); // Ambil CSRF token
          const fd = new FormData(form); // Buat FormData dari form

          // kalau user tidak ganti gambar, hapus field agar tidak memicu validasi file
          const fileInput = form.querySelector('input[name="gambar"]'); // Ambil input file
          if (!fileInput.files || fileInput.files.length === 0) { // Jika tidak ada file dipilih
            fd.delete('gambar'); // Hapus field gambar dari FormData
          }

          // ✅ gunakan URL dengan prefix /admin
          const updateUrl = `{{ url('/admin/produk/update') }}/${id}`; // URL update produk dengan id

          try { // Try-catch untuk request jaringan
            const res = await fetch(updateUrl, {
              method: 'POST', // Metode POST (bisa ditangani oleh controller update)
              headers: {
                'X-CSRF-TOKEN': token, // Header CSRF token
                // ✅ pastikan dianggap AJAX & minta JSON
                'X-Requested-With': 'XMLHttpRequest', // Menandakan AJAX request
                'Accept': 'application/json' // Minta response JSON
              },
              body: fd // Kirim FormData sebagai body
            });

            if (!res.ok) { // Jika response HTTP tidak ok (status >=400)
              const data = await res.json().catch(() => ({})); // Coba parse JSON atau fallback {}
              alert(data.message || 'Gagal menyimpan perubahan.'); // Tampilkan pesan error
              return; // Hentikan eksekusi
            }

            // kalau controller balas JSON success
            const data = await res.json().catch(() => ({})); // Parse JSON response
            if (data && data.success) { // Jika ada properti success true
              location.reload(); // Reload halaman untuk melihat perubahan
            } else {
              // fallback: kalau ternyata balasannya bukan JSON tapi 200 (mis. redirect)
              location.reload(); // Reload juga sebagai fallback
            }
          } catch (e) { // Tangani error jaringan
            alert('Terjadi kesalahan koneksi.'); // Tampilkan alert error koneksi
          }
        }; // Tutup onsubmit handler

        openPopup('popupEdit'); // Tampilkan popup edit
      }); // Tutup event listener click iconEdit
    } // Tutup kondisi if(editIcon)
  </script> <!-- Tutup blok script -->
</body> <!-- Tutup body -->

</html> <!-- Tutup html (asumsi file ini lengkap) -->