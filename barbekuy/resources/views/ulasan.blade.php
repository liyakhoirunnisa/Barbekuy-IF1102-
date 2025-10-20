<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ulasan & Rating</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-[#FFFFFF] min-h-screen text-[#751A25] font-sans">
    <!-- Header -->
    <header class="bg-[#751A25] text-white p-5 flex items-center justify-center relative sticky top-0 z-50 shadow-md">
        <a href="javascript:history.back()" class="absolute left-5 top-5 p-2 hover:bg-white/10 rounded-full">
            <i data-feather="chevron-left" class="w-6 h-6"></i>
        </a>

        <!-- ✅ Logo di header -->
        <div class="flex items-center gap-3">
            <h1 class="text-xl font-semibold">Ulasan & Rating</h1>
        </div>
    </header>

    <!-- Content -->
    <main class="px-4 py-6 space-y-5 max-w-3xl mx-auto">
        @foreach ($reviews as $r)
        <div class="bg-[#751A25] text-white rounded-xl p-4 shadow-md">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                    <i data-feather="user" class="w-5 h-5 text-white"></i>
                </div>
                <p class="font-medium">{{ $r->user_name }}</p>
            </div>

            <p class="mt-3 leading-relaxed">{{ $r->review_text }}</p>

            <!-- ✅ Logo paket tetap, ikon activity dihapus -->
             <div class="mt-3 flex items-center gap-2 text-sm text-[#FFFFFF]">
                <i class="bi bi-fire text-[#FFFFFF] text-lg"></i>
                <span>{{ $r->product_name }}</span>
            </div>

            <div class="flex justify-between items-center mt-4">
                <div class="flex gap-3 text-sm">
                    <button class="flex items-center gap-1 hover:opacity-80">
                        <i data-feather="heart" class="w-4 h-4"></i>
                    </button>
                    <button class="flex items-center gap-1 hover:opacity-80">
                        <i data-feather="message-circle" class="w-4 h-4"></i>
                    </button>
                </div>

                {{-- ⭐ Bintang warna kuning + angka rating --}}
                <div class="flex items-center gap-1">
                    @for ($i = 1; $i <= 5; $i++)
                        @php
                            $filled = $i <= floor($r->rating);
                            $half = ($r->rating - floor($r->rating)) >= 0.5 && $i == ceil($r->rating);
                        @endphp

                        @if ($filled)
                            <!-- Full Star -->
                            <i class="bi bi-star-fill text-[#F2C94C] text-base"></i>
                        @elseif ($half)
                            <!-- Half Star -->
                            <i class="bi bi-star-half text-[#F2C94C] text-base"></i>
                        @else
                            <!-- Empty Star -->
                            <i class="bi bi-star text-[#F2C94C] text-base"></i>
                        @endif
                    @endfor

                    <span class="text-[#F2C94C] text-sm font-medium ml-1">
                        {{ number_format($r->rating, 1, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>
        @endforeach
    </main>

    <script>feather.replace()</script>
</body>
</html>