<!DOCTYPE html> <!-- Deklarasi tipe dokumen HTML5 -->
<html lang="id"> <!-- Tag HTML utama, bahasa diset ke Indonesia -->

<head> <!-- Bagian head untuk metadata dan stylesheet -->
  <meta charset="UTF-8"> <!-- Set karakter encoding ke UTF-8 -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsif untuk mobile -->
  <title>Manajemen Transaksi | Barbekuy</title> <!-- Judul tab browser -->
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}"> <!-- Favicon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> <!-- Font Awesome CDN -->

  {{-- Google Font --}}
  <!-- Import font Poppins dari Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
    /* Mulai CSS internal */
    * {
      margin: 0;
      /* Hilangkan margin default */
      padding: 0;
      /* Hilangkan padding default */
      box-sizing: border-box;
      /* Hitung ukuran termasuk padding/border */
      font-family: 'Poppins', sans-serif
        /* Gunakan font Poppins */
    }

    body {
      background: #f5f6fa;
      /* Warna background terang */
      display: flex;
      /* Layout fleksibel */
      min-height: 100vh
        /* Tinggi minimal layar penuh */
    }

    /* Content */
    .content {
      flex: 1;
      /* Ambil ruang tersisa */
      padding: 30px 40px
        /* Ruang dalam area konten */
    }

    /* kotak utama jadi kolom biar area tabel bisa ambil tinggi tersisa */
    .content-box {
      background: #fff;
      /* Warna putih */
      border-radius: 12px;
      /* Sudut membulat */
      box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
      /* Bayangan lembut */
      display: flex;
      /* Layout flex */
      flex-direction: column;
      /* Susunan vertikal */
      height: 78vh;
      /* Tinggi custom */
      min-height: 0;
      /* Supaya flex child bisa shrink */
      padding: 28px
        /* Padding dalam box */
    }

    /* area khusus yg scroll */
    .table-scroll {
      flex: 1 1 auto;
      /* Bisa membesar & mengecil */
      min-height: 0;
      /* Biar scroll bekerja */
      overflow-y: auto;
      /* Scroll vertikal */
      border: 1px solid #eee;
      /* Border tipis */
      border-radius: 8px;
      /* Sudut membulat */
    }

    /* header tabel lengket di atas saat scroll */
    .table-scroll thead th {
      position: sticky;
      /* Sticky header */
      top: 0;
      /* Menempel di bagian atas */
      background: #fff;
      /* Background putih agar tidak transparan */
      z-index: 5;
      /* Biarkan berada di atas baris lain */
    }

    .content-header {
      display: flex;
      /* Susunan fleksibel */
      justify-content: space-between;
      /* Spasi rata kiri-kanan */
      align-items: center;
      /* Rata tengah vertikal */
      margin-bottom: 25px
        /* Jarak bawah */
    }

    .content-header h2 {
      font-size: 20px;
      /* Ukuran teks */
      font-weight: 600;
      /* Tebal */
      color: #333
        /* Warna gelap */
    }

    .btn {
      border: none;
      /* Tanpa border */
      padding: 9px 16px;
      /* Ruang dalam */
      border-radius: 6px;
      /* Sudut tumpul */
      font-size: 14px;
      /* Ukuran teks */
      cursor: pointer;
      /* Tampil pointer */
      font-weight: 500;
      /* Ketebalan teks */
      transition: .3s
        /* Animasi hover */
    }

    .btn-primary {
      background: #751A25;
      /* Warna merah gelap */
      color: #fff
        /* Teks putih */
    }

    .btn-primary:hover {
      background: #3d030a
        /* Warna lebih gelap saat hover */
    }

    /* Filter */
    .filters {
      display: flex;
      /* Susunan horizontal */
      justify-content: space-between;
      /* Rata kiri-kanan */
      align-items: center;
      /* Rata tengah vertikal */
      gap: 10px;
      /* Jarak antar item */
      margin-bottom: 25px
        /* Jarak bawah */
    }

    .filter-group {
      display: flex;
      /* Susunan horizontal */
      gap: 10px;
      /* Jarak antar elemen */
      flex: 1
        /* Isi ruang tersedia */
    }

    .filters select,
    .filters input {
      padding: 9px 12px;
      /* Padding input */
      border-radius: 6px;
      /* Sudut tumpul */
      border: 1px solid #dcdcdc;
      /* Border abu */
      font-size: 13px;
      /* Ukuran teks */
      outline: none;
      /* Hilangkan efek fokus bawaan */
      background: #fff
        /* Background putih */
    }

    .filters input {
      flex: 1
        /* Input pencarian ambil ruang lebih besar */
    }

    .filters select#fStatus {
      flex: 0 0 150px;
      /* Lebar tetap */
      width: 150px;
      /* Width eksplisit */
    }

    .filters input[type="date"] {
      flex: 0 0 135px;
      /* Lebar khusus tanggal */
      width: 135px;
      /* Width eksplisit */
      padding: 8px 10px;
      /* Padding lebih kecil */
    }

    .filters span.sep {
      align-self: center;
      /* Rata tengah vertikal */
      color: #666;
      /* Warna abu */
      margin: 0 2px;
      /* Jarak kiri-kanan */
    }

    /* Table */
    table {
      width: 100%;
      /* Penuh */
      border-collapse: collapse
        /* Hilangkan jarak antar border */
    }

    th,
    td {
      text-align: left;
      /* Rata kiri */
      padding: 12px 10px;
      /* Ruang dalam */
      border-bottom: 1px solid #eee;
      /* Garis bawah */
      font-size: 14px
        /* Ukuran teks */
    }

    th {
      color: #555;
      /* Warna lebih gelap */
      font-weight: 500
        /* Ketebalan sedang */
    }

    td a {
      color: #751A25;
      /* Warna link */
      text-decoration: none;
      /* Hilangkan garis bawah */
      font-weight: 500;
      /* Tebal */
      cursor: pointer
        /* Pointer */
    }

    td a:hover {
      text-decoration: underline
        /* Beri garis bawah saat hover */
    }

    table tbody tr:hover {
      background-color: rgba(211, 47, 47, .15);
      /* Hover merah transparan */
    }

    .status-select {
      /* Style untuk select status utama */
      appearance: none;
      /* Hilangkan tampilan default browser */
      border: 0;
      /* Tanpa border */
      padding: 4px 12px;
      /* Padding dalam */
      border-radius: 999px;
      /* Bentuk kapsul */
      font-size: 12px;
      /* Ukuran teks */
      font-weight: 500;
      /* Ketebalan teks */
      line-height: 1.6;
      /* Tinggi baris */
      cursor: pointer;
      /* Tunjukkan pointer saat hover */
    }

    .status-select.st-belum-bayar {
      /* Warna untuk status Belum Bayar */
      background: #ffe3e3;
      /* Background merah muda */
      color: #b71c1c;
      /* Teks merah gelap */
    }

    .status-select.st-diproses {
      /* Warna status Diproses */
      background: #fff7cc;
      /* Background kuning muda */
      color: #a77f00;
      /* Teks kuning gelap */
    }

    .status-select.st-siap-diambil {
      /* Warna Siap Diambil */
      background: #d2f7d0;
      /* Hijau muda */
      color: #2e7d32;
      /* Hijau tua */
    }

    .status-select.st-disewa {
      /* Warna Disewa */
      background: #e0f2ff;
      /* Biru muda */
      color: #0b6aa1;
      /* Biru gelap */
    }

    .status-select.st-selesai {
      /* Warna status Selesai */
      background: #d2f7d0;
      /* Hijau muda */
      color: #2e7d32;
      /* Hijau tua */
    }

    .status-select.st-dibatalkan {
      /* Warna Dibatalkan */
      background: #eee;
      /* Abu muda */
      color: #666;
      /* Abu gelap */
    }

    /* Pill yang tampil di tabel */
    .status-pill {
      /* Tampilan status berbentuk chip */
      border: 0;
      /* Tanpa border */
      border-radius: 999px;
      /* Bentuk kapsul penuh */
      padding: 4px 12px;
      /* Padding kecil */
      font-size: 12px;
      /* Ukuran teks kecil */
      font-weight: 500;
      /* Teks agak tebal */
      cursor: pointer;
      /* Bisa diklik */
    }

    /* Dropdown container */
    .status-dd {
      /* Wrapper dropdown */
      position: relative;
      /* Posisi relatif untuk menu */
      display: inline-block;
      /* Elemen inline-block */
    }

    .status-menu {
      /* Menu dropdown */
      position: absolute;
      /* Posisi absolut */
      top: 115%;
      /* Muncul di bawah pill */
      left: 0;
      /* Rata kiri */
      min-width: 160px;
      /* Lebar minimal */
      background: #fff;
      /* Background putih */
      border: 1px solid #eaeaea;
      /* Border tipis */
      border-radius: 10px;
      /* Sudut membulat */
      box-shadow: 0 12px 24px rgba(0, 0, 0, .1);
      /* Bayangan */
      padding: 6px;
      /* Padding */
      margin: 0;
      /* Tanpa margin */
      list-style: none;
      /* Hilangkan dot list */
      display: none;
      /* Awalnya disembunyikan */
      z-index: 20;
      /* Di atas elemen lain */
    }

    .status-dd.open .status-menu {
      /* Saat dropdown terbuka */
      display: block;
      /* Tampilkan */
    }

    .status-item {
      /* Item dalam dropdown */
      --dot: #999;
      /* Default warna dot */
      display: flex;
      /* Flex item */
      align-items: center;
      /* Rata tengah vertikal */
      justify-content: center;
      /* Konten tengah */
      gap: 8px;
      /* Jarak antar elemen */
      width: 100%;
      /* Lebar penuh */
      padding: 8px 10px;
      /* Padding compact */
      font-size: 12px;
      /* Ukuran teks */
      font-weight: 600;
      /* Tebal */
      border: 1px solid transparent;
      /* Border default */
      border-radius: 8px;
      /* Sudut lembut */
      background: #fff;
      /* Background putih */
      color: #333;
      /* Teks abu gelap */
      cursor: pointer;
      /* Klikable */
      transition: .15s ease;
      /* Animasi lembut */
    }

    .status-item:hover {
      /* Hover item */
      background: #f7f7f7;
      /* Background abu muda */
      border-color: #eee;
      /* Border abu */
      transform: translateY(-1px);
      /* Sedikit naik */
    }

    .status-item::before {
      /* Dot warna di kiri */
      content: "";
      /* Elemen kosong */
      width: 8px;
      /* Ukuran dot */
      height: 8px;
      /* Ukuran */
      border-radius: 50%;
      /* Bulat sempurna */
      background: var(--dot);
      /* Warna dari variabel */
    }

    .status-item.is-active {
      /* Item aktif */
      background: #f0f3ff;
      /* Background biru muda */
      border-color: #e3e8ff;
      /* Border biru */
    }

    .status-item.is-active::after {
      /* Icon centang aktif */
      content: "\f00c";
      /* Glyph FontAwesome */
      font-family: "Font Awesome 6 Free";
      /* FA family */
      font-weight: 900;
      /* Bold FA */
      font-size: 10px;
      /* Ukuran kecil */
      margin-left: 6px;
      /* Jarak kiri */
      color: #6473ff;
      /* Warna biru */
    }

    /* Map warna dot per status */
    .status-item.st-belum-bayar {
      --dot: #e53935;
    }

    /* Merah */

    .status-item.st-diproses {
      --dot: #f5a524;
    }

    /* Oranye */

    .status-item.st-siap-diambil {
      --dot: #0ea5e9;
    }

    /* Biru muda */

    .status-item.st-disewa {
      --dot: #6366f1;
    }

    /* Indigo */

    .status-item.st-selesai {
      --dot: #22c55e;
    }

    /* Hijau */

    .status-item.st-dibatalkan {
      --dot: #9ca3af;
    }

    /* Abu */

    /* Pill style tambahan */
    .status-pill {
      /* Chip status di tabel */
      display: inline-block;
      /* Inline block */
      border: 1px solid transparent;
      /* Border default */
      border-radius: 6px;
      /* Sudut kapsul */
      padding: 4px 10px;
      /* Padding compact */
      font-size: 12px;
      /* Ukuran teks */
      font-weight: 500;
      /* Ketebalan */
      cursor: pointer;
      /* Bisa diklik */
      position: relative;
      /* Untuk caret */
      line-height: 1.2;
      /* Line height */
    }

    .status-pill::after {
      /* Icon caret down */
      content: "\f107";
      /* FontAwesome caret */
      font-family: "Font Awesome 6 Free";
      /* Font Awesome */
      font-weight: 900;
      /* Bold */
      font-size: 10px;
      /* Ukuran icon */
      margin-left: 6px;
      /* Jarak kiri */
    }

    .status-dd.open .status-pill {
      /* Saat dropdown terbuka */
      outline: 1px solid #e5e7eb;
      /* Outline abu */
    }

    .status-dd.open .status-pill::after {
      /* Ikon berubah caret up */
      content: "\f106";
      /* caret-up */
    }

    /* Warna pill per status */
    .status-pill.st-belum-bayar {
      /* Chip Belum Bayar */
      background: #f9d2d0;
      /* Merah pastel */
      color: #b71c1c;
      /* Merah tua */
      border-color: #f3b5b2;
      /* Border merah muda */
    }

    .status-pill.st-diproses {
      /* Chip Diproses */
      background: #fff3bf;
      /* Kuning pastel */
      color: #a77f00;
      /* Kuning tua */
      border-color: #ffe7a0;
      /* Border */
    }

    .status-pill.st-siap-diambil {
      /* Chip Siap Diambil */
      background: #e0f2ff;
      /* Biru muda */
      color: #0b6aa1;
      /* Biru tua */
      border-color: #cfe8ff;
      /* Border biru */
    }

    .status-pill.st-disewa {
      /* Chip Disewa */
      background: #ebe9ff;
      /* Ungu muda */
      color: #3b3bb3;
      /* Ungu tua */
      border-color: #ddd9ff;
      /* Border */
    }

    .status-pill.st-selesai {
      /* Chip Selesai */
      background: #d2f7d0;
      /* Hijau muda */
      color: #2e7d32;
      /* Hijau tua */
      border-color: #b9efb6;
      /* Border */
    }

    .status-pill.st-dibatalkan {
      /* Chip Dibatalkan */
      background: #f0f0f0;
      /* Abu */
      color: #666;
      /* Abu gelap */
      border-color: #e3e3e3;
      /* Border */
    }

    .alert {
      /* Alert base */
      margin-bottom: 16px;
      /* Jarak bawah */
      padding: 10px 12px;
      /* Padding */
      border-radius: 8px;
      /* Sudut */
      border: 1px solid transparent;
      /* Border default */
    }

    .alert-success {
      /* Alert sukses */
      background: #eaf8ec;
      /* Hijau muda */
      color: #1d7a3d;
      /* Hijau tua */
      border-color: #cbeed3;
      /* Border */
    }

    .alert-error {
      /* Alert error */
      background: #fdeaea;
      /* Merah muda */
      color: #9b1c1c;
      /* Merah tua */
      border-color: #f5c2c2;
      /* Border */
    }

    .table-select {
      /* Select dalam tabel */
      padding: 6px 10px;
      /* Padding */
      border-radius: 6px;
      /* Sudut */
      border: 1px solid #dcdcdc;
      /* Border abu */
      font-size: 13px;
      /* Ukuran teks */
      background: #fff;
      /* Background putih */
    }

    .row-actions {
      /* Container aksi dalam row */
      display: flex;
      /* Flex */
      gap: 8px;
      /* Jarak antar tombol */
      align-items: center;
      /* Rata tengah */
    }

    .modal {
      /* Overlay modal */
      position: fixed;
      /* Tetap di layar */
      inset: 0;
      /* Penuh layar */
      background: rgba(0, 0, 0, .45);
      /* Gelap transparan */
      display: none;
      /* Awalnya sembunyi */
      align-items: center;
      /* Tengah vertikal */
      justify-content: center;
      /* Tengah horizontal */
      z-index: 1500;
      /* Di atas elemen lain */
    }

    .modal.open {
      /* Saat modal terbuka */
      display: flex;
      /* Tampilkan */
    }

    .modal-card {
      /* Card dalam modal */
      width: 720px;
      /* Lebar */
      max-width: 92vw;
      /* Untuk HP */
      background: #fff;
      /* Background putih */
      border-radius: 14px;
      /* Sudut membulat */
      box-shadow: 0 10px 30px rgba(0, 0, 0, .15);
      /* Bayangan */
      overflow: hidden;
      /* Hilangkan overflow */
    }

    .modal-head {
      /* Header modal */
      display: flex;
      /* Flex */
      align-items: center;
      /* Tengah */
      justify-content: space-between;
      /* Jarak kiri-kanan */
      padding: 16px 18px;
      /* Padding */
      border-bottom: 1px solid #eee;
      /* Garis bawah */
      background: #fafafa;
      /* Background abu */
    }

    .modal-head .modal-close {
      /* Tombol close header */
      width: 28px;
      /* Ukuran */
      height: 28px;
      /* Ukuran */
      padding: 0;
      /* Hilangkan padding */
      font-size: 16px;
      /* Ukuran ikon */
      line-height: 1;
      /* Height */
      display: inline-flex;
      /* Tengah */
      align-items: center;
      /* Tengah */
      justify-content: center;
      /* Tengah */
      border: none;
      /* Tanpa border */
      border-radius: 6px;
      /* Sudut */
      background: transparent;
      /* Tanpa background */
      color: #751A25;
      /* Warna merah */
      cursor: pointer;
      /* Klikable */
      transition: 0.2s;
      /* Animasi */
    }

    .modal-head .modal-close:hover {
      /* Hover close */
      background: #f3f4f6;
      /* Background abu muda */
    }

    .modal-head h3 {
      /* Judul modal */
      font-size: 16px;
      /* Ukuran teks */
      font-weight: 600;
      /* Tebal */
    }

    .modal-close {
      /* Tombol close di footer */
      width: 28px;
      /* Ukuran default */
      height: 28px;
      /* Ukuran */
      padding: 0;
      /* No padding */
      font-size: 16px;
      /* Ukuran icon */
      line-height: 1;
      /* Line height */
      display: inline-flex;
      /* Tengah */
      align-items: center;
      /* Tengah */
      justify-content: center;
      /* Tengah */
      border-radius: 6px;
      /* Sudut */
      color: #751A25;
      /* Warna */
    }

    .modal-body {
      /* Isi modal */
      padding: 18px;
      /* Padding */
      max-height: 70vh;
      /* Max tinggi */
      overflow: auto;
      /* Scroll */
    }

    .modal-section {
      /* Bagian modal */
      margin-bottom: 14px;
      /* Jarak bawah */
    }

    .modal-section h4 {
      /* Subjudul */
      font-size: 13px;
      /* Ukuran */
      font-weight: 600;
      /* Tebal */
      color: #444;
      /* Abu gelap */
      margin-bottom: 6px;
      /* Jarak */
    }

    .kv {
      /* Grid info */
      display: grid;
      /* Grid */
      grid-template-columns: 140px 1fr;
      /* Kolom kiri & kanan */
      gap: 8px 12px;
      /* Jarak */
      font-size: 13px;
      /* Ukuran teks */
    }

    .kv div {
      /* Item dalam grid */
      padding: 3px 0;
      /* Padding */
    }

    .items-table {
      /* Tabel item */
      width: 100%;
      /* Lebar penuh */
      border-collapse: collapse;
      /* Hilangkan spasi border */
      font-size: 13px;
      /* Ukuran teks */
      margin-top: 6px;
      /* Jarak atas */
    }

    .items-table th,
    .items-table td {
      /* Sel tabel */
      border-bottom: 1px solid #eee;
      /* Garis bawah */
      text-align: left;
      /* Rata kiri */
      padding: 8px 6px;
      /* Padding */
    }

    .items-table th {
      /* Header tabel */
      color: #666;
      /* Abu gelap */
      font-weight: 600;
      /* Tebal */
    }

    .modal-foot {
      /* Footer modal */
      padding: 14px 18px;
      /* Padding */
      display: flex;
      /* Flex */
      justify-content: flex-end;
      /* Rata kanan */
      gap: 10px;
      /* Jarak */
      border-top: 1px solid #eee;
      /* Garis atas */
    }

    .modal-foot .modal-close {
      /* Tombol close */
      width: auto;
      /* Auto width */
      height: auto;
      /* Auto height */
      padding: 8px 16px;
      /* Padding */
      font-size: 14px;
      /* Ukuran teks */
      border: none;
      /* Tanpa border */
      border-radius: 8px;
      /* Sudut */
      background: #751A25;
      /* Merah */
      color: #fff;
      /* Putih */
      cursor: pointer;
      /* Klikable */
      transition: 0.2s;
      /* Animasi */
    }

    .modal-foot .modal-close:hover {
      /* Hover */
      background: #500f19;
      /* Merah gelap */
    }

    .modal-foot .btn {
      /* Tombol lain */
      padding: 8px 12px;
      /* Padding */
      border-radius: 8px;
      /* Sudut */
      background: #751A25;
      /* Warna */
      color: #fff;
      /* Putih */
      border: 0;
      /* Tanpa border */
      cursor: pointer;
      /* Klikable */
    }

    .detail-link {
      /* Link di tabel */
      background: transparent;
      /* Transparan */
      border: 0;
      /* Tanpa border */
      padding: 0;
      /* Tanpa padding */
      color: #751A25;
      /* Merah */
      font-size: 15px;
      /* Ukuran */
      line-height: 1;
      /* Rapih */
      cursor: pointer;
      /* Klikable */
    }

    .detail-link:hover,
    .detail-link:focus {
      /* Hover link */
      text-decoration: underline;
      /* Garis bawah */
      outline: none;
      /* Tanpa outline */
    }

    .ktp-preview {
      /* Batasi lebar & tinggi gambar */
      max-width: 100%;
      /* biar gak melebar keluar container */
      width: auto;
      /* biar proporsional */
      height: auto;
      /* tetap jaga aspek rasio */
      max-height: 260px;
      /* 🔥 batasi tinggi gambar (silakan sesuaikan angka ini) */

      object-fit: contain;
      /* gambar tetap utuh, tidak terpotong */
      border-radius: 8px;
      border: 1px solid #eee;
      display: block;
    }

    /* Ringkasan total (subtotal, biaya layanan, total pembayaran) */
    .kv-amount {
      max-width: 360px;
      /* Biar tidak terlalu lebar */
      margin-left: auto;
      /* Geser ke kanan */
      margin-top: 8px;
    }

    .kv-amount div:nth-child(2n) {
      text-align: right;
      /* Kolom nilai di kanan */
    }

    @media (max-width: 600px) {
      /* Responsive untuk HP */

      .content {
        padding: 18px 16px;
      }

      /* Padding kecil */

      .content-header {
        flex-direction: column;
        /* Header jadi vertikal */
        align-items: flex-start;
        /* Rata kiri */
        gap: 10px;
        /* Jarak */
      }

      .content-header h2 {
        font-size: 18px;
      }

      /* Kecil */

      .filters {
        /* Filter scroll */
        overflow-x: auto;
        /* Scroll horizontal */
        flex-wrap: nowrap;
        /* Tidak turun baris */
        justify-content: flex-start;
        /* Rata kiri */
        -webkit-overflow-scrolling: touch;
        /* Smooth scroll */
        padding-bottom: 6px;
        /* Jarak bawah */
      }

      .filter-group {
        flex-wrap: nowrap;
        /* Tidak melipat */
        width: max-content;
        /* Lebar sesuai konten */
        display: flex;
        /* Flex */
        gap: 10px;
        /* Jarak */
      }

      .filters select,
      .filters input {
        white-space: nowrap;
        /* Tidak wrap */
        flex: 0 0 auto;
        /* Lebar tetap */
      }

      .filters span {
        flex: 0 0 auto;
      }

      /* Span tidak melar */

      .table-scroll {
        /* Tabel bisa geser */
        overflow-x: auto;
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
      }

      table {
        min-width: 650px;
      }

      /* Tabel minimal 650px */

      th,
      td {
        font-size: 12px;
        /* Kecil */
        padding: 10px 8px;
        /* Padding kecil */
      }

      .status-pill {
        font-size: 11px;
        /* Lebih kecil */
        padding: 4px 8px;
        /* Kecil */
      }

      .modal-card {
        max-width: 95vw;
        /* Hampir penuh layar */
      }

      .modal-body .items-table th,
      .modal-body .items-table td {
        padding: 6px 4px;
        /* Padat */
        font-size: 11px;
        /* Kecil */
      }

      .modal-body .items-table th:nth-child(1),
      .modal-body .items-table td:nth-child(1) {
        width: 45%;
        /* Kolom Produk */
      }

      .modal-body .items-table th:nth-child(2),
      .modal-body .items-table td:nth-child(2) {
        width: 15%;
        /* Qty */
      }

      .modal-body .items-table th:nth-child(3),
      .modal-body .items-table td:nth-child(3) {
        width: 45%;
        /* Harga */
      }

      .modal-body .items-table th:nth-child(4),
      .modal-body .items-table td:nth-child(4) {
        width: 25%;
        /* Subtotal */
      }

      .modal-body .items-table {
        min-width: auto;
        /* Auto width */
        width: 100%;
        /* Penuh */
        overflow-x: auto;
        /* Bisa geser */
      }
    }
  </style>
