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
        /* Variabel global */
        :root {
            --hdr: 56px;
            /* tinggi header utama (dipakai di .bb-header__inner & .tabs-bar) */
        }

        /* Reset dasar dan styling body */
        html,
        body {
            margin: 0;
            /* hilangkan margin default browser */
            padding: 0;
            /* hilangkan padding default browser */
            max-width: 100%;
            /* cegah body melebar lebih dari lebar viewport */
            overflow-x: hidden;
            /* hilangkan scroll horizontal */
            font-family: 'Poppins', sans-serif;
            /* font utama */
            background: #f9f9f9;
            /* warna background halaman */
        }

        /* Teks abu-abu kecil untuk info / empty state */
        .muted {
            color: #888;
            /* warna abu-abu */
            font-size: 12px;
            /* ukuran font kecil */
        }

        /* ===== Layout Container (mirip Bootstrap .container) ===== */
        .bb-container {
            width: 100%;
            /* lebar penuh */
            margin: 0 auto;
            /* center secara horizontal */
            padding: 0 24px;
            /* padding kiri kanan */
        }

        /* Breakpoint lebar container (mengikuti pola Bootstrap) */
        @media (min-width: 576px) {
            .bb-container {
                max-width: 540px;
                /* batas maksimal container pada layar >= 576px */
            }
        }

        @media (min-width: 768px) {
            .bb-container {
                max-width: 720px;
                /* batas maksimal container pada layar >= 768px */
            }
        }

        @media (min-width: 992px) {
            .bb-container {
                max-width: 960px;
                /* batas maksimal container pada layar >= 992px */
            }
        }

        @media (min-width: 1200px) {
            .bb-container {
                max-width: 1140px;
                /* batas maksimal container pada layar >= 1200px */
            }
        }

        @media (min-width: 1400px) {
            .bb-container {
                max-width: 1320px;
                /* batas maksimal container pada layar >= 1400px */
            }
        }

        /* padding khusus HP & tablet */
        @media (max-width: 992px) {
            .bb-container {
                padding-left: 18px;
                /* kurangi padding kiri di layar kecil */
                padding-right: 18px;
                /* kurangi padding kanan di layar kecil */
            }
        }

        /* container utama konten riwayat */
        .container {
            max-width: 1140px;
            /* batas lebar konten utama */
            margin: 24px auto 40px;
            /* jarak atas & bawah + center horizontal */
            padding: 0 16px;
            /* padding kiri kanan di dalam container */
        }

        /* ===== Header ===== */
        .bb-header {
            position: sticky;
            /* header nempel di atas saat discroll */
            top: 0;
            /* menempel di paling atas viewport */
            z-index: 1000;
            /* berada di atas elemen lain */
            background: #7B0D1E;
            /* warna maroon khas Barbekuy */
            color: #fff;
            /* warna teks putih */
            box-shadow: 0 2px 6px rgba(0, 0, 0, .15);
            /* bayangan halus di bawah header */
        }

        .bb-header__inner {
            height: var(--hdr);
            /* tinggi header sesuai variabel */
            display: flex;
            /* gunakan flexbox */
            align-items: center;
            /* vertikal tengah */
            justify-content: center;
            /* judul di tengah horizontal */
            position: relative;
            /* untuk posisi tombol back absolut */
        }

        .bb-header__title {
            margin: 0;
            /* hilangkan margin default h1 */
            font-weight: 600;
            /* font semi-bold */
            font-size: 1.5rem;
            /* ukuran judul */
        }

        .bb-header__back {
            position: absolute;
            /* posisikan relatif terhadap .bb-header__inner */
            left: 16px;
            /* jarak dari kiri */
            width: 36px;
            /* lebar tombol bulat */
            height: 36px;
            /* tinggi tombol bulat */
            border-radius: 9999px;
            /* bentuk benar-benar bulat */
            border: 0;
            /* tanpa border default */
            cursor: pointer;
            /* pointer saat dihover */
            background: rgba(255, 255, 255, .15);
            /* background putih transparan */
            color: #fff;
            /* ikon panah berwarna putih */
            display: flex;
            /* flex untuk center ikon */
            align-items: center;
            /* vertikal tengah */
            justify-content: center;
            /* horizontal tengah */
        }

        /* ===== Tabs Status ===== */
        .tabs-bar {
            position: sticky;
            /* bar tab juga nempel di bawah header */
            top: var(--hdr);
            /* posisinya tepat di bawah header */
            z-index: 999;
            /* sedikit di bawah header */
            background: #fff;
            /* background putih */
            border-bottom: 1px solid #ddd;
            /* garis pemisah bawah */
        }

        .tabs {
            display: flex;
            /* susun tab secara horizontal */
            justify-content: space-around;
            /* sebar rata antar tab */
            padding: 12px 0;
            /* padding atas bawah */
        }

        .tabs button {
            background: none;
            /* tanpa background tombol default */
            border: none;
            /* tanpa border tombol default */
            font-weight: 500;
            /* semi-bold untuk label tab */
            cursor: pointer;
            /* pointer saat dihover */
            color: #000;
            /* warna teks hitam */
            padding-bottom: 6px;
            /* beri ruang untuk garis aktif */
        }

        .tabs button.active {
            color: #7B0D1E;
            /* warna teks tab aktif */
            border-bottom: 2px solid #7B0D1E;
            /* garis bawah sebagai indikator aktif */
        }

        /* ===== Kartu Riwayat ===== */
        .order-card {
            background: #fff;
            /* kartu berwarna putih */
            margin: 1rem 0;
            /* jarak atas bawah antar kartu */
            padding: 1rem 1.5rem;
            /* padding isi kartu */
            border-radius: 10px;
            /* sudut membulat */
            box-shadow: 0 2px 6px rgba(0, 0, 0, .08);
            /* bayangan halus */
        }

        .order-header {
            display: flex;
            /* baris untuk tanggal & status */
            justify-content: space-between;
            /* tanggal di kiri, status di kanan */
            align-items: center;
            /* vertikal tengah */
            font-size: 14px;
            /* ukuran font */
            color: #777;
            /* warna teks abu-abu */
            gap: 8px;
            /* jarak antar elemen saat wrap */
            flex-wrap: wrap;
            /* boleh turun ke baris baru */
        }

        .order-header-left {
            display: flex;
            /* ikon + teks tanggal */
            align-items: center;
            /* vertikal tengah */
            gap: 8px;
            /* jarak antara ikon & teks */
        }

        .order-header-left .iconify {
            color: #7B0D1E;
            /* warna ikon kalender */
            font-size: 18px;
            /* ukuran ikon */
        }

        .status {
            font-weight: 600;
            /* status lebih tebal */
            color: #7B0D1E;
            /* warna maroon */
        }

        .product {
            display: flex;
            /* gambar + info produk + harga */
            align-items: center;
            /* vertikal tengah */
            margin-top: 1rem;
            /* jarak dari header order */
        }

        .product img {
            width: 80px;
            /* lebar gambar */
            height: 80px;
            /* tinggi gambar */
            border-radius: 10px;
            /* sudut membulat */
            object-fit: cover;
            /* gambar tetap proporsional */
            margin-right: 15px;
            /* jarak ke sisi kanan (info) */
            background: #fafafa;
            /* background abu terang jika gambar kecil */
        }

        .product-info {
            flex: 1;
            /* info produk mengambil ruang sisa */
        }

        .product-info h4 {
            font-size: 15px;
            /* ukuran nama produk */
            margin: 0;
            /* hilangkan margin default */
            color: #222;
            /* warna teks gelap */
        }

        .product-info p {
            font-size: 13px;
            /* ukuran teks detail bawah */
            color: #888;
            /* warna abu */
            margin: .2rem 0 0;
            /* sedikit jarak atas */
        }

        .price {
            text-align: left;
            /* teks harga rata kiri */
            font-weight: 500;
            /* semi-bold */
            font-size: 13px;
            /* ukuran font */
            color: #333;
            /* warna agak gelap */
            white-space: nowrap;
            /* cegah harga pindah baris */
        }

        .total {
            display: flex;
            /* teks "Total x Produk" + harga total */
            justify-content: space-between;
            /* sebar kiri kanan */
            align-items: flex-end;
            /* posisi vertikal di bawah */
            margin: 12px 0;
            /* jarak atas bawah */
        }

        .total span {
            font-size: 12px;
            /* ukuran teks kecil */
            color: #777;
            /* warna abu */
        }

        .total strong {
            font-size: 16px;
            /* ukuran total lebih besar */
            color: #000;
            /* warna hitam */
            font-weight: 700;
            /* bold */
        }

        .buttons {
            display: flex;
            /* kontainer tombol di empty state */
            gap: 8px;
            /* jarak antar tombol */
            flex-wrap: wrap;
            /* boleh turun baris */
            justify-content: flex-start;
            /* default rata kiri */
            align-items: center;
            /* vertikal tengah */
        }

        .buttons button {
            border-radius: 8px;
            /* sudut membulat */
            padding: 8px 16px;
            /* padding tombol */
            cursor: pointer;
            /* pointer saat dihover */
            font-weight: 500;
            /* semi-bold */
        }

        .btn-text .bi {
            font-size: 15px;
            /* ukuran ikon di tombol teks (Nilai / Lihat Penilaian) */
        }

        .btn-icon .bi {
            font-size: 18px;
            /* ukuran ikon jika suatu saat pakai .btn-icon */
        }

        .btn-primary {
            background: #7B0D1E;
            /* warna utama tombol */
            border: 1px solid #7B0D1E;
            /* border senada */
            color: #fff;
            /* teks putih */
        }

        .btn-primary:hover {
            background: #5d0a17;
            /* warna sedikit lebih gelap saat hover */
        }

        .btn-secondary {
            background: #ffffff;
            /* background putih */
            border: 1px solid #d5d5d5;
            /* border abu */
            color: #555;
            /* teks abu gelap */
            padding: 5px 14px;
            /* padding lebih ramping */
            font-size: 12px;
            /* ukuran font kecil */
            border-radius: 8px;
            /* sudut membulat */
            box-shadow: none;
            /* tanpa bayangan */
            line-height: 1.3;
            /* tinggi baris */
            display: inline-flex;
            /* inline-flex agar bisa dikombinasi dengan teks lain */
            align-items: center;
            /* vertikal tengah */
            justify-content: center;
            /* horizontal tengah */
        }

        .btn-secondary:hover {
            border-color: #7B0D1E;
            /* border maroon saat hover */
            color: #7B0D1E;
            /* teks maroon saat hover */
        }

        .order-actions-right .btn-secondary+.btn-secondary {
            margin-left: 6px;
            /* jarak antar tombol di kanan */
        }

        /* ===== Modal Detail Pesanan ===== */
        .modal-backdrop {
            position: fixed;
            /* selalu menutupi viewport */
            inset: 0;
            /* top, right, bottom, left = 0 */
            display: none;
            /* default: tersembunyi */
            justify-content: center;
            /* center konten modal secara horizontal */
            align-items: center;
            /* center konten modal secara vertikal */
            background: rgba(0, 0, 0, .6);
            /* overlay gelap semi transparan */
            z-index: 9999;
            /* di atas hampir semua elemen */
        }

        .modal-card {
            background: #fff;
            /* body modal putih */
            padding: 20px;
            /* padding konten */
            border-radius: 16px;
            /* sudut membulat */
            width: 90%;
            /* lebar relatif */
            max-width: 960px;
            /* lebar maksimum di desktop */
            max-height: 90vh;
            /* tinggi maksimum 90% viewport */
            overflow-y: auto;
            /* scroll jika konten tinggi */
            box-shadow: 0 5px 15px rgba(0, 0, 0, .3);
            /* bayangan modal */
            animation: fadeIn .25s ease;
            /* animasi muncul */
        }

        .order-header-popup {
            display: flex;
            /* baris tanggal + nomor pesanan */
            justify-content: space-between;
            /* sebar kiri kanan */
            align-items: flex-start;
            /* align ke atas */
            border-bottom: 1px solid #eee;
            /* garis pemisah bawah */
            padding-bottom: 10px;
            /* jarak ke bawah */
            margin-bottom: 12px;
            /* jarak dengan konten berikut */
            gap: 10px;
            /* jarak antar elemen saat wrap */
            flex-wrap: wrap;
            /* boleh pindah baris */
        }

        .order-date {
            color: #555;
            /* warna teks tanggal */
            font-size: 14px;
            /* ukuran font */
        }

        .order-id {
            color: #7B0D1E;
            /* warna maroon */
            font-weight: 600;
            /* semi-bold */
            font-size: 14px;
            /* ukuran font */
        }

        .modal-product {
            display: flex;
            /* gambar + info produk */
            gap: 18px;
            /* jarak antar elemen */
            align-items: center;
            /* vertikal tengah */
            margin-top: 10px;
            /* jarak dari atas */
        }

        .modal-product img {
            width: 110px;
            /* lebar gambar dalam modal */
            height: 110px;
            /* tinggi gambar */
            border-radius: 10px;
            /* sudut membulat */
            object-fit: cover;
            /* crop cover */
            background: #fafafa;
            /* background abu terang */
        }

        .modal-product .info h4 {
            margin: 0;
            /* hilangkan margin default */
            font-size: 16px;
            /* ukuran nama produk */
            font-weight: 600;
            /* semi-bold */
            color: #222;
            /* warna teks gelap */
        }

        .modal-product .info p {
            margin: 6px 0 0;
            /* jarak atas kecil */
            color: #666;
            /* warna abu gelap */
            font-size: 13px;
            /* ukuran font */
        }

        .modal-section {
            margin-top: 18px;
            /* jarak dengan blok sebelumnya */
            border-top: 1px solid #eee;
            /* garis pemisah atas */
            padding-top: 12px;
            /* jarak isi dengan garis */
        }

        .modal-section .label {
            font-weight: 600;
            /* label lebih tebal */
            color: #333;
            /* warna teks gelap */
            margin-bottom: 8px;
            /* jarak ke bawah */
        }

        .modal-section p {
            margin: 6px 0;
            /* margin vertikal kecil */
            color: #555;
            /* warna teks abu */
            font-size: 13px;
            /* ukuran font */
        }

        .modal-actions {
            display: flex;
            /* kontainer tombol pada modal */
            gap: 10px;
            /* jarak antar tombol */
            margin-top: 18px;
            /* jarak dengan konten di atas */
            flex-wrap: wrap;
            /* boleh turun baris */
        }

        .modal-btn {
            border-radius: 8px;
            /* sudut membulat */
            padding: 10px 16px;
            /* padding tombol */
            cursor: pointer;
            /* pointer saat dihover */
            border: none;
            /* tanpa border default */
        }

        .modal-btn.primary {
            background: #7B0D1E;
            /* warna tombol utama */
            color: #fff;
            /* teks putih */
        }

        .modal-btn.ghost {
            background: #fff;
            /* ghost: background putih */
            border: 1px solid #ddd;
            /* border abu */
            color: #333;
            /* teks gelap */
        }

        /* Animasi muncul modal */
        @keyframes fadeIn {
            from {
                opacity: 0;
                /* awal: transparan */
                transform: scale(.98);
                /* sedikit mengecil */
            }

            to {
                opacity: 1;
                /* akhir: terlihat penuh */
                transform: scale(1);
                /* ukuran normal */
            }
        }

        /* ===== Popup Ulasan ===== */
        .rv-backdrop {
            position: fixed;
            /* overlay ulasan menutupi layar */
            inset: 0;
            /* top/right/bottom/left = 0 */
            display: none;
            /* default tersembunyi */
            align-items: center;
            /* center vertikal */
            justify-content: center;
            /* center horizontal */
            background: rgba(0, 0, 0, .55);
            /* overlay gelap */
            z-index: 10000;
            /* di atas modal detail (sedikit lebih tinggi) */
        }

        .rv-card {
            width: min(960px, 92vw);
            /* lebar max 960px atau 92% viewport */
            max-height: 90vh;
            /* tinggi maksimal 90% viewport */
            overflow: auto;
            /* scroll jika terlalu tinggi */
            background: #fff;
            /* background putih */
            border-radius: 16px;
            /* sudut membulat */
            padding: 20px 24px 24px;
            /* padding isi kartu */
            box-shadow: 0 10px 30px rgba(0, 0, 0, .2);
            /* bayangan lebih tebal */
        }

        .rv-title {
            font-size: 20px;
            /* ukuran judul popup ulasan */
            font-weight: 700;
            /* bold */
            margin: 0 0 14px;
            /* jarak bawah */
            color: #1a1a1a;
            /* warna teks gelap */
        }

        .rv-head {
            display: flex;
            /* gambar + nama produk */
            align-items: center;
            /* vertikal tengah */
            gap: 14px;
            /* jarak antar elemen */
            margin-bottom: 12px;
            /* jarak bawah */
        }

        .rv-head img {
            width: 84px;
            /* lebar gambar */
            height: 84px;
            /* tinggi gambar */
            object-fit: cover;
            /* crop cover */
            border-radius: 12px;
            /* sudut membulat */
            background: #fafafa;
            /* background abu terang */
        }

        .rv-name {
            font-weight: 600;
            /* nama produk lebih tebal */
            font-size: 16px;
            /* ukuran font */
        }

        .rv-label {
            font-size: 14px;
            /* ukuran label */
            color: #333;
            /* warna teks gelap */
            margin: 12px 0 8px;
            /* jarak vertikal */
        }

        .rv-stars {
            display: flex;
            /* deretan ikon bintang */
            gap: 8px;
            /* jarak antar bintang */
            font-size: 22px;
            /* ukuran ikon bintang */
            color: #F2C94C;
            /* warna kuning bintang */
        }

        .rv-star {
            cursor: pointer;
            /* pointer saat dihover (bisa diklik) */
        }

        .rv-star.active {
            color: #F2C94C;
            /* warna bintang aktif (sama kuning) */
        }

        .rv-textarea {
            width: 100%;
            /* lebar penuh */
            max-width: 100%;
            /* cegah lebih lebar dari parent */
            box-sizing: border-box;
            /* padding masuk dalam lebar total */
            min-height: 120px;
            /* tinggi minimal area teks */
            resize: vertical;
            /* hanya boleh resize vertikal */
            border: 1px solid #eee;
            /* border abu tipis */
            border-radius: 10px;
            /* sudut membulat */
            padding: 12px;
            /* padding dalam textarea */
            font-size: 14px;
            /* ukuran teks */
            margin-top: 4px;
            /* jarak atas kecil */
            margin-bottom: 10px;
            /* jarak bawah sebelum tombol */
        }

        .rv-actions {
            display: flex;
            /* kontainer tombol di popup ulasan */
            gap: 12px;
            /* jarak antar tombol */
            justify-content: flex-end;
            /* tombol diratakan ke kanan */
            margin-top: 16px;
            /* jarak atas */
        }

        .rv-btn {
            padding: 10px 18px;
            /* padding tombol */
            border-radius: 10px;
            /* sudut membulat */
            cursor: pointer;
            /* pointer saat dihover */
            border: 1px solid transparent;
            /* border transparan dasar */
        }

        .rv-btn.rv-ghost {
            background: #fff;
            /* ghost: putih */
            border-color: #ddd;
            /* border abu */
            color: #333;
            /* teks gelap */
        }

        .rv-btn.rv-primary {
            background: #7B0D1E;
            /* warna utama */
            color: #fff;
            /* teks putih */
        }

        .rv-btn.rv-primary:hover {
            background: #5d0a17;
            /* warna lebih gelap saat hover */
        }

        /* ===== Aksi di kartu (layout baru) ===== */
        .order-actions {
            display: flex;
            /* baris untuk aksi kiri & kanan */
            justify-content: space-between;
            /* kiri & kanan terpisah */
            align-items: center;
            /* vertikal tengah */
            gap: 10px;
            /* jarak antar grup */
            margin-top: 10px;
            /* jarak dari bagian total */
            flex-wrap: wrap;
            /* boleh turun baris di layar sempit */
        }

        .order-actions-left,
        .order-actions-right {
            display: flex;
            /* susunan horizontal */
            align-items: center;
            /* vertikal tengah */
            gap: 8px;
            /* jarak antar tombol */
            flex-wrap: wrap;
            /* boleh turun baris */
        }

        /* tombol teks kecil: Nilai / Lihat Penilaian */
        .btn-text {
            background: transparent;
            /* tanpa background */
            border: none;
            /* tanpa border */
            color: #7B0D1E;
            /* teks maroon */
            font-size: 13px;
            /* ukuran teks kecil */
            padding: 4px 0;
            /* padding vertikal tipis */
            display: inline-flex;
            /* inline-flex agar sejajar ikon + teks */
            align-items: center;
            /* vertikal tengah */
            gap: 4px;
            /* jarak antara ikon dan teks */
            cursor: pointer;
            /* pointer saat dihover */
        }

        .btn-text .bi {
            font-size: 15px;
            /* ukuran ikon bintang kecil */
        }

        .btn-icon .bi {
            font-size: 18px;
            /* ukuran ikon jika pakai tombol ikon bulat */
        }

        /* Modal konfirmasi pembatalan: lebih ramping & isi di tengah */
        #cancelConfirmModal .modal-card {
            max-width: 480px;
            /* lebar maksimum kotak putih */
            width: 90%;
            /* lebar relatif terhadap viewport */
            text-align: center;
            /* judul & teks rata tengah */
        }

        /* Tombol di bagian bawah juga center */
        #cancelConfirmModal .modal-actions {
            justify-content: center;
            /* tombol "Tidak Jadi" & "Ya, Batalkan" di tengah */
        }

        /* ===== Responsive ===== */
        @media (max-width: 768px) {
            .bb-header__inner {
                padding: 0 18px;
                /* tambahkan padding kiri kanan di header */
            }

            .bb-header__title {
                font-size: 1.25rem;
                /* sedikit kecil di HP */
            }

            .tabs {
                padding: 8px 18px;
                /* padding samping lebih besar di HP */
                overflow-x: auto;
                /* kalau tab meluber, bisa discroll horizontal */
                justify-content: flex-start;
                /* tab mulai dari kiri */
                gap: 12px;
                /* jarak antar tab */
            }

            .tabs::after {
                content: "";
                /* elemen kosong sebagai spacer di ujung kanan */
                flex: 0 0 24px;
                /* lebar spacer */
            }

            .tabs button {
                flex: 0 0 auto;
                /* lebar tombol menyesuaikan konten */
                font-size: 13px;
                /* ukuran font lebih kecil */
                padding-bottom: 4px;
                /* padding bawah sedikit */
            }

            .container {
                margin: 16px auto 24px;
                /* jarak atas bawah lebih kecil di HP */
                padding: 0 18px;
                /* padding samping di HP */
            }

            .order-card {
                padding: 12px 14px;
                /* padding kartu sedikit lebih kecil */
            }

            .product {
                align-items: flex-start;
                /* konten produk rata atas di HP */
            }

            .product img {
                width: 70px;
                /* gambar lebih kecil */
                height: 70px;
                /* tinggi gambar lebih kecil */
                margin-right: 10px;
                /* jarak kanan sedikit lebih kecil */
            }

            .price {
                font-size: 12px;
                /* ukuran harga diperkecil */
            }

            .total {
                flex-direction: row;
                /* tetap horizontal */
                justify-content: space-between;
                /* sebar kiri kanan */
                align-items: center;
                /* pusatkan vertikal */
                gap: 0;
                /* tanpa gap tambahan */
            }

            .total strong {
                font-size: 15px;
                /* total sedikit lebih kecil */
            }

            .buttons {
                flex-wrap: wrap;
                /* tombol boleh turun baris */
                justify-content: flex-start;
                /* rata kiri */
                gap: 6px;
                /* jarak antar tombol */
            }

            .buttons button {
                flex: 0 0 auto;
                /* lebar mengikuti konten */
                min-width: 110px;
                /* lebar minimal tombol */
                max-width: 150px;
                /* lebar maksimal tombol */
                padding: 6px 10px;
                /* padding lebih kecil */
                font-size: 12px;
                /* ukuran font kecil */
                text-align: center;
                /* teks tengah */
            }


            /* ===== Modal detail pesanan di HP ===== */
            .modal-backdrop {
                align-items: center;
                /* center vertikal */
                justify-content: center;
                /* center horizontal */
                padding: 20px 14px;
                /* beri ruang di pinggir layar */
            }

            .modal-card {
                width: 100%;
                /* lebar penuh di HP */
                max-width: 480px;
                /* batas maksimal */
                border-radius: 12px;
                /* sudut sedikit lebih kecil */
                padding: 16px 14px;
                /* padding dalam modal */
                max-height: calc(100vh - 80px);
                /* tinggi maksimal minus margin atas-bawah */
                overflow-y: auto;
                /* scroll jika konten tinggi */
            }

            .order-header-popup {
                flex-direction: column;
                /* susun ke bawah di HP */
                align-items: flex-start;
                /* rata kiri */
                gap: 4px;
                /* jarak antar elemen */
            }

            .modal-product {
                align-items: flex-start;
                /* gambar + info rata atas */
                gap: 12px;
                /* jarak antar elemen */
            }

            .modal-product img {
                width: 72px;
                /* gambar sedikit lebih kecil */
                height: 72px;
                /* tinggi gambar */
            }

            /* ===== Popup ULASAN di HP ===== */
            .rv-backdrop {
                align-items: center;
                /* center vertikal */
                justify-content: center;
                /* center horizontal */
                padding: 20px 14px;
                /* padding di tepi layar */
            }

            .rv-card {
                width: 100%;
                /* lebar penuh di HP */
                max-width: 480px;
                /* lebar maksimum */
                border-radius: 12px;
                /* sudut sedikit lebih kecil */
                padding: 16px 14px;
                /* padding dalam kartu */
                max-height: calc(100vh - 80px);
                /* tinggi maksimal */
                overflow-y: auto;
                /* scroll bila tinggi */
            }

            .rv-head img {
                width: 64px;
                /* gambar produk lebih kecil */
                height: 64px;
                /* tinggi gambar */
            }

            .rv-title {
                font-size: 18px;
                /* judul sedikit lebih kecil */
            }

            .order-actions {
                flex-direction: row;
                /* tetap horizontal */
                align-items: flex-start;
                /* letakkan di atas */
            }

            .order-actions-left,
            .order-actions-right {
                width: 100%;
                /* setiap sisi lebar penuh di HP */
                justify-content: flex-start;
                /* rata kiri */
            }

            .order-actions-right {
                justify-content: flex-end;
                /* sisi kanan bisa diratakan kanan bila perlu */
            }
        }

        @media (max-width: 400px) {
            .buttons {
                justify-content: flex-start;
                /* di layar sangat kecil tetap rata kiri */
            }

            .buttons button {
                min-width: 100px;
                /* lebar minimal tombol diperkecil */
                max-width: 130px;
                /* lebar maksimal tombol diperkecil */
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
                    {{-- Tombol Batalkan Pesanan (hanya jika masih bisa dibatalkan) --}}
                    @if (in_array($status, ['Belum Bayar', 'Diproses']))
                    <form id="cancel-form-{{ $order->id_pesanan }}"
                        action="{{ route('pemesanan.batalkan', $order->id_pesanan) }}"
                        method="POST"
                        style="display: none;">
                        @csrf
                        @method('PATCH')
                    </form>

                    <button class="btn-secondary"
                        type="button"
                        onclick="openCancelModal('{{ $order->id_pesanan }}')">
                        Batalkan Pesanan
                    </button>
                    @endif

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
                    <button class="modal-btn ghost" onclick="hubungiKami('{{ $order->no_pesanan }}')">
                        Hubungi Kami
                    </button>
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

    {{-- Modal Konfirmasi Pembatalan --}}
    <div id="cancelConfirmModal" class="modal-backdrop" aria-hidden="true">
        <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="cancelModalTitle">
            <h3 id="cancelModalTitle" style="margin-top:0; color:#7B0D1E;">
                Batalkan Pesanan?
            </h3>

            <p style="font-size:13px; color:#555; margin-bottom:16px;">
                Pesanan yang sudah dibatalkan tidak dapat dikembalikan.
                Kamu yakin ingin membatalkan pesanan ini?
            </p>

            {{-- simpan id pesanan yang akan dibatalkan --}}
            <input type="hidden" id="cancelOrderId">

            <div class="modal-actions">
                <button type="button"
                    class="modal-btn ghost"
                    onclick="closeCancelModal()">
                    Tidak Jadi
                </button>
                <button type="button"
                    class="modal-btn primary"
                    onclick="submitCancel()">
                    Ya, Batalkan
                </button>
            </div>
        </div>
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

        function hubungiKami(noPesanan = '') {
            const nomorWa = '6287746567500'; 

            let pesan = 'Halo kak, saya ingin menanyakan pesanan saya.';
            if (noPesanan) {
                pesan = `Halo kak, saya ingin menanyakan pesanan dengan nomor pesanan ${noPesanan}.`;
            }

            const url = `https://wa.me/${nomorWa}?text=${encodeURIComponent(pesan)}`;
            window.location.href = url;
        }

        // ----- Konfirmasi pembatalan (pakai modal custom) -----
        function openCancelModal(orderId) {
            const modal = document.getElementById('cancelConfirmModal');
            const input = document.getElementById('cancelOrderId');

            if (!modal || !input) return;

            input.value = orderId;
            modal.style.display = 'flex';
            modal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }

        function closeCancelModal() {
            const modal = document.getElementById('cancelConfirmModal');
            if (!modal) return;

            modal.style.display = 'none';
            modal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }

        function submitCancel() {
            const orderId = document.getElementById('cancelOrderId')?.value;
            if (!orderId) return;

            const form = document.getElementById('cancel-form-' + orderId);
            if (form) {
                form.submit();
            }

            closeCancelModal();
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