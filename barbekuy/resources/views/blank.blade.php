<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pemesanan - Sedang Proses</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
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
            position: sticky;
            top: 0;
        }
        .tabs {
            display: flex;
            justify-content: space-around;
            background-color: white;
            padding: 1rem 0;
            border-bottom: 1px solid #ddd;
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
        .order-card {
            background-color: white;
            margin: 1.5rem;
            padding: 1rem 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .order-header {
            display: flex;
            align-items: center;
            font-size: 14px;
            color: #777;
        }
        .order-header i {
            margin-right: 5px;
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
        }
        .product-info {
            flex: 1;
        }
        .product-info h4 {
            font-size: 15px;
            margin: 0;
        }
        .product-info p {
            font-size: 13px;
            color: #888;
        }
        .price {
            text-align: right;
            font-weight: 600;
            color: #7B001F;
        }
        .total {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            font-size: 14px;
        }
        .buttons {
            display: flex;
            gap: 10px;
            margin-top: 1rem;
        }
        .buttons button {
            border: none;
            border-radius: 8px;
            padding: 8px 14px;
            cursor: pointer;
            font-weight: 500;
        }
        .btn-primary {
            background-color: #7B001F;
            color: white;
        }
        .btn-secondary {
            background-color: #fff;
            color: #555;
            border: 1px solid #ccc;
        }
        .status {
            text-align: right;
            margin-top: 10px;
            font-weight: 600;
            color: #7B001F;
        }
    </style>
</head>
<body>
    <header>Riwayat Pemesanan</header>

    <div class="tabs">
        <a href="/riwayatSemua">Semua</a>
        <a href="/riwayatProses" class="active">Sedang Proses</a>
        <a href="/riwayatSelesai">Selesai</a>
        <a href="/riwayatBatal">Dibatalkan</a>
    </div>

    <!-- Kartu Pesanan Proses -->
    <div class="order-card">
        <div class="order-header">
            <i>📅</i> Tanggal 8–9 Okt 2025
        </div>

        <div class="product">
            <img src="{{ asset('images/ber4.png') }}" alt="Paket Slice Ber-4 Xtra">
            <div class="product-info">
                <h4>Paket Slice Ber-4 Xtra</h4>
                <p>x1</p>
            </div>
            <div class="price">Rp245.000</div>
        </div>

        <div class="product">
            <img src="{{ asset('images/ber6.png') }}" alt="Paket Slice Ber-6 Xtra">
            <div class="product-info">
                <h4>Paket Slice Ber-6 Xtra</h4>
                <p>x1</p>
            </div>
            <div class="price">Rp345.000</div>
        </div>

        <div class="total">
            <span>Total 2 Produk</span>
            <strong>Rp590.000</strong>
        </div>

        <div class="buttons">
            <button class="btn-primary">Nilai</button>
            <button class="btn-secondary">Hubungi Kami</button>
            <button class="btn-secondary">Pesan Lagi</button>
        </div>

        <div class="status">Sedang Proses</div>
    </div>

</body>
</html>
