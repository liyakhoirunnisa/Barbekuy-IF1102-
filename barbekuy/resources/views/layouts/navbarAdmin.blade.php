@php
// hitung jumlah notifikasi belum dibaca untuk admin yang login
$notifUnreadCount = auth()->check()
? (auth()->user()->unreadNotifications()->count() ?? 0)
: 0;
@endphp

<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
  }

  body {
    background: #f5f6fa;
    display: flex;
    min-height: 100vh;
  }

  /* === SIDEBAR === */
  .sidebar {
    width: 240px;
    background: #751A25;
    color: #fff;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding-top: 20px;
    flex-shrink: 0;
  }

  .logo {
    height: 110px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #751A25;
  }

  .logo img {
    width: 190px;
    height: auto;
    object-fit: contain;
    position: relative;
    top: -18px;
  }

  .menu {
    width: 100%;
    margin-top: -3px;
  }

  .menu-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 26px;
    color: #fff;
    font-size: 14px;
    text-decoration: none;
    transition: 0.3s;
  }

  .menu-item i {
    font-size: 18px;
    width: 20px;
    text-align: center;
  }

  .menu-item:hover,
  .menu-item.active {
    background: rgba(255, 255, 255, 0.15);
    border-radius: 10px;
  }

  /* === TOPBAR === */
  .main-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    height: 100vh;
    overflow: hidden;
  }

  .topbar {
    height: 90px;
    background: #751A25;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    padding: 0 40px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    gap: 25px;
  }

  .topbar a {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 55px;
    position: relative;
  }

  .topbar a i {
    font-size: 22px;
    color: #fff;
    cursor: pointer;
    transition: 0.3s;
  }

  .topbar a i:hover {
    transform: scale(1.1);
  }

  .badge {
    position: absolute;
    top: 5px;
    right: 8px;
    background: red;
    color: #fff;
    font-size: 11px;
    padding: 2px 6px;
    border-radius: 50%;
  }

  .profile {
    height: 55px;
    display: flex;
    align-items: center;
    gap: 10px;
    background: #fff;
    color: #751A25;
    padding: 6px 14px;
    border-radius: 30px;
    font-weight: 500;
  }

  .avatar {
    background: #751A25;
    color: #fff;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
  }
</style>

<aside class="sidebar">
  <div class="logo"><img src="{{ asset('images/logoputih.png') }}" alt="Logo Barbekuy"></div>
  <div class="menu">
    <a href="{{ route('admin.beranda') }}" class="menu-item {{ request()->routeIs('admin.beranda') ? 'active' : '' }}">
      <i class="fa-solid fa-house"></i> Beranda
    </a>
    <a href="{{ route('admin.transaksi') }}" class="menu-item {{ request()->routeIs('admin.transaksi') ? 'active' : '' }}">
      <i class="fa-solid fa-money-check-dollar"></i> Transaksi
    </a>
    <a href="{{ route('admin.produk') }}" class="menu-item {{ request()->routeIs('admin.produk') ? 'active' : '' }}">
      <i class="fa-solid fa-box"></i> Produk
    </a>
    <a href="{{ route('admin.pengaturan') }}" class="menu-item {{ request()->routeIs('admin.pengaturan') ? 'active' : '' }}">
      <i class="fa-solid fa-gear"></i> Pengaturan
    </a>
  </div>
</aside>

<main class="main-content">
  <div class="topbar">
    <a href="{{ route('admin.notifikasi.index') }}" title="Notifikasi">
      <i class="fa-solid fa-bell"></i>
      @if(($notifUnreadCount ?? 0) > 0)
      <span class="badge">{{ $notifUnreadCount }}</span>
      @endif
    </a>

    <div class="profile">
      <div class="avatar">{{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}</div>
      <span>{{ Auth::user()->name ?? 'Admin Barbekuy' }}</span>
    </div>

    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Keluar">
      <i class="fa-solid fa-right-from-bracket" style="font-size:22px;color:#fff;margin-left:12px;"></i>
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
      @csrf
    </form>
  </div>