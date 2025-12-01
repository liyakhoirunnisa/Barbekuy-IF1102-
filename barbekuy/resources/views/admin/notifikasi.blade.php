<!doctype html> <!-- Deklarasi tipe dokumen HTML -->
<html lang="id"> <!-- Tag html utama dengan bahasa Indonesia -->

<head> <!-- Tag pembuka head -->
  <meta charset="utf-8" /> <!-- Set encoding karakter UTF-8 -->
  <meta name="viewport" content="width=device-width, initial-scale=1" /> <!-- Agar layout responsif di mobile -->
  <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Token CSRF Laravel -->
  <title>Notifikasi | Barbekuy</title> <!-- Judul halaman -->
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}"> <!-- Favicon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> <!-- CDN Font Awesome -->

  {{-- Google Font --}}
  <!-- Import font Poppins dari Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet"> <!-- Link Google Font -->

  <style>
    /* Tag pembuka style untuk CSS */
    * {
      /* Selector universal */
      margin: 0;
      /* Hilangkan margin default */
      padding: 0;
      /* Hilangkan padding default */
      box-sizing: border-box;
      /* Gunakan border-box */
      font-family: 'Poppins', sans-serif;
      /* Terapkan font Poppins */
    }

    html,
    /* Selector html */
    body {
      /* Selector body */
      max-width: 100%;
      /* Batas lebar maksimal 100% */
      overflow-x: hidden;
      /* Cegah scroll horizontal */
      /* cegah scroll horizontal */
      /* Komentar tambahan */
    }

    /* cukup set background saja di sini, layout diatur navbarAdmin */
    body {
      /* Style untuk body */
      background: #f5f6fa;
      /* Warna background */
    }

    /* Area abu-abu di luar kotak putih */
    .content {
      /* Wrapper konten */
      flex: 1;
      /* Isi ruang tersisa */
      padding: 30px 40px;
      /* Jarak dalam */
      overflow: hidden;
      /* Sembunyikan overflow */
    }

    /* Kotak putih utama */
    .content-box {
      background: #fff;
      /* Warna putih */
      border-radius: 12px;
      /* Sudut melengkung */
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
      /* Shadow lembut */
      padding: 28px;
      /* Padding dalam */
      max-height: calc(100vh - 120px);
      /* Maks tinggi */
      display: flex;
      /* Gunakan flexbox */
      flex-direction: column;
      /* Susunan vertikal */
      overflow: hidden;
      /* Non-scroll utama */
      /* body list yang scroll, bukan box ini */
      /* Catatan */
    }

    /* 🔹 HEADER (judul + dropdown) – FIX di atas, tidak scroll */
    .notif-header-wrap {
      flex-shrink: 0;
      /* Jangan mengecil */
      background: #fff;
      /* Background putih */
      padding-bottom: 10px;
      /* Padding bawah */
      border-bottom: 1px solid #f3f3f3;
      /* Garis bawah */
    }

    .content-header {
      display: flex;
      /* Gunakan flex */
      justify-content: space-between;
      /* Spasi kiri-kanan */
      align-items: center;
      /* Rata tengah vertikal */
      margin-bottom: 6px;
      /* Margin bawah */
    }

    .content-header h2 {
      font-size: 20px;
      /* Ukuran font */
      font-weight: 600;
      /* Ketebalan font */
      color: #000000;
      /* Warna hitam */
    }

    .notif-actions {
      display: flex;
      /* Flexbox */
      justify-content: space-between;
      /* Spasi antar elemen */
      align-items: center;
      /* Rata tengah */
      gap: 12px;
      /* Jarak antar elemen */
      margin-bottom: 4px;
      /* Margin bawah */
    }

    /* Update rules select utama */
    .notif-actions select {
      padding: 6px 12px;
      /* Padding */
      border-radius: 6px;
      /* Sudut melengkung */
      border: 1px solid #ccc;
      /* Border */
      font-size: 13px;
      /* Ukuran font */
      outline: none;
      /* Hilangkan outline */
      background: #fff;
      /* Background putih */
      width: auto;
      /* Lebar otomatis */
      max-width: 100%;
      /* Maksimal 100% */
      display: inline-block;
      /* Elemen inline-block */
    }

    .notif-actions select:hover {
      border-color: #751A25;
      /* Warna border saat hover */
    }

    /* 🔹 BODY – HANYA BAGIAN INI YANG SCROLL */
    .notif-body {
      flex: 1;
      /* Isi ruang tersisa */
      overflow-y: auto;
      /* Scroll vertikal */
      padding-top: 10px;
      /* Padding atas */
    }

    /* ===== LIST NOTIFIKASI ===== */
    .notif-section {
      margin-bottom: 25px;
      /* Jarak bawah */
    }

    .notif-section h4 {
      font-size: 15px;
      /* Ukuran font */
      margin-bottom: 12px;
      /* Margin bawah */
      color: #751A25;
      /* Warna */
      font-weight: 600;
      /* Ketebalan */
    }

    .notif-item {
      background: #fff;
      /* Background putih */
      border-radius: 8px;
      /* Sudut melengkung */
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
      /* Shadow */
      padding: 14px 20px;
      /* Padding */
      display: grid;
      /* Gunakan grid */
      grid-template-columns: 1fr 130px 100px;
      /* Template kolom */
      align-items: center;
      /* Rata tengah vertikal */
      margin-bottom: 10px;
      /* Margin bawah */
      transition: 0.2s;
      /* Animasi hover */
      column-gap: 30px;
      /* Jarak antar kolom */
      cursor: pointer;
      /* Pointer */
      /* pindahan dari style inline */
    }

    .notif-item:hover {
      background: #f8f8f8;
      /* Warna saat hover */
    }

    .notif-left {
      display: flex;
      /* Flex */
      align-items: center;
      /* Tengah */
      gap: 12px;
      /* Jarak */
    }

    .notif-left input[type="checkbox"] {
      transform: scale(1.2);
      /* Perbesar checkbox */
      cursor: pointer;
      /* Pointer */
    }

    .notif-message {
      font-size: 14px;
      /* Ukuran font */
      color: #333;
      /* Warna */
    }

    .notif-message b {
      color: #751A25;
      /* Warna bold */
    }

    .notif-time {
      font-size: 13px;
      /* Ukuran font */
      color: gray;
      /* Warna */
      text-align: right;
      /* Rata kanan */
      margin-right: 10px;
      /* Margin kanan */
    }

    .notif-status {
      font-size: 13px;
      /* Ukuran font */
      font-weight: 500;
      /* Bold kecil */
      text-align: right;
      /* Rata kanan */
      min-width: 90px;
      /* Lebar minimal */
      cursor: pointer;
      /* Pointer */
    }

    .notif-status.baca {
      color: gray;
      /* Warna status baca */
    }

    .notif-status.belum {
      color: #751A25;
      /* Warna status belum dibaca */
    }

    /* tombol status */
    .notif-status-btn {
      all: unset;
      /* Reset semua style */
      cursor: pointer;
      /* Pointer */
    }

    /* ===== POPUP HAPUS ===== */
    .popup-overlay {
      position: fixed;
      /* Tetap mengikuti layar */
      top: 0;
      /* Posisi atas */
      left: 0;
      /* Posisi kiri */
      width: 100%;
      /* Lebar penuh */
      height: 100%;
      /* Tinggi penuh */
      background: rgba(0, 0, 0, 0.4);
      /* Overlay gelap */
      display: none;
      /* Default hidden */
      justify-content: center;
      /* Tengah horizontal */
      align-items: center;
      /* Tengah vertikal */
      z-index: 999;
      /* Di atas elemen lain */
    }

    .popup-box {
      background: #fff;
      /* Background putih */
      border-radius: 16px;
      /* Sudut melengkung */
      width: 500px;
      /* Lebar */
      max-width: 90%;
      /* Maks 90% layar */
      padding: 30px 28px;
      /* Padding */
      text-align: center;
      /* Teks tengah */
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
      /* Shadow */
      animation: fadeIn 0.3s ease;
      /* Animasi */
    }

    @keyframes fadeIn {

      /* Animasi fade-in */
      from {
        /* Dari */
        opacity: 0;
        /* Transparan */
        transform: translateY(-10px);
        /* Geser ke atas */
      }

      to {
        /* Ke */
        opacity: 1;
        /* Tampak */
        transform: translateY(0);
        /* Kembali normal */
      }
    }

    .popup-box h3 {
      color: #751A25;
      /* Warna */
      font-size: 18px;
      /* Ukuran font */
      margin-bottom: 12px;
      /* Margin bawah */
      font-weight: 600;
      /* Bold */
    }

    .popup-box p {
      color: #555;
      /* Warna */
      font-size: 14px;
      /* Ukuran font */
      margin-bottom: 25px;
      /* Margin bawah */
    }

    .popup-buttons {
      display: flex;
      /* Flex */
      justify-content: center;
      /* Tengah */
      gap: 15px;
      /* Jarak */
    }

    .popup-buttons button {
      border: none;
      /* Tanpa border */
      padding: 8px 20px;
      /* Padding */
      border-radius: 8px;
      /* Sudut melengkung */
      font-size: 14px;
      /* Ukuran font */
      cursor: pointer;
      /* Pointer */
      transition: 0.3s;
      /* Animasi */
    }

    .btn-cancel {
      background: #fff;
      /* Background putih */
      color: #751A25;
      /* Warna teks */
      border: 1px solid #751A25;
      /* Border */
    }

    .btn-cancel:hover {
      background: #f4f4f4;
      /* Hover */
    }

    .btn-delete {
      background: #751A25;
      /* Warna tombol */
      color: #fff;
      /* Warna teks */
    }

    .btn-delete:hover {
      opacity: 0.9;
      /* Hover */
    }

    /* ===== BULK BAR DI BAWAH ===== */
    .bulk-bar {
      position: sticky;
      /* Tetap di bawah saat scroll */
      bottom: 0;
      /* Menempel bawah */
      margin-top: 20px;
      /* Margin atas */
      background: #fafafa;
      /* Background */
      border-radius: 14px;
      /* Sudut */
      padding: 12px 20px;
      /* Padding */
      display: none;
      /* Default hidden */
      align-items: center;
      /* Tengah */
      justify-content: space-between;
      /* Spasi */
      z-index: 10;
      /* Di atas item */
      box-shadow: 0 -2px 8px rgba(0, 0, 0, 0.06);
      /* Shadow */
    }

    .bulk-bar span {
      font-size: 13px;
      /* Ukuran font */
      color: #000000;
      /* Warna */
    }

    .bulk-bar .bulk-btn-delete {
      border: none;
      /* Tanpa border */
      background: #751A25;
      /* Warna */
      color: #fff;
      /* Warna teks */
      padding: 8px 20px;
      /* Padding */
      border-radius: 8px;
      /* Sudut */
      font-size: 13px;
      /* Ukuran font */
      cursor: pointer;
      /* Pointer */
      transition: 0.2s;
      /* Animasi */
    }

    .bulk-bar .bulk-btn-delete:hover {
      opacity: 0.9;
      /* Hover */
    }

    .bulk-left {
      display: flex;
      /* Flex */
      align-items: center;
      /* Tengah */
      gap: 16px;
      /* Jarak */
    }

    .bulk-select-all {
      display: flex;
      /* Flex */
      align-items: center;
      /* Tengah */
      gap: 8px;
      /* Jarak */
      font-size: 13px;
      /* Ukuran font */
      color: #000000;
      /* Warna */
      cursor: pointer;
      /* Pointer */
    }

    .bulk-select-all input[type="checkbox"] {
      transform: scale(1.1);
      /* Perbesar */
      cursor: pointer;
      /* Pointer */
    }

    .bulk-info-text {
      font-size: 13px;
      /* Ukuran font */
      color: #000000;
      /* Warna */
    }

    .bulk-count {
      font-weight: 600;
      /* Bold */
      color: #000000;
      /* Warna */
    }

    /* paragraf "Belum ada notifikasi." */
    .notif-empty {
      color: #777;
      /* Warna abu */
    }

    /* container pagination (margin-top: 12px) */
    .notif-pagination {
      margin-top: 12px;
      /* Margin atas */
    }

    /* form tersembunyi (tandai semua dibaca / belum dibaca) */
    #formReadAll,
    #formUnreadAll {
      display: none;
      /* Sembunyikan form */
    }

    /* =====================================================
       RESPONSIVE
       ===================================================== */

    /* Tablet dan ke bawah */
    @media (max-width: 992px) {
      .content {
        padding: 20px;
        /* Padding */
      }

      .content-box {
        padding: 20px;
        /* Padding */
        max-height: calc(100vh - 120px);
        /* Tinggi */
      }

      .notif-item {
        grid-template-columns: 1fr 110px;
        /* Dua kolom */
        column-gap: 16px;
        /* Jarak kolom */
      }

      .notif-time {
        text-align: left;
        /* Rata kiri */
        margin-right: 0;
        /* Hilangkan margin */
      }

      .bulk-bar {
        padding: 10px 14px;
        /* Padding */
      }

      .bulk-left {
        gap: 10px;
        /* Jarak */
      }
    }

    /* HP (layar kecil) */
    @media (max-width: 576px) {
      .content {
        padding: 12px 10px;
        /* Padding kecil */
      }

      .content-box {
        padding: 16px 12px;
        /* Padding kecil */
        border-radius: 10px;
        /* Sudut */
      }

      .content-header h2 {
        font-size: 18px;
        /* Ukuran font */
      }

      .notif-section h4 {
        font-size: 14px;
        /* Ukuran font */
      }

      .notif-actions {
        display: flex;
        /* Kembali flex */
        gap: 8px;
        /* Jarak */
        margin-bottom: 10px;
        /* Margin bawah */
      }

      .notif-actions>* {
        margin-bottom: 0;
        /* Hilangkan margin */
        width: 50%;
        /* Bagi dua */
      }

      .notif-actions form {
        width: 100%;
        /* Isi penuh */
      }

      .notif-actions select,
      .notif-actions form select {
        width: 100%;
        /* Lebar penuh */
        max-width: 100%;
        /* Max penuh */
      }

      .notif-item {
        grid-template-columns: 1fr;
        /* Satu kolom */
        row-gap: 6px;
        /* Jarak */
        padding: 12px 14px;
        /* Padding */
      }

      .notif-left {
        align-items: flex-start;
        /* Rata atas */
      }

      .notif-time {
        text-align: left;
        /* Rata kiri */
        font-size: 12px;
        /* Kecil */
        margin-top: 2px;
        /* Margin atas */
      }

      .notif-status {
        text-align: left;
        /* Rata kiri */
        margin-top: 4px;
        /* Margin */
      }

      .bulk-bar {
        flex-direction: row;
        /* Arah baris */
        gap: 10px;
        /* Jarak */
        padding: 10px 12px;
        /* Padding */
      }

      .bulk-btn-delete {
        white-space: nowrap;
        /* Jangan wrap */
      }
    }
  </style> <!-- Tutup style -->
