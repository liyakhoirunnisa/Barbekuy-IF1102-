<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda | Barbekuy</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #f9f9f9;
        }

        /* === Hero Section === */
        .hero {
            background-color: #751A25;
            color: white;
            text-align: center;
            padding: 140px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero .content {
            max-width: 720px;
        }

        .hero h1 {
            font-weight: 600;
            font-size: 2.8rem;
        }

        .hero p {
            font-size: 1.2rem;
            margin-top: 10px;
        }

        /* === Tentang Kami === */
        #tentang {
            padding: 80px 0;
        }

        #tentang h2 {
            color: #000;
            font-weight: 600;
            margin-bottom: 25px;
        }

        #tentang p {
            color: #333;
            font-size: 1.05rem;
        }

        /* === Menu Favorit === */
        #menu-favorit {
            background-color: #fff8f8;
            padding: 80px 0;
        }

        #menu-favorit h2 {
            color: #000;
            font-weight: 600;
            margin-bottom: 40px;
        }

        .menu-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .menu-card:hover {
            transform: translateY(-6px);
        }

        .menu-card img {
            border-radius: 12px 12px 0 0;
            width: 100%;
            height: 260px;
            object-fit: cover;
            object-position: center top;
        }

        .menu-card .card-body {
            text-align: center;
            padding: 16px 18px 20px;
            flex: 1;
        }

        .menu-card .card-title {
            font-size: 1.05rem;
            margin-bottom: 6px;
        }

        .menu-card .card-text.harga {
            font-size: 1.2rem;
            font-weight: 600;
            color: #751A25;
        }

        /* === Testimoni === */
        #testimoni {
            padding: 80px 0;
        }

        #testimoni h2 {
            color: #000;
            font-weight: 600;
            margin-bottom: 40px;
        }

        .testimoni-card {
            background-color: #751A25;
            color: white;
            padding: 25px;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .testimoni-bottom {
            margin-top: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* === Footer === */
        footer {
            background-color: #751A25;
            color: white;
            padding: 30px 0;
            text-align: center;
        }

        footer a {
            word-break: break-word;
        }

        /* Tombol Lihat Lebih Banyak */
        .btn-lihat-lebih {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 28px;
            background-color: transparent;
            border: 2px solid #751A25;
            color: #751A25;
            font-weight: 600;
            border-radius: 50px;
            text-decoration: none;
            transition: 0.3s;
            box-shadow: 0 4px 10px rgba(117, 26, 37, 0.15);
        }

        .btn-lihat-lebih:hover {
            background-color: #751A25;
            color: white;
            transform: translateY(-3px);
        }

        /* ============================
           PADDING RESPONSIVE (bukan desktop)
           ============================ */
        @media (max-width: 992px) {
            .responsive-padding {
                padding-left: 18px !important;
                padding-right: 18px !important;
            }

            #tentang,
            #menu-favorit,
            #testimoni {
                padding: 60px 0;
            }

            .hero h1 {
                font-size: 2.3rem;
            }

            .hero p {
                font-size: 1.1rem;
            }
        }

        /* ============================
           RESPONSIVE MOBILE
           ============================ */
        @media (max-width: 768px) {

            .hero {
                padding: 90px 20px;
            }

            .hero h1 {
                font-size: 1.9rem;
            }

            .hero p {
                font-size: 1rem;
            }

            #tentang .row {
                flex-direction: column;
                text-align: center;
            }

            #tentang img {
                margin-top: 15px;
                max-height: 260px;
            }

            .menu-card img {
                height: 200px;
            }

            .testimoni-bottom {
                flex-direction: column;
                gap: 6px;
                align-items: flex-start;
            }

            footer .col-md-4 {
                margin-bottom: 25px;
                text-align: center;
            }
        }

        .floating-wa {
            position: fixed;
            bottom: 22px;
            right: 22px;
            background-color: #25D366;
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 32px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
            z-index: 999;
            transition: 0.3s;
            text-decoration: none;
        }

        .floating-wa:hover {
            background-color: #1ebe5d;
            transform: scale(1.08);
        }

        /* ============================
           RESPONSIVE PHONE < 480px
           ============================ */
        @media (max-width: 480px) {

            /* gambar tentang kami lebih kecil & center */
            .tentang-img-wrapper {
                display: flex;
                justify-content: center;
            }

            .tentang-img-wrapper img {
                width: 75% !important;
                max-width: 240px !important;
                height: auto !important;
                border-radius: 12px;
            }

            /* Teks makin kecil */
            .hero {
                padding: 70px 20px;
            }

            .hero h1 {
                font-size: 1.6rem;
            }

            .hero p {
                font-size: 0.9rem;
            }

            .menu-card img {
                height: 170px;
            }

            .testimoni-card {
                font-size: 0.9rem;
                padding: 18px;
            }

            /* Tombol kecil tapi tidak full width */
            .btn-lihat-lebih {
                padding: 10px 20px;
                font-size: 0.88rem;
                border-width: 1.8px;
                border-radius: 40px;
                width: auto;
                display: inline-flex;
            }

            .floating-wa {
                width: 52px;
                height: 52px;
                font-size: 28px;
                bottom: 18px;
                right: 18px;
            }
        }
    </style>
</head>

