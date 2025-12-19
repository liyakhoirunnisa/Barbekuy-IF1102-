@php // Membuka blok PHP khusus Blade untuk menulis logic server-side
$notifUnreadCount = auth()->check() // Mengecek apakah user sedang login / terautentikasi
? (auth()->user()->unreadNotifications()->count() ?? 0) // Jika login, ambil jumlah notifikasi yang belum dibaca, jika null maka default 0
: 0; // Jika tidak login, set jumlah notifikasi menjadi 0
@endphp

<style>
  * {
    margin: 0;
    /* Hapus margin default browser */
    padding: 0;
    /* Hapus padding default browser */
    box-sizing: border-box;
    /* Padding & border tidak menambah ukuran elemen */
    font-family: 'Poppins', sans-serif;
    /* Set font untuk seluruh halaman */
  }

  body {
    background: #f5f6fa;
    /* Warna latar belakang halaman */
    display: flex;
    /* Jadikan body sebagai flex container */
    min-height: 100vh;
    /* Tinggi minimal sama dengan tinggi viewport */
  }

  /* === SIDEBAR === */
  .sidebar {
    width: 240px;
    /* Lebar sidebar */
    background: #751A25;
    /* Warna background sidebar */
    color: #fff;
    /* Warna teks sidebar */
    display: flex;
    /* Flex container */
    flex-direction: column;
    /* Susunan vertikal */
    align-items: center;
    /* Posisi item di tengah secara horizontal */
    padding-top: 20px;
    /* Jarak atas */
    flex-shrink: 0;
    /* Tidak menyusut saat container kecil */
    transition: 0.3s ease;
    /* Animasi smooth saat berubah */
  }

  .logo {
    height: 110px;
    /* Tinggi logo container */
    display: flex;
    /* Flex untuk center konten */
    align-items: center;
    /* Vertikal center */
    justify-content: center;
    /* Horizontal center */
    background: #751A25;
    /* Warna background logo */
  }

  .logo img {
    width: 190px;
    /* Lebar logo */
    height: auto;
    /* Tinggi otomatis agar proporsi terjaga */
    object-fit: contain;
    /* Agar gambar tetap proporsional */
    position: relative;
    /* Agar bisa digeser dengan top */
    top: -18px;
    /* Geser logo ke atas */
  }

  .menu {
    width: 100%;
    /* Lebar menu sama dengan sidebar */
    margin-top: -3px;
    /* Sedikit overlap dengan logo */
  }

  .menu-item {
    display: flex;
    /* Flex container untuk ikon + teks */
    align-items: center;
    /* Vertikal center */
    gap: 12px;
    /* Jarak antara ikon dan teks */
    padding: 14px 26px;
    /* Padding dalam menu */
    color: #fff;
    /* Warna teks menu */
    font-size: 14px;
    /* Ukuran font */
    text-decoration: none;
    /* Hilangkan garis bawah link */
    transition: 0.3s;
    /* Animasi hover */
  }

  .menu-item i {
    font-size: 18px;
    /* Ukuran ikon */
    width: 20px;
    /* Lebar area ikon */
    text-align: center;
    /* Ratakan ikon di tengah */
  }

  .menu-item:hover,
  .menu-item.active {
    background: rgba(255, 255, 255, 0.15);
    /* Background saat hover/aktif */
    border-radius: 10px;
    /* Sudut membulat */
  }

  /* === TOPBAR === */
  .main-content {
    flex: 1;
    /* Mengisi sisa layar */
    display: flex;
    /* Flex container */
    flex-direction: column;
    /* Susunan vertikal */
    height: 100vh;
    /* Tinggi sama viewport */
    overflow: hidden;
    /* Hilangkan scroll default */
  }

  .topbar {
    height: 90px;
    /* Tinggi topbar */
    background: #751A25;
    /* Warna background topbar */
    display: flex;
    /* Flex container */
    align-items: center;
    /* Vertikal center */
    justify-content: flex-end;
    /* Konten ke kanan */
    padding: 0 40px;
    /* Jarak kiri dan kanan */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    /* Shadow halus */
    gap: 25px;
    /* Jarak antar elemen */
  }

  /* === TAMBAHAN RESPONSIVE: tombol menu === */
  .menu-toggle {
    display: none;
    /* Tidak tampil di desktop */
    font-size: 26px;
    /* Ukuran ikon toggle */
    color: #fff;
    /* Warna ikon toggle */
    cursor: pointer;
    /* Pointer saat hover */
    margin-right: auto;
    /* Posisi kiri */
  }

  .topbar a {
    display: flex;
    /* Flex container */
    align-items: center;
    /* Vertikal center */
    justify-content: center;
    /* Horizontal center */
    height: 55px;
    /* Tinggi link */
    position: relative;
    /* Agar badge bisa absolute */
  }

  .topbar a i {
    font-size: 22px;
    /* Ukuran ikon */
    color: #fff;
    /* Warna ikon */
    cursor: pointer;
    /* Pointer saat hover */
    transition: 0.3s;
    /* Animasi hover */
  }

  .topbar a i:hover {
    transform: scale(1.1);
    /* Zoom saat hover */
  }

  .badge {
    position: absolute;
    /* Absolute terhadap parent */
    top: 5px;
    /* Jarak dari atas */
    right: 8px;
    /* Jarak dari kanan */
    background: red;
    /* Warna background badge */
    color: #fff;
    /* Warna teks badge */
    font-size: 11px;
    /* Ukuran font */
    padding: 2px 6px;
    /* Padding dalam badge */
    border-radius: 50%;
    /* Bentuk bulat */
  }

  .profile {
    height: 55px;
    /* Tinggi profile */
    display: flex;
    /* Flex container */
    align-items: center;
    /* Vertikal center */
    gap: 10px;
    /* Jarak avatar & teks */
    background: #fff;
    /* Warna background profile */
    color: #751A25;
    /* Warna teks profile */
    padding: 6px 14px;
    /* Padding dalam profile */
    border-radius: 30px;
    /* Sudut membulat */
    font-weight: 500;
    /* Tebal font */
  }

  .avatar {
    background: #751A25;
    /* Warna latar avatar */
    color: #fff;
    /* Warna teks avatar */
    width: 32px;
    /* Lebar avatar */
    height: 32px;
    /* Tinggi avatar */
    border-radius: 50%;
    /* Bentuk bulat */
    display: flex;
    /* Flex container */
    align-items: center;
    /* Vertikal center */
    justify-content: center;
    /* Horizontal center */
    font-weight: 600;
    /* Tebal teks */
  }

  .avatar-img {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
    display: block;
  }

  /* Khusus ikon logout (pindahan dari inline style) */
  .logout-icon {
    font-size: 22px;
    /* Ukuran ikon logout */
    color: #fff;
    /* Warna ikon logout */
    margin-left: 12px;
    /* Jarak kiri dari profile */
  }

  /* Form logout disembunyikan (pindahan dari style inline) */
  #logout-form {
    display: none;
    /* Form logout tidak terlihat di halaman */
  }

  /* === RESPONSIVE HP === */
  @media (max-width: 768px) {
    body {
      position: relative;
      /* Dibutuhkan untuk overlay */
    }

    .sidebar {
      position: fixed;
      /* Sidebar fixed di HP */
      left: -240px;
      /* Sidebar tersembunyi di kiri */
      top: 0;
      /* Posisi atas */
      height: 100%;
      /* Tinggi penuh */
      z-index: 999;
      /* Layer di atas konten lain */
    }

    .sidebar.show {
      left: 0;
      /* Sidebar muncul */
    }

    .menu-toggle {
      display: block;
      /* Muncul di HP */
    }

    .topbar {
      justify-content: space-between;
      /* Elemen tersebar */
      padding: 0 20px;
      /* Padding lebih kecil */
    }

    .profile span {
      display: none;
      /* Sembunyikan teks nama */
    }

    .overlay {
      position: fixed;
      /* Overlay fixed */
      top: 0;
      /* Atas 0 */
      left: 0;
      /* Kiri 0 */
      width: 100%;
      /* Lebar penuh */
      height: 100%;
      /* Tinggi penuh */
      background: rgba(0, 0, 0, 0.35);
      /* Hitam transparan */
      z-index: 500;
      /* Layer di bawah sidebar */
      display: none;
      /* Default hidden */
    }

    .overlay.show {
      display: block;
      /* Tampil saat sidebar terbuka */
    }
  }
