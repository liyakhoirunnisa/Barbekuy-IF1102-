<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Beranda | Barbekuy</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
  <style>
    /* ---------- BASE ---------- */
    *{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif}
    html,body{height:100%}
    body{display:flex;min-height:100vh;background:#f5f6fa;overflow:hidden;color:#1f1f1f}

    /* ---------- SIDEBAR (TIDAK DIUBAH) ---------- */
    .sidebar{width:240px;background:#751A25;color:#fff;display:flex;flex-direction:column;align-items:center;padding-top:20px;}
    .logo{height:110px;display:flex;align-items:center;justify-content:center;background:#751A25;}
    .logo img{width:190px;height:auto;object-fit:contain;position:relative;top:-18px;}
    .menu{width:100%;margin-top:-3px;}
    .menu-item{display:flex;align-items:center;gap:12px;padding:14px 26px;color:#fff;font-size:14px;text-decoration:none;transition:0.3s;}
    .menu-item img{width:20px;height:20px;object-fit:contain;filter:brightness(0) invert(1);}
    .menu-item:hover,.menu-item.active{background:rgba(255,255,255,0.15);border-radius:10px;}
    .notif{background:#fff;color:#751A25;font-size:11px;padding:2px 8px;border-radius:12px;margin-left:auto;font-weight:600;}

    /* ---------- TOPBAR (TIDAK DIUBAH) ---------- */
    .main-content{flex:1;display:flex;flex-direction:column;height:100vh;overflow:hidden;}
    .topbar{height:110px;background:#751A25;display:flex;align-items:center;justify-content:flex-end;padding:0 40px;gap:25px;}
    .topbar a img{width:28px;height:28px;filter:brightness(0) invert(1);cursor:pointer;transition:0.3s;}
    .topbar a img:hover{transform:scale(1.1);}
    .profile{height:55px;display:flex;align-items:center;gap:10px;background:#fff;color:#751A25;padding:6px 14px;border-radius:30px;font-weight:500;}
    .avatar{background:#751A25;color:#fff;width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:600;}

    /* ---------- DASHBOARD CONTENT ---------- */
    .dashboard-content{flex:1;padding:28px 36px;overflow:auto;}
    .title-row{display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:18px}
    .title-row h1{font-size:28px;color:#751A25;font-weight:700}
    /* top stats row */
    .top-cards{display:grid;grid-template-columns:repeat(3,1fr);gap:22px;margin-bottom:34px}
    .stat-card{background:#fff;border-radius:12px;padding:20px;box-shadow:0 6px 18px rgba(16,24,32,0.04);min-height:130px;display:flex;flex-direction:column;justify-content:space-between}
    .stat-card .meta{display:flex;align-items:center;justify-content:space-between}
    .stat-card .meta img{width:32px;height:32px;object-fit:contain;}
    .stat-card h3{font-size:14px;color:#333;margin:0;font-weight:600}
    .stat-card .value{font-size:22px;font-weight:700;color:#751A25;margin-top:8px}
    .stat-chart{width:100%;height:78px;margin-top:6px}
    .stat-chart svg{width:100%;height:100%}
    .stat-chart path{stroke:#751A25;stroke-width:3;fill:none;stroke-linecap:round;stroke-linejoin:round}
    .stat-chart circle{fill:#fff;stroke:#751A25;stroke-width:2}

    /* ---------- Paling Laris ---------- */
    .section-title{font-size:22px;color:#1b1b1b;font-weight:700;margin:20px 0 18px 0}
    .product-cards{display:flex;justify-content:center;gap:34px;margin-bottom:34px}
    .product-card{width:300px;background:#fff;border-radius:12px;box-shadow:0 6px 18px rgba(16,24,32,0.04);padding:22px;text-align:center;display:flex;flex-direction:column;align-items:center;gap:12px}
    .product-card img{width:180px;height:180px;object-fit:cover;border-radius:14px}
    .product-card h4{font-size:16px;color:#222;margin:0}
    .product-card .price{font-size:20px;color:#751A25;font-weight:800;margin-top:8px}

    /* ---------- Bottom grid ---------- */
    .bottom-grid{display:grid;grid-template-columns:220px 1fr 360px;gap:22px;align-items:start}
    .left-column{display:flex;flex-direction:column;gap:18px}
    .small-box{background:#fff;border-radius:12px;padding:18px;text-align:center;box-shadow:0 6px 18px rgba(16,24,32,0.04)}
    .small-box h4{font-size:14px;color:#666;margin-bottom:6px}
    .small-box .num{font-size:22px;color:#751A25;font-weight:800}

    .stock-box{background:#fff;border-radius:12px;padding:18px;box-shadow:0 6px 18px rgba(16,24,32,0.04)}
    .stock-box h3{font-size:18px;margin-bottom:14px;color:#111}
    .stock-list{display:flex;gap:14px;flex-wrap:nowrap;overflow-x:auto;padding-bottom:6px}
    .stock-item{min-width:240px;background:#fff;border:1px solid #f0f0f0;border-radius:10px;padding:12px;display:flex;gap:12px;align-items:center}
    .stock-item img{width:68px;height:68px;object-fit:cover;border-radius:8px}
    .stock-item .meta h5{font-size:14px;margin-bottom:6px;color:#222}
    .stock-item .meta p{font-size:12px;color:#777}

    .chart-box{background:#fff;border-radius:12px;padding:18px;box-shadow:0 6px 18px rgba(16,24,32,0.04);height:100%}
    .chart-box h3{font-size:16px;margin-bottom:18px;color:#111;text-align:center}
    .bars{display:flex;align-items:flex-end;justify-content:space-around;height:220px;padding:10px 8px;position:relative}
    .bars .bar-wrap{display:flex;flex-direction:column;align-items:center;gap:8px;width:80px}
    .bars .bar{width:56px;border-radius:8px 8px 0 0;background:#751A25;position:relative;display:flex;align-items:flex-end;justify-content:center}
    .bars .bar.non{background:#cdb3b6}
    .bars .label{font-size:14px;color:#222}
    .bars .axis-y{position:absolute;left:12px;top:10px;bottom:10px;border-left:1px solid #e6e6e6;width:0}
    .bars .axis-x{position:absolute;left:10px;right:10px;bottom:10px;border-top:1px solid #e6e6e6;height:0}
    .bar-value{font-size:13px;color:#751A25;font-weight:700;position:relative;bottom:6px}

    /* === Perbaiki posisi & ukuran icon notifikasi agar sejajar dengan profile admin === */
.topbar a {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 55px; /* sejajar dengan tinggi profile */
}

    /* --- Perbaikan ukuran ikon pada kartu statistik --- */
.stat-card .meta img {
  width: 20px;
  height: 20px;
  object-fit: contain;

  /* Filter yang disetel untuk mendekati #751A25 */
  filter: invert(23%) sepia(62%) saturate(4000%) hue-rotate(335deg) brightness(30%) contrast(95%);
}
  </style>
</head>
<body>
  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="logo"><img src="{{ asset('images/logoputih.png') }}" alt="Logo Barbekuy"></div>
    <div class="menu">
      <a href="#" class="menu-item active"><img src="{{ asset('images/beranda.png') }}"> Beranda</a>
      <a href="{{ route('transaksi') }}" class="menu-item"><img src="{{ asset('images/transaksi.png') }}"> Transaksi</a>
      <a href="{{ route('produk') }}" class="menu-item">
        <img src="{{ asset('images/produk.png') }}"> Produk</a>
      <a href="{{ route('pembayaran') }}" class="menu-item">
        <img src="{{ asset('images/pembayaran.png') }}"> Pembayaran</a>
      <a href="{{ route('pesan') }}" class="menu-item">
        <img src="{{ asset('images/chat.png') }}"> Pesan</a>
      <a href="{{ route('pengaturan') }}" class="menu-item"><img src="{{ asset('images/settings.png') }}"> Pengaturan</a>
    </div>
  </aside>

  <!-- MAIN -->
  <main class="main-content">
    <div class="topbar">
      <a href="{{ route('notifikasi') }}"><img src="{{ asset('images/bell.png') }}" alt="Notifikasi"></a>
      <div class="profile"><div class="avatar">A</div><span>Admin Barbekuy</span></div>
    </div>

    <div class="dashboard-content">
      <div class="title-row"><h2>Beranda</h2></div>

      <!-- Top stat cards -->
      <div class="top-cards">
        <!-- Pesanan -->
        <div class="stat-card">
          <div class="meta">
            <h3>Pesanan</h3>
            <img src="https://img.icons8.com/ios-filled/50/000000/shopping-cart.png" alt="Icon Pesanan">
          </div>
          <div class="value">350</div>
          <div class="stat-chart">
            <svg viewBox="0 0 200 60"><path d="M0 45 C30 38, 60 35, 90 38 C120 41, 150 35, 200 28" />
              <circle cx="10" cy="44" r="2.2"/><circle cx="50" cy="39" r="2.2"/><circle cx="90" cy="38" r="2.2"/><circle cx="130" cy="40" r="2.2"/><circle cx="170" cy="35" r="2.2"/></svg>
          </div>
        </div>

        <!-- Pelanggan -->
        <div class="stat-card">
          <div class="meta">
            <h3>Pelanggan</h3>
            <img src="https://img.icons8.com/ios-filled/50/000000/user-group-man-man.png" alt="Icon Pelanggan">
          </div>
          <div class="value">75</div>
          <div class="stat-chart">
            <svg viewBox="0 0 200 60"><path d="M0 42 C30 36, 60 34, 90 36 C120 38, 150 33, 200 30" />
              <circle cx="15" cy="41" r="2.2"/><circle cx="60" cy="34" r="2.2"/><circle cx="110" cy="36" r="2.2"/><circle cx="160" cy="34" r="2.2"/></svg>
          </div>
        </div>

        <!-- Pendapatan -->
        <div class="stat-card">
          <div class="meta">
            <h3>Pendapatan</h3>
            <img src="https://img.icons8.com/ios-filled/50/000000/wallet.png" alt="Icon Pendapatan">
          </div>
          <div class="value">Rp 4.250.000</div>
          <div class="stat-chart">
            <svg viewBox="0 0 200 60"><path d="M0 44 C40 38, 80 36, 120 38 C150 40, 180 39, 200 36" />
              <circle cx="20" cy="43" r="2.2"/><circle cx="70" cy="36" r="2.2"/><circle cx="120" cy="38" r="2.2"/><circle cx="170" cy="37" r="2.2"/></svg>
          </div>
        </div>
      </div>

      <!-- Paling Laris (centered) -->
      <div class="section-title">Paling Laris</div>
      <div class="product-cards">
        <div class="product-card">
          <img src="{{ asset('images/paket ber4 xtra.png') }}" alt="Paket Slice Ber-4 Xtra">
          <h4>Paket Slice Ber-4 Xtra</h4>
          <div class="price">Rp245.000</div>
        </div>

        <div class="product-card">
          <img src="{{ asset('images/paket ber6 xtra.png') }}" alt="Paket Slice Ber-6 Xtra">
          <h4>Paket Slice Ber-6 Xtra</h4>
          <div class="price">Rp345.000</div>
        </div>

        <div class="product-card">
          <img src="{{ asset('images/paket ber10 xtra.png') }}" alt="Paket Slice Ber-10 Xtra">
          <h4>Paket Slice Ber-10 Xtra</h4>
          <div class="price">Rp525.000</div>
        </div>
      </div>

      <!-- Bottom grid: left small boxes stacked, middle stock, right comparison chart -->
      <div class="bottom-grid">
        <!-- left: perminggu / perbulan stacked -->
        <div class="left-column">
          <div class="small-box">
            <h4>Perminggu</h4>
            <div class="num">10</div>
          </div>
          <div class="small-box">
            <h4>Perbulan</h4>
            <div class="num">35</div>
          </div>
        </div>

        <!-- middle: stock kosong -->
        <div class="stock-box">
          <h3>Stok Kosong</h3>
          <div class="stock-list">
            <div class="stock-item">
              <img src="{{ asset('images/paket ber4 xtra.png') }}" alt="">
              <div class="meta">
                <h5>Paket Slice Ber-4 Xtra</h5>
                <p>Tersedia 15 Oktober</p>
              </div>
            </div>

            <div class="stock-item">
              <img src="{{ asset('images/paket ber6 xtra.png') }}" alt="">
              <div class="meta">
                <h5>Paket Slice Ber-6 Xtra</h5>
                <p>Tersedia 15 Oktober</p>
              </div>
            </div>
          </div>
        </div>

        <!-- right: paket vs non paket (bar with axis + percentages) -->
        <div class="chart-box">
          <h3>Perbandingan Paket vs Non Paket</h3>
          <div class="bars">
            <div class="axis-y"></div>
            <div class="axis-x"></div>

            <!-- Paket (75%) -->
            <div class="bar-wrap">
              <div class="bar" style="height:150px;">
                <div class="bar-value">75%</div>
              </div>
              <div class="label">Paket</div>
            </div>

            <!-- Non Paket (25%) -->
            <div class="bar-wrap">
              <div class="bar non" style="height:60px;">
                <div class="bar-value" style="color:#7a5a5a">25%</div>
              </div>
              <div class="label">Non Paket</div>
            </div>

          </div>
        </div>
      </div>

    </div>
  </main>
</body>
</html>
