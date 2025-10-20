{{-- resources/views/menu.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu | Barbekuy</title>

  {{-- Bootstrap CSS --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #fff;
      color: #000;
    }

    h2 {
      color: #000000;
      font-weight: 800;
      font-size: 2rem;
      text-align: center;
      margin: 50px 0 60px 0;
    }

    .judul-menu {
      display: inline-block;
      font-weight: 600;
      letter-spacing: 0.3px;
      margin: 0px 0 30px 0;
    }

    article {
      border: 1px solid #eee;
      border-radius: 16px;
      box-shadow: 0 3px 8px rgba(0,0,0,0.05);
      transition: transform 0.2s ease;
      padding: 20px;
      background-color: #fff;
    }

    article:hover {
      transform: translateY(-4px);
    }

    article img {
      width: 110px;
      height: 110px;
      object-fit: contain;
      border-radius: 10px;
      background: #fafafa;
    }

    .badge-price {
      position: absolute;
      top: 6px;
      right: 6px;
      background-color: #751A25;
      color: white;
      font-size: 11px;
      padding: 2px 8px;
      border-radius: 10px;
    }

    /* Ikon keranjang */
    .ikon-keranjang {
      color: #751A25;
      text-decoration: none;
      transition: 0.3s;
    }

    .ikon-keranjang:hover {
      color: #9c2833;
    }

    /* Tombol utama Beli Sekarang (versi lebih kecil) */
    /* Tombol utama Beli Sekarang (ukuran sedang, pas proporsinya) */
    .btn-beli {
    background-color: #751A25 !important;
    color: #ffffff !important;
    border-radius: 6px;
    padding: 6px 14px; /* ukuran sedang */
    font-weight: 600;
    font-size: 0.9rem; /* sedikit lebih besar dari sebelumnya */
    border: none !important;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 2px 6px rgba(117, 26, 37, 0.25);
    display: inline-block;
    line-height: 1.2;
    }

    .btn-beli:hover {
    background-color: #9c2833 !important;
    color: #ffffff !important;
    transform: translateY(-1px);
    box-shadow: 0 3px 8px rgba(117, 26, 37, 0.35);
    }



    /* Footer */
    footer {
      background-color: #751A25;
      color: white;
      padding: 30px 0;
      text-align: center;
    }

    footer a {
      color: white;
      text-decoration: none;
    }

    footer a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  {{-- Navbar --}}
  @include('layouts.navbar')

  <div class="container mt-5 mb-5">
    <h2><span class="judul-menu">Pilih Paket Barbekuy<br>Sesuaikan dengan Selera Kamu</span></h2>

    @php
      $items = [
        ['name'=>'Paket Slice Ber-2','price'=>125000,'img'=>'ber2.png','badge'=>'125K',
        'desc'=>'1 set alat BBQ (include gas), 250g slice fat/lowfat, saus cocol, saus marinasi, 2 bratwurst, selada, bawang bombay, margarin, free alat makan.'],
        ['name'=>'Paket Slice Ber-2 Xtra','price'=>155000,'img'=>'ber2extra.png','badge'=>'155K',
        'desc'=>'1 set alat BBQ (include gas), 500g slice fat/lowfat, saus cocol, saus marinasi, 2 bratwurst, selada, bawang bombay, margarin, free alat makan.'],
        ['name'=>'Paket Slice Ber-4','price'=>215000,'img'=>'ber4.png','badge'=>'215K',
        'desc'=>'1 set alat BBQ (include gas), 750g slice fat/lowfat, saus cocol, saus marinasi, 2 bratwurst, selada, bawang bombay, margarin, free alat makan.'],
        ['name'=>'Paket Slice Ber-4 Xtra','price'=>245000,'img'=>'ber4extra.png','badge'=>'245K',
        'desc'=>'1 set alat BBQ (include gas), 1000g slice fat/lowfat, saus cocol, saus marinasi, 2 bratwurst, selada, bawang bombay, margarin, free alat makan.'],
        ['name'=>'Paket Slice Ber-6','price'=>315000,'img'=>'ber6.png','badge'=>'315K',
        'desc'=>'1 set alat BBQ (include gas), 1250g slice fat/lowfat, saus cocol, saus marinasi, 2 bratwurst, selada, bawang bombay, margarin, free alat makan.'],
        ['name'=>'Paket Slice Ber-6 Xtra','price'=>345000,'img'=>'ber6extra.png','badge'=>'345K',
        'desc'=>'1 set alat BBQ (include gas), 1500g slice fat/lowfat, saus cocol, saus marinasi, 2 bratwurst, selada, bawang bombay, margarin, free alat makan.'],
        ['name'=>'Paket Slice Ber-8','price'=>415000,'img'=>'ber8.png','badge'=>'415K',
        'desc'=>'1 set alat BBQ (include gas), 1750g slice fat/lowfat, saus cocol, saus marinasi, 2 bratwurst, selada, bawang bombay, margarin, free alat makan.'],
        ['name'=>'Paket Slice Ber-8 Xtra','price'=>445000,'img'=>'ber8extra.png','badge'=>'445K',
        'desc'=>'1 set alat BBQ (include gas), 2000g slice fat/lowfat, saus cocol, saus marinasi, 2 bratwurst, selada, bawang bombay, margarin, free alat makan.'],
        ['name'=>'Paket Slice Ber-10','price'=>485000,'img'=>'ber10.png','badge'=>'485K',
        'desc'=>'1 set alat BBQ (include gas), 2250g slice fat/lowfat, saus cocol, saus marinasi, 2 bratwurst, selada, bawang bombay, margarin, free alat makan.'],
        ['name'=>'Paket Slice Ber-10 Xtra','price'=>525000,'img'=>'ber10extra.png','badge'=>'525K',
        'desc'=>'1 set alat BBQ (include gas), 2500g slice fat/lowfat, saus cocol, saus marinasi, 2 bratwurst, selada, bawang bombay, margarin, free alat makan.'],
      ];
    @endphp

    <div class="row gy-4">
      @foreach ($items as $it)
        <div class="col-md-6">
          <article class="d-flex align-items-center justify-content-between">
            <div class="flex-grow-1 me-3">
              <h5 class="fw-semibold mb-1">{{ $it['name'] }}</h5>
              <p class="fw-bold mb-1" style="color: #751A25;">Rp{{ number_format($it['price'], 0, ',', '.') }}</p>
              <small class="text-muted d-block mb-2">{{ $it['desc'] }}</small>
              <div class="d-flex align-items-center gap-2 mt-2">
                  <!-- Ikon Troli -->
                  <a href="{{ url('/keranjang') }}" class="ikon-keranjang">
                      <i class="bi bi-cart3 fs-5"></i>
                  </a>


                  <!-- Tombol utama: Beli Sekarang -->
                  <a href="{{ url('/pemesanan') }}" class="btn-beli">
                      Beli
                  </a>
              </div>
            </div>

            <div class="position-relative">
              <img src="{{ asset('images/'.$it['img']) }}" alt="{{ $it['name'] }}">
              <span class="badge-price">{{ $it['badge'] }}</span>
            </div>
          </article>
        </div>
      @endforeach
    </div>
  </div>

  {{-- Footer --}}
  <footer id="kontak" style="background-color: #751A25; color: white; padding: 50px 0 20px 0;">
    <div class="container">
      <div class="row align-items-start mb-4">
        <!-- Logo -->
        <div class="col-md-4 text-center text-md-start mb-4 mb-md-0">
          <img src="{{ asset('images/logoputih.png') }}" alt="Barbekuy Logo" style="width: 160px;">
          <p class="mt-2 small mb-0">HOME SERVICE<br>TASTY • EASY • AFFORDABLE</p>
        </div>

        <!-- Jam Buka -->
        <div class="col-md-4 text-md-start mb-4 mb-md-0">
          <h6 class="fw-bold mb-2">Jam Buka Kami</h6>
          <p class="mb-0">Setiap Hari : 08.00 - 22.00 WIB</p>
        </div>

        <!-- Kontak Kami -->
        <div class="col-md-4 text-md-start">
          <h6 class="fw-bold mb-2">Kontak Kami</h6>
          <p class="mb-0">
            <a href="https://maps.app.goo.gl/2JV4KyWNrhMcZGN6A?g_st=aw" target="_blank" class="text-white text-decoration-none">
              Sumampir Kulon, Sumampir, Purwokerto Utara, Banyumas Regency, Central Java 53125
            </a><br>
            <a href="https://wa.me/6281215310817" target="_blank" class="text-white text-decoration-none d-flex align-items-center mt-1">
              <i class="bi bi-whatsapp me-2"></i>
              <span>+6281215310817</span>
            </a>
          </p>
        </div>
      </div>

      <hr style="border-top: 2px dotted #fff; margin: 30px 0;">

      <div class="d-flex justify-content-between align-items-center flex-column flex-md-row">
        <div class="mb-2 mb-md-0">
          <a href="https://instagram.com/barbekuy.purwokerto" target="_blank" class="text-white text-decoration-none d-flex align-items-center">
            <i class="bi bi-instagram me-2" style="font-size: 1.2rem;"></i>
            <span>@barbekuy.purwokerto</span>
          </a>
        </div>

        <div>
          <a href="{{ url('/chat') }}" class="text-white text-decoration-none d-flex align-items-center justify-content-center">
            <span class="me-2">Chat kami</span>
            <i class="bi bi-chat-dots"></i>
          </a>
        </div>
      </div>
    </div>
  </footer>

  {{-- Bootstrap JS --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