<body>

    {{-- Navbar --}}
    @include('layouts.navbar')

    {{-- Hero Section --}}
    <section class="hero">
        <div class="content">
            <h1>Selamat Datang di Barbekuy!</h1>
            <p>Waktunya BBQ-an praktis! Semua lengkap, tinggal grill aja.</p>
        </div>
    </section>

    {{-- Tentang Kami --}}
    <section id="tentang" class="container py-5 responsive-padding">
        <div class="row align-items-center">

            <!-- GAMBAR DULU -->
            <div class="col-md-6 text-center mb-4 tentang-img-wrapper">
                <img src="{{ asset('images/loginpage.png') }}"
                    alt="Tentang Barbekuy"
                    class="img-fluid rounded-4 shadow-lg"
                    style="width: 100%; max-width: 500px; max-height: 400px; object-fit: cover; object-position: 50% 30%;">
            </div>

            <!-- TEKS SESUDAHNYA -->
            <div class="col-md-6">
                <h2 class="mb-4" style="color: #000000; font-weight: 600;">Tentang Kami</h2>
                <p style="color: #333; font-size: 1.05rem; text-align: justify;">
                    Di <strong>Barbekuy</strong>, kami percaya bahwa momen terbaik tercipta di sekitar panggangan yang menyala,
                    aroma daging yang menggoda, dan tawa hangat bersama orang-orang terdekat.
                    Kami hadir untuk memudahkan kamu menikmati serunya acara BBQ tanpa harus pusing menyiapkan perlengkapannya.
                    Cukup sewa alat dan bahan grill dari kami — mulai dari panggangan, arang, bumbu, hingga daging segar siap bakar.
                    Semuanya praktis, higienis, dan siap pakai!
                    Dengan Barbekuy, kamu bisa fokus menikmati momen kebersamaan, sementara urusan perlengkapan kami yang tangani.
                </p>
            </div>

        </div>
    </section>

    {{-- Menu Favorit (dinamis) --}}
    <section id="menu-favorit" class="responsive-padding">
        <div class="container text-center">
            <h2>Menu Paling Laris</h2>
            <div class="row justify-content-center">
                @forelse ($bestSellers as $p)
                @php
                $img = !empty($p->gambar)
                ? asset('storage/' . ltrim($p->gambar, '/'))
                : asset('images/bbq.jpg');
                $harga = $p->harga ?? $p->harga_satuan ?? 0;
                @endphp

                <div class="col-md-4 mb-4">
                    <div class="card menu-card">
                        <img src="{{ $img }}" class="card-img-top" alt="{{ $p->nama_produk }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $p->nama_produk }}</h5>
                            <p class="card-text harga">Rp{{ number_format($harga, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-muted">Belum ada data best seller.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Testimoni --}}
    <section id="testimoni" class="container text-center py-5 responsive-padding">
        <h2 class="mb-5" style="color: #000000; font-weight: 600;">Apa Kata Mereka Tentang Kami</h2>

        <div class="row justify-content-center cards-equal">
            @forelse ($ulasanTerbaru as $u)
            <div class="col-md-4 mb-4">
                <div class="p-4 rounded-4 shadow-sm testimoni-card"
                    style="background-color: #751A25; color: white; text-align: left;">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset('images/default-user.png') }}" alt="Profil"
                            class="rounded-circle me-3" width="40" height="40" style="object-fit: cover;">
                        <div>
                            <h6 class="mb-0 fw-semibold">{{ $u->nama_user }}</h6>
                            <small>{{ $u->nama_produk }}</small>
                        </div>
                    </div>

                    <p style="font-style: italic; line-height: 1.6; text-align: justify;">
                        “{{ $u->komentar }}”
                    </p>

                    <div class="testimoni-bottom mt-3">
                        <div class="text-warning">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="bi {{ $i <= round($u->rating) ? 'bi-star-fill' : 'bi-star' }}"></i>
                                @endfor
                                <span class="text-white ms-2">{{ number_format($u->rating, 1, ',', '.') }}</span>
                        </div>
                        <span style="font-size: 0.85rem;">
                            {{ \Carbon\Carbon::parse($u->created_at)->diffForHumans() }}
                        </span>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-muted">Belum ada ulasan dari pelanggan.</p>
            @endforelse
        </div>

        <div class="text-center mt-2">
            <a href="{{ route('ulasan.index') }}" class="btn-lihat-lebih">
                Lihat Lebih Banyak
                <span class="arrow">→</span>
            </a>
        </div>
    </section>

    {{-- Footer --}}
    <footer id="kontak" class="responsive-padding" style="background-color: #751A25; color: white; padding: 50px 0 20px 0;">
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
                        <a href="https://maps.app.goo.gl/2JV4KyWNrhMcZGN6A?g_st=aw"
                            target="_blank"
                            class="text-white text-decoration-none">
                            Sumampir Kulon, Sumampir, Purwokerto Utara, Banyumas Regency, Central Java 53125
                        </a><br>
                        <a href="https://wa.me/6287746567500"
                            target="_blank"
                            class="text-white text-decoration-none d-flex align-items-center justify-content-center justify-content-md-start mt-1">
                            <i class="bi bi-whatsapp me-2"></i>
                            <span>+6287746567500</span>
                        </a>
                    </p>
                </div>
            </div>

            <hr style="border-top: 2px dotted #fff; margin: 30px 0;">

            <div class="d-flex justify-content-between align-items-center flex-column flex-md-row">
                <div class="mb-2 mb-md-0">
                    <a href="https://instagram.com/barbekuy.purwokerto" target="_blank"
                        class="text-white text-decoration-none d-flex align-items-center">
                        <i class="bi bi-instagram me-2" style="font-size: 1.2rem;"></i>
                        <span>@barbekuy.purwokerto</span>
                    </a>
                </div>

            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp -->
    <a href="https://wa.me/6287746567500?text=Haii%20Kak!%20Saya%20mau%20tanya.."
        target="_blank"
        class="floating-wa">
        <i class="bi bi-whatsapp"></i>
    </a>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>