</style>

<!-- OVERLAY untuk klik di luar sidebar -->
<div id="overlay" class="overlay"></div> <!-- Div overlay muncul saat sidebar di HP dibuka -->

<aside class="sidebar" id="sidebar"> <!-- Sidebar utama untuk menu admin, ID digunakan agar bisa di-toggle dengan JS -->
  <div class="logo"> <!-- Container logo -->
    <img src="{{ asset('images/logoputih.png') }}" alt="Logo Barbekuy"> <!-- Memanggil file logo dari folder public/images -->
    {{-- Logo Barbekuy --}} <!-- Komentar Blade, hanya untuk developer -->
  </div>

  <div class="menu"> <!-- Container menu sidebar -->
    <!-- Link ke halaman Beranda admin -->
    <a href="{{ route('admin.beranda') }}" class="menu-item {{ request()->routeIs('admin.beranda') ? 'active' : '' }}">
      <i class="fa-solid fa-house"></i> Beranda <!-- Ikon rumah menggunakan FontAwesome + teks menu Beranda -->
      {{-- Link ke halaman beranda admin --}} <!-- Komentar Blade -->
    </a>

    <!-- Link ke halaman Transaksi admin -->
    <a href="{{ route('admin.transaksi') }}" class="menu-item {{ request()->routeIs('admin.transaksi') ? 'active' : '' }}">
      <i class="fa-solid fa-money-check-dollar"></i> Transaksi <!-- Ikon uang menggunakan FontAwesome + teks menu Transaksi -->
      {{-- Link ke halaman transaksi admin --}} <!-- Komentar Blade -->
    </a>

    <!-- Link ke halaman Produk admin -->
    <a href="{{ route('admin.produk') }}" class="menu-item {{ request()->routeIs('admin.produk') ? 'active' : '' }}">
      <i class="fa-solid fa-box"></i> Produk <!-- Ikon kotak menggunakan FontAwesome + teks menu Produk -->
      {{-- Link ke halaman produk admin --}} <!-- Komentar Blade -->
    </a>

    <!-- Link ke halaman Pengaturan admin  -->
    <a href="{{ route('admin.pengaturan') }}" class="menu-item {{ request()->routeIs('admin.pengaturan') ? 'active' : '' }}">
      <i class="fa-solid fa-gear"></i> Pengaturan <!-- Ikon gear menggunakan FontAwesome + teks menu Pengaturan -->
      {{-- Link ke halaman pengaturan admin --}} <!-- Komentar Blade -->
    </a>
  </div>
