<!DOCTYPE html> <!-- Menandakan dokumen ini HTML5 -->
<html lang="id"> <!-- Tag pembuka HTML, lang="id" artinya bahasa Indonesia -->

<head> <!-- Bagian kepala halaman, berisi info, link CSS, dsb -->
    <meta charset="UTF-8"> <!-- Menentukan encoding karakter, UTF-8 mendukung banyak karakter -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Agar halaman responsive di mobile -->
    <title>Beranda | Barbekuy</title> <!-- Judul halaman yang tampil di tab browser -->

    {{-- Bootstrap CSS --}} <!-- Komentar Blade/Laravel, untuk catatan bahwa ini Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> <!-- Menghubungkan file CSS Bootstrap dari CDN -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet"> <!-- Menghubungkan font Poppins dari Google Fonts -->

    <style>
        * {
            /* Selector universal, berlaku untuk semua elemen */
            font-family: 'Poppins', sans-serif;
            /* Mengatur font default semua elemen ke Poppins */
            box-sizing: border-box;
            /* Memastikan padding & border dihitung dalam ukuran elemen */
        }

        html,
        body {
            /* Mengatur tag html dan body */
            margin: 0;
            /* Menghapus margin default browser */
            padding: 0;
            /* Menghapus padding default browser */
        }

        body {
            /* Styling untuk body */
            background-color: #f9f9f9;
            /* Memberikan warna latar belakang abu-abu terang */
        }

        /* === Hero Section === */
        .hero {
            /* Bagian hero/banner utama */
            background-color: #751A25;
            /* Warna latar belakang hero merah tua */
            color: white;
            /* Warna teks putih */
            text-align: center;
            /* Teks di tengah */
            padding: 140px 20px;
            /* Jarak atas-bawah 140px, kiri-kanan 20px */
            display: flex;
            /* Mengaktifkan flexbox */
            align-items: center;
            /* Vertikal center isi hero */
            justify-content: center;
            /* Horizontal center isi hero */
        }

        .hero .content {
            /* Konten di dalam hero */
            max-width: 720px;
            /* Maksimal lebar 720px */
        }

        .hero h1 {
            /* Judul di hero */
            font-weight: 600;
            /* Tebal teks sedang */
            font-size: 2.8rem;
            /* Ukuran font besar */
        }

        .hero p {
            /* Paragraf di hero */
            font-size: 1.2rem;
            /* Ukuran font sedang */
            margin-top: 10px;
            /* Jarak atas paragraf 10px */
        }

        /* === Tentang Kami === */
        #tentang {
            /* Bagian tentang kami */
            padding: 80px 0;
            /* Jarak atas-bawah 80px, kiri-kanan 0 */
        }

        #tentang h2 {
            /* Judul di bagian tentang kami */
            color: #000;
            /* Warna teks hitam */
            font-weight: 600;
            /* Tebal teks sedang */
            margin-bottom: 25px;
            /* Jarak bawah 25px */
        }

        #tentang p {
            /* Paragraf di bagian tentang kami */
            color: #333;
            /* Warna teks abu gelap */
            font-size: 1.05rem;
            /* Ukuran font sedikit lebih besar dari default */
        }


        /* === Menu Favorit === */
        #menu-favorit {
            /* Bagian menu favorit */
            background-color: #fff8f8;
            /* Latar belakang merah muda pucat */
            padding: 80px 0;
            /* Jarak atas-bawah 80px */
        }

        #menu-favorit h2 {
            /* Judul menu favorit */
            color: #000;
            /* Teks hitam */
            font-weight: 600;
            /* Teks agak tebal */
            margin-bottom: 40px;
            /* Jarak bawah judul */
        }

        .menu-card {
            /* Kotak menu untuk tiap item favorit */
            border: none;
            /* Hilangkan garis tepi */
            border-radius: 12px;
            /* Sudut membulat */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            /* Bayangan tipis agar kotak terlihat menonjol */
            transition: 0.3s;
            /* Animasi transisi saat hover */
            height: 100%;
            /* Tinggi kotak penuh */
            display: flex;
            /* Flexbox untuk isi kotak */
            flex-direction: column;
            /* Susunan konten vertikal */
        }

        .menu-card:hover {
            /* Saat mouse di atas kotak menu */
            transform: translateY(-6px);
            /* Kotak naik sedikit */
        }

        .menu-card img {
            /* Gambar di kotak menu */
            border-radius: 12px 12px 0 0;
            /* Sudut atas membulat */
            width: 100%;
            /* Lebar penuh kotak */
            height: 260px;
            /* Tinggi gambar */
            object-fit: cover;
            /* Gambar menyesuaikan ukuran tanpa merusak rasio */
            object-position: center top;
            /* Fokus gambar di tengah atas */
        }

        .menu-card .card-body {
            /* Konten teks di kotak menu */
            text-align: center;
            /* Teks di tengah */
            padding: 16px 18px 20px;
            /* Jarak dalam kotak: atas 16px, kiri-kanan 18px, bawah 20px */
            flex: 1;
            /* Memenuhi ruang tersisa di kotak */
        }

        .menu-card .card-title {
            /* Judul menu di kotak menu */
            font-size: 1.05rem;
            /* Ukuran font sedang */
            margin-bottom: 6px;
            /* Jarak bawah judul */
        }

        .menu-card .card-text.harga {
            /* Harga menu di kotak menu */
            font-size: 1.2rem;
            /* Sedikit lebih besar dari teks biasa */
            font-weight: 600;
            /* Teks agak tebal */
            color: #751A25;
            /* Warna merah tua */
        }


        /* === Testimoni === */
        #testimoni {
            /* Bagian testimoni pelanggan */
            padding: 80px 0;
            /* Jarak atas-bawah 80px */
        }

        #testimoni h2 {
            /* Judul di bagian testimoni */
            color: #000;
            /* Teks hitam */
            font-weight: 600;
            /* Teks agak tebal */
            margin-bottom: 40px;
            /* Jarak bawah judul */
        }

        .testimoni-card {
            /* Kotak testimoni */
            background-color: #751A25;
            /* Latar belakang merah tua */
            color: white;
            /* Teks putih */
            padding: 25px;
            /* Jarak dalam kotak */
            border-radius: 12px;
            /* Sudut kotak membulat */
            display: flex;
            /* Flexbox untuk isi kotak */
            flex-direction: column;
            /* Susunan konten vertikal */
            height: 100%;
            /* Tinggi kotak penuh */
        }

        .testimoni-bottom {
            /* Bagian bawah kotak testimoni (nama & rating) */
            margin-top: auto;
            /* Dorong ke bawah kotak */
            display: flex;
            /* Flexbox untuk susunan horizontal */
            justify-content: space-between;
            /* Jarak antar elemen merata */
            align-items: center;
            /* Rata tengah vertikal */
        }

        /* === Footer === */
        footer {
            /* Bagian bawah halaman */
            background-color: #751A25;
            /* Latar belakang merah tua */
            color: white;
            /* Teks putih */
            padding: 30px 0;
            /* Jarak atas-bawah 30px */
            text-align: center;
            /* Teks di tengah */
        }

        footer a {
            /* Link di footer */
            word-break: break-word;
            /* Memecah kata panjang agar tidak keluar kotak */
        }


        /* Tombol Lihat Lebih Banyak */
        .btn-lihat-lebih {
            /* Styling tombol “Lihat Lebih Banyak” */
            display: inline-flex;
            /* Membuat tombol fleksibel dan sejajar dengan ikon/isi */
            align-items: center;
            /* Rata tengah vertikal isi tombol */
            gap: 8px;
            /* Jarak antar isi tombol (misal teks & ikon) */
            padding: 12px 28px;
            /* Jarak dalam tombol: atas-bawah 12px, kiri-kanan 28px */
            background-color: transparent;
            /* Latar tombol transparan */
            border: 2px solid #751A25;
            /* Garis tepi merah tua */
            color: #751A25;
            /* Warna teks merah tua */
            font-weight: 600;
            /* Teks agak tebal */
            border-radius: 50px;
            /* Sudut tombol bulat (capsule) */
            text-decoration: none;
            /* Hilangkan garis bawah teks */
            transition: 0.3s;
            /* Animasi halus saat hover */
            box-shadow: 0 4px 10px rgba(117, 26, 37, 0.15);
            /* Bayangan halus di bawah tombol */
        }

        .btn-lihat-lebih:hover {
            /* Saat mouse di atas tombol */
            background-color: #751A25;
            /* Latar merah tua */
            color: white;
            /* Teks putih */
            transform: translateY(-3px);
            /* Tombol sedikit naik */
        }


        /* ============================
           PADDING RESPONSIVE (bukan desktop)
           ============================ */
        @media (max-width: 992px) {

            /* Aturan ini berlaku untuk layar tablet & smartphone */
            .responsive-padding {
                /* Kelas untuk padding responsif */
                padding-left: 18px !important;
                /* Jarak kiri 18px, paksa override jika ada style lain */
                padding-right: 18px !important;
                /* Jarak kanan 18px, paksa override */
            }

            #tentang,
            #menu-favorit,
            #testimoni {
                /* Bagian utama halaman */
                padding: 60px 0;
                /* Kurangi jarak atas-bawah agar pas di layar kecil */
            }

            .hero h1 {
                /* Judul hero di layar kecil */
                font-size: 2.3rem;
                /* Ukuran font lebih kecil agar muat di layar */
            }

            .hero p {
                /* Paragraf hero di layar kecil */
                font-size: 1.1rem;
                /* Ukuran font sedikit lebih kecil */
            }
        }

        /* ============================
           RESPONSIVE MOBILE
           ============================ */
        @media (max-width: 768px) {

            /* Aturan berlaku untuk layar smartphone */
            .hero {
                /* Bagian hero */
                padding: 90px 20px;
                /* Kurangi jarak atas-bawah agar pas di layar kecil */
            }

            .hero h1 {
                /* Judul hero */
                font-size: 1.9rem;
                /* Font lebih kecil agar muat di layar kecil */
            }

            .hero p {
                /* Paragraf hero */
                font-size: 1rem;
                /* Font lebih kecil */
            }

            #tentang .row {
                /* Baris di bagian tentang */
                flex-direction: column;
                /* Susunan kolom jadi vertikal */
                text-align: center;
                /* Teks rata tengah */
            }

            #tentang img {
                /* Gambar di bagian tentang */
                margin-top: 15px;
                /* Jarak atas gambar */
                max-height: 260px;
                /* Tinggi maksimal gambar */
            }

            .menu-card img {
                /* Gambar di kotak menu */
                height: 200px;
                /* Kurangi tinggi gambar agar pas layar kecil */
            }

            .testimoni-bottom {
                /* Bagian bawah kotak testimoni */
                flex-direction: column;
                /* Susunan elemen vertikal */
                gap: 6px;
                /* Jarak antar elemen */
                align-items: flex-start;
                /* Rata kiri */
            }

            footer .col-md-4 {
                /* Kolom di footer */
                margin-bottom: 25px;
                /* Jarak bawah antar kolom */
                text-align: center;
                /* Teks rata tengah */
            }
        }

        /* Tombol WhatsApp mengambang */
        .floating-wa {
            /* Tombol WA di pojok kanan bawah */
            position: fixed;
            /* Tetap di layar meski scroll */
            bottom: 22px;
            /* Jarak dari bawah layar */
            right: 22px;
            /* Jarak dari kanan layar */
            background-color: #25D366;
            /* Warna hijau khas WA */
            color: white;
            /* Teks/ikon putih */
            width: 60px;
            /* Lebar tombol */
            height: 60px;
            /* Tinggi tombol */
            border-radius: 50%;
            /* Bentuk bulat */
            display: flex;
            /* Flexbox untuk pusatkan isi */
            justify-content: center;
            /* Pusat horizontal */
            align-items: center;
            /* Pusat vertikal */
            font-size: 32px;
            /* Ukuran ikon/teks besar */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
            /* Bayangan halus */
            z-index: 999;
            /* Pastikan di atas elemen lain */
            transition: 0.3s;
            /* Animasi halus saat hover */
            text-decoration: none;
            /* Hilangkan garis bawah link */
        }

        .floating-wa:hover {
            /* Saat mouse di atas tombol WA */
            background-color: #1ebe5d;
            /* Hijau sedikit lebih gelap */
            transform: scale(1.1);
            /* Tombol membesar sedikit */
        }

        /* ============================
           RESPONSIVE PHONE < 480px
           ============================ */
        @media (max-width: 480px) {
            /* Aturan berlaku untuk smartphone kecil */

            /* Gambar Tentang Kami lebih kecil & rata tengah */
            .tentang-img-wrapper {
                /* Kotak pembungkus gambar */
                display: flex;
                /* Flexbox agar mudah diatur */
                justify-content: center;
                /* Rata tengah horizontal */
            }

            .tentang-img-wrapper img {
                /* Gambar di bagian tentang */
                width: 75% !important;
                /* Lebar 75% dari kotak pembungkus */
                max-width: 240px !important;
                /* Lebar maksimal 240px */
                height: auto !important;
                /* Tinggi menyesuaikan proporsi */
                border-radius: 12px;
                /* Sudut membulat */
            }

            /* Teks di hero lebih kecil */
            .hero {
                /* Bagian hero */
                padding: 70px 20px;
                /* Kurangi jarak atas-bawah agar pas layar kecil */
            }

            .hero h1 {
                /* Judul hero */
                font-size: 1.6rem;
                /* Font lebih kecil */
            }

            .hero p {
                /* Paragraf hero */
                font-size: 0.9rem;
                /* Font lebih kecil */
            }

            .menu-card img {
                /* Gambar di kotak menu */
                height: 170px;
                /* Kurangi tinggi gambar agar pas layar kecil */
            }

            .testimoni-card {
                /* Kotak testimoni */
                font-size: 0.9rem;
                /* Font lebih kecil */
                padding: 18px;
                /* Kurangi padding */
            }

            /* Tombol “Lihat Lebih Banyak” lebih kecil tapi tidak full width */
            .btn-lihat-lebih {
                padding: 10px 20px;
                /* Kurangi jarak dalam tombol */
                font-size: 0.88rem;
                /* Font lebih kecil */
                border-width: 1.8px;
                /* Lebar garis tepi sedikit lebih tipis */
                border-radius: 40px;
                /* Bulatan tombol tetap terlihat */
                width: auto;
                /* Tidak full width */
                display: inline-flex;
                /* Tetap fleksibel untuk teks & ikon */
            }

            /* Tombol WhatsApp mengambang lebih kecil */
            .floating-wa {
                /* Tombol WA */
                width: 52px;
                /* Lebar dikurangi */
                height: 52px;
                /* Tinggi dikurangi */
                font-size: 28px;
                /* Ukuran ikon lebih kecil */
                bottom: 18px;
                /* Jarak dari bawah layar dikurangi */
                right: 18px;
                /* Jarak dari kanan layar dikurangi */
            }
        }
    </style>
