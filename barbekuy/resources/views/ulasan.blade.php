<!DOCTYPE html> <!-- Deklarasi tipe dokumen HTML -->
<html lang="id"> <!-- Set bahasa halaman menjadi Indonesia -->

<head> <!-- Bagian kepala halaman, memuat konfigurasi -->
    <meta charset="UTF-8"> <!-- Mengatur karakter agar mendukung UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Supaya layout responsif di HP -->
    <title>Ulasan & Rating</title> <!-- Judul tab browser -->

    <script src="https://cdn.tailwindcss.com"></script> <!-- Import Tailwind CSS -->
    <script src="https://unpkg.com/feather-icons"></script> <!-- Import Feather Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet"> <!-- Import font Poppins -->
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script> <!-- Import Iconify -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> <!-- Import Bootstrap Icons -->
</head>

<style>
    :root {
        /* Variabel CSS global */
        --hdr: 56px;
        /* Tinggi header ditentukan jadi 56px */
    }

    body {
        /* Styling seluruh halaman */
        font-family: 'Poppins', sans-serif;
        /* Menggunakan font Poppins */
    }

    /* ========================
       MIRROR BOOTSTRAP .container
       ======================== */
    .bb-container {
        /* Class kontainer seperti Bootstrap */
        width: 100%;
        /* Lebar penuh */
        margin: 0 auto;
        /* Tengah */
        padding: 0 16px;
        /* Spasi kiri-kanan */
    }

    @media (min-width:576px) {

        /* Lebar layar kecil */
        .bb-container {
            max-width: 540px;
            /* Lebar maksimal saat lebar layar >= 576px */
        }
    }

    @media (min-width:768px) {

        /* Tablet */
        .bb-container {
            max-width: 720px;
            /* Lebar maksimal saat >= 768px */
        }
    }

    @media (min-width:992px) {

        /* Laptop kecil */
        .bb-container {
            max-width: 960px;
            /* Lebar maksimal saat >= 992px */
        }
    }

    @media (min-width:1200px) {

        /* Laptop besar */
        .bb-container {
            max-width: 1140px;
            /* Lebar maksimal saat >= 1200px */
        }
    }

    @media (min-width:1400px) {

        /* Monitor besar */
        .bb-container {
            max-width: 1320px;
            /* Lebar maksimal saat >= 1400px */
        }
    }

    /* ========================
       HEADER (SERAGAM DGN HALAMAN LAIN)
       ======================== */
    .bb-header {
        position: sticky;
        /* Header tetap di atas saat halaman discroll */
        top: 0;
        /* Nempel di bagian atas */
        z-index: 1000;
        /* Dipastikan di atas elemen lain */
        background: #7B0D1E;
        /* Warna merah gelap */
        color: #fff;
        /* Teks putih */
        box-shadow: 0 2px 6px rgba(0, 0, 0, .15);
        /* Bayangan lembut */
    }

    .bb-header__inner {
        height: var(--hdr);
        /* Tinggi sesuai variabel hdr */
        display: flex;
        /* Flexbox layout */
        align-items: center;
        /* Konten vertikal tengah */
        justify-content: center;
        /* Konten horizontal tengah */
        position: relative;
        /* Untuk posisi tombol back */
    }

    .bb-header__title {
        margin: 0;
        /* Hilangkan margin default */
        font-weight: 600;
        /* Teks tebal */
        font-size: 1.5rem;
        /* Ukuran font judul */
    }

    .bb-header__back {
        position: absolute;
        /* Posisi bebas di dalam header */
        left: 16px;
        /* Geser ke kiri 16px */
        width: 36px;
        /* Lebar tombol */
        height: 36px;
        /* Tinggi tombol */
        border-radius: 9999px;
        /* Biar bulat */
        border: 0;
        /* Hilangkan border */
        cursor: pointer;
        /* Tunjukkan tombol bisa diklik */
        background: rgba(255, 255, 255, .15);
        /* Warna background transparan */
        color: #fff;
        /* Ikon putih */
        display: flex;
        /* Biar konten tengah */
        align-items: center;
        justify-content: center;
    }

    /* ============================
       RESPONSIVE ULASAN & RATING
       ============================ */

    /* HP kecil (max 576px) */
    /* Style khusus layar kecil */
    @media (max-width: 576px) {
        /* Berlaku jika lebar layar <= 576px */

        /* Container utama */
        main {
            /* Elemen utama halaman */
            padding-left: 1rem !important;
            /* Tambah padding kiri biar tidak mepet */
            padding-right: 1rem !important;
            /* Tambah padding kanan biar tidak mepet */
        }

        /* Kartu ulasan */
        article {
            /* Kotak berisi satu ulasan */
            padding: 1rem !important;
            /* Biar tetap ada ruang dalam */
        }

        /* Header ulasan: user + waktu + rating */
        article header {
            /* Baris header dalam ulasan */
            flex-direction: column;
            /* Susun ke bawah (vertikal) */
            align-items: flex-start;
            /* Teks rata kiri */
            gap: 10px;
            /* Jarak antar elemen 10px */
        }

        /* Info user */
        article header>div:first-child {
            /* Bagian pertama (biasanya nama & waktu) */
            width: 100%;
            /* Lebar penuh */
        }

        /* Rating bintang */
        article header .flex.items-center.gap-1 {
            /* Elemen rating bintang */
            width: 100%;
            /* Lebar penuh */
            justify-content: flex-start;
            /* Rata kiri */
        }

        /* Komentar */
        article p {
            /* Teks komentar ulasan */
            font-size: 0.9rem;
            /* Ukuran lebih kecil agar pas layar kecil */
            line-height: 1.4;
            /* Spasi antar baris lebih nyaman dibaca */
        }

        /* Nama produk */
        article .flex.items-center.gap-2 {
            /* Container item (misal nama produk & ikon) */
            flex-wrap: wrap;
            /* Kalau tidak muat, turun ke bawah */
            font-size: 0.85rem;
            /* Ukuran teks lebih kecil */
        }
    }

    /* Tablet (max-width: 768px) */
    /* Style khusus layar tablet */
    @media (max-width: 768px) {
        /* Jika layar <= 768px */

        main {
            /* Container utama */
            padding-left: 1.25rem;
            /* Sedikit lebih lebar dibanding HP */
            padding-right: 1.25rem;
        }

        article {
            /* Kartu ulasan */
            padding: 1.2rem;
            /* Tambah ruang */
        }

        article p {
            /* Teks komentar */
            font-size: 0.95rem;
            /* Sedikit lebih besar dari HP */
        }
    }

    /* Dekstop kecil (max 1024px) */
    /* Style untuk laptop kecil */
    @media (max-width: 1024px) {
        /* Jika layar <= 1024px */

        main {
            /* Container utama */
            max-width: 800px;
            /* Batasi lebar agar tidak terlalu melebar */
            padding-left: 1.5rem;
            /* Tambah jarak kiri */
            padding-right: 1.5rem;
            /* Tambah jarak kanan */
        }
    }
