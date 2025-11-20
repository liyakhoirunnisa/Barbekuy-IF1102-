<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ulasan & Rating</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<style>
    :root {
        --hdr: 56px;
    }

    body {
        font-family: 'Poppins', sans-serif;
    }

    /* mirror .container Bootstrap */
    .bb-container {
        width: 100%;
        margin: 0 auto;
        padding: 0 16px;
    }

    @media (min-width:576px) {
        .bb-container {
            max-width: 540px
        }
    }

    @media (min-width:768px) {
        .bb-container {
            max-width: 720px
        }
    }

    @media (min-width:992px) {
        .bb-container {
            max-width: 960px
        }
    }

    @media (min-width:1200px) {
        .bb-container {
            max-width: 1140px
        }
    }

    @media (min-width:1400px) {
        .bb-container {
            max-width: 1320px
        }
    }

    /* === HEADER (match pemesanan/riwayat) === */
    .bb-header {
        position: sticky;
        top: 0;
        z-index: 1000;
        background: #7B0D1E;
        color: #fff;
        box-shadow: 0 2px 6px rgba(0, 0, 0, .15);
    }

    .bb-header__inner {
        height: var(--hdr);
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .bb-header__title {
        margin: 0;
        font-weight: 600;
        font-size: 1.5rem;
    }

    .bb-header__back {
        position: absolute;
        left: 16px;
        width: 36px;
        height: 36px;
        border-radius: 9999px;
        border: 0;
        cursor: pointer;
        background: rgba(255, 255, 255, .15);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* ============================
   RESPONSIVE ULASAN & RATING
   ============================ */

    /* HP kecil (max 576px) */
    @media (max-width: 576px) {

        /* Container utama */
        main {
            padding-left: 1rem !important;
            padding-right: 1rem !important;
        }

        /* Kartu ulasan */
        article {
            padding: 1rem !important;
        }

        /* Header ulasan: user + waktu + rating */
        article header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        /* Info user */
        article header>div:first-child {
            width: 100%;
        }

        /* Rating bintang */
        article header .flex.items-center.gap-1 {
            width: 100%;
            justify-content: flex-start;
        }

        /* Komentar */
        article p {
            font-size: 0.9rem;
            line-height: 1.4;
        }

        /* Nama produk */
        article .flex.items-center.gap-2 {
            flex-wrap: wrap;
            font-size: 0.85rem;
        }
    }

    /* Tablet (max-width: 768px) */
    @media (max-width: 768px) {

        main {
            padding-left: 1.25rem;
            padding-right: 1.25rem;
        }

        article {
            padding: 1.2rem;
        }

        article p {
            font-size: 0.95rem;
        }
    }

    /* Dekstop kecil (max 1024px) */
    @media (max-width: 1024px) {

        main {
            max-width: 800px;
            padding-left: 1.5rem;
            padding-right: 1.5rem;
        }
    }
</style>

<body class="bg-white min-h-screen text-[#751A25] font-sans">
    <!-- Header -->
    <header class="bb-header">
        <div class="bb-container bb-header__inner">
            <button class="bb-header__back" onclick="history.back()" aria-label="Kembali">
                <span class="iconify" data-icon="mdi:chevron-left" style="font-size:1.25rem;"></span>
            </button>
            <h1 class="bb-header__title">Ulasan & Rating</h1>
        </div>
    </header>

    <main class="bb-container px-4 py-6 space-y-5">
        {{-- Flash success/error --}}
        @if (session('success'))
        <div class="rounded-lg border border-emerald-200 bg-emerald-50 text-emerald-700 px-4 py-3">
            {{ session('success') }}
        </div>
        @endif
        @if ($errors->any())
        <div class="rounded-lg border border-rose-200 bg-rose-50 text-rose-700 px-4 py-3">
            {{ $errors->first() }}
        </div>
        @endif

        @forelse ($reviews as $r)
        <article class="bg-[#751A25] text-white rounded-xl p-4 shadow-md">
            <header class="flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                        <i data-feather="user" class="w-5 h-5 text-white"></i>
                    </div>
                    <div>
                        <p class="font-medium leading-tight">{{ $r->user_name }}</p>
                        @if(!empty($r->created_at))
                        <p class="text-xs text-white/80">
                            {{ \Carbon\Carbon::parse($r->created_at)->translatedFormat('d M Y, H:i') }}
                        </p>
                        @endif
                    </div>
                </div>

                {{-- ⭐ rating bintang + angka --}}
                <div class="flex items-center gap-1">
                    @php
                    $rounded = (int) round($r->rating);
                    @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="bi {{ $i <= $rounded ? 'bi-star-fill' : 'bi-star' }} text-[#F2C94C] text-base"></i>
                        @endfor
                        <span class="text-[#F2C94C] text-sm font-medium ml-1">
                            {{ number_format((float) $r->rating, 1, ',', '.') }}
                        </span>
                </div>
            </header>

            <p class="mt-3 leading-relaxed">{{ $r->komentar }}</p>

            <div class="mt-3 flex items-center gap-2 text-sm text-white">
                <i class="bi bi-fire text-white text-lg"></i>
                <span class="font-medium">{{ $r->product_name }}</span>
            </div>
        </article>
        @empty
        <div class="rounded-xl border border-dashed border-[#751A25]/30 p-6 text-center">
            <p class="text-[#751A25]/80">Belum ada ulasan yang masuk.</p>
            <p class="text-sm text-[#751A25]/60 mt-1">Selesaikan pesananmu lalu beri penilaian dari halaman Riwayat.</p>
        </div>
        @endforelse

        {{-- Pagination (kalau $reviews adalah paginator) --}}
        @if(method_exists($reviews, 'links'))
        <div class="pt-2">
            {{ $reviews->links() }}
        </div>
        @endif
    </main>

    <script>
        feather.replace()
    </script>
</body>

</html>