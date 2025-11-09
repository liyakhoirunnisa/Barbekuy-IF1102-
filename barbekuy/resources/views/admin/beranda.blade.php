<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Beranda | Barbekuy</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
  <!-- Tambahan Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

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

    .dashboard-content {
      flex: 1;
      padding: 28px 36px;
      overflow: auto;
    }

    .title-row {
      display: flex;
      align-items: flex-end;
      justify-content: space-between;
      margin-bottom: 18px
    }

    .title-row h1 {
      font-size: 28px;
      color: #751A25;
      font-weight: 700
    }

    .top-cards {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 22px;
      margin-bottom: 34px
    }

    .stat-card {
      background: #fff;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 6px 18px rgba(16, 24, 32, 0.04);
      min-height: 130px;
      display: flex;
      flex-direction: column;
      justify-content: space-between
    }

    .stat-card .meta {
      display: flex;
      align-items: center;
      justify-content: space-between
    }

    .stat-card .meta i {
      font-size: 20px;
      color: #751A25;
    }

    .stat-card h3 {
      font-size: 14px;
      color: #333;
      margin: 0;
      font-weight: 600
    }

    .stat-card .value {
      font-size: 22px;
      font-weight: 700;
      color: #751A25;
      margin-top: 8px
    }

    .stat-chart {
      width: 100%;
      height: 78px;
      margin-top: 6px
    }

    .stat-chart svg {
      width: 100%;
      height: 100%
    }

    .stat-chart path {
      stroke: #751A25;
      stroke-width: 3;
      fill: none;
      stroke-linecap: round;
      stroke-linejoin: round
    }

    .stat-chart circle {
      fill: #fff;
      stroke: #751A25;
      stroke-width: 2
    }

    .section-title {
      font-size: 22px;
      color: #1b1b1b;
      font-weight: 700;
      margin: 20px 0 18px 0
    }

    .product-cards {
      display: flex;
      justify-content: center;
      gap: 34px;
      margin-bottom: 34px
    }

    .product-card {
      width: 300px;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 6px 18px rgba(16, 24, 32, 0.04);
      padding: 22px;
      text-align: center;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 12px
    }

    .product-card img {
      width: 180px;
      height: 180px;
      object-fit: cover;
      border-radius: 14px
    }

    .product-card h4 {
      font-size: 16px;
      color: #222;
      margin: 0
    }

    .product-card .price {
      font-size: 20px;
      color: #751A25;
      font-weight: 800;
      margin-top: 8px
    }

    .bottom-grid {
      display: grid;
      grid-template-columns: 220px 1fr 360px;
      gap: 22px;
      align-items: start
    }

    .left-column {
      display: flex;
      flex-direction: column;
      gap: 18px
    }

    .small-box {
      background: #fff;
      border-radius: 12px;
      padding: 18px;
      text-align: center;
      box-shadow: 0 6px 18px rgba(16, 24, 32, 0.04)
    }

    .small-box h4 {
      font-size: 14px;
      color: #666;
      margin-bottom: 6px
    }

    .small-box .num {
      font-size: 22px;
      color: #751A25;
      font-weight: 800
    }

    .stock-box {
      background: #fff;
      border-radius: 12px;
      padding: 18px;
      box-shadow: 0 6px 18px rgba(16, 24, 32, 0.04)
    }

    .stock-box h3 {
      font-size: 18px;
      margin-bottom: 14px;
      color: #111
    }

    .stock-list {
      display: flex;
      gap: 14px;
      flex-wrap: nowrap;
      overflow-x: auto;
      padding-bottom: 6px
    }

    .stock-item {
      min-width: 240px;
      background: #fff;
      border: 1px solid #f0f0f0;
      border-radius: 10px;
      padding: 12px;
      display: flex;
      gap: 12px;
      align-items: center
    }

    .stock-item img {
      width: 68px;
      height: 68px;
      object-fit: cover;
      border-radius: 8px
    }

    .stock-item .meta h5 {
      font-size: 14px;
      margin-bottom: 6px;
      color: #222
    }

    .stock-item .meta p {
      font-size: 12px;
      color: #777
    }

    .chart-box {
      background: #fff;
      border-radius: 12px;
      padding: 18px;
      box-shadow: 0 6px 18px rgba(16, 24, 32, 0.04);
      height: 100%
    }

    .chart-box h3 {
      font-size: 16px;
      margin-bottom: 18px;
      color: #111;
      text-align: center
    }

    .bars {
      display: flex;
      align-items: flex-end;
      justify-content: space-around;
      height: 220px;
      padding: 10px 8px;
      position: relative
    }

    .bars .bar-wrap {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 8px;
      width: 80px
    }

    .bars .bar {
      width: 56px;
      border-radius: 8px 8px 0 0;
      background: #751A25;
      position: relative;
      display: flex;
      align-items: flex-end;
      justify-content: center
    }

    .bars .bar.non {
      background: #cdb3b6
    }

    .bars .label {
      font-size: 14px;
      color: #222
    }

    .bars .axis-y {
      position: absolute;
      left: 12px;
      top: 10px;
      bottom: 10px;
      border-left: 1px solid #e6e6e6;
      width: 0
    }

    .bars .axis-x {
      position: absolute;
      left: 10px;
      right: 10px;
      bottom: 10px;
      border-top: 1px solid #e6e6e6;
      height: 0
    }

    .bar-value {
      font-size: 13px;
      color: #751A25;
      font-weight: 700;
      position: relative;
      bottom: 6px
    }

    .topbar a {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 55px;
    }
  </style>