</style>

<body class="bg-white min-h-screen text-[#751A25] font-sans"> <!-- Latar putih, tinggi minimal layar, teks merah tua, font sans-serif -->
    <!-- Header -->
    <header class="bb-header"> <!-- Header halaman tetap di atas -->
        <div class="bb-container bb-header__inner"> <!-- Container header -->
            <button class="bb-header__back" onclick="history.back()" aria-label="Kembali"> <!-- Tombol kembali -->
                <span class="iconify" data-icon="mdi:chevron-left" style="font-size:1.25rem;"></span> <!-- Ikon panah kiri -->
            </button>
            <h1 class="bb-header__title">Ulasan & Rating</h1> <!-- Judul halaman -->
        </div>
    </header>

    <main class="bb-container px-4 py-6 space-y-5"> <!-- Container utama, padding, jarak antar elemen -->
        {{-- Flash success/error --}} <!-- Komentar blade: pesan sukses/error -->
        @if (session('success')) <!-- Cek jika ada pesan sukses -->
        <div class="rounded-lg border border-emerald-200 bg-emerald-50 text-emerald-700 px-4 py-3"> <!-- Box hijau untuk pesan sukses -->
            {{ session('success') }} <!-- Tampilkan pesan sukses -->
        </div>
        @endif
        @if ($errors->any()) <!-- Cek jika ada error -->
        <div class="rounded-lg border border-rose-200 bg-rose-50 text-rose-700 px-4 py-3"> <!-- Box merah untuk pesan error -->
            {{ $errors->first() }} <!-- Tampilkan error pertama -->
        </div>
        @endif

        @forelse ($reviews as $r) {{-- Mulai looping semua ulasan --}}

        <article class="bg-[#751A25] text-white rounded-xl p-4 shadow-md">
            {{-- Kartu ulasan satuan --}}

            <header class="flex items-center justify-between gap-3">
                {{-- Bagian header: user + waktu + rating --}}

                <div class="flex items-center gap-3">
                    {{-- Bagian info user kiri --}}

                    @if(!empty($r->avatar_path))
                    <img
                        src="{{ asset('storage/' . ltrim($r->avatar_path, '/')) }}"
                        alt="Profil"
                        class="w-10 h-10 rounded-full object-cover" />
                    @else
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                        {{-- Icon avatar user --}}
                        <i data-feather="user" class="w-5 h-5 text-white"></i>
                    </div>
                    @endif

                    <div>
                        {{-- Nama user --}}
                        <p class="font-medium leading-tight">{{ $r->user_name }}</p>

                        {{-- Tanggal ulasan (hanya tampil jika ada) --}}
                        @if (!empty($r->created_at))
                        <p class="text-xs text-white/80">
                            {{ \Carbon\Carbon::parse($r->created_at)->translatedFormat('d M Y, H:i') }}
                        </p>
                        @endif
                    </div>
                </div>

                {{-- ⭐ Bagian rating bintang --}}
                <div class="flex items-center gap-1">

                    @php
                    // Membulatkan rating ke bilangan bulat
                    $rounded = (int) round($r->rating);
                    @endphp

                    @for ($i = 1; $i <= 5; $i++)
                        {{-- Tampilkan bintang penuh jika $i <= rating --}}
                        <i class="bi {{ $i <= $rounded ? 'bi-star-fill' : 'bi-star' }} text-[#F2C94C] text-base"></i>
                        @endfor

                        {{-- Angka rating --}}
                        <span class="text-[#F2C94C] text-sm font-medium ml-1">
                            {{ number_format((float) $r->rating, 1, ',', '.') }}
                        </span>
                </div>

            </header>

            {{-- Komentar ulasan --}}
            <p class="mt-3 leading-relaxed">{{ $r->komentar }}</p>

            {{-- Nama produk yang diulas --}}
            <div class="mt-3 flex items-center gap-2 text-sm text-white">
                <i class="bi bi-fire text-white text-lg"></i> {{-- Ikon grill --}}
                <span class="font-medium">{{ $r->product_name }}</span>
            </div>

        </article>

        @empty {{-- Jika tidak ada ulasan sama sekali --}}

        <div class="rounded-xl border border-dashed border-[#6C757D] p-6 text-center">
            {{-- Box tampilan kosong --}}
            <p class="text-[#6C757D]">Belum ada ulasan</p>
        </div>

        @endforelse {{-- Selesai looping --}}

        {{-- Pagination (kalau $reviews adalah paginator) --}} <!-- Komentar blade: pagination -->
        @if(method_exists($reviews, 'links')) <!-- Cek kalau ada fungsi links() -->
        <div class="pt-2">
            {{ $reviews->links() }} <!-- Tampilkan pagination -->
        </div>
        @endif
    </main>

    <!-- Ganti semua ikon feather -->
    <script>
        feather.replace()
    </script>
</body>

</html>
