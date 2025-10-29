<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar | Barbekuy</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<style>
        * {
            font-family: 'Poppins', sans-serif;
        }

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

        .search-box i {
            color: #000000;
            font-size: 1rem;
            margin-right: 10px;
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

        /* === Ikon Keranjang (tanpa teks) === */
        .nav-keranjang {
            color: #751A25;
            font-size: 1.35rem;
            transition: 0.3s;
            margin-left: 10px;
            position: relative;
        }

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
            box-shadow: 0 0 3px rgba(0,0,0,0.2);
        }

        /* Responsive */
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

{{-- === NAVBAR === --}}
<nav class="navbar navbar-expand-lg sticky-top">
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
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
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
          <a href="{{ route('keranjang.index') }}" class="nav-keranjang" title="Keranjang">
            <i class="bi bi-cart3"></i>
            <span class="badge-cart">{{ $cartCount ?? 0 }}</span>
          </a>
        </li>

        {{-- 🔐 Profil / Login --}}
        @auth
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="profileMenu"
              role="button" data-bs-toggle="dropdown" aria-expanded="false" title="Profil">
              <i class="bi bi-person-circle" style="font-size:1.4rem; color:#751A25;"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileMenu">
              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="dropdown-item">
                    <i class="bi bi-box-arrow-right me-2"></i> Keluar
                  </button>
                </form>
              </li>
            </ul>
          </li>
        @else
          <li class="nav-item ms-lg-3">
            <a href="{{ route('login') }}" class="btn btn-login text-white">Masuk</a>
          </li>
        @endauth
      </ul>

      {{-- 🔍 SEARCH HP --}}
      <form class="d-lg-none mt-3 w-100" action="{{ url('/search') }}" method="GET">
        <div class="search-box d-flex align-items-center bg-white rounded-3 px-3 py-2 shadow-sm border">
          <i class="bi bi-search me-2 text-dark"></i>
          <input type="text" name="q" placeholder="Cari..." class="border-0 outline-none w-100" style="font-size: 0.95rem; color: #000;">
        </div>
      </form>
    </div>
  </div>
</nav>
</body>
</html>

