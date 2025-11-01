{{-- resources/views/components/navbar.blade.php --}}
@php
  $__cart = session('keranjang', []);
  $cartCount = 0;
  if (is_array($__cart)) {
    foreach ($__cart as $row) { $cartCount += (int)($row['jumlah'] ?? 1); }
  }
  $user = auth()->user();
@endphp

<style>
  .navbar { background-color:#fff; box-shadow:0 2px 8px rgba(0,0,0,0.1); }
  .navbar-brand img { width:130px; }
  .nav-link { color:#800000 !important; font-weight:500; transition:.3s; margin-right:10px; }
  .nav-link:hover { color:#a00000 !important; }
  .btn-login { background:#800000; color:#fff !important; border-radius:8px; padding:6px 18px; transition:.3s; }
  .btn-login:hover { background:#a00000; }

  .search-box { display:flex; align-items:center; background:#fff; border-radius:12px; padding:8px 14px;
                box-shadow:0 0 5px rgba(128,0,0,.08); border:1px solid rgba(128,0,0,.1); width:400px;
                transition:all .3s ease; margin:0 20px; }
  .search-box:hover { box-shadow:0 0 15px rgba(128,0,0,.15); }
  .search-box input { border:none; outline:none; width:100%; font-size:.95rem; color:#000; }
  .search-box input::placeholder { color:#000; opacity:.7; }

  /* Ikon umum (keranjang, riwayat, dll) */
  .nav-icon, .nav-keranjang {
    color:#751A25; font-size:1.35rem; transition:.3s; margin-left:10px; position:relative; display:inline-flex; align-items:center;
  }
  .nav-icon:hover, .nav-keranjang:hover { color:#9c2833; }

  .badge-cart { position:absolute; top:-4px; right:-8px; background:#d32f2f; color:#fff; font-size:10px;
                font-weight:600; padding:2px 5px; border-radius:50%; line-height:1; min-width:18px;
                text-align:center; box-shadow:0 0 3px rgba(0,0,0,.2); }

  .dropdown-menu { z-index: 2000; }

  .icon { display:inline-block; width:1.25em; height:1.25em; vertical-align:-.2em; }
  .icon-lg { width:1.4em; height:1.4em; vertical-align:-.25em; }
  .me-2 { margin-right:.5rem !important; }

  @media (max-width: 992px) {
    .search-box { width:100%; margin:10px 0; }
    .nav-link { margin:10px 0; }
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
      <div class="search-box d-flex align-items-center bg-white rounded-3 px-3 py-2 shadow-sm border" style="width:400px;">
        <span class="icon me-2" aria-hidden="true">
          {{-- search --}}
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398l3.85 3.85a1 1 0 1 0 1.415-1.415zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
          </svg>
        </span>
        <input type="text" name="q" placeholder="Cari..." class="border-0 outline-none w-100" style="font-size:.95rem;color:#000;">
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
          <a href="{{ route('keranjang.index') }}" class="nav-keranjang" title="Keranjang" aria-label="Keranjang">
            <span class="icon" aria-hidden="true">
              {{-- cart3 --}}
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor">
                <path d="M0 1.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .485.379L2.89 6H14.5a.5.5 0 0 1 .49.598l-1.5 7A.5.5 0 0 1 13 14H4a.5.5 0 0 1-.49-.402L1.61 3H.5a.5.5 0 0 1-.5-.5M4.415 13h8.17l1.2-5.6H3.22z"/>
                <path d="M5 16a1 1 0 1 0 0-2 1 1 0 0 0 0 2m7 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
              </svg>
            </span>
            <span id="cart-badge" class="badge-cart"
                  @if(($cartCount ?? 0) <= 0) style="display:none" @endif>
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
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
         width="22" height="22" fill="none" stroke="currentColor"
         stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
      <!-- panah melingkar -->
      <path d="M9 3a9 9 0 1 1-6.364 2.636"/>
      <path d="M3 3v4h4"/>
      <!-- jam -->
      <circle cx="12" cy="12" r="7.2" opacity="0"/>  <!-- hanya untuk padding view -->
      <path d="M12 7.5v5l3 2"/>  <!-- jarum jam -->
    </svg>
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
                  <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                  <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 5.522 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                </svg>
              </span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileMenu">
              {{-- Pengaturan Akun --}}
              <li>
                <a class="dropdown-item" href="{{ url('/pengaturan') }}">
                  <span class="icon me-2" aria-hidden="true">
                    {{-- gear --}}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor">
                      <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492"/>
                      <path d="M9.796 1.343 9.53.064A1 1 0 0 0 8.563-.5h-1.126a1 1 0 0 0-.968.564l-.265 1.279a5.53 5.53 0 0 0-1.28.74L3.22 1.23A1 1 0 0 0 2.1 1.02l-.795.795a1 1 0 0 0 .21 1.12l1.393 1.393a5.53 5.53 0 0 0-.74 1.28L.59 6.469A1 1 0 0 0 .026 7.437v1.126a1 1 0 0 0 .564.968l1.279.265c.165.46.399.892.74 1.28L1.23 12.78a1 1 0 0 0-.21 1.12l.795.795a1 1 0 0 0 1.12.21l1.393-1.393c.388.341.82.575 1.28.74l.265 1.279a1 1 0 0 0 .968.564h1.126a1 1 0 0 0 .968-.564l.265-1.279c.46-.165.892-.399 1.28-.74l1.393 1.393a1 1 0 0 0 1.12-.21l.795-.795a1 1 0 0 0-.21-1.12l-1.393-1.393c.341-.388.575-.82.74-1.28l1.279-.265a1 1 0 0 0 .564-.968V7.437a1 1 0 0 0-.564-.968l-1.279-.265a5.53 5.53 0 0 0-.74-1.28l1.393-1.393a1 1 0 0 0 .21-1.12l-.795-.795a1 1 0 0 0-1.12-.21L11.78 3.22a5.53 5.53 0 0 0-1.28-.74z"/>
                    </svg>
                  </span>
                  Pengaturan Akun
                </a>
              </li>

              @if($user && $user->role === 'admin')
                <li><hr class="dropdown-divider"></li>
                <li>
                  <a class="dropdown-item"
                     href="@if(Route::has('admin.beranda')) {{ route('admin.beranda') }} @else {{ url('/admin/beranda') }} @endif">
                    <span class="icon me-2" aria-hidden="true">
                      {{-- speedometer2 --}}
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor">
                        <path d="M8 4a.5.5 0 0 1 .5.5v4.21l2.146 2.146a.5.5 0 1 1-.707.707L7.5 9.707V4.5A.5.5 0 0 1 8 4z"/>
                        <path d="M3.278 14A7 7 0 1 1 12.722 14z"/>
                      </svg>
                    </span>
                    Admin Dashboard
                  </a>
                </li>
              @endif

              <li><hr class="dropdown-divider"></li>
              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="dropdown-item">
                    <span class="icon me-2" aria-hidden="true">
                      {{-- box-arrow-right --}}
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor">
                        <path d="M6 3a2 2 0 0 0-2 2v2h1V5a1 1 0 0 1 1-1h7V3z"/>
                        <path d="M11.5 8 9 5.5V7H4v2h5v1.5z"/>
                        <path d="M14 4h1v8h-1z"/>
                      </svg>
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
              <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001l3.85 3.85a1 1 0 0 0 1.415-1.415l-3.85-3.85a1 1 0 0 0-.017-.017zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
          </svg>
          </span>
          <input type="text" name="q" placeholder="Cari..." class="border-0 outline-none w-100" style="font-size:.95rem;color:#000;">
        </div>
      </form>
    </div>
  </div>
</nav>