</head>

<body>

    {{-- Navbar --}}
    @include('layouts.navbar') <!-- Memanggil file navbar dari layout -->

    {{-- Hero Section --}}
    <section class="hero"> <!-- Bagian hero/banner depan halaman -->
        <div class="content"> <!-- Konten di hero -->
            <h1>Selamat Datang di Barbekuy!</h1> <!-- Judul hero -->
            <p>Waktunya BBQ-an praktis! Semua lengkap, tinggal grill aja.</p> <!-- Paragraf hero -->
        </div>
    </section>

    {{-- Tentang Kami --}}
    <section id="tentang" class="container py-5 responsive-padding"> <!-- Bagian tentang kami -->
        <div class="row align-items-center"> <!-- Baris flex untuk gambar & teks -->
            <!-- GAMBAR DULU -->
            <div class="col-md-6 text-center mb-4 tentang-img-wrapper"> <!-- Kolom gambar -->
                <!-- Deskripsi gambar untuk aksesibilitas -->
                <!-- Bootstrap responsive, sudut bulat, bayangan -->
                <!-- Ukuran dan posisi gambar -->
                <img src="{{ asset('images/loginpage.png') }}"
                    alt="Tentang Barbekuy"
                    class="img-fluid rounded-4 shadow-lg"
                    style="width: 100%; max-width: 500px; max-height: 400px; object-fit: cover; object-position: 50% 30%;">
            </div>


            <!-- TEKS SESUDAHNYA -->
            <div class="col-md-6"> <!-- Kolom teks -->
                <h2 class="mb-4" style="color: #000000; font-weight: 600;">Tentang Kami</h2> <!-- Judul kolom -->
                <p style="color: #333; font-size: 1.05rem; text-align: justify;"> <!-- Paragraf teks -->
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
    <section id="menu-favorit" class="responsive-padding"> <!-- Bagian menu favorit -->
        <div class="container text-center"> <!-- Container Bootstrap, teks rata tengah -->
            <h2>Menu Paling Laris</h2> <!-- Judul section -->
            <div class="row justify-content-center"> <!-- Baris flex untuk kotak menu -->
                @forelse ($bestSellers as $p) <!-- Loop data best seller, kalau kosong tampilkan pesan -->
                @php
                // Cek gambar produk: kalau ada ambil dari storage, kalau tidak pakai default
                $img = !empty($p->gambar)
                ? asset('storage/' . ltrim($p->gambar, '/'))
                : asset('images/bbq.jpg');
                // Ambil harga: cek properti harga atau harga_satuan, default 0
                $harga = $p->harga ?? $p->harga_satuan ?? 0;
                @endphp

                <div class="col-md-4 mb-4"> <!-- Kolom untuk tiap kotak menu -->
                    <div class="card menu-card"> <!-- Kotak menu -->
                        <img src="{{ $img }}" class="card-img-top" alt="{{ $p->nama_produk }}"> <!-- Gambar produk -->
                        <div class="card-body"> <!-- Konten kotak menu -->
                            <h5 class="card-title">{{ $p->nama_produk }}</h5> <!-- Nama produk -->
                            <p class="card-text harga">Rp{{ number_format($harga, 0, ',', '.') }}</p> <!-- Harga produk -->
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-muted">Belum ada data best seller.</p> <!-- Pesan jika data kosong -->
                @endforelse
            </div>
        </div>
    </section>


    {{-- Testimoni --}}
    <section id="testimoni" class="container text-center py-5 responsive-padding"> <!-- Bagian testimoni -->
        <h2 class="mb-5" style="color: #000000; font-weight: 600;">Apa Kata Mereka Tentang Kami</h2> <!-- Judul section -->

        <div class="row justify-content-center cards-equal"> <!-- Baris untuk kotak testimoni -->
            @forelse ($ulasanTerbaru as $u) <!-- Loop data ulasan, kalau kosong tampilkan pesan -->

            <div class="col-md-4 mb-4"> <!-- Kolom untuk tiap kotak testimoni -->
                <div class="p-4 rounded-4 shadow-sm testimoni-card"
                    style="background-color: #751A25; color: white; text-align: left;"> <!-- Kotak testimoni -->

                    <!-- Profil user -->
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset('images/default-user.png') }}" alt="Profil"
                            class="rounded-circle me-3" width="40" height="40" style="object-fit: cover;"> <!-- Foto user -->
                        <div>
                            <h6 class="mb-0 fw-semibold">{{ $u->nama_user }}</h6> <!-- Nama user -->
                            <small>{{ $u->nama_produk }}</small> <!-- Produk yang diulas -->
                        </div>
                    </div>

                    <!-- Komentar/ulasan -->
                    <p style="font-style: italic; line-height: 1.6; text-align: justify;">
                        “{{ $u->komentar }}”
                    </p>

                    <!-- Rating & waktu -->
                    <div class="testimoni-bottom mt-3">
                        <div class="text-warning">
                            @for ($i = 1; $i <= 5; $i++) <!-- Loop untuk bintang rating -->
                                <i class="bi {{ $i <= round($u->rating) ? 'bi-star-fill' : 'bi-star' }}"></i>
                                @endfor
                                <span class="text-white ms-2">{{ number_format($u->rating, 1, ',', '.') }}</span> <!-- Nilai rating -->
                        </div>
                        <span style="font-size: 0.85rem;">
                            {{ \Carbon\Carbon::parse($u->created_at)->diffForHumans() }} <!-- Waktu dibuat ulasan -->
                        </span>
                    </div>
                </div>
            </div>

            @empty
            <p class="text-muted">Belum ada ulasan dari pelanggan.</p> <!-- Pesan jika tidak ada data -->
            @endforelse
        </div>

        <!-- Tombol lihat lebih banyak -->
        <div class="text-center mt-2">
            <a href="{{ route('ulasan.index') }}" class="btn-lihat-lebih">
                Lihat Lebih Banyak
                <span class="arrow">→</span>
            </a>
        </div>
    </section>

    {{-- Footer --}}
    <footer id="kontak" class="responsive-padding" style="background-color: #751A25; color: white; padding: 50px 0 20px 0;"> <!-- Bagian footer, warna merah marun dan teks putih -->
        <div class="container"> <!-- Container Bootstrap -->

            <div class="row align-items-start mb-4"> <!-- Baris untuk 3 kolom: logo, jam buka, kontak -->

                <!-- Logo -->
                <div class="col-md-4 text-center text-md-start mb-4 mb-md-0"> <!-- Kolom logo, rata tengah di mobile, rata kiri di desktop -->
                    <img src="{{ asset('images/logoputih.png') }}" alt="Barbekuy Logo" style="width: 160px;"> <!-- Logo -->
                    <p class="mt-2 small mb-0">HOME SERVICE<br>TASTY • EASY • AFFORDABLE</p> <!-- Tagline -->
                </div>

                <!-- Jam Buka -->
                <div class="col-md-4 text-md-start mb-4 mb-md-0"> <!-- Kolom jam buka -->
                    <h6 class="fw-bold mb-2">Jam Buka Kami</h6> <!-- Judul kecil -->
                    <p class="mb-0">Setiap Hari : 08.00 - 22.00 WIB</p> <!-- Isi jam buka -->
                </div>

                <!-- Kontak Kami -->
                <div class="col-md-4 text-md-start"> <!-- Kolom kontak -->
                    <h6 class="fw-bold mb-2">Kontak Kami</h6> <!-- Judul kecil -->
                    <p class="mb-0">
                        <!-- Alamat dengan link Google Maps -->
                        <a href="https://maps.app.goo.gl/2JV4KyWNrhMcZGN6A?g_st=aw"
                            target="_blank"
                            class="text-white text-decoration-none">
                            Sumampir Kulon, Sumampir, Purwokerto Utara, Banyumas Regency, Central Java 53125
                        </a><br>
                        <!-- Nomor WhatsApp dengan ikon -->
                        <a href="https://wa.me/6287746567500"
                            target="_blank"
                            class="text-white text-decoration-none d-flex align-items-center justify-content-center justify-content-md-start mt-1">
                            <i class="bi bi-whatsapp me-2"></i> <!-- Ikon WA -->
                            <span>+6287746567500</span> <!-- Nomor WA -->
                        </a>
                    </p>
                </div>

            </div>

            <hr style="border-top: 2px dotted #fff; margin: 30px 0;"> <!-- Garis putus-putus untuk pemisah -->

            <div class="d-flex justify-content-between align-items-center flex-column flex-md-row"> <!-- Baris bawah footer -->
                <div class="mb-2 mb-md-0"> <!-- Kolom Instagram -->
                    <a href="https://instagram.com/barbekuy.purwokerto" target="_blank"
                        class="text-white text-decoration-none d-flex align-items-center">
                        <i class="bi bi-instagram me-2" style="font-size: 1.2rem;"></i> <!-- Ikon Instagram -->
                        <span>@barbekuy.purwokerto</span> <!-- Handle Instagram -->
                    </a>
                </div>

            </div>
        </div>
    </footer>


    <!-- Floating WhatsApp -->
    <a href="https://wa.me/6287746567500?text=Haii%20Kak!%20Saya%20mau%20tanya.."
        target="_blank"
        class="floating-wa"> <!-- Class CSS untuk tombol mengambang -->
        <i class="bi bi-whatsapp"></i> <!-- Ikon WhatsApp -->
    </a>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> <!-- Script Bootstrap, sudah include Popper -->

</body> <!-- Tutup body -->

</html> <!-- Tutup HTML -->