</head>

<body> <!-- Tag pembuka body halaman -->
  {{-- 🔹 Sidebar + Topbar --}} {{-- Include layout navbar/topbar admin --}}
  @include('layouts.navbarAdmin') {{-- Menyisipkan navbar dan sidebar dari layout --}}

  @php // Mulai blok PHP untuk variabel mapping status
  // Map status -> kelas badge (untuk tampilan) // komentar asli sudah ada
  $statusClass = [ // Array mapping status ke kelas
  'Belum Bayar' => 'belum-bayar', // Mapping: "Belum Bayar" -> "belum-bayar"
  'Diproses' => 'diproses', // Mapping: "Diproses" -> "diproses"
  'Siap Diambil' => 'siap-diambil', // Mapping: "Siap Diambil" -> "siap-diambil"
  'Disewa' => 'disewa', // Mapping: "Disewa" -> "disewa"
  'Selesai' => 'selesai', // Mapping: "Selesai" -> "selesai"
  'Dibatalkan' => 'dibatalkan', // Mapping: "Dibatalkan" -> "dibatalkan"
  ]; // Tutup array $statusClass
  @endphp {{-- Tutup blok PHP --}}

  <!-- Main Content --> <!-- Komentar: area konten utama -->
  <main class="main-content"> <!-- Tag main untuk isi halaman -->
    <div class="content"> <!-- Wrapper .content (kanan) -->
      <div class="content-box"> <!-- Kotak putih utama berisi header, filter, tabel -->

        <div class="content-header"> <!-- Header konten: judul + aksi -->
          <h2>Manajemen Transaksi Pemesanan</h2> <!-- Judul halaman -->
          <a
            href="{{ route('admin.transaksi.export', request()->only(['status','from','to','q'])) }}"
            class="btn btn-primary">
            Export CSV
          </a> <!-- Tombol export Excel -->
        </div> <!-- Tutup .content-header -->

        {{-- Flash & Error --}} {{-- Bagian notifikasi sukses/eror --}}
        @if (session('success')) {{-- Cek session success --}}
        <div class="alert alert-success">{{ session('success') }}</div> <!-- Tampilkan pesan sukses -->
        @endif {{-- Tutup if session success --}}
        @if ($errors->any()) {{-- Cek apakah ada error validasi --}}
        <div class="alert alert-error">{{ $errors->first() }}</div> <!-- Tampilkan error pertama -->
        @endif {{-- Tutup if errors --}}

        <div class="filters"> <!-- Kontainer filter (status, tanggal, pencarian) -->
          <form method="GET" class="filter-group" id="txFilterForm"> <!-- Form GET untuk filter server-side -->
            {{-- STATUS (utama) --}} {{-- Label internal: dropdown status --}}
            <select name="status" id="fStatus"> <!-- Dropdown status untuk filter -->
              <option value="">Semua Status</option> <!-- Opsi default: semua status -->
              @foreach ($statuses as $st) <!-- Looping status dari backend -->
              <option value="{{ $st }}" {{ request('status')===$st ? 'selected' : '' }}> <!-- Pilih jika cocok request -->
                {{ $st }} <!-- Tampilkan teks status -->
              </option> <!-- Tutup option -->
              @endforeach <!-- Tutup loop statuses -->
            </select> <!-- Tutup select status -->

            {{-- RENTANG TANGGAL --}} {{-- Rentang tanggal dari/ke untuk filter --}}
            <input type="date" name="from" id="fFrom" value="{{ request('from') }}"> <!-- Input tanggal mulai -->
            <span style="align-self:center;color:#666;">s.d.</span> <!-- Separator "s.d." -->
            <input type="date" name="to" id="fTo" value="{{ request('to') }}"> <!-- Input tanggal akhir -->

            {{-- PENCARIAN (ID / Nama penerima) --}} {{-- Pencarian client-side / server-side --}}
            <!-- Input pencarian transaksi -->
            <!-- type="text" → Tipe teks untuk pencarian -->
            <!-- name="q" → Nama input q -->
            <!-- id="fQ" → ID fQ untuk JS -->
            <!-- placeholder → Placeholder input -->
            <!-- value → Nilai default dari request -->
            <!-- autocomplete → Nonaktifkan autocomplete browser -->
            <!-- style → Flex style agar mengisi ruang -->

            <input
              type="text"
              name="q"
              id="fQ"
              placeholder="Cari ID Transaksi / Nama penerima…"
              value="{{ request('q') }}"
              autocomplete="off"
              style="flex:1" />
          </form> <!-- Tutup form filter -->
        </div> <!-- Tutup .filters -->
        <div class="table-scroll"> <!-- Wrapper yang bisa discroll untuk tabel -->
          <table> <!-- Tabel transaksi -->
            <thead> <!-- Header tabel -->
              <tr> <!-- Baris header -->
                <th>ID Transaksi</th> <!-- Kolom ID -->
                <th>Tanggal Pemesanan</th> <!-- Kolom tanggal -->
                <th>Nama</th> <!-- Kolom nama penerima/user -->
                <th>Status Pemesanan</th> <!-- Kolom status -->
                <th>Total</th> <!-- Kolom total harga -->
                <th>Aksi</th> <!-- Kolom aksi (detail) -->
              </tr> <!-- Tutup baris header -->
            </thead> <!-- Tutup thead -->
            @php
            // 🔹 Biaya layanan tetap (tidak ambil dari database)
            $BIAYA_LAYANAN = 1000;
            @endphp
            <tbody id="txBody"> <!-- Body tabel dengan id txBody untuk JS -->
              @forelse ($orders as $order) <!-- Loop orders, tampilkan tiap order -->
              <tr> <!-- Baris order -->
                <td>{{ $order->no_pesanan }}</td> <!-- Tampilkan nomor pesanan -->
                <td>{{ optional($order->created_at)->format('d/m/Y') }}</td> <!-- Tampilkan tanggal dibuat (format d/m/Y) -->
                <td>{{ $order->nama_penerima ?? optional($order->user)->name ?? '-' }}</td> <!-- Tampilkan nama penerima atau nama user atau '-' -->

                {{-- STATUS: dropdown bergaya badge, auto-submit saat diubah --}} {{-- Kolom status interaktif --}}
                <td> <!-- Kolom status dengan form PATCH untuk update status -->
                  <form method="POST" action="{{ route('admin.transaksi.updateStatus', $order) }}" class="status-form"> <!-- Form update status -->
                    @csrf <!-- Token CSRF Laravel -->
                    @method('PATCH') <!-- Method spoofing PATCH -->

                    <div class="status-dd"> <!-- Container dropdown status custom -->
                      {{-- tombol pill yang kelihatan di tabel --}} {{-- Tombol pill tampil di tabel --}}
                      <button type="button"
                        class="status-pill {{ 'st-'.Str::of($order->status_pesanan)->lower()->replace(' ', '-') }}"> <!-- Tombol pill dengan kelas dinamis sesuai status -->
                        {{ $order->status_pesanan ?? '-' }} <!-- Teks status atau '-' kalau null -->
                      </button> <!-- Tutup button -->

                      {{-- nilai yang akan dikirim --}} {{-- Input hidden menampung nilai status yang akan dikirim --}}
                      <input type="hidden" name="status_pesanan" value="{{ $order->status_pesanan }}"> <!-- Hidden input status -->

                      {{-- menu opsi berwarna --}} {{-- Daftar opsi status berwarna di dropdown --}}
                      <ul class="status-menu"> <!-- UL menu opsi status -->
                        @foreach ($statuses as $st) <!-- Loop setiap opsi status -->
                        @php // Buat kelas CSS untuk item status --}}
                        $cls = 'st-'.\Illuminate\Support\Str::of($st)->lower()->replace(' ', '-'); // Generate class dari status --}}
                        @endphp <!-- Tutup php singkat -->
                        <li> <!-- Item list -->
                          <button type="button" class="status-item {{ $cls }}" data-value="{{ $st }}"> <!-- Tombol item dengan data-value -->
                            {{ $st }} <!-- Teks opsi status -->
                          </button> <!-- Tutup tombol item -->
                        </li> <!-- Tutup li -->
                        @endforeach <!-- Tutup loop statuses untuk menu -->
                      </ul> <!-- Tutup UL status-menu -->
                    </div> <!-- Tutup .status-dd -->
                  </form> <!-- Tutup form status -->
                </td> <!-- Tutup kolom status -->

                <td>
                  {{-- Total (subtotal + biaya layanan) --}}
                  Rp{{ number_format($order->total_harga, 0, ',', '.') }}
                </td>

                {{-- Aksi tetap: link Detail (atau nanti popup) --}} {{-- Kolom aksi: Detail --}}
                <td> <!-- Kolom Aksi -->
                  @php
                  // Mapping details menjadi array sederhana
                  $items = $order->details->map(function($d){
                  return [
                  'nama' => optional($d->product)->nama_produk ?? 'Produk',
                  'qty' => (int)($d->jumlah ?? 1),
                  // Harga di modal = subtotal per item (total harga produk itu)
                  'harga' => (int)($d->subtotal ?? (($d->harga_satuan ?? $d->harga_sewa ?? 0) * ($d->jumlah ?? 1))),
                  ];
                  })->values()->toArray();

                  // 🔹 Ambil path KTP dari tabel pemesanan
                  $ktpPath = $order->ktp_path;

                  // 🔹 Konversi ke URL penuh (storage)
                  $ktpUrl = $ktpPath
                  ? asset('storage/' . ltrim($ktpPath, '/'))
                  : null;

                  // Hitung subtotal = total_harga - biaya_layanan (tanpa ubah database)
                  $subtotal = (int)($order->total_harga ?? 0);
                  $grandTotal = $subtotal + $BIAYA_LAYANAN;

                  // Siapkan payload order untuk dikirim ke atribut data-order
                  $payload = [
                  'id' => $order->id_pesanan,
                  'no' => $order->no_pesanan,
                  'nama' => $order->nama_penerima ?? optional($order->user)->name,
                  'tgl_pesan' => optional($order->created_at)?->format('d/m/Y'),
                  'tgl_sewa' => optional($order->tanggal_sewa)?->format('d/m/Y'),
                  'tgl_kembali' => optional($order->tanggal_pengembalian)?->format('d/m/Y'),
                  'status' => $order->status_pesanan,
                  'subtotal' => $subtotal, // 70.000 (tetap)
                  'biaya_layanan' => $BIAYA_LAYANAN, // 1.000
                  'total' => $grandTotal, // 71.000 (total pembayaran)
                  'items' => $items,
                  'ktp' => $ktpUrl,
                  ];
                  @endphp

                  <button type="button"
                    class="detail-link"
                    data-order='@json($payload)'> <!-- Tombol yang menyertakan payload JSON di atribut data-order -->
                    Detail <!-- Teks tombol Detail -->
                  </button> <!-- Tutup button detail -->
                </td> <!-- Tutup kolom aksi -->


              </tr> <!-- Tutup baris order -->
              @empty <!-- Jika tidak ada orders -->
              <tr> <!-- Baris fallback kosong -->
                <td colspan="6" style="text-align:center;color:#777;">Belum ada transaksi.</td> <!-- Pesan belum ada transaksi -->
              </tr> <!-- Tutup baris fallback -->
              @endforelse <!-- Tutup forelse loop orders -->
            </tbody> <!-- Tutup tbody -->
          </table> <!-- Tutup table -->
        </div> <!-- Tutup .table-scroll -->
        <!-- ========== Modal Detail Pesanan ========== --> <!-- Komentar pembeda: modal detail -->
        <div class="modal" id="orderModal" aria-hidden="true"> <!-- Modal overlay, awalnya tersembunyi -->
          <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="md-title"> <!-- Card modal dengan aksesibilitas -->
            <div class="modal-head"> <!-- Header modal: judul + close -->
              <h3 id="md-title">Detail Pemesanan</h3> <!-- Judul modal -->
              <button type="button" class="modal-close" aria-label="Tutup"> <!-- Tombol tutup modal -->
                &times; <!-- Simbol × -->
              </button> <!-- Tutup tombol -->
            </div> <!-- Tutup modal-head -->

            <div class="modal-body"> <!-- Container utama isi modal, berisi semua detail pesanan -->
              {{-- 🔹 Informasi Pesanan --}} <!-- Komentar Blade: section untuk info umum pesanan -->
              <div class="modal-section"> <!-- Satu blok/section di dalam modal -->
                <h4>Informasi Pesanan</h4> <!-- Judul kecil section: Informasi Pesanan -->
                <div class="kv" id="md-kv"> <!-- Grid key-value (label : nilai), akan diisi lewat JavaScript -->
                  <!-- Diisi via JS --> <!-- Placeholder, menandakan konten akan di-generate JS -->
                </div> <!-- Tutup div .kv -->
              </div> <!-- Tutup div .modal-section (Informasi Pesanan) -->

              {{-- 🔹 Section Foto KTP --}} <!-- Komentar Blade: section khusus untuk menampilkan foto KTP -->
              <div class="modal-section" id="md-ktp-section" style="display:none;">
                <h4>Foto KTP</h4>
                <img id="md-ktp-img"
                  src=""
                  alt="KTP Pelanggan"
                  class="ktp-preview"> <!-- Gambar KTP, src akan di-set via JS, dengan styling border & rounded -->
              </div> <!-- Tutup div .modal-section (Foto KTP) -->

              {{-- 🔹 Item Pesanan --}} <!-- Komentar Blade: section daftar item yang dipesan -->
              <div class="modal-section"> <!-- Section untuk tabel item pesanan -->
                <h4>Item</h4>
                <table class="items-table" id="md-items">
                  <thead>
                    <tr>
                      <th>Produk</th>
                      <th>Qty</th>
                      <th>Harga</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>

                <!-- 🔥 Container ringkasan pembayaran -->
                <div class="kv kv-amount" id="md-summary">
                  <!-- Isi kolom ini nanti di-generate otomatis lewat JavaScript -->
                </div>
              </div> <!-- Tutup div .modal-section (Item Pesanan) -->
            </div> <!-- Tutup div .modal-body -->

            <div class="modal-foot"> <!-- Footer modal dengan tombol tutup -->
              <button type="button" class="btn modal-close">Tutup</button> <!-- Tombol tutup modal -->
            </div> <!-- Tutup modal-foot -->
          </div> <!-- Tutup modal-card -->
        </div> <!-- Tutup modal overlay -->
      </div> <!-- Tutup .content-box -->
    </div> <!-- Tutup .content -->
  </main> <!-- Tutup main -->

  <script>
    // Mulai blok JavaScript

    // ===== VARIABEL FORM & INPUT =====
    // Variabel DOM untuk form filter dan input
    const form = document.getElementById('txFilterForm'); // Ambil elemen form filter
    const fStatus = document.getElementById('fStatus'); // Ambil elemen dropdown status
    const fFrom = document.getElementById('fFrom'); // Ambil elemen tanggal from
    const fTo = document.getElementById('fTo'); // Ambil elemen tanggal to
    const fQ = document.getElementById('fQ'); // Ambil elemen pencarian q

    // ===== NORMALISASI TEKS =====
    // Fungsi untuk normalisasi string (lowercase, hapus aksen)
    const norm = (s) => (s || '')
      .toString() // Pastikan jadi string
      .toLowerCase() // Ubah ke huruf kecil semua
      .normalize('NFD') // Normalisasi Unicode NFD
      .replace(/[\u0300-\u036f]/g, ''); // Hapus tanda aksen/diakritik

    // auto-submit saat status / tanggal berubah
    // Tambahkan event listener change untuk auto-submit
    [fStatus, fFrom, fTo].forEach(el => // Looping elemen yang perlu auto submit
      el.addEventListener('change', () => form.requestSubmit ? form.requestSubmit() : form.submit()) // Request submit kalau tersedia, fallback submit
    ); // Tutup forEach

    // ===== AUTO FILTER CLIENT-SIDE SAAT KETIK =====
    // Inisialisasi txBody untuk filter client-side
    const txBody = document.getElementById('txBody'); // Ambil tbody tabel transaksi

    function filterTransaksi() { // Fungsi filter client-side berdasarkan input q
      const q = norm(fQ.value || ''); // Ambil nilai q yang sudah dinormalisasi
      if (!txBody) return; // Jika tbody tidak ada, berhenti

      const rows = txBody.querySelectorAll('tr:not(#txEmptyRow)'); // Ambil semua baris kecuali txEmptyRow
      let visible = 0; // Hitung jumlah baris yang cocok

      rows.forEach(row => { // Iterasi tiap baris untuk cek kecocokan
        // Kolom 0: ID, 1: Tanggal, 2: Nama
        const idTx = norm(row.children[0]?.textContent); // Ambil dan normalisasi ID transaksi
        const tgl = norm(row.children[1]?.textContent); // Ambil dan normalisasi tanggal
        const nama = norm(row.children[2]?.textContent); // Ambil dan normalisasi nama

        const match = !q || idTx.includes(q) || tgl.includes(q) || nama.includes(q); // Cek apakah baris match query
        row.style.display = match ? '' : 'none'; // Tampilkan/sembunyikan baris
        if (match) visible++; // Increment jika cocok
      }); // Tutup foreach rows

      // Tampilkan/hilangkan baris “kosong”
      // Menangani pesan tidak ada hasil
      let emptyRow = document.getElementById('txEmptyRow'); // Cek row kosong jika ada
      if (visible === 0) { // Jika tidak ada hasil tampilkan pesan
        if (!emptyRow) { // Jika row kosong belum dibuat
          emptyRow = document.createElement('tr'); // Buat elemen tr baru
          emptyRow.id = 'txEmptyRow'; // Set id tr
          // Isi konten pesan kosong
          emptyRow.innerHTML = `
          <td colspan="7" style="text-align:center;color:#777;padding:16px;">
            Tidak ada transaksi yang cocok
          </td>`;
          txBody.appendChild(emptyRow); // Masukkan row kosong ke tbody
        } else {
          // penting: kalau sebelumnya sempat di-hide, tampilkan lagi
          emptyRow.style.display = ''; // Tampilkan row kosong kembali
          // opsional: pastikan di paling bawah
          txBody.appendChild(emptyRow); // Pindahkan ke akhir tbody
        }
      } else if (emptyRow) { // Jika ada hasil dan row kosong terlanjur ada
        emptyRow.remove(); // Hapus row kosong
      }
    } // Tutup function filterTransaksi

    // ketik = langsung filter (tanpa submit)
    // Event listener input untuk pencarian langsung
    fQ.addEventListener('input', filterTransaksi); // Pasang listener input

    // jalankan saat load (kalau ada nilai q dari server)
    // Jalankan filter saat DOM siap
    document.addEventListener('DOMContentLoaded', filterTransaksi); // Pasang listener DOMContentLoaded

    // --- FILTER STATUS/TANGGAL tetap submit server ---
    // Pastikan event change submit juga (duplikat aman)
    [fStatus, fFrom, fTo].forEach(el => // Loop elemen yang submit ke server
      el.addEventListener('change', () => // Event change submit form
        form.requestSubmit ? form.requestSubmit() : form.submit() // requestSubmit if available
      )
    ); // Tutup forEach

    // toggle buka/tutup dropdown
    // Global click handler untuk dropdown status custom
    document.addEventListener('click', function(e) { // Pasang listener click di dokumen
      // buka
      // Cek klik pada status-pill untuk buka dropdown
      if (e.target.closest('.status-pill')) { // Jika klik pada pill
        const dd = e.target.closest('.status-dd'); // Cari container .status-dd terdekat
        document.querySelectorAll('.status-dd.open').forEach(x => x.classList.remove('open')); // Tutup dropdown lain
        dd.classList.toggle('open'); // Toggle kelas open pada dd yang diklik
        return; // Hentikan eksekusi lebih lanjut
      }
      // pilih status
      // Cek klik pada item status di menu
      const item = e.target.closest('.status-item'); // Cari .status-item terdekat
      if (item) { // Jika ada item yang diklik
        const dd = item.closest('.status-dd'); // Cari container dd
        const form = dd.closest('form'); // Form update status terkait
        const input = form.querySelector('input[name="status_pesanan"]'); // Hidden input status di form
        const pill = dd.querySelector('.status-pill'); // Pill untuk tampilkan teks status

        // set value
        // Set nilai input hidden dan teks pill
        input.value = item.dataset.value; // Set input ke nilai yang dipilih
        pill.textContent = item.dataset.value; // Update teks pill

        // update warna pill
        // Ganti kelas pill agar menyesuaikan warna
        pill.className = 'status-pill ' + item.className.replace('status-item', '').trim(); // Set class pill baru

        // tutup menu & submit
        // Tutup dropdown lalu submit form ke server
        dd.classList.remove('open'); // Tutup dropdown
        form.submit(); // Submit form (PATCH)
        return; // Hentikan eksekusi lebih lanjut
      }
      // klik di luar → tutup semua
      // Jika klik di area lain, tutup semua dropdown yg terbuka
      document.querySelectorAll('.status-dd.open').forEach(x => x.classList.remove('open')); // Tutup semua dropdown
    }); // Tutup document click listener

    function statusClass(v) { // Fungsi map status string ke kelas CSS
      switch ((v || '').toLowerCase()) { // Normalisasi input menjadi lower case
        case 'belum bayar': // Jika 'belum bayar'
          return 'st-belum-bayar';
        case 'diproses': // Jika 'diproses'
          return 'st-diproses';
        case 'siap diambil': // Jika 'siap diambil'
          return 'st-siap-diambil';
        case 'disewa': // Jika 'disewa'
          return 'st-disewa';
        case 'selesai': // Jika 'selesai'
          return 'st-selesai';
        case 'dibatalkan': // Jika 'dibatalkan'
          return 'st-dibatalkan';
        default: // Default fallback
          return 'st-belum-bayar';
      }
    } // Tutup function statusClass

    // set kelas awal untuk semua dropdown status
    // Inisialisasi class untuk select bila ada
    document.addEventListener('DOMContentLoaded', function() { // Saat DOM siap
      document.querySelectorAll('.status-select').forEach(function(sel) { // Loop semua .status-select
        sel.classList.add(statusClass(sel.value)); // Tambahkan class sesuai nilai
      });
    }); // Tutup DOMContentLoaded listener

    function openPopup(id) { // Fungsi helper open popup (jika diperlukan)
      document.getElementById(id).style.display = 'flex'; // Set display flex untuk buka popup
    } // Tutup openPopup

    function closePopup(id) { // Fungsi helper close popup (jika diperlukan)
      document.getElementById(id).style.display = 'none'; // Sembunyikan popup dengan display none
    } // Tutup closePopup

    const rupiah = n => 'Rp' + (n || 0).toString() // Fungsi format rupiah sederhana
      .replace(/[^0-9\-]/g, '') // Hapus karakter non-digit kecuali minus
      .replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Sisipkan titik ribuan

    // buka modal & render
    // Handler klik untuk membuka modal detail dan render konten
    document.addEventListener('click', function(e) { // Listener global untuk mendeteksi klik di seluruh dokumen
      const btn = e.target.closest('.detail-link'); // Mencari elemen terdekat dengan class .detail-link (tombol Detail)
      if (!btn) return; // Jika bukan tombol detail, hentikan fungsi
      const data = JSON.parse(btn.dataset.order || '{}'); // Ambil payload JSON dari atribut data-order lalu parse ke object

      // judul
      // Set judul modal dengan nomor pesanan
      document.getElementById('md-title').textContent = // Ambil elemen judul modal
        `Detail Pemesanan • ${data.no || '-'}`; // Isi teks judul dengan nomor pesanan atau fallback '-'

      // key-values
      // Render daftar key-value info pesanan ke container kv
      const kv = document.getElementById('md-kv'); // Ambil elemen container kv
      kv.innerHTML = [ // Membuat array pasangan [label, nilai] kemudian dijadikan HTML
        ['Nama', data.nama || '-'], // Baris nama penerima
        ['Tanggal Pesan', data.tgl_pesan || '-'], // Baris tanggal pemesanan
        ['Tanggal Sewa', data.tgl_sewa || '-'], // Baris tanggal sewa
        ['Pengembalian', data.tgl_kembali || '-'], // Baris tanggal kembali
        ['Status', data.status || '-'], // Baris status pesanan
      ].map(([k, v]) => `<div>${k}</div><div><strong>${v}</strong></div>`).join(''); // Ubah jadi HTML grid dengan label dan nilai lalu gabungkan

      // 🔹 Foto KTP
      const ktpSection = document.getElementById('md-ktp-section'); // Ambil container section KTP
      const ktpImg = document.getElementById('md-ktp-img'); // Ambil elemen gambar KTP

      if (data.ktp) { // Cek apakah data KTP ada
        ktpSection.style.display = 'block'; // Tampilkan section KTP
        ktpImg.src = data.ktp; // Set URL sumber gambar KTP
      } else { // Jika tidak ada KTP
        ktpSection.style.display = 'none'; // Sembunyikan section KTP
        ktpImg.removeAttribute('src'); // Hapus atribut src agar tidak memuat gambar lama
      }

      // items
      // Render baris-baris item ke tabel item modal
      const tbody = document.querySelector('#md-items tbody'); // Ambil tbody tabel item
      const items = Array.isArray(data.items) ? data.items : []; // Validasi items harus array
      tbody.innerHTML = items.length ?
        items.map(it => ` 
      <tr>
        <td>${it.nama || '-'}</td> <!-- Nama produk -->
        <td>${it.qty ?? '-'}</td> <!-- Jumlah -->
        <td>${rupiah(it.harga || 0)}</td> <!-- Harga -->
      </tr>`).join('') // Gabungkan seluruh baris
        :
        `<tr><td colspan="3" style="text-align:center;color:#777;">Tidak ada item.</td></tr>`; // Tampilkan pesan jika tidak ada item
      // 🔹 Ringkasan pembayaran: Subtotal, Biaya Layanan, Total
      const summaryBox = document.getElementById('md-summary');
      if (summaryBox) {
        const subtotal = Number(data.subtotal ?? 0);
        const fee = Number(data.biaya_layanan ?? 0);
        const totalBayar = Number(data.total ?? subtotal + fee);

        summaryBox.innerHTML = `
    <div>Subtotal Pesanan</div><div>${rupiah(subtotal)}</div>
    <div>Biaya Layanan</div><div>${rupiah(fee)}</div>
    <div></div><div><hr style="border:0;border-top:1px solid #e5e7eb;margin:4px 0;"></div>
    <div><strong>Total Pembayaran</strong></div><div><strong>${rupiah(totalBayar)}</strong></div>
  `;
      }
      // Tampilkan modal dengan menambah class open
      document.getElementById('orderModal').classList.add('open'); // Tambahkan class open agar modal muncul
    }); // Tutup click listener untuk membuka modal

    // tutup modal (klik tombol X, tombol Tutup, atau overlay)
    // Event listeners untuk menutup modal
    document.querySelectorAll('#orderModal .modal-close').forEach(el => { // Pilih semua elemen penutup modal
      el.addEventListener('click', () => document.getElementById('orderModal').classList.remove('open')); // Remove class open saat diklik
    }); // Tutup forEach penutup modal

    document.getElementById('orderModal').addEventListener('click', (e) => { // Klik overlay modal
      if (e.target.id === 'orderModal') e.currentTarget.classList.remove('open'); // Jika klik backdrop, tutup modal
    }); // Tutup listener overlay

    // opsional: tutup saat ESC
    // Listener keyboard untuk tombol Escape
    document.addEventListener('keydown', (e) => { // Pasang listener keydown global
      if (e.key === 'Escape') document.getElementById('orderModal').classList.remove('open'); // Tutup modal jika ESC ditekan
    }); // Tutup keydown listener
  </script> <!-- Tutup Script  -->
</body> <!-- Tutup body -->

</html> <!-- Tutup HTML dokumen -->
