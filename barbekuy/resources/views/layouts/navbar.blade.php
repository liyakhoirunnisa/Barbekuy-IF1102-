@php
$__cart = session('keranjang', []);
$cartCount = 0;
if (is_array($__cart)) {
foreach ($__cart as $row) { $cartCount += (int)($row['jumlah'] ?? 1); }
}
$user = auth()->user();
@endphp

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
  nav.navbar {
    background-color: #ffffff;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  }

  .navbar-brand img {
    width: 130px;
  }

  .nav-link {
    color: #800000 !important;
    font-weight: 500;
    transition: 0.3s;
    margin-right: 10px;
  }

  .nav-link:hover {
    color: #a00000 !important;
  }

  .btn-login {
    background-color: #800000;
    color: #fff !important;
    border-radius: 8px;
    padding: 6px 18px;
    transition: 0.3s;
  }

  .btn-login:hover {
    background-color: #a00000;
  }

  /* === SEARCH BAR STYLE === */
  .search-box {
    display: flex;
    align-items: center;
    background: #fff;
    border-radius: 12px;
    padding: 8px 14px;
    box-shadow: 0 0 5px rgba(128, 0, 0, 0.08);
    border: 1px solid rgba(128, 0, 0, 0.1);
    width: 400px;
    transition: all 0.3s ease;
    margin: 0 20px;
  }

  .search-box:hover {
    box-shadow: 0 0 15px rgba(128, 0, 0, 0.15);
  }

  .search-box input {
    border: none;
    outline: none;
    width: 100%;
    font-size: 0.95rem;
    color: #000000;
  }

  .search-box input::placeholder {
    color: #000000;
    opacity: 0.7;
  }

  /* Ikon umum (keranjang, riwayat, dll) */
  .nav-icon,
  .nav-keranjang {
    color: #751A25;
    font-size: 1.35rem;
    transition: 0.3s;
    margin-left: 10px;
    position: relative;
  }


  .nav-icon:hover,
  .nav-keranjang:hover {
    color: #9c2833;
  }

  /* === Badge Notifikasi di Keranjang === */
  .badge-cart {
    position: absolute;
    top: -4px;
    right: -8px;
    background-color: #d32f2f;
    color: white;
    font-size: 10px;
    font-weight: 600;
    padding: 2px 5px;
    border-radius: 50%;
    line-height: 1;
    min-width: 18px;
    text-align: center;
    box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);
  }

  .dropdown-menu {
    z-index: 2000;
  }

  .icon {
    display: inline-block;
    width: 1.25em;
    height: 1.25em;
    vertical-align: -.2em;
  }

  .icon-lg {
    width: 1.4em;
    height: 1.4em;
    vertical-align: -.25em;
  }

  .me-2 {
    margin-right: .5rem !important;
  }

  @media (max-width: 992px) {
    .search-box {
      width: 100%;
      margin: 10px 0;
    }

    .nav-link {
      margin: 10px 0;
    }
  }
</style>

