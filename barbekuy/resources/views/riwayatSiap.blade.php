<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Riwayat Pemesanan - Disiapkan</title>
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
            top: 0; left: 0; right: 0;
            z-index: 1000;
        }

        .tabs {
            display: flex;
            justify-content: space-around;
            background-color: white;
            padding: 1rem 0;
            border-bottom: 1px solid #ddd;
            position: fixed;
            top: 65px; left: 0; right: 0;
            z-index: 999;
        }

        .tabs a {
            color: #000;
            text-decoration: none;
            font-weight: 500;
        }

        .tabs a.active {
            color: #7B001F;
            border-bottom: 2px solid #7B001F;
            padding-bottom: 5px;
        }

        .content { 
            margin-top: 150px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 60vh;
            color: #555;
            text-align: center;
        }

        .content .iconify {
            font-size: 64px;
            color: #ccc;
            margin-bottom: 12px;
        }

        .content h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .content p {
            font-size: 14px;
            color: #888;
            max-width: 300px;
        }
    </style>
</head>
<body>
    <header>Riwayat Pemesanan</header>

    {{-- Navbar --}}
    <div class="tabs">
        <a href="/riwayatSemua" class="{{ request()->is('riwayatSemua') ? 'active' : '' }}">Semua</a>
        <a href="/riwayatProses" class="{{ request()->is('riwayatProses') ? 'active' : '' }}">Sedang Proses</a>
        <a href="/riwayatSiap" class="{{ request()->is('riwayatSiap') ? 'active' : '' }}">Disiapkan</a>
        <a href="/riwayatSewa" class="{{ request()->is('riwayatSewa') ? 'active' : '' }}">Disewa</a>
        <a href="/riwayatSelesai" class="{{ request()->is('riwayatSelesai') ? 'active' : '' }}">Selesai</a>
        <a href="/riwayatBatal" class="{{ request()->is('riwayatBatal') ? 'active' : '' }}">Dibatalkan</a>
    </div>

    <!-- Konten Kosong -->
    <div class="content">
        <span class="iconify" data-icon="mdi:clipboard-text-outline"></span>
        <h3>Belum Ada Pesanan Disiapkan</h3>
        <p>Pesanan yang sedang disiapkan akan muncul di sini setelah penjual memproses pesananmu.</p>
    </div>
</body>
</html>
