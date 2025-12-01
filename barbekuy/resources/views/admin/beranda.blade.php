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
      /* Latar belakang kartu statistik putih */
      border-radius: 12px;
      /* Sudut kartu melengkung 12px */
      padding: 20px;
      /* Ruang dalam isi kartu */
      box-shadow: 0 6px 18px rgba(16, 24, 32, 0.04);
      /* Bayangan halus di bawah kartu */
      min-height: 130px;
      /* Tinggi minimum kartu agar tampilan rapi */
      display: flex;
      /* Flexbox untuk mengatur isi kartu */
      flex-direction: column;
      /* Susun isi kartu secara vertikal */
      justify-content: space-between
        /* Bagi ruang vertikal antara bagian atas & chart */
    }

    .stat-card .meta {
      display: flex;
      /* Flexbox untuk judul dan ikon di baris yang sama */
      align-items: center;
      /* Rata vertikal tengah */
      justify-content: space-between
        /* Jarak maksimal antara teks dan ikon */
    }

    .stat-card .meta i {
      font-size: 20px;
      /* Ukuran ikon di kartu statistik */
      color: #751A25;
      /* Warna ikon maroon sesuai brand */
    }

    .stat-card h3 {
      font-size: 14px;
      /* Ukuran teks label kecil (Pesanan, Pelanggan, dst) */
      color: #333;
      /* Warna teks abu tua */
      margin: 0;
      /* Hilangkan margin default heading */
      font-weight: 600
        /* Tebal sedang untuk label */
    }

    .stat-card .value {
      font-size: 22px;
      /* Ukuran angka utama statistik */
      font-weight: 700;
      /* Tebal untuk menonjolkan angka */
      color: #751A25;
      /* Warna maroon untuk angka */
      margin-top: 8px
        /* Jarak atas dari label ke angka */
    }

    .stat-chart {
      width: 100%;
      /* Chart lebar penuh dalam kartu */
      height: 78px;
      /* Tinggi area chart mini */
      margin-top: 6px
        /* Jarak atas dari angka ke chart */
    }

    .stat-chart svg {
      width: 100%;
      /* SVG chart isi penuh container */
      height: 100%
        /* Tinggi SVG mengikuti tinggi stat-chart */
    }

    .stat-chart path {
      stroke: #751A25;
      /* Warna garis chart maroon */
      stroke-width: 3;
      /* Ketebalan garis chart */
      fill: none;
      /* Tidak ada isi area di bawah garis */
      stroke-linecap: round;
      /* Ujung garis dibuat membulat */
      stroke-linejoin: round
        /* Sudut pertemuan garis dibuat halus */
    }

    .stat-chart circle {
      fill: #fff;
      /* Isi titik chart putih */
      stroke: #751A25;
      /* Garis luar titik maroon */
      stroke-width: 2
        /* Ketebalan garis luar titik */
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
      gap: 34px;
      /* Jarak antar kartu produk */
      margin-bottom: 34px
        /* Jarak bawah dari deretan produk ke section berikutnya */
    }

    .product-card {
      width: 300px;
      /* Lebar tetap kartu produk */
      background: #fff;
      /* Latar belakang kartu putih */
      border-radius: 12px;
      /* Sudut kartu melengkung */
      box-shadow: 0 6px 18px rgba(16, 24, 32, 0.04);
      /* Bayangan halus kartu */
      padding: 22px;
      /* Ruang dalam kartu */
      text-align: center;
      /* Seluruh teks di tengah */
      display: flex;
      /* Flexbox untuk isi kartu */
      flex-direction: column;
      /* Susun isi kartu secara vertikal */
      align-items: center;
      /* Rata tengah horizontal */
      gap: 12px
        /* Jarak vertikal antar elemen di dalam kartu */
    }

    .product-card img {
      width: 180px;
      /* Lebar gambar produk */
      height: 180px;
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
      margin: 0
        /* Hilangkan margin bawaan heading */
    }

    .product-card .price {
      font-size: 20px;
      /* Ukuran teks harga */
      color: #751A25;
      /* Warna harga maroon */
      font-weight: 800;
      /* Lebih tebal agar harga menonjol */
      margin-top: 8px
        /* Jarak atas dari nama produk ke harga */
    }

    .product-card small {
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

        <div class="stat-card"> <!-- Kartu statistik pertama: Pesanan -->
          <div class="meta"> <!-- Baris atas kartu: label + ikon -->
            <h3>Pesanan</h3> <!-- Label kartu: total pesanan -->
            <i class="bi bi-cart-fill"></i> <!-- Ikon keranjang Bootstrap Icons -->
          </div> <!-- Tutup .meta -->
          <div class="value">{{ number_format($pesananTotal ?? 0, 0, ',', '.') }}</div> <!-- Angka total pesanan (format ribuan) -->
          <div class="stat-chart"> <!-- Area mini-chart dekoratif -->
            <svg viewBox="0 0 200 60"> <!-- SVG untuk garis tren pesanan -->
              <path d="M0 45 C30 38, 60 35, 90 38 C120 41, 150 35, 200 28" /> <!-- Garis lengkung tren -->
              <circle cx="10" cy="44" r="2.2" /> <!-- Titik-titik data di sepanjang garis -->
              <circle cx="50" cy="39" r="2.2" />
              <circle cx="90" cy="38" r="2.2" />
              <circle cx="130" cy="40" r="2.2" />
              <circle cx="170" cy="35" r="2.2" />
            </svg>
          </div> <!-- Tutup .stat-chart -->
        </div> <!-- Tutup stat-card Pesanan -->

        <div class="stat-card"> <!-- Kartu statistik kedua: Pelanggan -->
          <div class="meta"> <!-- Baris atas kartu: label + ikon -->
            <h3>Pelanggan</h3> <!-- Label kartu: total pelanggan -->
            <i class="bi bi-people-fill"></i> <!-- Ikon orang (grup) -->
          </div> <!-- Tutup .meta -->
          <div class="value">{{ number_format($pelangganTotal ?? 0, 0, ',', '.') }}</div> <!-- Angka total pelanggan -->
          <div class="stat-chart"> <!-- Area mini-chart dekoratif -->
            <svg viewBox="0 0 200 60"> <!-- SVG untuk garis tren pelanggan -->
              <path d="M0 42 C30 36, 60 34, 90 36 C120 38, 150 33, 200 30" /> <!-- Garis tren -->
              <circle cx="15" cy="41" r="2.2" /> <!-- Titik-titik data -->
              <circle cx="60" cy="34" r="2.2" />
              <circle cx="110" cy="36" r="2.2" />
              <circle cx="160" cy="34" r="2.2" />
            </svg>
          </div> <!-- Tutup .stat-chart -->
        </div> <!-- Tutup stat-card Pelanggan -->

        <div class="stat-card"> <!-- Kartu statistik ketiga: Pendapatan -->
          <div class="meta"> <!-- Baris atas kartu: label + ikon -->
            <h3>Pendapatan</h3> <!-- Label kartu: total pendapatan -->
            <i class="bi bi-cash-stack"></i> <!-- Ikon tumpukan uang -->
          </div> <!-- Tutup .meta -->
          <div class="value">Rp {{ number_format($pendapatanTotal ?? 0, 0, ',', '.') }}</div> <!-- Total pendapatan dalam format Rupiah -->
          <div class="stat-chart"> <!-- Area mini-chart dekoratif -->
            <svg viewBox="0 0 200 60"> <!-- SVG garis tren pendapatan -->
              <path d="M0 44 C40 38, 80 36, 120 38 C150 40, 180 39, 200 36" /> <!-- Garis tren -->
              <circle cx="20" cy="43" r="2.2" /> <!-- Titik-titik data -->
              <circle cx="70" cy="36" r="2.2" />
              <circle cx="120" cy="38" r="2.2" />
              <circle cx="170" cy="37" r="2.2" />
            </svg>
          </div> <!-- Tutup .stat-chart -->
        </div> <!-- Tutup stat-card Pendapatan -->

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
</body> <!-- Tutup body halaman -->

</html> <!-- Tutup dokumen HTML -->