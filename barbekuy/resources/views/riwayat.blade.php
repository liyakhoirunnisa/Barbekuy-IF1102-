<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Riwayat Pemesanan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f9f9f9;
            margin: 0;
        }

        header {
            background: #7B001F;
            color: #fff;
            padding: 1.2rem 2rem;
            text-align: center;
            font-weight: 600;
            font-size: 20px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .tabs {
            display: flex;
            justify-content: space-around;
            background: #fff;
            padding: 1rem 0;
            border-bottom: 1px solid #ddd;
            position: fixed;
            top: 65px;
            left: 0;
            right: 0;
            z-index: 999;
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
            color: #7B001F;
            border-bottom: 2px solid #7B001F;
        }

        .container {
            max-width: 980px;
            margin: 150px auto 40px;
            padding: 0 16px;
        }

        .alert {
            max-width: 980px;
            margin: 110px auto 8px;
            padding: 10px 12px;
            border-radius: 8px;
        }

        .alert-success {
            background: #eaf8ec;
            color: #1d7a3d;
            border: 1px solid #cbeed3;
        }

        .alert-danger {
            background: #fdeaea;
            color: #9b1c1c;
            border: 1px solid #f5c2c2;
        }

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
            color: #7B001F;
            font-size: 18px;
        }

        .status {
            font-weight: 600;
            color: #7B001F;
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
            flex-wrap: wrap;
        }

        .buttons button {
            border-radius: 8px;
            padding: 8px 16px;
            cursor: pointer;
            font-weight: 500;
        }

        .btn-primary {
            background: #7B001F;
            border: 1px solid #7B001F;
            color: #fff;
        }

        .btn-primary:hover {
            background: #68011b;
        }

        .btn-secondary {
            background: #fff;
            border: 1.5px solid #ccc;
            color: #444;
            box-shadow: 0 2px 4px rgba(0, 0, 0, .05);
        }

        .btn-secondary:hover {
            border-color: #7B001F;
            color: #7B001F;
        }

        /* modal */
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
            color: #7B001F;
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
            background: #7B001F;
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

        .muted {
            color: #888;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <header>Riwayat Pemesanan</header>

    {{-- Flash message --}}
    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Tabs filter (client-side) --}}
    <div class="tabs" role="tablist" aria-label="Filter status">
        <button type="button" class="active" data-filter="all">Semua</button>
        <button type="button" data-filter="Belum Bayar">Belum Bayar</button>
        <button type="button" data-filter="Menunggu Konfirmasi">Sedang Proses</button>
        <button type="button" data-filter="Disiapkan">Disiapkan</button>
        <button type="button" data-filter="Disewa">Disewa</button>
        <button type="button" data-filter="Selesai">Selesai</button>
        <button type="button" data-filter="Dibatalkan">Dibatalkan</button>
    </div>

    <div class="container" id="ordersContainer">
        @forelse ($pemesanan as $order)
        @php
        $status = $order->status_pesanan ?? '-';
        $mulai = \Carbon\Carbon::parse($order->tanggal_sewa)->translatedFormat('d F Y');
        $akhir = \Carbon\Carbon::parse($order->tanggal_pengembalian)->translatedFormat('d F Y');
        $totalQty = $order->details->sum('jumlah_sewa');
        $modalId = 'detailModal_'.$order->id_pesanan;
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
                <strong>Rp{{ number_format($order->total_harga,0,',','.') }}</strong>
            </div>

            <div class="muted">NO. PESANAN: {{ $order->no_pesanan }}</div>

            <div class="buttons" style="margin-top:10px;">
                @if ($status === 'Selesai')
                <button class="btn-primary">Nilai</button>
                @endif
                <button class="btn-secondary" onclick="hubungiKami()">Hubungi Kami</button>
                <button class="btn-secondary" onclick="pesanLagi('{{ route('menu') }}')">Pesan Lagi</button>
                <button class="btn-secondary" onclick="openDetailModal('{{ $modalId }}')">Lihat Rincian</button>
            </div>
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
                        <p class="price">Rp{{ number_format($d->harga_satuan,0,',','.') }} /hari • Subtotal: Rp{{ number_format($d->subtotal,0,',','.') }}</p>
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
                    <p class="label" style="margin-top:8px;">Total Pembayaran: Rp{{ number_format($order->total_harga,0,',','.') }}</p>
                    {{-- Jika kamu simpan metode pembayaran di header, tampilkan di sini --}}
                    {{-- <p>Metode Pembayaran: {{ strtoupper($order->metode_pembayaran) }}</p> --}}
                </div>

                <div class="modal-actions">
                    <button class="modal-btn primary" onclick="closeAllModals()">Tutup</button>
                    <button class="modal-btn ghost" onclick="pesanLagi('{{ route('menu') }}')">Pesan Lagi</button>
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

        function applyFilter(value) {
            cards.forEach(c => {
                const st = (c.getAttribute('data-status') || '').trim();
                const show = (value === 'all') ? true : (st === value);
                c.style.display = show ? '' : 'none';
            });
        }

        tabs.forEach(btn => {
            btn.addEventListener('click', () => {
                setActiveTab(btn);
                applyFilter(btn.dataset.filter);
            });
        });

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
    </script>
</body>

</html>