</head>

<body>
  {{-- 🔹 Sidebar + Topbar --}}
  @include('layouts.navbarAdmin')

  <main class="main-content">
    <div class="dashboard-content">
      <div class="title-row">
        <h2>Beranda</h2>
      </div>

      {{-- 🔹 3 kartu statistik dinamis --}}
      <div class="top-cards">
        <div class="stat-card">
          <div class="meta">
            <h3>Pesanan</h3>
            <i class="bi bi-cart-fill"></i>
          </div>
          <div class="value">{{ number_format($pesananTotal ?? 0, 0, ',', '.') }}</div>
          <div class="stat-chart">
            <svg viewBox="0 0 200 60">
              <path d="M0 45 C30 38, 60 35, 90 38 C120 41, 150 35, 200 28" />
              <circle cx="10" cy="44" r="2.2" />
              <circle cx="50" cy="39" r="2.2" />
              <circle cx="90" cy="38" r="2.2" />
              <circle cx="130" cy="40" r="2.2" />
              <circle cx="170" cy="35" r="2.2" />
            </svg>
          </div>
        </div>

        <div class="stat-card">
          <div class="meta">
            <h3>Pelanggan</h3>
            <i class="bi bi-people-fill"></i>
          </div>
          <div class="value">{{ number_format($pelangganTotal ?? 0, 0, ',', '.') }}</div>
          <div class="stat-chart">
            <svg viewBox="0 0 200 60">
              <path d="M0 42 C30 36, 60 34, 90 36 C120 38, 150 33, 200 30" />
              <circle cx="15" cy="41" r="2.2" />
              <circle cx="60" cy="34" r="2.2" />
              <circle cx="110" cy="36" r="2.2" />
              <circle cx="160" cy="34" r="2.2" />
            </svg>
          </div>
        </div>

        <div class="stat-card">
          <div class="meta">
            <h3>Pendapatan</h3>
            <i class="bi bi-cash-stack"></i>
          </div>
          <div class="value">Rp {{ number_format($pendapatanTotal ?? 0, 0, ',', '.') }}</div>
          <div class="stat-chart">
            <svg viewBox="0 0 200 60">
              <path d="M0 44 C40 38, 80 36, 120 38 C150 40, 180 39, 200 36" />
              <circle cx="20" cy="43" r="2.2" />
              <circle cx="70" cy="36" r="2.2" />
              <circle cx="120" cy="38" r="2.2" />
              <circle cx="170" cy="37" r="2.2" />
            </svg>
          </div>
        </div>
      </div>

      <!-- Paling Laris (dinamis) -->
      <div class="section-title">Paling Laris</div>
      <div class="product-cards">
        @forelse ($bestSellers as $p)
        @php
        $img = !empty($p->gambar)
        ? asset('storage/'.ltrim($p->gambar, '/'))
        : asset('images/bbq.jpg'); // fallback
        @endphp

        <div class="product-card">
          <img src="{{ $img }}" alt="{{ $p->nama_produk }}">
          <h4>{{ $p->nama_produk }}</h4>
          <div class="price">Rp{{ number_format($p->harga_tampil ?? 0, 0, ',', '.') }}</div>
          <small style="color:#777;">Terjual {{ (int) $p->total_terjual }}</small>
        </div>
        @empty
        <p class="text-muted" style="width:100%; text-align:center;">Belum ada data best seller.</p>
        @endforelse
      </div>

      <!-- middle: stock kosong -->
      <div class="stock-box">
        <h3>Stok Kosong</h3>
        <div class="stock-list">
          @forelse ($outOfStock as $p)
          @php
          $img = !empty($p->gambar)
          ? asset('storage/'.ltrim($p->gambar, '/'))
          : asset('images/bbq.jpg'); // fallback jika tidak ada gambar
          @endphp

          <div class="stock-item">
            <img src="{{ $img }}" alt="{{ $p->nama_produk }}">
            <div class="meta">
              <h5>{{ $p->nama_produk }}</h5>
              <p>Stok: {{ (int)($p->stok ?? 0) }}</p>
            </div>
          </div>
          @empty
          <p class="text-muted" style="margin:0 auto;">Tidak ada produk yang kehabisan stok.</p>
          @endforelse
        </div>
      </div>
    </div>
    </div>
  </main>
</body>
</html>