</aside> <!-- Akhir sidebar -->

</aside>

<main class="main-content"> <!-- Main container untuk konten utama admin, termasuk topbar dan halaman konten -->

  <div class="topbar"> <!-- Topbar / navbar horizontal di atas halaman admin -->

    <!-- TOMBOL TOGGLE (TAMBAHAN) -->
    <i class="fa-solid fa-bars menu-toggle" id="menuToggle"></i> <!-- Ikon hamburger untuk toggle sidebar di HP, ID digunakan di JS -->

    <a href="{{ route('admin.notifikasi.index') }}" title="Notifikasi"> <!-- Link ke halaman notifikasi admin -->
      <i class="fa-solid fa-bell"></i> <!-- Ikon lonceng notifikasi -->
      @if(($notifUnreadCount ?? 0) > 0) <!-- Cek jika ada notifikasi yang belum dibaca -->
      <span class="badge">{{ $notifUnreadCount }}</span> <!-- Tampilkan jumlah notifikasi dalam badge merah -->
      @endif
    </a>

    <div class="profile"> <!-- Container profile user -->
      <!-- Avatar bulat menampilkan huruf awal nama user, default 'A' -->
      @if(!empty(Auth::user()->avatar_path))
      <img class="avatar-img" src="{{ asset('storage/' . ltrim(Auth::user()->avatar_path, '/')) }}" alt="Avatar">
      @else
      <div class="avatar">{{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}</div>
      @endif
      <span>{{ Auth::user()->name ?? 'Admin Barbekuy' }}</span> <!-- Nama lengkap user, default 'Admin Barbekuy' jika kosong -->
    </div>

    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Keluar"> <!-- Link logout -->
      <i class="fa-solid fa-right-from-bracket logout-icon"></i> <!-- Ikon keluar / logout dengan class CSS khusus -->
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST"> <!-- Form logout tersembunyi (di-hide via CSS) -->
      @csrf <!-- Token CSRF untuk keamanan request POST -->
    </form>
  </div> <!-- Akhir topbar -->

  <script>
    /* === SCRIPT RESPONSIVE === */
    const sidebar = document.getElementById("sidebar"); // Ambil elemen sidebar
    const overlay = document.getElementById("overlay"); // Ambil elemen overlay
    const toggle = document.getElementById("menuToggle"); // Ambil elemen tombol toggle sidebar

    // buka sidebar saat klik toggle
    toggle.addEventListener("click", () => {
      sidebar.classList.add("show"); // Tambah class 'show' agar sidebar muncul
      overlay.classList.add("show"); // Tambah class 'show' agar overlay muncul
    });

    // klik overlay menutup sidebar
    overlay.addEventListener("click", () => {
      sidebar.classList.remove("show"); // Hapus class 'show', sidebar hilang
      overlay.classList.remove("show"); // Hapus class 'show', overlay hilang
    });
  </script>