</head> <!-- Tutup head -->

<body> <!-- Membuka elemen body halaman -->
  {{-- 🔹 Sidebar + Topbar --}} <!-- Include bagian navbar admin -->
  @include('layouts.navbarAdmin') <!-- Memanggil file navbar -->

  <!-- Main Content --> <!-- Label area konten utama -->
  <main class="main-content"> <!-- Wrapper konten utama -->
    <div class="content"> <!-- Container konten -->
      <div class="content-box"> <!-- Box berisi elemen notifikasi -->

        {{-- 🔹 HEADER STICKY (judul + dropdown) --}} <!-- Header yang tetap di atas -->
        <div class="notif-header-wrap"> <!-- Wrapper header -->
          <div class="content-header"> <!-- Header judul -->
            <h2>Notifikasi</h2> <!-- Judul halaman -->
          </div>

          {{-- Actions bar --}} <!-- Bar berisi dropdown aksi dan filter -->
          <div class="notif-actions"> <!-- Wrapper actions -->

            {{-- Left: select aksi --}} <!-- Dropdown bulk action -->
            <select id="notif-action"> <!-- Pilihan aksi massal -->
              <option value="">Pilih</option> <!-- Opsi default -->
              <option value="read-all">Tandai semua dibaca</option> <!-- Mass read -->
              <option value="unread-all">Tandai semua belum dibaca</option> <!-- Mass unread -->
            </select>

            {{-- Right: filter --}} <!-- Bagian filter status -->
            <form method="GET" action="{{ route('admin.notifikasi.index') }}"> <!-- Form filter -->
              <select class="filter-right" name="filter" onchange="this.form.submit()"> <!-- Dropdown filter status -->
                <option value="all" {{ ($filter??'all')==='all' ? 'selected' : '' }}>Semua</option> <!-- Tampilkan semua -->
                <option value="unread" {{ ($filter??'')==='unread' ? 'selected' : '' }}>Belum dibaca</option> <!-- Filter unread -->
                <option value="read" {{ ($filter??'')==='read' ? 'selected' : '' }}>Sudah dibaca</option> <!-- Filter read -->
              </select>
            </form> <!-- Tutup form filter -->
          </div> <!-- Tutup notif-actions -->
        </div> <!-- Tutup notif-header-wrap -->

        <div class="notif-body"> <!-- Body utama daftar notifikasi -->

          {{-- ================== List dinamis dengan grouping ================== --}} <!-- Grouping by date -->
          @php
          use Carbon\Carbon; /* Import Carbon untuk waktu */
          $today = $notifications->filter(fn($n) => optional($n->created_at)->isToday()); /* Notifikasi hari ini */
          $yesterday = $notifications->filter(fn($n) => optional($n->created_at)->isYesterday()); /* Notifikasi kemarin */
          $earlier = $notifications->filter(fn($n) => $n->created_at && !$n->created_at->isToday() && !$n->created_at->isYesterday()); /* Notifikasi sebelumnya */
          @endphp

          {{-- Hari ini --}} <!-- Section untuk notifikasi hari ini -->
          @if($today->count()) <!-- Cek jika ada data today -->
          <div class="notif-section"> <!-- Wrapper section today -->
            <h4>Hari ini</h4> <!-- Judul section -->

            @foreach($today as $n) <!-- Loop setiap notifikasi hari ini -->
            @php
            $data = $n->data ?? []; /* Ambil payload notifikasi */
            $pesan = $data['pesan'] ?? 'Ada aktivitas baru'; /* Pesan notifikasi */
            $waktu = optional($n->created_at)->diffForHumans(); /* Format waktu */
            $unread = is_null($n->read_at); /* Cek apakah unread */
            @endphp

            @php
            // URL redirect ke transaksi (pakai ?order=ID)
            $toUrl = route('admin.transaksi') . '?order=' . urlencode($data['id_pesanan'] ?? ''); /* Tujuan klik notif */
            $readUrl = route('admin.notifikasi.read', $n->id); /* URL untuk tandai dibaca */
            @endphp

            <div class="notif-item"
              data-read-url="{{ $readUrl }}" <!-- Endpoint untuk JS mark-as-read -->
              data-to-url="{{ $toUrl }}"> <!-- Endpoint untuk redirect -->

              <div class="notif-left"> <!-- Area kiri: checkbox + pesan -->

                {{-- cegah klik checkbox ikut redirect --}} <!-- Supaya checkbox tidak pindah halaman -->
                <input type="checkbox" class="chk" value="{{ $n->id }}" onclick="event.stopPropagation()"> <!-- Checkbox pilihan notif -->

                <div class="notif-message"> <!-- Pesan notifikasi -->
                  @php $nama = $data['nama_pengguna'] ?? 'Pelanggan'; @endphp <!-- Nama pengirim -->
                  <b>{{ $nama }}</b> melakukan pemesanan <!-- Isi pesan -->
                  @if(!empty($data['id_pesanan'])) <b>#{{ $data['id_pesanan'] }}</b>@endif <!-- Tampilkan ID pesanan -->
                </div> <!-- Tutup notif-message -->
              </div> <!-- Tutup notif-left -->

              <div class="notif-time">{{ $waktu }}</div> <!-- Waktu dibuatnya notif -->

              {{-- tombol status tetap ada, tapi jangan ikut trigger redirect --}} <!-- Pastikan tombol tidak redirect -->
              <div class="notif-status {{ $unread ? 'belum' : 'baca' }}" onclick="event.stopPropagation()"> <!-- Status unread/read -->
                <form method="POST" action="{{ route('admin.notifikasi.read',$n->id) }}" onclick="event.stopPropagation()"> <!-- Form mark as read -->
                  @csrf <!-- Token Laravel -->
                  <button type="submit" class="notif-status-btn">{{ $unread ? 'Belum dibaca' : 'Baca' }}</button> <!-- Tombol status -->
                </form>
              </div> <!-- Tutup notif-status -->
            </div> <!-- Tutup notif-item -->
            @endforeach
          </div> <!-- Tutup notif-section -->
          @endif <!-- Tutup kondisi hari ini -->
          {{-- Kemarin --}}
          @if($yesterday->count()) {{-- Jika ada notifikasi kemarin --}}
          <div class="notif-section"> {{-- Wrapper section notifikasi kemarin --}}
            <h4>Kemarin</h4> {{-- Judul section --}}

            @foreach($yesterday as $n) {{-- Loop data notifikasi kemarin --}}
            @php
            $data = $n->data ?? []; // Ambil data notifikasi
            $pesan = $data['pesan'] ?? 'Ada aktivitas baru'; // Pesan default
            $waktu = optional($n->created_at)->diffForHumans(); // Format waktu
            $unread = is_null($n->read_at); // Status belum dibaca
            @endphp

            @php
            $toUrl = route('admin.transaksi') . '?order=' . urlencode($data['id_pesanan'] ?? ''); // URL redirect
            $readUrl = route('admin.notifikasi.read', $n->id); // URL tandai dibaca
            @endphp

            <div class="notif-item" {{-- Kontainer item notifikasi --}}
              data-read-url="{{ $readUrl }}" {{-- URL mark-as-read --}}
              data-to-url="{{ $toUrl }}"> {{-- URL redirect --}}

              <div class="notif-left"> {{-- Bagian kiri --}}
                {{-- cegah klik checkbox ikut redirect --}}
                <input type="checkbox" class="chk" value="{{ $n->id }}" onclick="event.stopPropagation()"> {{-- Checkbox --}}

                <div class="notif-message"> {{-- Pesan notifikasi --}}
                  @php $nama = $data['nama_pengguna'] ?? 'Pelanggan'; @endphp {{-- Ambil nama --}}
                  <b>{{ $nama }}</b> melakukan pemesanan {{-- Teks utama --}}
                  @if(!empty($data['id_pesanan'])) <b>#{{ $data['id_pesanan'] }}</b>@endif {{-- ID pesanan --}}
                </div>
              </div>

              <div class="notif-time">{{ $waktu }}</div> {{-- Waktu notifikasi --}}

              <div class="notif-status {{ $unread ? 'belum' : 'baca' }}" onclick="event.stopPropagation()"> {{-- Status --}}
                <form method="POST" action="{{ route('admin.notifikasi.read',$n->id) }}" onclick="event.stopPropagation()"> {{-- Form mark-as-read --}}
                  @csrf
                  <button type="submit" class="notif-status-btn">{{ $unread ? 'Belum dibaca' : 'Baca' }}</button> {{-- Tombol --}}
                </form>
              </div>
            </div>
            @endforeach
          </div>
          @endif

          {{-- Lebih lama --}}
          @if($earlier->count()) {{-- Jika ada notifikasi yang lebih lama --}}
          <div class="notif-section"> {{-- Wrapper section earlier --}}
            <h4>Sebelumnya</h4> {{-- Judul section --}}

            @foreach($earlier as $n) {{-- Loop data earlier --}}
            @php
            $data = $n->data ?? []; // Ambil data notifikasi
            $pesan = $data['pesan'] ?? 'Ada aktivitas baru'; // Pesan default
            $waktu = optional($n->created_at)->translatedFormat('d M Y, H:i'); // Format waktu lengkap
            $unread = is_null($n->read_at); // Status belum dibaca
            @endphp

            @php
            $toUrl = route('admin.transaksi') . '?order=' . urlencode($data['id_pesanan'] ?? ''); // URL redirect
            $readUrl = route('admin.notifikasi.read', $n->id); // URL tandai dibaca
            @endphp

            <div class="notif-item" {{-- Kontainer item --}}
              data-read-url="{{ $readUrl }}" {{-- URL mark-as-read --}}
              data-to-url="{{ $toUrl }}"> {{-- URL redirect --}}

              <div class="notif-left"> {{-- Bagian kiri --}}
                <input type="checkbox" class="chk" value="{{ $n->id }}" onclick="event.stopPropagation()"> {{-- Checkbox --}}

                <div class="notif-message"> {{-- Teks notifikasi --}}
                  @php $nama = $data['nama_pengguna'] ?? 'Pelanggan'; @endphp {{-- Nama --}}
                  <b>{{ $nama }}</b> melakukan pemesanan {{-- Pesan --}}
                  @if(!empty($data['id_pesanan'])) <b>#{{ $data['id_pesanan'] }}</b>@endif {{-- ID --}}
                </div>
              </div>

              <div class="notif-time">{{ $waktu }}</div> {{-- Waktu --}}

              <div class="notif-status {{ $unread ? 'belum' : 'baca' }}" onclick="event.stopPropagation()"> {{-- Status --}}
                <form method="POST" action="{{ route('admin.notifikasi.read',$n->id) }}" onclick="event.stopPropagation()"> {{-- Form --}}
                  @csrf
                  <button type="submit" class="notif-status-btn">{{ $unread ? 'Belum dibaca' : 'Baca' }}</button> {{-- Tombol --}}
                </form>
              </div>
            </div>

            @endforeach
          </div>
          @endif

          {{-- Jika kosong total --}}
          @if(!$today->count() && !$yesterday->count() && !$earlier->count()) {{-- Semua kategori kosong --}}
          <p class="notif-empty">Belum ada notifikasi.</p> {{-- Teks kosong --}}
          @endif

          {{-- Pagination --}}
          <div class="notif-pagination">{{ $notifications->withQueryString()->links() }}</div> {{-- Pagination list --}}

          <!-- Bar aksi bulk di bawah -->
          <div class="bulk-bar" id="bulkBar"> <!-- Bar bulk action -->
            <div class="bulk-left"> <!-- Area kiri bulk -->
              <label class="bulk-select-all"> <!-- Checkbox select all -->
                <input type="checkbox" id="bulkSelectAll"> <!-- Checkbox pilih semua -->
                <span>Pilih semua</span> <!-- Label -->
              </label>

              <span class="bulk-info-text"> <!-- Info jumlah -->
                <span id="bulkCount" class="bulk-count">0</span> notifikasi dipilih <!-- Jumlah dipilih -->
              </span>
            </div>

            <button type="button" class="bulk-btn-delete" onclick="openBulkDelete()">Hapus</button> <!-- Tombol hapus -->
          </div>
        </div>
      </div>
  </main>


  <!-- Popup Konfirmasi -->
  <div class="popup-overlay" id="popupHapus"> <!-- Overlay popup -->
    <div class="popup-box"> <!-- Kontainer popup -->
      <h3>Hapus Notifikasi</h3> <!-- Judul -->
      <p>Apakah Anda yakin ingin menghapus notifikasi yang dipilih?</p> <!-- Pesan -->

      <div class="popup-buttons"> <!-- Tombol popup -->
        <button class="btn-cancel" onclick="closePopup()">Batal</button> <!-- Batalkan -->

        <form id="bulkDeleteForm" method="POST" action="{{ route('admin.notifikasi.bulkDestroy') }}"> <!-- Form bulk delete -->
          @csrf @method('DELETE') <!-- Token + method DELETE -->
          <div id="bulkIds"></div> <!-- Container ID yang mau dihapus -->
          <button class="btn-delete" type="submit">Hapus</button> <!-- Tombol hapus -->
        </form>
      </div>
    </div>
  </div>


  {{-- Form tandai semua dibaca (disembunyikan) --}} {{-- komentar --}}
  <form id="formReadAll" method="POST" action="{{ route('admin.notifikasi.readAll') }}"> {{-- form POST untuk tandai semua dibaca --}}
    @csrf {{-- token csrf --}}
  </form> {{-- tutup form --}}

  {{-- Form tandai semua belum dibaca (disembunyikan) --}} {{-- komentar --}}
  <form id="formUnreadAll" method="POST" action="{{ route('admin.notifikasi.unreadAll') }}"> {{-- form POST untuk tandai semua belum dibaca --}}
    @csrf {{-- token csrf --}}
  </form> {{-- tutup form --}}

  <script>
    // Ambil CSRF token dari meta
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.content; // ambil token CSRF dari meta tag

    // Klik satu baris notif -> POST mark-as-read -> redirect ke Transaksi
    document.querySelectorAll('.notif-item').forEach(row => { // loop tiap baris notifikasi
      row.addEventListener('click', async (e) => { // tambah event klik pada row
        // ⚠ Jika klik berasal dari checkbox atau elemen di dalam form/tombol,
        // jangan jalankan redirect / tandai dibaca
        if (
          e.target.closest('.chk') || // klik berasal dari checkbox -> abaikan
          e.target.closest('button') || // klik berasal dari tombol -> abaikan
          e.target.closest('form') // klik berasal dari form -> abaikan
        ) {
          return; // hentikan agar tidak redirect
        }

        const readUrl = row.dataset.readUrl; // ambil URL untuk tandai dibaca
        const toUrl = row.dataset.toUrl; // ambil URL tujuan redirect

        if (!toUrl) return; // jika tidak ada URL tujuan -> keluar

        // tandai dibaca (silent fail jika error)
        if (readUrl && CSRF) { // jika ada URL dan token CSRF
          try {
            await fetch(readUrl, { // kirim POST tandai dibaca
              method: 'POST',
              headers: {
                'X-CSRF-TOKEN': CSRF // header token
              }
            });
          } catch (e) {
            /* abaikan error */ // jika gagal, jangan hentikan proses
          }
        }

        // redirect ke halaman transaksi (dengan ?order=xxx)
        window.location.href = toUrl; // pindah ke halaman detail
      });
    });

    const selectAction = document.getElementById("notif-action"); // dropdown aksi bulk
    const popup = document.getElementById("popupHapus"); // popup konfirmasi hapus
    const bulkIds = document.getElementById("bulkIds"); // container input hidden id bulk
    const bulkBar = document.getElementById("bulkBar"); // bar aksi bulk di bawah
    const bulkCount = document.getElementById("bulkCount"); // jumlah notifikasi terpilih
    const bulkSelectAll = document.getElementById("bulkSelectAll"); // checkbox "pilih semua"

    // Dropdown: fokus ke status baca (semua dibaca / semua belum dibaca)
    selectAction.addEventListener("change", function() { // ketika dropdown berubah
      if (this.value === "read-all") { // user pilih "tandai semua dibaca"
        document.getElementById("formReadAll").submit(); // submit form dibaca semua
        this.value = ""; // reset dropdown
      } else if (this.value === "unread-all") { // user pilih "tandai semua belum dibaca"
        document.getElementById("formUnreadAll").submit(); // submit form belum dibaca semua
        this.value = ""; // reset dropdown
      }
    });

    // Hitung checkbox terpilih & tampilkan / sembunyikan bulk bar
    function updateBulkBar() { // fungsi update tampilan bulk bar
      const all = document.querySelectorAll(".chk"); // ambil semua checkbox notif
      const count = document.querySelectorAll(".chk:checked").length; // hitung yang dicentang
      const total = all.length; // total checkbox

      // Atur teks jumlah
      bulkCount.textContent = count; // tampilkan jumlah yang dipilih

      // Tampilkan bar hanya kalau ada yang dipilih
      if (count > 0) { // jika ada checkbox terpilih
        bulkBar.style.display = "flex"; // tampilkan bar
      } else {
        bulkBar.style.display = "none"; // sembunyikan bar
      }

      // Sync checkbox "Pilih semua" (tanpa tanda minus)
      if (bulkSelectAll) { // jika checkbox selectAll ada
        if (count === total && total > 0) { // jika semua dipilih
          bulkSelectAll.checked = true; // centang select all
          bulkSelectAll.indeterminate = false; // hilangkan tanda minus
        } else {
          bulkSelectAll.checked = false; // uncheck
          bulkSelectAll.indeterminate = false; // tidak setengah
        }
      }
    }

    // Pasang listener pada semua checkbox notifikasi
    document.querySelectorAll(".chk").forEach(chk => { // loop checkbox
      chk.addEventListener("change", (e) => { // ketika checkbox berubah
        e.stopPropagation(); // cegah klik row
        updateBulkBar(); // update tampilan bulk bar
      });
    });

    // Checkbox "Pilih semua" di bulk bar
    if (bulkSelectAll) { // jika elemen selectAll ada
      bulkSelectAll.addEventListener("change", () => { // event klik
        const checked = bulkSelectAll.checked; // status centang
        document.querySelectorAll(".chk").forEach(c => { // loop semua checkbox
          c.checked = checked; // centang/uncentang semuanya
        });
        updateBulkBar(); // update bar
      });
    }

    // Buka popup hapus untuk item yang dipilih
    function openBulkDelete() { // fungsi buka popup hapus
      const ids = Array.from(document.querySelectorAll(".chk:checked")).map(c => c.value); // ambil semua ID yang dicentang
      if (!ids.length) return; // jika tidak ada -> batal

      // isi hidden inputs
      bulkIds.innerHTML = ""; // kosongkan isi sebelumnya
      ids.forEach(id => { // loop ID
        const inp = document.createElement("input"); // buat input hidden
        inp.type = "hidden"; // tipe hidden
        inp.name = "ids[]"; // array ids[]
        inp.value = id; // nilai id
        bulkIds.appendChild(inp); // masukkan ke container
      });

      popup.style.display = "flex"; // tampilkan popup
    }

    function closePopup() { // fungsi tutup popup
      popup.style.display = "none"; // sembunyikan popup
    }
  </script>
</body>

</html>