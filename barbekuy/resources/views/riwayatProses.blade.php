<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Riwayat Pemesanan - Sedang Proses</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
        }

        header {
            background-color: #7B001F;
            color: white;
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
            background-color: white;
            padding: 1rem 0;
            border-bottom: 1px solid #ddd;
            position: fixed;
            top: 65px;
            left: 0;
            right: 0;
            z-index: 999;
        }

        .tabs a { color: #000; text-decoration: none; font-weight: 500; }
        .tabs a.active { color: #7B001F; border-bottom: 2px solid #7B001F; padding-bottom: 5px; }

        .content { margin-top: 150px; }

        .order-card {
            background-color: white;
            margin: 1.5rem;
            padding: 1rem 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .order-header { display:flex; justify-content:space-between; align-items:center; font-size:14px; color:#777; }
        .order-header-left { display:flex; align-items:center; }
        .order-header-left .iconify { color:#7B001F; margin-right:8px; font-size:18px; }
        .status { font-weight:600; color:#7B001F; }

        .product { display:flex; align-items:center; margin-top:1rem; }
        .product img { width:80px; height:80px; border-radius:10px; object-fit:cover; margin-right:15px; }
        .product-info { flex:1; }
        .product-info h4 { font-size:15px; margin:0; }
        .product-info p { font-size:13px; color:#888; }

        .price { text-align:left; font-weight:500; font-size:13px; color:#333; }

        .total {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 12px;   /* jarak atas */
            margin-bottom: 12px; /* jarak bawah */
        }

        .total span { font-size:12px; color:#777; }
        .total strong { font-size:16px; color:#000; font-weight:700; }

        /* ====== TOMBOL DI HALAMAN & MODAL ====== */

        .buttons button {
            border-radius: 8px;
            padding: 8px 16px;
            cursor: pointer;
            font-weight: 500;
        }

        /* 🔴 Tombol utama (merah) */
        .btn-primary {
            background-color: #7B001F;
            border: 1px solid #7B001F;
            color: white;
        }
        .btn-primary:hover {
            background-color: #68011bff;
            color: #FFFFFF;
            border-color: #7B001F;
        }

        /* ⚪ Tombol sekunder (putih) */
        .btn-secondary {
            background-color: #fff;
            border: 1.5px solid #ccc;
            color: #444;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .btn-secondary:hover {
            border-color: #7B001F;
            color: #7B001F;
        }

        /* 🎯 Efek klik (active state) */
        .btn-primary:active,
        .btn-secondary:active {
            opacity: 0.9;
        }

        /* 🟣 Tombol di dalam modal */
        .modal-btn {
            border-radius: 8px;
            padding: 10px 16px;
            cursor: pointer;
        }

        .modal-btn.primary {
            background: #7B001F;
            color: #fff;
        }
        .modal-btn.primary:hover {
            background: #68011bff;
            color: #FFFFFF;
            border: 1.5px solid #7B001F;
        }

        .modal-btn.ghost {
            background: #fff;
            border: 1.5px solid #ddd;
            color: #333;
        }
        .modal-btn.ghost:hover {
            border-color: #7B001F;
            color: #7B001F;
        }

        /* ======== Modal (Popup) ======== */
        [id^="detailModal"] {
            position: fixed;               /* biar nempel di layar, bukan di bawah halaman */
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: none;                 /* default: disembunyikan */
            justify-content: center;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.6);  /* efek gelap di belakang */
            z-index: 9999;                 /* biar tampil di atas elemen lain */
        }

        /* Isi kotak popup */
        .modal-card {
            background-color: #fff;
            padding: 20px;
            border-radius: 16px;
            width: 90%;
            max-width: 960px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            animation: fadeIn 0.3s ease;
        }

        .modal-card h3 { font-weight:600; text-align:left; margin:0 0 12px 0; color:#7B001F; }

        .order-header-popup { display:flex; justify-content:space-between; align-items:flex-start; border-bottom:1px solid #eee; padding-bottom:10px; margin-bottom:12px; }
        .order-date { color:#555; font-size:14px; }
        .order-id { color:#7B001F; font-weight:600; font-size:14px; }

        .modal-product { display:flex; gap:18px; align-items:center; margin-top:10px; }
        .modal-product img { width:110px; height:110px; border-radius:10px; object-fit:cover; }
        .modal-product .info h4 { margin:0; font-size:16px; font-weight:600; }
        .modal-product .info p { margin:6px 0 0 0; color:#666; font-size:13px; }

        .modal-section { margin-top:18px; border-top:1px solid #eee; padding-top:12px; }
        .modal-section .label { font-weight:600; color:#333; margin-bottom:8px; }
        .modal-section p { margin:6px 0; color:#555; font-size:13px; }

        .modal-actions { display:flex; justify-content:flex-start; gap:10px; margin-top:18px; flex-wrap:wrap; }
        .modal-btn { border-radius:8px; padding:10px 16px; cursor:pointer; border:none; }
        .modal-btn.primary { background:#7B001F; color:#fff; }
        .modal-btn.ghost { background:#fff; border:1px solid #ddd; color:#333; }

        @keyframes fadeIn { from { opacity:0; transform:scale(.98);} to{ opacity:1; transform:scale(1);} }

        @media (max-width:640px) {
            .modal-product img { width:88px; height:88px; }
            .modal-card { padding:18px; }
        }
    </style>
</head>
<body>
    <header>Riwayat Pemesanan</header>

    {{-- Include Navbar --}}
    @include('layouts.navbarRiwayat')

    <div class="content">
        <!-- ✅ Kartu 1 (Selesai) -->
        <div class="order-card">
            <div class="order-header">
                <div class="order-header-left">
                    <span class="iconify" data-icon="mdi:calendar"></span>
                    Tanggal 8–9 Oktober 2025
                </div>
                <div class="status">Sedang Proses</div>
            </div>

            <div class="product">
                <img src="images/ber4extra.png" alt="Paket Slice Ber-4 Xtra">
                <div class="product-info">
                    <h4>Paket Slice Ber-4 Xtra</h4>
                    <p>x1</p>
                </div>
                <div class="price">Rp245.000</div>
            </div>

            <div class="total">
                <span>Total 1 Produk</span>
                <strong>Rp246.000</strong>
            </div>

            <div class="buttons">
                <button class="btn-primary">Nilai</button>
                <button class="btn-secondary">Hubungi Kami</button>
                <button class="btn-secondary">Pesan Lagi</button>
                <button class="btn-secondary" onclick="openDetailModal('detailModal1')">Lihat Rincian</button>
            </div>
        </div>
    </div>

    <!-- ===== MODAL DETAIL PESANAN 1 ===== -->
    <div id="detailModal1" aria-hidden="true">
        <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
            <div class="order-header-popup">
                <div class="order-date">
                    <span class="iconify" data-icon="mdi:calendar"></span> Tanggal 6–7 Oktober 2025
                </div>
                <div class="order-id">NO. PESANAN: P4X–003 | Pesanan Sedang Proses</div>
            </div>

            <h3 id="modalTitle">Detail Pesanan</h3>

            <div class="modal-product">
                <img src="{{ asset('images/ber4extra.png') }}" alt="Paket Slice Ber-4 Xtra">
                <div class="info">
                    <h4>Paket Slice Ber–4 Xtra</h4>
                    <p>x1</p>
                    <p class="price">Rp245.000</p>
                </div>
            </div>

            <div class="modal-section">
                <div class="label">Ringkasan</div>
                <p>Total 1 Produk</p>
                <p>Pesan untuk pemilik: ambil agak siang</p>
            </div>

            <div class="modal-section">
                <div class="label">Lokasi Pengambilan</div>
                <p>Sumampir Kulon, Sumampir, Purwokerto Utara, Kabupaten Banyumas, Jawa Tengah 53125</p>
            </div>

            <div class="modal-section">
                <div class="label">Rincian Pembayaran</div>
                <p>Subtotal Pesanan: Rp245.000</p>
                <p>Biaya Layanan: Rp1.000</p>
                <p class="label" style="margin-top:8px;">Total Pembayaran: Rp246.000</p>
                <p>Metode Pembayaran: COD</p>
            </div>

            <div class="modal-actions">
                <button class="modal-btn primary" onclick="closeDetailModal()">Tutup</button>
                <button class="modal-btn ghost" onclick="handlePesanLagi()">Pesan Lagi</button>
                <button class="modal-btn ghost" onclick="handleHubungi()">Hubungi Kami</button>
            </div>
        </div>
    </div>

    <script>
        function openDetailModal(id) {
            const modal = document.getElementById(id);
            modal.style.display = 'flex';
            modal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden'; // biar halaman gak bisa discroll saat popup muncul
        }

        function closeDetailModal() {
            const modals = document.querySelectorAll('[id^="detailModal"]');
            modals.forEach(modal => {
                modal.style.display = 'none';
                modal.setAttribute('aria-hidden', 'true');
            });
            document.body.style.overflow = ''; // aktifkan scroll lagi
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeDetailModal();
        });
    </script>


</body>
</html>