<nav class="navbar navbar-expand-lg navbar-light sticky-top">
  <div class="container">
    {{-- 🔥 LOGO KIRI --}}
    <a class="navbar-brand d-flex align-items-center" href="{{ route('beranda') }}">
      <img src="{{ asset('images/logo.png') }}" alt="Barbekuy Logo" class="me-2" style="height:36px;width:auto;">
    </a>

    {{-- 🔍 SEARCH BAR (desktop) --}}
    <form class="d-none d-lg-block" action="{{ url('/search') }}" method="GET">
      <div class="search-box d-flex align-items-center bg-white rounded-3 px-3 py-2 shadow-sm border" style="width: 400px;">
        <i class="bi bi-search me-2 text-dark"></i>
        <input type="text" name="q" placeholder="Cari..." class="border-0 outline-none w-100" style="font-size: 0.95rem; color: #000;">
      </div>
    </form>

    {{-- ☰ TOGGLER HP --}}
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    {{-- 📋 MENU KANAN --}}
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav align-items-center">
        <li class="nav-item"><a class="nav-link" href="{{ route('beranda') }}">Beranda</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ url('/#tentang') }}">Tentang Kami</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('menu') }}">Menu</a></li>
        <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
      </ul>

      <ul class="navbar-nav align-items-center actions">
        {{-- 🧺 Keranjang --}}
        <li class="nav-item position-relative">
          <a href="{{ route('keranjang.index') }}" class="nav-keranjang position-relative" title="Keranjang">
            <i class="bi bi-cart3 fs-5"></i>
            <span id="cart-badge"
              class="badge-cart position-absolute top-0 start-100 translate-middle rounded-pill bg-danger"
              @if(($cartCount ?? 0) <=0) style="display:none" @endif>
              {{ $cartCount ?? 0 }}
            </span>
          </a>
        </li>

        {{-- 🕘 Riwayat (ikon terpisah di sebelah keranjang) --}}
        <li class="nav-item position-relative ms-2">
          <a class="nav-icon" title="Riwayat Pesanan" aria-label="Riwayat Pesanan"
            href="@if(Route::has('riwayat.semua')) {{ route('riwayat.semua') }}
           @elseif(Route::has('pemesanan.riwayat')) {{ route('pemesanan.riwayat') }}
           @else {{ url('/riwayat') }} @endif">
            {{-- history-clock icon --}}
            <i class="bi-clock-history fs-5"></i>
          </a>
        </li>


        {{-- 🔐 Profil / Login --}}
        @auth
        <li class="nav-item dropdown ms-2">
          <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="profileMenu"
            role="button" data-bs-toggle="dropdown" aria-expanded="false" title="Profil">
            <span class="icon-lg" aria-hidden="true" style="color:#751A25;">
              {{-- person-circle --}}
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 5.522 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
              </svg>
            </span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileMenu">
            {{-- Pengaturan Akun --}}
            <li>
              <a class="dropdown-item" href="{{ url('/pengaturan') }}">
                <span class="icon me-2" aria-hidden="true">
                  {{-- gear --}}
                  <i class="bi bi-gear fs-5" style="color:#751A25;"></i>
                </span>
                Pengaturan Akun
              </a>
            </li>

            @if($user && $user->role === 'admin')
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item"
                href="@if(Route::has('admin.beranda')) {{ route('admin.beranda') }} @else {{ url('/admin/beranda') }} @endif">
                <span class="icon me-2" aria-hidden="true">
                  {{-- speedometer2 --}}
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor">
                    <path d="M8 4a.5.5 0 0 1 .5.5v4.21l2.146 2.146a.5.5 0 1 1-.707.707L7.5 9.707V4.5A.5.5 0 0 1 8 4z" />
                    <path d="M3.278 14A7 7 0 1 1 12.722 14z" />
                  </svg>
                </span>
                Admin Dashboard
              </a>
            </li>
            @endif

            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item">
                  <span class="icon me-2" aria-hidden="true">
                    {{-- box-arrow-right --}}
                    <i class="bi bi-box-arrow-right fs-5" style="color:#751A25;"></i>
                  </span>
                  Keluar
                </button>
              </form>
            </li>
          </ul>
        </li>
        @else
        <li class="nav-item ms-lg-2">
          <a href="{{ route('login') }}" class="btn btn-login text-white">Masuk</a>
        </li>
        @endauth
      </ul>

      {{-- 🔍 SEARCH HP --}}
      <form class="d-lg-none mt-3 w-100" action="{{ url('/search') }}" method="GET">
        <div class="search-box d-flex align-items-center bg-white rounded-3 px-3 py-2 shadow-sm border">
          <span class="icon me-2" aria-hidden="true">
            {{-- search --}}
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor">
              <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001l3.85 3.85a1 1 0 0 0 1.415-1.415l-3.85-3.85a1 1 0 0 0-.017-.017zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
            </svg>
          </span>
          <input type="text" name="q" placeholder="Cari..." class="border-0 outline-none w-100" style="font-size:.95rem;color:#000;">
        </div>
      </form>
    </div>
  </div>
</nav>