<div class="sidebar">
  <div class="logo">
    <img src="{{ asset('images/logo.png') }}" alt="Logo Berbekuy">
  </div>
  
  <div class="menu">
    <a href="{{ route('dashboard') }}" class="menu-item {{ request()->is('dashboard') ? 'active' : '' }}">
      <img src="{{ asset('images/dashboard.png') }}"> Dashboard
    </a>
    <a href="{{ route('transaksi') }}" class="menu-item {{ request()->is('transaksi') ? 'active' : '' }}">
      <img src="{{ asset('images/transaksi.png') }}"> Transaksi
    </a>
    <a href="{{ route('produk') }}" class="menu-item {{ request()->is('produk') ? 'active' : '' }}">
      <img src="{{ asset('images/produk.png') }}"> Produk
    </a>
    <a href="{{ route('pembayaran') }}" class="menu-item {{ request()->is('pembayaran') ? 'active' : '' }}">
      <img src="{{ asset('images/pembayaran.png') }}"> Pembayaran
    </a>
  </div>
</div>