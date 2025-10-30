{{-- resources/views/layouts/navbar.blade.php --}}

@php
  $__cart = session('keranjang', []);
  $cartCount = 0;
  if (is_array($__cart)) {
    foreach ($__cart as $row) { $cartCount += (int)($row['jumlah'] ?? 1); }
  }
@endphp

<style>
  /* (pindahkan ke CSS global kalau sudah ada) */
  *{ font-family:'Poppins',sans-serif; }
  nav.navbar{ background:#fff; box-shadow:0 2px 8px rgba(0,0,0,.1); }
  .navbar-brand img{ width:130px; }
  .nav-link{ color:#800000 !important; font-weight:500; transition:.3s; margin-right:10px; }
  .nav-link:hover{ color:#a00000 !important; }
  .btn-login{ background:#800000; color:#fff !important; border-radius:8px; padding:6px 18px; transition:.3s; }
  .btn-login:hover{ background:#a00000; }
  .search-box{ display:flex; align-items:center; background:#fff; border-radius:12px; padding:8px 14px;
               box-shadow:0 0 5px rgba(128,0,0,.08); border:1px solid rgba(128,0,0,.1); width:400px; transition:.3s; margin:0 20px; }
  .search-box:hover{ box-shadow:0 0 15px rgba(128,0,0,.15); }
  .search-box i{ color:#000; font-size:1rem; margin-right:10px; }
  .search-box input{ border:none; outline:none; width:100%; font-size:.95rem; color:#000; }
  .search-box input::placeholder{ color:#000; opacity:.7; }
  .nav-keranjang{ color:#751A25; font-size:1.35rem; transition:.3s; margin-left:10px; position:relative; }
  .nav-keranjang:hover{ color:#9c2833; }
  .badge-cart{ position:absolute; top:-4px; right:-8px; background:#d32f2f; color:#fff; font-size:10px; font-weight:600;
               padding:2px 5px; border-radius:50%; line-height:1; min-width:18px; text-align:center; box-shadow:0 0 3px rgba(0,0,0,.2); }
  @media (max-width: 992px){ .search-box{ width:100%; margin:10px 0; } .nav-link{ margin:10px 0; } }
</style>

<nav class="navbar navbar-expand-lg navbar-light sticky-top">
  <div class="container">
    {{-- Logo --}}
    <a class="navbar-brand d-flex align-items-center" href="{{ route('beranda') }}">
      <img src="{{ asset('images/logo.png') }}" alt="Barbekuy Logo" class="me-2" style="height:36px;width:auto;">
    </a>

    {{-- Search (desktop) --}}
    <form class="d-none d-lg-block" action="{{ url('/search') }}" method="GET">
      <div class="search-box d-flex align-items-center bg-white rounded-3 px-3 py-2 shadow-sm border" style="width: 400px;">
        <i class="bi bi-search me-2 text-dark"></i>
        <input type="text" name="q" placeholder="Cari..." class="border-0 outline-none w-100" style="font-size:.95rem;color:#000;">
      </div>
    </form>

    {{-- Toggler --}}
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    {{-- Menu kanan --}}
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav align-items-center">
        <li class="nav-item"><a class="nav-link" href="{{ route('beranda') }}">Beranda</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ url('/#tentang') }}">Tentang Kami</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('menu') }}">Menu</a></li>
        <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
      </ul>

      <ul class="navbar-nav align-items-center actions">
        {{-- Keranjang --}}
        <li class="nav-item position-relative">
          <a href="{{ route('keranjang.index') }}" class="nav-keranjang" title="Keranjang">
            <i class="bi bi-cart3"></i>
            {{-- sembunyikan di server jika 0 --}}
            <span class="badge-cart" @if(($cartCount ?? 0) <= 0) style="display:none" @endif>
              {{ $cartCount ?? 0 }}
            </span>
          </a>
        </li>

        {{-- Profil / Login --}}
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

      {{-- Search (mobile) --}}
      <form class="d-lg-none mt-3 w-100" action="{{ url('/search') }}" method="GET">
        <div class="search-box d-flex align-items-center bg-white rounded-3 px-3 py-2 shadow-sm border">
          <i class="bi bi-search me-2 text-dark"></i>
          <input type="text" name="q" placeholder="Cari..." class="border-0 outline-none w-100" style="font-size:.95rem;color:#000%;">
        </div>
      </form>
    </div>
  </div>
</nav>

@auth
<script>
(function () {
  const badge = document.querySelector('.badge-cart');
  if (!badge) return;

  async function refreshCartCount() {
    try {
      const res = await fetch('{{ route('keranjang.count') }}', {
        headers: { 'Accept': 'application/json' },
        credentials: 'same-origin'
      });
      if (!res.ok) return;
      const data = await res.json();
      const n = parseInt(data.count || 0, 10) || 0;
      badge.textContent = n;
      badge.style.display = n > 0 ? 'inline-block' : 'none';
    } catch (_) { /* no-op */ }
  }

  // Perbarui ketika halaman lain menambah/menghapus item
  window.addEventListener('cart:updated', refreshCartCount);
})();
</script>
@endauth
