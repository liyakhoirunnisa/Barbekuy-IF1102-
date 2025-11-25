<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Riwayat Pemesanan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- untuk ikon bintang -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>

    <style>
        :root {
            --hdr: 56px;
            /* tinggi header */
            --tabs: 48px;
            /* kira-kira tinggi bar tab */
        }

        html,
        body {
            margin: 0;
            padding: 0;
            max-width: 100%;
            overflow-x: hidden;
            font-family: 'Poppins', sans-serif;
            background: #f9f9f9;
        }

        .muted {
            color: #888;
            font-size: 12px;
        }

        /* ===== Layout Container (mirip Bootstrap .container) ===== */
        .bb-container {
            width: 100%;
            margin: 0 auto;
            padding: 0 24px;
        }

        @media (min-width: 576px) {
            .bb-container {
                max-width: 540px;
            }
        }

        @media (min-width: 768px) {
            .bb-container {
                max-width: 720px;
            }
        }

        @media (min-width: 992px) {
            .bb-container {
                max-width: 960px;
            }
        }

        @media (min-width: 1200px) {
            .bb-container {
                max-width: 1140px;
            }
        }

        @media (min-width: 1400px) {
            .bb-container {
                max-width: 1320px;
            }
        }

        /* padding khusus HP & tablet */
        @media (max-width: 992px) {
            .bb-container {
                padding-left: 18px;
                padding-right: 18px;
            }
        }

        /* container utama konten riwayat */
        .container {
            max-width: 1140px;
            margin: 24px auto 40px;
            padding: 0 16px;
        }

        /* ===== Header ===== */
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

        /* ===== Tabs Status ===== */
        .tabs-bar {
            position: sticky;
            top: var(--hdr);
            z-index: 999;
            background: #fff;
            border-bottom: 1px solid #ddd;
        }

        .tabs {
            display: flex;
            justify-content: space-around;
            padding: 12px 0;
        }

        .tabs button {
            background: none;
            border: none;
            font-weight: 500;
            cursor: pointer;
            color: #000;
            padding-bottom: 6px;
        }

        .tabs button.active {
            color: #7B0D1E;
            border-bottom: 2px solid #7B0D1E;
        }

        /* ===== Kartu Riwayat ===== */
        .order-card {
            background: #fff;
            margin: 1rem 0;
            padding: 1rem 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, .08);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
            color: #777;
            gap: 8px;
            flex-wrap: wrap;
        }

        .order-header-left {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .order-header-left .iconify {
            color: #7B0D1E;
            font-size: 18px;
        }

        .status {
            font-weight: 600;
            color: #7B0D1E;
        }

        .product {
            display: flex;
            align-items: center;
            margin-top: 1rem;
        }

        .product img {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            object-fit: cover;
            margin-right: 15px;
            background: #fafafa;
        }

        .product-info {
            flex: 1;
        }

        .product-info h4 {
            font-size: 15px;
            margin: 0;
            color: #222;
        }

        .product-info p {
            font-size: 13px;
            color: #888;
            margin: .2rem 0 0;
        }

        .price {
            text-align: left;
            font-weight: 500;
            font-size: 13px;
            color: #333;
            white-space: nowrap;
        }

        .total {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin: 12px 0;
        }

        .total span {
            font-size: 12px;
            color: #777;
        }

        .total strong {
            font-size: 16px;
            color: #000;
            font-weight: 700;
        }

        .buttons {
            display: flex;
            gap: 8px;
            /* Jarak antar tombol */
            flex-wrap: wrap;
            justify-content: flex-start;
            align-items: center;
            /* ⬅️ baru, supaya sejajar */
        }

        .buttons button {
            border-radius: 8px;
            padding: 8px 16px;
            cursor: pointer;
            font-weight: 500;
        }

        /* tombol teks kecil: Nilai / Lihat Penilaian */
        .btn-text {
            background: transparent;
            border: none;
            color: #7B0D1E;
            font-size: 13px;
            padding: 4px 0;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-left: 0;
            /* ⬅️ pastikan tidak ada jarak tambahan */
            padding-left: 0;
            cursor: pointer;
        }

        .btn-text .bi {
            font-size: 15px;
        }

        /* ikon WA bulat kecil */
        .btn-icon {
            width: 34px;
            height: 34px;
            border-radius: 999px;
            border: 1px solid #ccc;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #25D366;
            box-shadow: 0 2px 4px rgba(0, 0, 0, .05);
        }

        .btn-icon .bi {
            font-size: 18px;
        }

        .btn-primary {
            background: #7B0D1E;
            border: 1px solid #7B0D1E;
            color: #fff;
        }

        .btn-primary:hover {
            background: #5d0a17;
        }

        .btn-secondary {
            background: #ffffff;
            border: 1px solid #d5d5d5;
            color: #555;
            padding: 5px 14px;
            /* tinggi lebih kecil */
            font-size: 12px;
            /* font kecil */
            border-radius: 8px;
            /* pill */
            box-shadow: none;
            /* hilangin bayangan */
            line-height: 1.3;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-secondary:hover {
            border-color: #7B0D1E;
            color: #7B0D1E;
        }

        .order-actions-right .btn-secondary+.btn-secondary {
            margin-left: 6px;
        }

        /* ===== Modal Detail Pesanan ===== */
        .modal-backdrop {
            position: fixed;
            inset: 0;
            display: none;
            justify-content: center;
            align-items: center;
            background: rgba(0, 0, 0, .6);
            z-index: 9999;
        }

        .modal-card {
            background: #fff;
            padding: 20px;
            border-radius: 16px;
            width: 90%;
            max-width: 960px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 5px 15px rgba(0, 0, 0, .3);
            animation: fadeIn .25s ease;
        }

        .order-header-popup {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-bottom: 12px;
            gap: 10px;
            flex-wrap: wrap;
        }

        .order-date {
            color: #555;
            font-size: 14px;
        }

        .order-id {
            color: #7B0D1E;
            font-weight: 600;
            font-size: 14px;
        }

        .modal-product {
            display: flex;
            gap: 18px;
            align-items: center;
            margin-top: 10px;
        }

        .modal-product img {
            width: 110px;
            height: 110px;
            border-radius: 10px;
            object-fit: cover;
            background: #fafafa;
        }

        .modal-product .info h4 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            color: #222;
        }

        .modal-product .info p {
            margin: 6px 0 0;
            color: #666;
            font-size: 13px;
        }

        .modal-section {
            margin-top: 18px;
            border-top: 1px solid #eee;
            padding-top: 12px;
        }

        .modal-section .label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .modal-section p {
            margin: 6px 0;
            color: #555;
            font-size: 13px;
        }

        .modal-actions {
            display: flex;
            gap: 10px;
            margin-top: 18px;
            flex-wrap: wrap;
        }

        .modal-btn {
            border-radius: 8px;
            padding: 10px 16px;
            cursor: pointer;
            border: none;
        }

        .modal-btn.primary {
            background: #7B0D1E;
            color: #fff;
        }

        .modal-btn.ghost {
            background: #fff;
            border: 1px solid #ddd;
            color: #333;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(.98);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* ===== Popup Ulasan ===== */
        .rv-backdrop {
            position: fixed;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, .55);
            z-index: 10000;
        }

        .rv-card {
            width: min(960px, 92vw);
            max-height: 90vh;
            overflow: auto;
            background: #fff;
            border-radius: 16px;
            padding: 20px 24px 24px;
            /* 🔁 tambahin padding kanan & bawah sedikit */
            box-shadow: 0 10px 30px rgba(0, 0, 0, .2);
        }

        .rv-title {
            font-size: 20px;
            font-weight: 700;
            margin: 0 0 14px;
            color: #1a1a1a;
        }

        .rv-head {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 12px;
        }

        .rv-head img {
            width: 84px;
            height: 84px;
            object-fit: cover;
            border-radius: 12px;
            background: #fafafa;
        }

        .rv-name {
            font-weight: 600;
            font-size: 16px;
        }

        .rv-label {
            font-size: 14px;
            color: #333;
            margin: 12px 0 8px;
        }

        .rv-stars {
            display: flex;
            gap: 8px;
            font-size: 22px;
            color: #F2C94C;
        }

        .rv-star {
            cursor: pointer;
        }

        .rv-star.active {
            color: #F2C94C;
        }

        .rv-textarea {
            width: 100%;
            max-width: 100%;
            /* 🔁 cegah lebih lebar dari kartu */
            box-sizing: border-box;
            /* 🔁 pastikan termasuk padding */
            min-height: 120px;
            resize: vertical;
            border: 1px solid #eee;
            border-radius: 10px;
            padding: 12px;
            font-size: 14px;
            margin-top: 4px;
            /* 🔁 beri jarak kecil dari label */
            margin-bottom: 10px;
            /* 🔁 jarak sebelum tombol, biar nggak nempel */
        }

        .rv-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            margin-top: 16px;
        }

        .rv-btn {
            padding: 10px 18px;
            border-radius: 10px;
            cursor: pointer;
            border: 1px solid transparent;
        }

        .rv-btn.rv-ghost {
            background: #fff;
            border-color: #ddd;
            color: #333;
        }

        .rv-btn.rv-primary {
            background: #7B0D1E;
            color: #fff;
        }

        .rv-btn.rv-primary:hover {
            background: #5d0a17;
        }

        /* ===== Aksi di kartu (layout baru) ===== */
        .order-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
            flex-wrap: wrap;
        }

        .order-actions-left,
        .order-actions-right {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        /* tombol teks kecil: Nilai / Lihat Penilaian */
        .btn-text {
            background: transparent;
            border: none;
            color: #7B0D1E;
            font-size: 13px;
            padding: 4px 0;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            cursor: pointer;
        }

        .btn-text .bi {
            font-size: 15px;
        }

        /* ikon WA bulat kecil */
        .btn-icon {
            width: 34px;
            height: 34px;
            border-radius: 999px;
            border: 1px solid #ccc;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #25D366;
            box-shadow: 0 2px 4px rgba(0, 0, 0, .05);
        }

        .btn-icon .bi {
            font-size: 18px;
        }

        /* ===== Responsive ===== */
        @media (max-width: 768px) {
            .bb-header__inner {
                padding: 0 18px;
            }

            .bb-header__title {
                font-size: 1.25rem;
            }

            .tabs {
                padding: 8px 18px;
                overflow-x: auto;
                justify-content: flex-start;
                gap: 12px;
            }

            .tabs::after {
                content: "";
                flex: 0 0 24px;
            }

            .tabs button {
                flex: 0 0 auto;
                font-size: 13px;
                padding-bottom: 4px;
            }

            .container {
                margin: 16px auto 24px;
                padding: 0 18px;
            }

            .order-card {
                padding: 12px 14px;
            }

            .product {
                align-items: flex-start;
            }

            .product img {
                width: 70px;
                height: 70px;
                margin-right: 10px;
            }

            .price {
                font-size: 12px;
            }

            .total {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
                gap: 0;
            }

            .total strong {
                font-size: 15px;
            }

            .buttons {
                flex-wrap: wrap;
                justify-content: flex-start;
                gap: 6px;
            }

            .buttons button {
                flex: 0 0 auto;
                min-width: 110px;
                max-width: 150px;
                padding: 6px 10px;
                font-size: 12px;
                text-align: center;
            }


            /* ===== Modal detail pesanan di HP ===== */
            .modal-backdrop {
                align-items: center;
                justify-content: center;
                padding: 20px 14px;
            }

            .modal-card {
                width: 100%;
                max-width: 480px;
                border-radius: 12px;
                padding: 16px 14px;
                max-height: calc(100vh - 80px);
                overflow-y: auto;
            }

            .order-header-popup {
                flex-direction: column;
                align-items: flex-start;
                gap: 4px;
            }

            .modal-product {
                align-items: flex-start;
                gap: 12px;
            }

            .modal-product img {
                width: 72px;
                height: 72px;
            }

            /* ===== Popup ULASAN di HP ===== */
            .rv-backdrop {
                align-items: center;
                justify-content: center;
                padding: 20px 14px;
                /* ada jarak atas–bawah */
            }

            .rv-card {
                width: 100%;
                max-width: 480px;
                /* lebar nyaman di HP */
                border-radius: 12px;
                padding: 16px 14px;
                max-height: calc(100vh - 80px);
                /* tidak kepotong, bisa discroll */
                overflow-y: auto;
            }

            .rv-head img {
                width: 64px;
                height: 64px;
                /* gambar produk sedikit diperkecil */
            }

            .rv-title {
                font-size: 18px;
            }

            .order-actions {
                flex-direction: row;
                align-items: flex-start;
            }

            .order-actions-left,
            .order-actions-right {
                width: 100%;
                justify-content: flex-start;
            }

            .order-actions-right {
                justify-content: flex-end;
            }
        }

        @media (max-width: 400px) {
            .buttons {
                justify-content: flex-start;
            }

            .buttons button {
                min-width: 100px;
                max-width: 130px;
            }
        }
    </style>

</head>

<body>
    <!-- HEADER (match pemesanan) -->
    <header class="bb-header">
        <div class="bb-container bb-header__inner">
            <button class="bb-header__back" onclick="history.back()" aria-label="Kembali">
                <span class="iconify" data-icon="mdi:chevron-left" style="font-size:1.25rem;"></span>
            </button>
            <h1 class="bb-header__title">Riwayat Pemesanan</h1>
        </div>
    </header>

    <!-- TABS (sticky di bawah header, konten dibatasi container) -->
    <div class="tabs-bar" role="tablist" aria-label="Filter status">
        <div class="bb-container tabs">
            <!-- default aktif: Belum Bayar -->
            <button type="button" class="active" data-filter="Belum Bayar">Belum Bayar</button>
            <button type="button" data-filter="Diproses">Diproses</button>
            <button type="button" data-filter="Disewa">Disewa</button>
            <button type="button" data-filter="Selesai">Selesai</button>
            <button type="button" data-filter="Dibatalkan">Dibatalkan</button>
        </div>
    </div>

    <div class="container" id="ordersContainer">
        @forelse ($pemesanan as $order)
        @php
        $status = $order->status_pesanan ?? '-';
        $mulai = \Carbon\Carbon::parse($order->tanggal_sewa)->translatedFormat('d F Y');
        $akhir = \Carbon\Carbon::parse($order->tanggal_pengembalian)->translatedFormat('d F Y');
        $totalQty = $order->details->sum('jumlah_sewa');
        $modalId = 'detailModal_'.$order->id_pesanan;

        // anggap total_harga = subtotal
        $subtotalDisplay = $order->total_harga;
        $biayaLayananFix = 1000;
        $totalDisplay = $subtotalDisplay + $biayaLayananFix;

        // === Teks metode pembayaran (untuk kartu & modal) ===
        $metodeDisplay = 'Tidak diketahui';

        if ($order->metode_pembayaran === 'cod') {
        $metodeDisplay = 'Bayar di Tempat (COD)';
        } elseif ($order->metode_pembayaran === 'midtrans') {
        if ($order->payment_channel) {
        // contoh: "Bayar Online (BCA VA)", "Bayar Online (GoPay)", dll.
        $metodeDisplay = 'Bayar Online (' . $order->payment_channel . ')';
        } else {
        $metodeDisplay = 'Bayar Online';
        }
        } elseif (!empty($order->metode_pembayaran)) {
        $metodeDisplay = $order->metode_pembayaran;
        }
        @endphp

        <div class="order-card order-item" data-status="{{ $status }}">
            <div class="order-header">
                <div class="order-header-left">
                    <span class="iconify" data-icon="mdi:calendar"></span>
                    <span>Tanggal {{ $mulai }} – {{ $akhir }}</span>
                </div>
                <div class="status">{{ $status }}</div>
            </div>

            {{-- Daftar produk di header kartu (ringkas) --}}
            @foreach ($order->details as $d)
            @php
            $p = $d->product;
            $img = $p && $p->gambar
            ? asset('storage/'.ltrim($p->gambar,'/'))
            : asset('images/bbq.jpg'); // fallback lokal
            @endphp

            <div class="product">
                <img src="{{ $img }}" alt="{{ $p->nama_produk ?? 'Produk' }}">
                <div class="product-info">
                    <h4>{{ $p->nama_produk ?? $d->id_produk }}</h4>
                    <p>x{{ $d->jumlah_sewa }} • {{ $d->durasi_hari }} hari</p>
                </div>
                <div class="price">Rp{{ number_format($d->subtotal,0,',','.') }}</div>
            </div>
            @endforeach

            <div class="total">
                <span>Total {{ $totalQty }} Produk</span>
                <strong>Rp{{ number_format($totalDisplay,0,',','.') }}</strong>
            </div>
            @php
            $firstDetail = $order->details->first();
            $reviewModalId = null;

            if ($firstDetail) {
            $pFirst = $firstDetail->product;
            $imgFirst = $pFirst && $pFirst->gambar
            ? asset('storage/'.ltrim($pFirst->gambar,'/'))
            : asset('images/bbq.jpg');
            $reviewModalId = 'reviewModal_'.$firstDetail->id_detail; // pakai id_detail
            }
            @endphp

            <div class="order-actions">
                {{-- KIRI: Nilai / Lihat Penilaian --}}
                <div class="order-actions-left">
                    @if ($status === 'Selesai' && $firstDetail)
                    @if (empty($firstDetail->ulasan))
                    <button class="btn-text" type="button" data-open-review="{{ $reviewModalId }}">
                        <i class="bi bi-star"></i>
                        <span>Nilai</span>
                    </button>
                    @else
                    <button class="btn-text" type="button" data-open-view-review="{{ $firstDetail->id_detail }}">
                        <i class="bi bi-star-fill"></i>
                        <span>Lihat Penilaian</span>
                    </button>
                    @endif
                    @endif
                </div>

                {{-- KANAN: Pesan Lagi + Lihat Rincian --}}
                <div class="order-actions-right">
                    @if (in_array($status, ['Selesai', 'Dibatalkan']))
                    <button class="btn-secondary" type="button" onclick="pesanLagi('{{ route('menu') }}')">
                        Pesan Lagi
                    </button>
                    @endif

                    <button class="btn-secondary" type="button" onclick="openDetailModal('{{ $modalId }}')">
                        Lihat Rincian
                    </button>
                </div>
            </div>


            @if ($status === 'Selesai' && $firstDetail && empty($firstDetail->ulasan))
            <div id="{{ $reviewModalId }}" class="rv-backdrop" aria-hidden="true">
                <div class="rv-card" role="dialog" aria-modal="true">
                    <h3 class="rv-title">Nilai Produk</h3>

                    <div class="rv-head">
                        <img src="{{ $imgFirst }}" alt="{{ $pFirst->nama_produk ?? 'Produk' }}">
                        <div class="rv-name">{{ $pFirst->nama_produk ?? 'Produk' }}</div>
                    </div>

                    <form action="{{ route('ulasan.store') }}" method="POST">
                        @csrf
                        {{-- ⬇️ gunakan id_detail --}}
                        <input type="hidden" name="order_detail_id" value="{{ $firstDetail->id_detail }}">
                        <input type="hidden" name="rating" value="0">

                        <div class="rv-label">Kualitas Produk &amp; Pelayanan :</div>
                        <div class="rv-stars" data-stars-for="{{ $firstDetail->id_detail }}">
                            <i class="bi bi-star rv-star" data-val="1"></i>
                            <i class="bi bi-star rv-star" data-val="2"></i>
                            <i class="bi bi-star rv-star" data-val="3"></i>
                            <i class="bi bi-star rv-star" data-val="4"></i>
                            <i class="bi bi-star rv-star" data-val="5"></i>
                        </div>

                        <div class="rv-label">Ketik Ulasan :</div>
                        <textarea name="comment" class="rv-textarea" placeholder="Ceritakan pengalaman kamu…"></textarea>

                        <div class="rv-actions">
                            <button type="button" class="rv-btn rv-ghost" data-close-review>Nanti Saja</button>
                            <button type="submit" class="rv-btn rv-primary">Ya</button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
            @if ($status === 'Selesai' && $firstDetail && $firstDetail->ulasan)
            @php
            $rv = $firstDetail->ulasan;
            $rounded = (int) round($rv->rating);
            @endphp
            <div id="viewReview_{{ $firstDetail->id_detail }}" class="rv-backdrop" aria-hidden="true">
                <div class="rv-card" role="dialog" aria-modal="true">
                    <h3 class="rv-title">Penilaian Kamu</h3>

                    <div class="rv-head">
                        <img src="{{ $imgFirst }}" alt="{{ $pFirst->nama_produk ?? 'Produk' }}">
                        <div class="rv-name">{{ $pFirst->nama_produk ?? 'Produk' }}</div>
                    </div>

                    <div class="rv-label">Rating :</div>
                    <div class="rv-stars">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="bi {{ $i <= $rounded ? 'bi-star-fill' : 'bi-star' }}"></i>
                            @endfor
                            <span style="margin-left:8px; font-weight:600;">
                                {{ number_format((float)$rv->rating,1,',','.') }}
                            </span>
                    </div>

                    <div class="rv-label">Ulasan :</div>
                    <div class="rv-textarea" style="min-height:auto;">{{ $rv->komentar }}</div>

                    <div class="rv-actions">
                        <button type="button" class="rv-btn rv-primary" data-close-view-review>Tutup</button>
                    </div>
                </div>
            </div>
            @endif
        </div>

        {{-- Modal Detail untuk pesanan ini --}}
        <div id="{{ $modalId }}" class="modal-backdrop" aria-hidden="true">
            <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="modalTitle_{{ $order->id_pesanan }}">
                <div class="order-header-popup">
                    <div class="order-date">
                        <span class="iconify" data-icon="mdi:calendar"></span>
                        Tanggal {{ $mulai }} – {{ $akhir }}
                    </div>
                    <div class="order-id">NO. PESANAN: {{ $order->no_pesanan }} | Status: {{ $status }}</div>
                </div>

                <h3 id="modalTitle_{{ $order->id_pesanan }}" style="margin:0 0 8px; color:#7B001F;">Detail Pesanan</h3>

                @foreach ($order->details as $d)
                @php
                $p = $d->product;
                $img = $p && $p->gambar ? asset('storage/'.ltrim($p->gambar,'/')) : asset('images/bbq.jpg');
                @endphp
                <div class="modal-product">
                    <img src="{{ $img }}" alt="{{ $p->nama_produk ?? 'Produk' }}">
                    <div class="info">
                        <h4>{{ $p->nama_produk ?? $d->id_produk }}</h4>
                        <p>x{{ $d->jumlah_sewa }} • {{ $d->durasi_hari }} hari</p>
                        <p class="price">Rp{{ number_format($d->subtotal,0,',','.') }}</p>
                    </div>
                </div>
                @endforeach

                <div class="modal-section">
                    <div class="label">Ringkasan</div>
                    <p>Total {{ $totalQty }} Produk</p>
                    @if(!empty($order->catatan_tambahan))
                    <p>Pesan untuk pemilik: {{ $order->catatan_tambahan }}</p>
                    @endif
                </div>

                <div class="modal-section">
                    <div class="label">Data Penerima</div>
                    <p>Nama Penerima: {{ $order->nama_penerima }}</p>
                </div>

                <div class="modal-section">
                    <div class="label">Rincian Pembayaran</div>

                    @php
                    // anggap total_harga = subtotal (belum termasuk biaya layanan)
                    $subtotal = $order->total_harga;
                    $biayaLayanan = 1000;
                    $totalBayar = $subtotal + $biayaLayanan;
                    @endphp

                    <p style="margin-top:8px;">Subtotal Pesanan: Rp{{ number_format($subtotal, 0, ',', '.') }}</p>
                    <p>Biaya Layanan: Rp{{ number_format($biayaLayanan, 0, ',', '.') }}</p>
                    <p class="label">Total Pembayaran: Rp{{ number_format($totalBayar, 0, ',', '.') }}</p>
                    <p>Metode Pembayaran: {{ $metodeDisplay }}</p>
                </div>

                <div class="modal-actions">
                    <button class="modal-btn primary" onclick="closeAllModals()">Tutup</button>
                    <button class="modal-btn ghost" onclick="hubungiKami()">Hubungi Kami</button>
                </div>
            </div>
        </div>
        @empty

        <div class="order-card" style="text-align:center;">
            <div class="muted">Belum ada riwayat pemesanan.</div>
            <div class="buttons" style="justify-content:center; margin-top:12px;">
                <a href="{{ route('menu') }}"><button class="btn-primary">Mulai Belanja</button></a>
            </div>
        </div>
        @endforelse
    </div>

    <script>
        // ==== Tabs filter (client-side) ====
        const tabs = document.querySelectorAll('.tabs button');
        const cards = document.querySelectorAll('.order-item');

        function setActiveTab(btn) {
            tabs.forEach(t => t.classList.remove('active'));
            btn.classList.add('active');
        }

        // value = label tab (Belum Bayar, Diproses, dst.)
        function applyFilter(value) {
            cards.forEach(c => {
                const st = (c.getAttribute('data-status') || '').trim();
                let show = false;

                if (!value) {
                    // fallback: tampilkan semua
                    show = true;
                } else if (value === 'Diproses') {
                    show = (
                        st === 'Diproses' ||
                        st === 'Siap Diambil'
                    );
                } else {
                    // tab lain: cocokkan langsung
                    show = (st === value);
                }

                c.style.display = show ? '' : 'none';
            });
        }

        tabs.forEach(btn => {
            btn.addEventListener('click', () => {
                setActiveTab(btn);
                applyFilter(btn.dataset.filter);
            });
        });

        // apply filter awal sesuai tab yang aktif (Belum Bayar)
        const initialActive = document.querySelector('.tabs button.active');
        if (initialActive) {
            applyFilter(initialActive.dataset.filter);
        }

        // ==== Modal helpers ====
        function openDetailModal(id) {
            const modal = document.getElementById(id);
            if (!modal) return;
            modal.style.display = 'flex';
            modal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }

        function closeAllModals() {
            document.querySelectorAll('.modal-backdrop').forEach(m => {
                m.style.display = 'none';
                m.setAttribute('aria-hidden', 'true');
            });
            document.body.style.overflow = '';
        }
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeAllModals();
        });

        // ==== Actions ====
        function pesanLagi(menuUrl) {
            window.location.href = menuUrl;
        }

        function hubungiKami() {
            window.location.href = "https://wa.me/6287746567500";
        }

        // buka modal ulasan
        document.addEventListener('click', (e) => {
            const openBtn = e.target.closest('[data-open-review]');
            if (openBtn) {
                const id = openBtn.getAttribute('data-open-review');
                const m = document.getElementById(id);
                if (m) {
                    m.style.display = 'flex';
                    m.setAttribute('aria-hidden', 'false');
                    document.body.style.overflow = 'hidden';
                }
            }
            const closeBtn = e.target.closest('[data-close-review]');
            if (closeBtn) {
                const m = closeBtn.closest('.rv-backdrop');
                if (m) {
                    m.style.display = 'none';
                    m.setAttribute('aria-hidden', 'true');
                    document.body.style.overflow = '';
                }
            }
        });

        // klik backdrop = tutup
        document.addEventListener('click', (e) => {
            if (e.target.classList && e.target.classList.contains('rv-backdrop')) {
                e.target.style.display = 'none';
                e.target.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = '';
            }
        });

        // ESC = tutup
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                document.querySelectorAll('.rv-backdrop').forEach(m => {
                    m.style.display = 'none';
                    m.setAttribute('aria-hidden', 'true');
                });
                document.body.style.overflow = '';
            }
        });

        // rating bintang
        function setStars(wrapper, val) {
            wrapper.querySelectorAll('.rv-star').forEach(star => {
                star.classList.toggle('active', Number(star.dataset.val) <= val);
                // switch ikon penuh/kosong
                star.classList.remove('bi-star', 'bi-star-fill');
                star.classList.add(Number(star.dataset.val) <= val ? 'bi-star-fill' : 'bi-star');
            });
            const form = wrapper.closest('form');
            if (form) form.querySelector('input[name="rating"]').value = val;
        }

        document.querySelectorAll('.rv-stars').forEach(wrapper => {
            // default kosong
            setStars(wrapper, 0);
            wrapper.addEventListener('click', (e) => {
                const star = e.target.closest('.rv-star');
                if (!star) return;
                const val = Number(star.dataset.val || 0);
                setStars(wrapper, val);
            });
        });
        // buka/tutup modal "Lihat Penilaian"
        document.addEventListener('click', (e) => {
            // open
            const openViewBtn = e.target.closest('[data-open-view-review]');
            if (openViewBtn) {
                const idDetail = openViewBtn.getAttribute('data-open-view-review'); // id_detail
                const modal = document.getElementById('viewReview_' + idDetail);
                if (modal) {
                    modal.style.display = 'flex';
                    modal.setAttribute('aria-hidden', 'false');
                    document.body.style.overflow = 'hidden';
                }
            }
            // close
            const closeViewBtn = e.target.closest('[data-close-view-review]');
            if (closeViewBtn) {
                const modal = closeViewBtn.closest('.rv-backdrop');
                if (modal) {
                    modal.style.display = 'none';
                    modal.setAttribute('aria-hidden', 'true');
                    document.body.style.overflow = '';
                }
            }
        });
    </script>
</body>

</html>