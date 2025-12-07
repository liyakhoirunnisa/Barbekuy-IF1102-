<!doctype html> <!-- Deklarasi tipe dokumen HTML5 -->
<html lang="id"> <!-- Bahasa halaman: Indonesia -->

<head>
  <meta charset="utf-8" /> <!-- Set karakter encoding UTF-8 -->
  <meta name="viewport" content="width=device-width, initial-scale=1" /> <!-- Responsif di berbagai perangkat -->
  <title>Beranda | Barbekuy</title> <!-- Judul halaman -->
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}"> <!-- Icon favicon -->

  <!-- Tambahan Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> <!-- Library ikon -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script> <!-- Library Chart.js untuk grafik -->

  {{-- Google Font --}}
  <!-- Import font Poppins dari Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet"> <!-- Link Google Font -->

  <style>
    * {
      margin: 0;
      /* Hilangkan margin default semua elemen */
      padding: 0;
      /* Hilangkan padding default semua elemen */
      box-sizing: border-box;
      /* Hitung lebar/tinggi elemen termasuk padding & border */
      font-family: 'Poppins', sans-serif;
      /* Gunakan font Poppins untuk seluruh halaman */
    }

    body {
      background: #f5f6fa;
      /* Warna latar belakang abu muda dashboard */
      display: flex;
      /* Gunakan flexbox untuk menata body (sidebar + konten) */
      min-height: 100vh;
      /* Tinggi minimum layar penuh (viewport height) */
    }

    /* container utama konten (sebelah kanan sidebar) */
    .main-content {
      flex: 1;
      /* Ambil sisa ruang yang tersedia di samping sidebar */
      display: flex;
      /* Jadikan main-content sebagai flex container */
      flex-direction: column;
      /* Susun isi main-content secara vertikal */
      min-width: 0;
      /* Cegah overflow horizontal pada konten fleksibel */
    }

    .dashboard-content {
      flex: 1;
      /* Isi dashboard-content memenuhi tinggi yang tersedia di main-content */
      padding: 28px 36px;
      /* Ruang dalam (atas/bawah 28px, kiri/kanan 36px) */
      overflow: auto;
      /* Izinkan konten di-scroll jika tinggi melebihi ruang */
    }

    .title-row {
      display: flex;
      /* Gunakan flexbox untuk judul dan elemen lain di baris judul */
      align-items: flex-end;
      /* Rata vertikal di bagian bawah */
      justify-content: space-between;
      /* Jarak maksimal antara judul dan elemen di kanan (kalau ada) */
      margin-bottom: 18px
        /* Jarak bawah dari baris judul ke elemen berikutnya */
    }

    .title-row h1,
    .title-row h2 {
      font-size: 28px;
      /* Ukuran font judul halaman */
      color: #000000;
      /* Warna teks judul (hitam) */
      font-weight: 700
        /* Tebal font judul */
    }

    .top-cards {
      display: grid;
      /* Gunakan CSS Grid untuk deretan kartu statistik atas */
      grid-template-columns: repeat(3, minmax(0, 1fr));
      /* Tiga kolom, masing-masing fleksibel 1fr */
      gap: 22px;
      /* Jarak antar kartu statistik */
      margin-bottom: 34px
        /* Jarak bawah dari deretan kartu ke section berikutnya */
    }

    .stat-card {
      background: #fff;
      border-radius: 12px;
      padding: 24px 22px;
      /* 🔼 padding lebih tebal */
      box-shadow: 0 6px 18px rgba(16, 24, 32, 0.04);
      min-height: 180px;
      /* 🔼 box lebih tinggi */
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .stat-card .meta i {
      font-size: 24px;
      /* ikon sedikit lebih besar */
    }

    .stat-card h3 {
      font-size: 16px;
      /* label "Pesanan" dll lebih besar */
    }

    .stat-card .value {
      font-size: 28px;
      /* angka utama lebih besar */
      font-weight: 700;
      color: #751A25;
      margin-top: 10px;
    }

    .stat-chart {
      width: 100%;
      height: 120px;
      /* 🔼 area grafik diperbesar */
      margin-top: 10px;
      position: relative;
      padding-top: 8px;
      box-sizing: border-box;
    }


    /* Biar canvas selalu ikut ukuran container */
    .stat-chart canvas {
      width: 100% !important;
      height: 100% !important;
    }

    .section-title {
      font-size: 22px;
      /* Ukuran font judul section (Paling Laris, Stok Kosong) */
      color: #1b1b1b;
      /* Warna teks hampir hitam */
      font-weight: 700;
      /* Tebal judul section */
      margin: 20px 0 18px 0
        /* Margin atas 20px, kanan 0, bawah 18px, kiri 0 */
    }

    .product-cards {
      display: flex;
      /* Gunakan flexbox untuk deretan kartu produk */
      justify-content: flex-start;
      /* Susun dari kiri ke kanan (tidak di-center) */
      gap: 20px;
      /* Jarak antar kartu produk */
      margin-bottom: 26px
        /* Jarak bawah dari deretan produk ke section berikutnya */
    }

    .product-card {
      width: 220px;
      /* Lebar tetap kartu produk */
      background: #fff;
      /* Latar belakang kartu putih */
      border-radius: 12px;
      /* Sudut kartu melengkung */
      box-shadow: 0 6px 18px rgba(16, 24, 32, 0.04);
      /* Bayangan halus kartu */
      padding: 10px 12px 14px;
      /* Ruang dalam kartu */
      text-align: center;
      /* Seluruh teks di tengah */
      display: flex;
      /* Flexbox untuk isi kartu */
      flex-direction: column;
      /* Susun isi kartu secara vertikal */
      align-items: center;
      /* Rata tengah horizontal */
      gap: 10px
        /* Jarak vertikal antar elemen di dalam kartu */
    }

    .product-card img {
      width: 140px;
      /* Lebar gambar produk */
      height: 140px;
      /* Tinggi gambar produk */
      object-fit: cover;
      /* Gambar memenuhi kotak tanpa merusak proporsi */
      border-radius: 14px
        /* Sudut gambar sedikit melengkung */
    }

    .product-card h4 {
      font-size: 16px;
      /* Ukuran nama produk */
      color: #222;
      /* Warna teks abu gelap */
    }

    .product-card .price {
      font-size: 14px;
      /* Ukuran teks harga */
      color: #751A25;
      /* Warna harga maroon */
      font-weight: 800;
      /* Lebih tebal agar harga menonjol */
    }

    .product-card small {
      font-size: 12px;
      color: #777;
      /* Warna teks keterangan kecil "Terjual X" abu sedang */
      /* warna teks "Terjual ..." */
    }

    /* pesan jika data kosong (best seller & stok kosong) */
    .section-empty {
      width: 100%;
      /* Lebar pesan memenuhi container */
      text-align: center;
      /* Teks pesan rata tengah */
      margin: 0 auto;
      /* Margin otomatis kiri-kanan agar posisi tengah */
    }

    .stock-box {
      background: #fff;
      /* Latar belakang kotak stok putih */
      border-radius: 12px;
      /* Sudut kotak stok melengkung */
      padding: 18px;
      /* Ruang dalam kotak stok */
      box-shadow: 0 6px 18px rgba(16, 24, 32, 0.04);
      /* Bayangan halus kotak stok */
      margin-bottom: 24px;
      /* Jarak bawah dari section stok ke elemen berikutnya */
    }

    .stock-box h3 {
      font-size: 18px;
      /* Ukuran judul kecil di dalam kotak stok (kalau dipakai) */
      margin-bottom: 14px;
      /* Jarak bawah judul ke isi stok */
      color: #111
        /* Warna teks judul stok hitam pekat */
    }

    .stock-list {
      display: flex;
      /* Flexbox untuk deretan item stok kosong */
      gap: 14px;
      /* Jarak antar item stok */
      flex-wrap: nowrap;
      /* Jangan bungkus ke baris berikut; geser horizontal */
      overflow-x: auto;
      /* Izinkan scroll horizontal jika item banyak */
      padding-bottom: 6px
        /* Ruang bawah kecil agar scroll bar tidak terlalu mepet */
    }

    .stock-item {
      min-width: 240px;
      /* Lebar minimum tiap kartu stok */
      background: #fff;
      /* Latar belakang kartu stok putih */
      border: 1px solid #f0f0f0;
      /* Border tipis abu sangat muda */
      border-radius: 10px;
      /* Sudut kartu stok melengkung */
      padding: 12px;
      /* Ruang dalam kartu stok */
      display: flex;
      /* Flexbox untuk isi kartu stok */
      gap: 12px;
      /* Jarak antara gambar dan teks */
      align-items: center
        /* Rata tengah vertikal isi kartu stok */
    }

    .stock-item img {
      width: 68px;
      /* Lebar gambar produk di stok */
      height: 68px;
      /* Tinggi gambar produk di stok */
      object-fit: cover;
      /* Gambar memenuhi area tanpa distorsi */
      border-radius: 8px
        /* Sudut gambar stok melengkung */
    }

    .stock-item .meta h5 {
      font-size: 14px;
      /* Ukuran nama produk di kartu stok */
      margin-bottom: 6px;
      /* Jarak bawah nama ke teks stok */
      color: #222
        /* Warna teks nama produk abu gelap */
    }

    .stock-item .meta p {
      font-size: 12px;
      /* Ukuran teks detail stok (misal "Stok: 0") */
      color: #777
        /* Warna teks abu sedang */
    }

    .topbar a {
      display: flex;
      /* Topbar link sebagai flex container */
      align-items: center;
      /* Rata vertikal tengah isi link */
      justify-content: center;
      /* Rata tengah horizontal isi link */
      height: 55px;
      /* Tinggi tetap area klik topbar */
    }

    /* ================================
       📱 RESPONSIVE
       ================================ */

    /* Tablet (<= 992px) */
    @media (max-width: 992px) {
      body {
        flex-direction: column;
        /* Susun body vertikal (sidebar bisa di atas) pada tablet */
      }

      .dashboard-content {
        padding: 20px 18px;
        /* Sedikit kurangi padding di tablet */
      }

      .title-row h1,
      .title-row h2 {
        font-size: 24px;
        /* Kecilkan ukuran judul di tablet */
      }

      .top-cards {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        /* Dari 3 kolom jadi 2 kolom di tablet */
        gap: 16px;
        /* Kurangi jarak antar kartu */
      }

      .product-cards {
        flex-wrap: wrap;
        /* Izinkan kartu produk turun ke baris berikutnya */
        justify-content: center;
        /* Rata tengah deretan produk di tablet */
        gap: 18px;
        /* Jarak antar kartu sedikit lebih rapat */
      }

      .product-card {
        width: 260px;
        /* Lebar kartu produk sedikit diperkecil di tablet */
      }

      .stock-list {
        /* tetap scroll horizontal di tablet */
        padding-bottom: 8px;
        /* Tambah padding bawah agar scroll lebih nyaman */
      }
    }

    /* Mobile (<= 576px) */
    @media (max-width: 576px) {
      .dashboard-content {
        padding: 18px 14px;
        /* Padding lebih kecil di layar HP */
      }

      .title-row {
        flex-direction: column;
        /* Judul dan elemen lain disusun vertikal */
        align-items: flex-start;
        /* Rata kiri judul */
        gap: 4px;
        /* Jarak kecil antar elemen di title-row */
      }

      .title-row h1,
      .title-row h2 {
        font-size: 20px;
        /* Judul lebih kecil lagi di HP */
      }

      .top-cards {
        grid-template-columns: 1fr;
        /* Kartu statistik satu kolom (full width) */
        gap: 14px;
        /* Jarak antar kartu statistik di HP */
      }

      .stat-card {
        min-height: auto;
        /* Lepas batas tinggi minimum di HP */
        padding: 16px;
        /* Padding lebih kecil di HP */
      }

      .stat-card .value {
        font-size: 18px;
        /* Perkecil ukuran angka statistik di HP */
      }

      .section-title {
        font-size: 18px;
        /* Perkecil judul section di HP */
        margin-top: 16px;
        /* Tambah sedikit jarak atas */
      }

      .product-cards {
        flex-direction: column;
        /* Kartu produk ditumpuk vertikal di HP */
        align-items: stretch;
        /* Kartu lebar penuh container */
        gap: 16px;
        /* Jarak antar kartu produk di HP */
      }

      .product-card {
        width: 100%;
        /* Kartu produk full width di HP */
        padding: 18px;
        /* Padding sedikit lebih kecil */
      }

      .product-card img {
        width: 100%;
        /* Gambar produk lebar penuh kartu di HP */
        max-width: 260px;
        /* Tapi dibatasi maksimum 260px agar tidak terlalu besar */
        height: auto;
        /* Tinggi mengikuti rasio gambar */
      }

      .stock-list {
        flex-direction: column;
        /* Item stok ditumpuk vertikal di HP */
        overflow-x: visible;
        /* Tidak perlu scroll horizontal di HP */
      }

      .stock-item {
        width: 100%;
        /* Kartu stok lebar penuh container di HP */
        min-width: 0;
        /* Hilangkan batas lebar minimum agar fleksibel */
      }
    }
  </style>
</head>

<body> <!-- Awal body halaman -->

  {{-- 🔹 Sidebar + Topbar --}}
  @include('layouts.navbarAdmin') <!-- Menyertakan partial Blade navbarAdmin (sidebar + topbar admin) -->

  <main class="main-content"> <!-- Wrapper utama konten di sebelah kanan sidebar -->
    <div class="dashboard-content"> <!-- Area isi dashboard yang bisa discroll -->
      <div class="title-row"> <!-- Baris untuk judul halaman (dan bisa untuk action di kanan) -->
        <h2>Beranda</h2> <!-- Judul halaman: Beranda -->
      </div> <!-- Tutup title-row -->

      {{-- 🔹 3 kartu statistik dinamis --}}
      <div class="top-cards"> <!-- Grid berisi 3 kartu statistik (Pesanan, Pelanggan, Pendapatan) -->

        <div class="stat-card">
          <div class="meta">
            <h3>Pesanan</h3>
            <i class="bi bi-cart-fill"></i>
          </div>
          <div class="value">{{ number_format($pesananTotal ?? 0, 0, ',', '.') }}</div>
          <div class="stat-chart">
            <canvas id="chartPesanan"></canvas>
          </div>
        </div>

        <div class="stat-card">
          <div class="meta">
            <h3>Pelanggan</h3>
            <i class="bi bi-people-fill"></i>
          </div>
          <div class="value">{{ number_format($pelangganTotal ?? 0, 0, ',', '.') }}</div>
          <div class="stat-chart">
            <canvas id="chartPelanggan"></canvas>
          </div>
        </div>

        <div class="stat-card">
          <div class="meta">
            <h3>Pendapatan</h3>
            <i class="bi bi-cash-stack"></i>
          </div>
          <div class="value">Rp {{ number_format($pendapatanTotal ?? 0, 0, ',', '.') }}</div>
          <div class="stat-chart">
            <canvas id="chartPendapatan"></canvas>
          </div>
        </div>


      </div> <!-- Tutup .top-cards (grid 3 kartu statistik) -->

      <!-- Paling Laris (dinamis) -->
      <div class="section-title">Paling Laris</div> <!-- Judul section untuk produk paling laris -->
      <div class="product-cards"> <!-- Container flex untuk kartu-kartu produk paling laris -->
        <!-- Looping setiap produk best seller -->
        @forelse ($bestSellers as $p)
        @php
        $img = !empty($p->gambar)
        ? asset('storage/'.ltrim($p->gambar, '/'))
        : asset('images/bbq.jpg'); // fallback gambar default jika tidak ada di storage
        @endphp

        <div class="product-card"> <!-- Kartu satu produk paling laris -->
          <img src="{{ $img }}" alt="{{ $p->nama_produk }}"> <!-- Gambar produk (dari storage atau fallback) -->
          <h4>{{ $p->nama_produk }}</h4> <!-- Nama produk -->
          <div class="price">Rp{{ number_format($p->harga_tampil ?? 0, 0, ',', '.') }}</div> <!-- Harga tampil produk -->
          <small>Terjual {{ (int) $p->total_terjual }}</small> <!-- Jumlah produk terjual -->
        </div> <!-- Tutup .product-card -->
        <!-- Jika tidak ada data di bestSellers -->
        @empty
        <p class="text-muted section-empty">Belum ada data paling laris.</p>
        @endforelse
      </div> <!-- Tutup .product-cards -->

      <!-- middle: stock kosong -->
      <div class="section-title">Stok Kosong</div> <!-- Judul section untuk daftar produk stok kosong -->
      <div class="stock-box"> <!-- Box putih berisi daftar stok kosong -->
        <div class="stock-list"> <!-- List horizontal scrollable produk dengan stok kosong -->
          @forelse ($outOfStock as $p) <!-- Loop setiap produk yang stoknya kosong -->
          @php
          $img = !empty($p->gambar)
          ? asset('storage/'.ltrim($p->gambar, '/'))
          : asset('images/bbq.jpg'); // fallback jika tidak ada gambar produk
          @endphp

          <div class="stock-item"> <!-- Kartu item stok kosong -->
            <img src="{{ $img }}" alt="{{ $p->nama_produk }}"> <!-- Gambar produk di stok kosong -->
            <div class="meta"> <!-- Wrapper teks informasi produk -->
              <h5>{{ $p->nama_produk }}</h5> <!-- Nama produk -->
              <p>Stok: {{ (int)($p->stok ?? 0) }}</p> <!-- Informasi stok produk (biasanya 0) -->
            </div> <!-- Tutup .meta -->
          </div> <!-- Tutup .stock-item -->
          @empty <!-- Jika tidak ada produk yang stoknya habis -->
          <p class="text-muted section-empty">Tidak ada produk yang kehabisan stok.</p> <!-- Pesan jika tidak ada stok kosong -->
          @endforelse <!-- Akhir forelse stok kosong -->
        </div> <!-- Tutup .stock-list -->
      </div> <!-- Tutup .stock-box -->
    </div> <!-- Tutup .dashboard-content -->
    </div> <!-- Elemen penutup ekstra (pastikan struktur sesuai dengan layout utama) -->
  </main> <!-- Tutup main-content (wrapper konten utama) -->

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Helper: bikin sparkline modern (gradient, smooth, tooltip)
      function createSparkline(canvasId, labels, data, isCurrency) {
        var canvas = document.getElementById(canvasId);
        if (!canvas || !data || data.length === 0) {
          return;
        }

        var ctx = canvas.getContext('2d');

        // Gradient maroon -> transparan
        var gradient = ctx.createLinearGradient(0, 0, 0, canvas.height);
        gradient.addColorStop(0, 'rgba(117, 26, 37, 0.30)');
        gradient.addColorStop(1, 'rgba(117, 26, 37, 0)');

        new Chart(ctx, {
          type: 'line',
          data: {
            labels: labels,
            datasets: [{
              data: data,
              borderColor: '#751A25',
              backgroundColor: gradient,
              borderWidth: 2,
              tension: 0.4,
              fill: true,
              pointRadius: 0,
              pointHoverRadius: 3,
              pointHitRadius: 8
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: {
              padding: {
                top: 10,
                bottom: 2,
                left: 0,
                right: 0
              }
            },
            plugins: {
              legend: {
                display: false
              },
              tooltip: {
                enabled: true,
                displayColors: false,
                backgroundColor: '#111',
                titleColor: '#ffffff',
                bodyColor: '#ffffff',
                padding: 8,
                callbacks: {
                  label: function(context) {
                    var value = context.parsed.y;
                    if (isCurrency) {
                      return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                    }
                    return value + ' total';
                  }
                }
              }
            },
            interaction: {
              mode: 'index',
              intersect: false
            },
            scales: {
              x: {
                display: false,
                grid: {
                  display: false
                }
              },
              y: {
                display: false,
                grid: {
                  display: false
                }
              }
            }
          }
        });
      }

      // ==============================
      // 📅 DATA DARI BACKEND (REAL)
      // ==============================

      const monthLabels = @json($chartLabels ?? []);
      const pesananBulanan = @json($chartPesanan ?? []);
      const pelangganBulanan = @json($chartPelanggan ?? []);
      const pendapatanBulanan = @json($chartPendapatan ?? []);

      createSparkline('chartPesanan', monthLabels, pesananBulanan, false);
      createSparkline('chartPelanggan', monthLabels, pelangganBulanan, false);
      createSparkline('chartPendapatan', monthLabels, pendapatanBulanan, true);
    });
  </script>

</body> <!-- Tutup body halaman -->

</html> <!-- Tutup dokumen HTML -->