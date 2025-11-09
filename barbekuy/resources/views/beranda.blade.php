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
        }

        /* === Hero Section === */
        .hero {
            background-color: #751A25;
            /* 🔥 ganti dari gambar ke warna solid */
            color: white;
            text-align: center;
            padding: 140px 20px;
            position: relative;
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
            color: #000000;
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
            color: #000000;
            font-weight: 600;
            margin-bottom: 40px;
        }

        .menu-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
        }

        .menu-card:hover {
            transform: translateY(-6px);
        }

        .menu-card img {
            border-radius: 12px 12px 0 0;
            weight: 260px height: 260px;
            /* 🔥 lebih tinggi dari sebelumnya */
            object-fit: cover;
            object-position: center top;
            /* fokus ke bagian atas gambar */
            transition: transform 0.3s ease;
        }

        .menu-card .card-text.harga {
            font-size: 1.2rem;
            /* 🔥 lebih besar dari default */
            font-weight: 600;
            /* biar terlihat tegas */
            color: #751A25;
            /* merah tua sesuai tema Barbekuy */
            margin-top: 8px;
        }


        .menu-card .card-body {
            text-align: center;
        }

        /* === Testimoni === */
        #testimoni {
            padding: 80px 0;
        }

        #testimoni h2 {
            color: #000000;
            font-weight: 600;
            margin-bottom: 40px;
        }

        .testimoni-box {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .testimoni-box p {
            font-style: italic;
            color: #555;
        }

        .testimoni-box h6 {
            color: #751A25;
            margin-top: 15px;
        }

        /* === Footer === */
        footer {
            background-color: #751A25;
            color: white;
            padding: 30px 0;
            text-align: center;
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
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(117, 26, 37, 0.15);
        }

        .btn-lihat-lebih:hover {
            background-color: #751A25;
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 6px 14px rgba(117, 26, 37, 0.3);
        }

        .btn-lihat-lebih:active {
            transform: translateY(0);
            box-shadow: 0 2px 6px rgba(117, 26, 37, 0.3);
        }

        .btn-lihat-lebih .arrow {
            transition: transform 0.3s ease;
        }

        .btn-lihat-lebih:hover .arrow {
            transform: translateX(6px);
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
    <section id="tentang" class="container py-5">
        <div class="row align-items-center">
            {{-- Kolom kiri: teks --}}
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

            <!-- Kolom kanan: gambar -->
            <div class="col-md-6 text-center">
                <img src="{{ asset('images/loginpage.png') }}"
                    alt="Tentang Barbekuy"
                    class="img-fluid rounded-4 shadow-lg"
                    style="width: 100%; max-width: 500px; max-height: 400px; object-fit: cover; object-position: 50% 30%;">
            </div>
        </div>
    </section>


    {{-- Menu Favorit --}}
    <section id="menu-favorit">
        <div class="container text-center">
            <h2>Menu Paling Laris</h2>
            <div class="row justify-content-center">
                <div class="col-md-4 mb-4">
                    <div class="card menu-card">
                        <img src="{{ asset('images/ber4extra.png') }}" class="card-img-top" alt="Paket Slice Ber-4 Extra">
                        <div class="card-body">
                            <h5 class="card-title">Paket Slice Ber-4 Extra</h5>
                            <p class="card-text harga">Rp245.000</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card menu-card">
                        <img src="{{ asset('images/ber6extra.png') }}" class="card-img-top" alt="Paket Slice Ber-4 Extra">
                        <div class="card-body">
                            <h5 class="card-title">Paket Slice Ber-6 Extra</h5>
                            <p class="card-text harga">Rp345.000</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card menu-card">
                        <img src="{{ asset('images/ber10extra.png') }}" class="card-img-top" alt="Paket Slice Ber-4 Extra">
                        <div class="card-body">
                            <h5 class="card-title">Paket Slice Ber-10 Extra</h5>
                            <p class="card-text harga">Rp525.000</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{-- Testimoni --}}
    <section id="testimoni" class="container text-center py-5">
        <h2 class="mb-5" style="color: #000000; font-weight: 600;">Apa Kata Mereka Tentang Kami</h2>

        <div class="row justify-content-center">
            {{-- Testimoni 1 --}}
            <div class="col-md-4 mb-4">
                <div class="p-4 rounded-4 shadow-sm" style="background-color: #751A25; color: white; text-align: left;">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset('images/profile1.jpg') }}" alt="Profil"
                            class="rounded-circle me-3" width="40" height="40" style="object-fit: cover;">
                        <div>
                            <h6 class="mb-0 fw-semibold">Theresa Jordan</h6>
                        </div>
                    </div>

                    <p style="font-style: italic; line-height: 1.6; text-align: justify;">
                        “Pas banget buat BBQ kecil-kecilan bareng temen! Dagingnya fresh, bumbunya lengkap, dan porsinya pas banget. Nggak nyangka sepraktis ini, tinggal panggang aja!”
                    </p>

                    <div class="mt-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <span><i class="bi bi-fire me-1"></i> Paket Slice Ber-4 Xtra</span>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mt-3">
                            <div>
                                <i class="bi bi-heart me-2"></i>
                                <i class="bi bi-chat-left-text"></i>
                            </div>
                            <div class="text-warning">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                                <span class="text-white ms-2">4,8</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Testimoni 2 --}}
            <div class="col-md-4 mb-4">
                <div class="p-4 rounded-4 shadow-sm" style="background-color: #751A25; color: white; text-align: left;">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset('images/profile2.jpg') }}" alt="Profil"
                            class="rounded-circle me-3" width="40" height="40" style="object-fit: cover;">
                        <div>
                            <h6 class="mb-0 fw-semibold">Theresa Jordan</h6>
                        </div>
                    </div>

                    <p style="font-style: italic; line-height: 1.6; text-align: justify;">
                        “Paket 6xtra ini favorit banget! Dagingnya banyak, potongannya tebal, bumbunya lengkap dan semua alatnya bersih serta siap pakai. Bikin acara keluarga jadi makin seru!”
                    </p>

                    <div class="mt-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <span><i class="bi bi-fire me-1"></i> Paket Slice Ber-6 Xtra</span>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mt-3">
                            <div>
                                <i class="bi bi-heart me-2"></i>
                                <i class="bi bi-chat-left-text"></i>
                            </div>
                            <div class="text-warning">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star"></i>
                                <span class="text-white ms-2">4,7</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Testimoni 3 --}}
            <div class="col-md-4 mb-4">
                <div class="p-4 rounded-4 shadow-sm" style="background-color: #751A25; color: white; text-align: left;">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset('images/profile3.jpg') }}" alt="Profil"
                            class="rounded-circle me-3" width="40" height="40" style="object-fit: cover;">
                        <div>
                            <h6 class="mb-0 fw-semibold">Theresa Jordan</h6>
                        </div>
                    </div>

                    <p style="font-style: italic; line-height: 1.6; ">
                        “Perfect buat pesta BBQ rame-rame! Pilihan dagingnya lengkap, bumbunya komplit ada bonus saus juga. Servisnya cepat dan ramah, recommended banget buat acara besar!”
                    </p>

                    <div class="mt-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <span><i class="bi bi-fire me-1"></i> Paket Slice Ber-10 Xtra</span>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mt-3">
                            <div>
                                <i class="bi bi-heart me-2"></i>
                                <i class="bi bi-chat-left-text"></i>
                            </div>
                            <div class="text-warning">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                                <span class="text-white ms-2">4,8</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-2">
            <a href="{{ route('ulasan.index') }}" class="btn-lihat-lebih">
                Lihat Lebih Banyak
                <span class="arrow">→</span>
            </a>
        </div>

    </section>


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
                        <a href="https://maps.app.goo.gl/2JV4KyWNrhMcZGN6A?g_st=aw"
                            target="_blank"
                            class="text-white text-decoration-none">
                            Sumampir Kulon, Sumampir, Purwokerto Utara, Banyumas Regency, Central Java 53125
                        </a><br>
                        <!-- Link ke WhatsApp -->
                        <a href="https://wa.me/6287746567500"
                            target="_blank"
                            class="text-white text-decoration-none d-flex align-items-center mt-1">
                            <i class="bi bi-whatsapp me-2"></i>
                            <span>+6287746567500</span>
                        </a>
                    </p>
                </div>
            </div>

            <!-- Garis Putus-Putus -->
            <hr style="border-top: 2px dotted #fff; margin: 30px 0;">

            <!-- Bawah Footer -->
            <div class="d-flex justify-content-between align-items-center flex-column flex-md-row">
                <!-- Instagram -->
                <div class="mb-2 mb-md-0">
                    <a href="https://instagram.com/barbekuy.purwokerto" target="_blank"
                        class="text-white text-decoration-none d-flex align-items-center">
                        <i class="bi bi-instagram me-2" style="font-size: 1.2rem;"></i>
                        <span>@barbekuy.purwokerto</span>
                    </a>
                </div>

                <!-- Chat Kami -->
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