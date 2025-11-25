<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* Blok CSS internal */
        :root {
            /* Selector root untuk mendefinisikan variabel CSS global */
            --bb-header-height: 56px;
            /* Variabel tinggi header sticky 56px */
            --bb-max-width: 1140px;
            /* Variabel lebar maksimum konten 1140px */
        }

        body {
            /* Styling elemen body HTML */
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            /* Menggunakan font sistem modern */
            margin: 0;
            /* Menghapus margin default browser */
        }

        .body-pemesanan {
            /* Kelas khusus untuk body halaman pemesanan */
            background-color: #f9fafb;
            /* Warna background abu muda */
            min-height: 100vh;
            /* Tinggi minimum 1 viewport penuh */
        }

        /* HEADER STICKY */
        .bb-header {
            /* Styling container header utama */
            position: sticky;
            /* Header menempel di atas saat scroll */
            top: 0;
            /* Posisi sticky di paling atas */
            z-index: 50;
            /* Supaya berada di atas elemen lain */
            background: #7B0D1E;
            /* Warna background merah marun */
            color: #fff;
            /* Warna teks putih */
            box-shadow: 0 1px 4px rgba(0, 0, 0, .18);
            /* Bayangan halus di bawah header */
        }

        .bb-header-inner {
            /* Wrapper konten di dalam header */
            max-width: var(--bb-max-width);
            /* Lebar maksimum mengikuti variabel global */
            margin: 0 auto;
            /* Dipusatkan secara horizontal */
            padding-left: 1rem;
            /* Padding kiri 16px */
            padding-right: 1rem;
            /* Padding kanan 16px */
            height: var(--bb-header-height);
            /* Tinggi header mengikuti variabel tinggi header */
            display: flex;
            /* Menggunakan flexbox untuk layout */
            align-items: center;
            /* Vertikal: isi header rata tengah */
            justify-content: center;
            /* Horizontal: isi header rata tengah */
            position: relative;
            /* Untuk posisi absolut tombol back di dalamnya */
        }

        @media (min-width: 640px) {

            /* Media query untuk layar >= 640px */
            .bb-header-inner {
                /* Menyesuaikan padding header di layar yang lebih lebar */
                padding-left: 1.5rem;
                /* Padding kiri 24px */
                padding-right: 1.5rem;
                /* Padding kanan 24px */
            }
        }

        @media (min-width: 1024px) {

            /* Media query untuk layar >= 1024px */
            .bb-header-inner {
                /* Menyesuaikan padding header di desktop besar */
                padding-left: 2rem;
                /* Padding kiri 32px */
                padding-right: 2rem;
                /* Padding kanan 32px */
            }
        }

        .bb-header-back {
            /* Tombol kembali di header */
            position: absolute;
            /* Diposisikan absolut di dalam bb-header-inner */
            left: 1rem;
            /* Ditempatkan 16px dari sisi kiri */
            width: 36px;
            /* Lebar tombol 36px */
            height: 36px;
            /* Tinggi tombol 36px */
            border-radius: 9999px;
            /* Membuat tombol bulat penuh */
            border: 0;
            /* Menghilangkan border default tombol */
            cursor: pointer;
            /* Mengubah cursor menjadi pointer saat hover */
            background: rgba(255, 255, 255, 0.15);
            /* Background putih transparan */
            display: flex;
            /* Menggunakan flexbox di dalam tombol */
            align-items: center;
            /* Pusatkan ikon secara vertikal */
            justify-content: center;
            /* Pusatkan ikon secara horizontal */
        }

        .bb-header-back span {
            /* Ikon di dalam tombol kembali */
            font-size: 1.25rem;
            /* Ukuran ikon sekitar 20px */
            color: #fff;
            /* Warna ikon putih */
        }

        .bb-header-title {
            /* Judul teks header "Pemesanan" */
            margin: 0;
            /* Hilangkan margin default h1 */
            font-weight: 600;
            /* Ketebalan font medium-bold */
            font-size: 1.5rem;
            /* Ukuran font sekitar 24px */
        }

        /* MAIN WRAPPER */
        .bb-main {
            /* Wrapper utama konten halaman */
            max-width: var(--bb-max-width);
            /* Lebar maksimum mengikuti variabel global */
            margin: 0 auto;
            /* Konten dipusatkan */
            padding-top: 1rem;
            /* Padding atas 16px */
            padding-bottom: 1.5rem;
            /* Padding bawah 24px */
            padding-left: 1rem;
            /* Padding kiri 16px */
            padding-right: 1rem;
            /* Padding kanan 16px */
        }

        @media (min-width: 640px) {

            /* Media query layar >= 640px */
            .bb-main {
                /* Mengubah padding horizontal di layar lebih besar */
                padding-left: 1.5rem;
                /* Padding kiri 24px */
                padding-right: 1.5rem;
                /* Padding kanan 24px */
            }
        }

        @media (min-width: 1024px) {

            /* Media query layar >= 1024px */
            .bb-main {
                /* Mengubah padding horizontal di desktop besar */
                padding-left: 2rem;
                /* Padding kiri 32px */
                padding-right: 2rem;
                /* Padding kanan 32px */
            }
        }

        /* ALERT ERROR */
        .alert-error {
            /* Styling untuk box pesan error */
            max-width: 768px;
            /* Lebar maksimum 768px (sekitar container md) */
            margin: 1rem auto 0;
            /* Margin atas 16px, kanan-kiri auto, bawah 0 */
            padding: 1rem;
            /* Padding dalam 16px */
            border-radius: 0.75rem;
            /* Sudut membulat 12px */
            background: #fef2f2;
            /* Background merah muda lembut */
            color: #b91c1c;
            /* Warna teks merah tua */
            font-size: 0.875rem;
            /* Ukuran font kecil (14px) */
        }

        .list-error {
            /* Styling untuk list error di dalam alert */
            list-style: disc;
            /* Bentuk bullet disc (titik bulat) */
            padding-left: 1.25rem;
            /* Padding kiri 20px untuk menjorokkan bullet */
            margin: 0;
            /* Hilangkan margin default ul */
        }

        /* CARD UMUM */
        .card-section {
            /* Styling umum untuk setiap kartu/bagian */
            background: #ffffff;
            /* Background putih */
            border-radius: 1rem;
            /* Sudut membulat 16px */
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
            /* Bayangan lembut di bawah card */
            padding: 1rem;
            /* Padding dalam 16px */
            margin-bottom: 0.5rem;
            /* Jarak bawah antar card 8px */
        }

        .card-header {
            /* Header kecil di atas tiap card */
            display: flex;
            /* Menggunakan flexbox untuk susun ikon & judul */
            align-items: center;
            /* Vertikal rata tengah */
            margin-bottom: 0.75rem;
            /* Jarak bawah 12px dari konten card */
        }

        .icon-section {
            /* Styling ikon di header card */
            margin-right: 0.75rem;
            /* Jarak kanan dari teks 12px */
            font-size: 1.25rem;
            /* Ukuran ikon 20px */
            color: #6b7280;
            /* Warna abu-abu */
        }

        .section-title {
            /* Judul bagian card */
            font-weight: 600;
            /* Ketebalan sedang */
            color: #374151;
            /* Warna teks abu gelap */
            margin: 0;
            /* Hilangkan margin default heading */
        }

        /* PRODUK: SINGLE & MULTI CARD */
        .single-product-wrapper,
        .multi-product-card {
            /* Card item produk untuk mode single & multi */
            display: flex;
            /* Menggunakan flexbox untuk layout item */
            flex-direction: column;
            /* Default arah kolom (vertikal) di mobile */
            align-items: flex-start;
            /* Isi rata kiri */
            gap: 0.75rem;
            /* Jarak antar elemen 12px */
            border: 1px solid #e5e7eb;
            /* Border abu muda */
            border-radius: 0.75rem;
            /* Sudut membulat 12px */
            padding: 0.75rem;
            /* Padding dalam 12px */
        }

        @media (min-width: 640px) {
            /* Media query layar >= 640px */

            .single-product-wrapper,
            .multi-product-card {
                /* Mengubah layout card di layar lebih besar */
                flex-direction: row;
                /* Arah flex menjadi horizontal */
                align-items: center;
                /* Isi card rata tengah vertikal */
                gap: 1rem;
                /* Jarak antar elemen 16px */
            }
        }

        .product-image-single {
            /* Gambar produk untuk mode single */
            width: 100%;
            /* Di mobile lebar penuh card */
            height: 10rem;
            /* Tinggi 160px */
            object-fit: cover;
            /* Gambar menutupi area dengan proporsi terjaga */
            border-radius: 0.5rem;
            /* Sudut membulat 8px */
        }

        @media (min-width: 640px) {

            /* Media query layar >= 640px */
            .product-image-single {
                /* Ubah ukuran gambar single di desktop kecil */
                width: 6rem;
                /* Lebar 96px */
                height: 6rem;
                /* Tinggi 96px */
            }
        }

        .product-image-multi {
            /* Gambar produk untuk mode multi item */
            width: 5rem;
            /* Lebar 80px */
            height: 5rem;
            /* Tinggi 80px */
            object-fit: cover;
            /* Gambar tetap proporsional & menutupi frame */
            border-radius: 0.5rem;
            /* Sudut membulat 8px */
        }

        .product-main-info {
            /* Kolom teks utama info produk */
            flex: 1;
            /* Mengambil sisa lebar yang tersedia */
        }

        .product-name {
            /* Nama produk untuk mode single */
            font-weight: 600;
            /* Ketebalan medium */
            font-size: 1.125rem;
            /* Ukuran font 18px */
            color: #111827;
            /* Warna teks hampir hitam */
            margin: 0 0 0.25rem 0;
            /* Margin bawah 4px, sisi lain 0 */
        }

        .product-meta-row {
            /* Baris info tambahan (tanggal, durasi, dll.) */
            display: flex;
            /* Susun ikon dan teks secara horizontal */
            align-items: center;
            /* Vertikal rata tengah */
            gap: 0.25rem;
            /* Jarak antar elemen 4px */
            font-size: 0.875rem;
            /* Ukuran font kecil (14px) */
            color: #6b7280;
            /* Warna teks abu-abu */
        }

        .product-meta-row+.product-meta-row {
            /* Baris meta berikutnya setelah baris pertama */
            margin-top: 0.25rem;
            /* Jarak atas 4px agar tidak terlalu rapat */
        }

        .product-price-box {
            /* Kolom untuk harga dan jumlah produk */
            width: 100%;
            /* Di mobile lebar penuh */
            text-align: left;
            /* Teks rata kiri di mobile */
            margin-top: 0.5rem;
            /* Jarak atas 8px dari konten sebelumnya */
        }

        @media (min-width: 640px) {

            /* Media query layar >= 640px */
            .product-price-box {
                /* Ubah gaya kolom harga di layar lebih besar */
                width: auto;
                /* Lebar otomatis sesuai konten */
                text-align: right;
                /* Teks rata kanan di desktop */
                margin-top: 0;
                /* Hilangkan margin atas di desktop */
            }
        }

        .price-single {
            /* Teks harga satuan produk */
            color: #7B0D1E;
            /* Warna merah marun khas brand */
            font-weight: 700;
            /* Ketebalan bold */
            margin: 0;
            /* Hilangkan margin default */
        }

        .qty-single {
            /* Teks jumlah produk (x2, x3, dll.) */
            font-size: 0.875rem;
            /* Ukuran font kecil (14px) */
            color: #6b7280;
            /* Warna abu-abu */
            margin: 0;
            /* Hilangkan margin default */
        }

        .total-row {
            /* Baris yang menampilkan total produk/total harga */
            display: flex;
            /* Susun label & angka secara horizontal */
            justify-content: space-between;
            /* Label di kiri, angka di kanan */
            align-items: center;
            /* Vertikal rata tengah */
            margin-top: 0.75rem;
            /* Jarak atas 12px */
            padding-top: 0.5rem;
            /* Padding atas 8px */
            border-top: 1px solid #e5e7eb;
            /* Garis pemisah di atas baris total */
            font-size: 0.95rem;
            /* Ukuran font sedikit lebih kecil dari default */
            color: #374151;
            /* Warna teks abu gelap */
        }

        .total-row strong {
            /* Teks total yang digaris tebal */
            font-weight: 600;
            /* Ketebalan medium-bold */
        }

        .multi-list-wrapper {
            /* Wrapper untuk daftar banyak produk (multi item) */
            display: flex;
            /* Menggunakan flexbox */
            flex-direction: column;
            /* Susun card produk secara vertikal */
            gap: 0.75rem;
            /* Jarak antar card 12px */
        }

        .multi-product-name {
            /* Nama produk di mode multi item */
            font-weight: 600;
            /* Ketebalan medium */
            color: #111827;
            /* Warna hampir hitam */
            margin: 0 0 0.25rem 0;
            /* Margin bawah 4px */
        }

        .multi-product-meta {
            /* Container info meta (tanggal & durasi) di multi item */
            font-size: 0.875rem;
            /* Ukuran font kecil */
            color: #6b7280;
            /* Warna abu-abu */
        }

        .subtotal-text {
            /* Teks subtotal per produk di multi item */
            font-size: 0.875rem;
            /* Ukuran font kecil */
            font-weight: 600;
            /* Teks agak tebal */
            margin-top: 0.25rem;
            /* Jarak atas 4px dari jumlah */
        }

        /* UTIL */
        .section-spacing-top {
            /* Kelas utilitas untuk memberi jarak atas */
            margin-top: 0.75rem;
            /* Margin-top 12px */
        }

        .hidden {
            /* Kelas untuk menyembunyikan elemen */
            display: none;
            /* Tidak ditampilkan di layout */
        }

        /* PESAN TAMBAHAN */
        .message-container {
            /* Wrapper untuk bagian pesan tambahan */
            margin-top: 0.75rem;
            /* Jarak atas dari elemen sebelumnya 12px */
        }

        .message-toggle-btn {
            /* Tombol untuk menampilkan/menyembunyikan textarea pesan */
            display: flex;
            /* Susun ikon & teks secara horizontal */
            align-items: center;
            /* Vertikal rata tengah */
            gap: 0.25rem;
            /* Jarak antara ikon dan teks 4px */
            font-size: 0.875rem;
            /* Ukuran font kecil 14px */
            color: #6b7280;
            /* Warna abu-abu */
            background: none;
            /* Tidak ada background khusus */
            border: none;
            /* Tanpa border */
            padding: 0;
            /* Tanpa padding tambahan */
            cursor: pointer;
            /* Cursor pointer saat di-hover */
            transition: color 0.2s ease;
            /* Transisi halus saat warna berubah */
        }

        .message-toggle-btn:hover {
            /* Efek hover pada tombol pesan */
            color: #7B0D1E;
            /* Ubah warna teks jadi merah marun saat hover */
        }

        .message-textarea {
            /* Textarea untuk catatan tambahan */
            width: 100%;
            /* Lebar penuh container */
            border: 1px solid #d1d5db;
            /* Border abu muda */
            border-radius: 0.5rem;
            /* Sudut membulat 8px */
            margin-top: 0.5rem;
            /* Jarak atas 8px dari tombol */
            padding: 0.5rem;
            /* Padding dalam 8px */
            font-size: 0.875rem;
            /* Ukuran font kecil */
            color: #374151;
            /* Warna teks abu gelap */
        }

        .message-textarea:focus {
            /* Styling saat textarea fokus */
            outline: none;
            /* Hilangkan outline biru default */
            background: #ffffff;
            /* Background putih */
            border-color: #7B0D1E;
            /* Border berubah jadi merah marun */
            box-shadow: 0 0 0 1px #7B0D1E33;
            /* Efek ring merah marun tipis */
        }

        /* INPUT TEXT */
        .input-text {
            /* Input teks umum (nama penerima, dll.) */
            width: 100%;
            /* Lebar penuh container */
            border: 1px solid #d1d5db;
            /* Border abu muda */
            border-radius: 0.5rem;
            /* Sudut membulat 8px */
            padding: 0.5rem;
            /* Padding dalam 8px */
            color: #374151;
            /* Warna teks abu gelap */
        }

        .input-text:focus {
            /* Efek fokus pada input teks */
            outline: none;
            /* Hilangkan outline default */
            border-color: #7B0D1E;
            /* Border berubah jadi merah marun */
            box-shadow: 0 0 0 1px #7B0D1E33;
            /* Ring merah marun lembut */
        }

        /* LOKASI */
        .location-text {
            /* Teks alamat lokasi pengambilan */
            color: #4b5563;
            /* Warna abu gelap */
            font-size: 0.875rem;
            /* Ukuran font kecil 14px */
            margin: 0;
            /* Hilangkan margin default paragraf */
        }

        /* DROPZONE / UPLOAD KTP */
        .dropzone {
            /* Area drag & drop upload KTP */
            border: 2px dashed #d1d5db;
            /* Border garis putus-putus abu muda */
            border-radius: 0.75rem;
            /* Sudut membulat 12px */
            display: flex;
            /* Gunakan flexbox */
            flex-direction: column;
            /* Susun konten secara vertikal */
            align-items: center;
            /* Rata tengah horizontal */
            justify-content: center;
            /* Rata tengah vertikal */
            padding: 2.5rem 1rem;
            /* Padding vertikal besar 40px, horizontal 16px */
            background: #f9fafb;
            /* Background abu sangat muda */
            cursor: pointer;
            /* Menunjukkan bahwa area bisa diklik */
            transition: border-color 0.2s ease, background-color 0.2s ease;
            /* Transisi halus untuk perubahan warna */
        }

        .dropzone.hover {
            /* Kelas tambahan saat dropzone dalam keadaan hover via JS */
            border-color: #7B0D1E;
            /* Border berubah jadi merah marun */
            background: #ffffff;
            /* Background jadi putih */
        }

        .dropzone-circle {
            /* Lingkaran ikon upload di dalam dropzone */
            width: 4rem;
            /* Lebar 64px */
            height: 4rem;
            /* Tinggi 64px */
            border-radius: 9999px;
            /* Membuat bentuk lingkaran penuh */
            border: 1px solid #d1d5db;
            /* Border abu muda */
            display: flex;
            /* Gunakan flexbox */
            align-items: center;
            /* Rata tengah vertikal */
            justify-content: center;
            /* Rata tengah horizontal */
            margin-bottom: 0.75rem;
            /* Jarak bawah 12px */
            background: #ffffff;
            /* Background putih */
        }

        .dropzone-title {
            /* Judul teks utama di dropzone */
            color: #6b7280;
            /* Warna abu-abu */
            font-size: 0.875rem;
            /* Ukuran font kecil 14px */
            margin-bottom: 0.25rem;
            /* Jarak bawah 4px */
        }

        .dropzone-subtitle {
            /* Teks kecil penjelasan format file di dropzone */
            color: #9ca3af;
            /* Warna abu lebih terang */
            font-size: 0.75rem;
            /* Ukuran font sangat kecil (12px) */
            margin-bottom: 0.75rem;
            /* Jarak bawah 12px */
            text-align: center;
            /* Teks rata tengah */
        }

        .btn-choose-file {
            /* Tombol "Pilih File" di dalam label */
            background: #7B0D1E;
            /* Background merah marun */
            color: #ffffff;
            /* Teks putih */
            padding: 0.5rem 1rem;
            /* Padding vertikal 8px, horizontal 16px */
            border-radius: 0.5rem;
            /* Sudut membulat 8px */
            border: none;
            /* Tanpa border tambahan */
            font-size: 0.875rem;
            /* Ukuran font kecil 14px */
            cursor: pointer;
            /* Cursor pointer */
            transition: background-color 0.2s ease;
            /* Transisi perubahan warna background */
        }

        .btn-choose-file:hover {
            /* Efek hover pada tombol pilih file */
            background: #5d0a17;
            /* Background merah marun yang lebih gelap */
        }

        .preview-container {
            /* Wrapper untuk area preview gambar KTP */
            margin-top: 1rem;
            /* Jarak atas 16px dari dropzone */
        }

        .preview-layout {
            /* Layout dalam preview (gambar + tombol aksi) */
            display: flex;
            /* Menggunakan flexbox */
            flex-direction: column;
            /* Default susunan vertikal di mobile */
            align-items: flex-start;
            /* Rata kiri untuk konten */
            gap: 1rem;
            /* Jarak antar elemen 16px */
        }

        @media (min-width: 640px) {

            /* Media query layar >= 640px */
            .preview-layout {
                /* Mengubah layout preview di layar besar */
                flex-direction: row;
                /* Susunan jadi horizontal */
            }
        }

        .preview-image {
            /* Gambar preview KTP */
            width: 100%;
            /* Lebar penuh container di mobile */
            max-width: 24rem;
            /* Lebar maksimum 384px */
            border-radius: 0.5rem;
            /* Sudut membulat 8px */
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            /* Bayangan halus */
        }

        .preview-actions {
            /* Kolom untuk tombol Ganti/Hapus di preview */
            display: flex;
            /* Gunakan flexbox */
            flex-direction: column;
            /* Susunan vertikal */
            gap: 0.5rem;
            /* Jarak antar tombol 8px */
        }

        .btn-outline {
            /* Tombol outline (Ganti KTP) */
            padding: 0.5rem 1rem;
            /* Padding vertikal 8px, horizontal 16px */
            background: #ffffff;
            /* Background putih */
            border: 1px solid #d1d5db;
            /* Border abu muda */
            color: #374151;
            /* Warna teks abu gelap */
            border-radius: 0.5rem;
            /* Sudut membulat 8px */
            font-size: 0.875rem;
            /* Ukuran font kecil 14px */
            font-weight: 500;
            /* Ketebalan sedang */
            display: inline-flex;
            /* Inline-flex agar tombol menyesuaikan konten */
            align-items: center;
            /* Vertikal rata tengah */
            gap: 0.5rem;
            /* Jarak antar isi di dalam tombol 8px */
            cursor: pointer;
            /* Cursor pointer */
            transition: border-color 0.2s ease, background-color 0.2s ease;
            /* Transisi halus border dan background */
        }

        .btn-outline:hover {
            /* Efek hover pada tombol outline */
            border-color: #7B0D1E;
            /* Border berubah jadi merah marun */
            background: rgba(123, 13, 30, 0.05);
            /* Background diberi sedikit warna marun transparan */
        }

        .btn-danger {
            /* Tombol berwarna merah (Hapus KTP) */
            padding: 0.5rem 1rem;
            /* Padding vertikal 8px, horizontal 16px */
            background: #7B0D1E;
            /* Background merah marun */
            color: #ffffff;
            /* Teks putih */
            border-radius: 0.5rem;
            /* Sudut membulat 8px */
            font-size: 0.875rem;
            /* Ukuran font kecil */
            font-weight: 500;
            /* Ketebalan sedang */
            border: none;
            /* Tanpa border tambahan */
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
            /* Bayangan sedikit lebih tegas */
            cursor: pointer;
            /* Cursor pointer */
            transition: background-color 0.2s ease, transform 0.1s ease;
            /* Transisi warna dan efek scale */
        }

        .btn-danger:hover {
            /* Efek hover pada tombol merah */
            background: #5d0a17;
            /* Background lebih gelap */
        }

        .btn-danger:active {
            /* Efek ketika tombol merah ditekan */
            transform: scale(0.95);
            /* Sedikit mengecil saat diklik */
        }

        /* METODE PEMBAYARAN */
        .payment-options {
            /* Wrapper untuk daftar metode pembayaran */
            display: flex;
            /* Menggunakan flexbox */
            flex-direction: column;
            /* Susun pilihan secara vertikal */
            gap: 0.75rem;
            /* Jarak antar opsi 12px */
        }

        .payment-option {
            /* Card untuk tiap metode pembayaran */
            display: flex;
            /* Susun label & radio button secara horizontal */
            align-items: center;
            /* Vertikal rata tengah */
            justify-content: space-between;
            /* Label di kiri, radio di kanan */
            border: 1px solid #e5e7eb;
            /* Border abu muda */
            padding: 0.75rem;
            /* Padding dalam 12px */
            border-radius: 0.75rem;
            /* Sudut membulat 12px */
            cursor: pointer;
            /* Bisa diklik di mana saja */
            transition: border-color 0.2s ease;
            /* Transisi perubahan warna border */
        }

        .payment-option:hover {
            /* Efek hover pada card metode pembayaran */
            border-color: #7B0D1E;
            /* Border berubah jadi merah marun */
        }

        .payment-label {
            /* Wrapper label teks & ikon pembayaran */
            display: flex;
            /* Susun ikon & teks horizontal */
            align-items: center;
            /* Vertikal rata tengah */
            gap: 0.5rem;
            /* Jarak antar ikon dan teks 8px */
            font-weight: 500;
            /* Teks agak tebal */
            color: #374151;
            /* Warna teks abu gelap */
        }

        .payment-radio {
            /* Input radio untuk metode pembayaran */
            width: 1.25rem;
            /* Lebar 20px */
            height: 1.25rem;
            /* Tinggi 20px */
        }

        /* RINCIAN PEMBAYARAN */
        .rincian-list {
            /* Wrapper daftar baris rincian pembayaran */
            display: flex;
            /* Menggunakan flexbox */
            flex-direction: column;
            /* Susun baris secara vertikal */
            gap: 0.5rem;
            /* Jarak antar baris 8px */
            color: #374151;
            /* Warna teks abu gelap */
            font-size: 0.875rem;
            /* Ukuran font kecil 14px */
        }

        .rincian-row {
            /* Baris untuk label dan nilai rincian */
            display: flex;
            /* Susun label dan nilai secara horizontal */
            justify-content: space-between;
            /* Label di kiri, nilai di kanan */
        }

        .rincian-total {
            /* Styling khusus baris total pembayaran */
            font-weight: 600;
            /* Teks lebih tebal */
            border-top: 1px solid #e5e7eb;
            /* Garis pemisah di atas total */
            padding-top: 0.5rem;
            /* Padding atas 8px */
        }

        /* TOMBOL SUBMIT */
        .submit-row {
            /* Wrapper untuk tombol submit di bagian bawah */
            display: flex;
            /* Menggunakan flexbox */
            justify-content: flex-end;
            /* Posisi tombol di ujung kanan */
            align-items: center;
            /* Vertikal rata tengah */
            margin-top: 1rem;
            /* Jarak atas 16px */
            padding-bottom: 2.5rem;
            /* Padding bawah 40px agar tidak terlalu mepet tepi layar */
        }

        .btn-submit {
            /* Tombol kirim form "Buat Pesanan" */
            background: #7B0D1E;
            /* Background merah marun */
            color: #ffffff;
            /* Teks putih */
            font-weight: 500;
            /* Teks agak tebal */
            padding: 0.5rem 1.5rem;
            /* Padding vertikal 8px, horizontal 24px */
            border-radius: 0.5rem;
            /* Sudut membulat 8px */
            border: none;
            /* Tanpa border */
            cursor: pointer;
            /* Cursor pointer */
            transition: background-color 0.2s ease;
            /* Transisi perubahan warna background */
        }

        .btn-submit:hover {
            /* Efek hover pada tombol submit */
            background: #5d0a17;
            /* Background lebih gelap */
        }
    </style> <!-- Akhir blok CSS -->
</head>

<body class="bg-gray-50 min-h-screen">
    @php /* Blok PHP untuk menyiapkan data sebelum ditampilkan di view */
    $first = ($items ?? [])[0] ?? null; // Ambil elemen pertama dari array $items (jika ada), jika tidak ada nilainya null

    $tanggalMulaiSewa = $tanggalMulaiSewa ?? ($first['mulai'] ?? null); // Isi tanggal mulai sewa dari variabel atau dari item pertama, fallback null
    $tanggalPengembalian = $tanggalPengembalian ?? ($first['akhir'] ?? null); // Isi tanggal pengembalian dari variabel atau item pertama, fallback null
    $jumlah = $jumlah ?? ($first['jumlah'] ?? 1); // Isi jumlah sewa, default 1 jika belum terisi
    $durasi = $durasi ?? ($first['durasi'] ?? 1); // Isi durasi sewa dalam hari, default 1

    if (!isset($produk) && $first) { // Jika objek $produk belum ada tapi data $first tersedia
    $produk = (object) [ // Buat objek stdClass untuk menyimpan info produk
    'id_produk' => $first['id_produk'] ?? null, // ID produk dari item pertama, atau null
    'nama_produk' => $first['nama'] ?? 'Produk', // Nama produk, default "Produk" jika tidak ada
    'gambar' => $first['gambar'] ?? 'produk/placeholder.png', // Path gambar, default placeholder jika kosong
    'harga' => $first['harga'] ?? 0, // Harga satuan produk, default 0
    'jumlah' => $first['jumlah'] ?? 1, // Jumlah sewa, default 1
    ]; // Akhir pembuatan objek produk
    } // Akhir if pengecekan $produk & $first

    $biaya_layanan = $biaya_layanan ?? 1000; // Set biaya layanan default 1000 jika belum diisi

    if (!isset($total_produk)) { // Jika total produk belum dihitung sebelumnya
    if (!empty($items)) { // Jika ada banyak item di keranjang ($items tidak kosong)
    $total_produk = array_sum(array_map(fn($it) => (int) ($it['subtotal'] ?? 0), $items)); // Jumlahkan semua subtotal tiap item
    } elseif (isset($produk)) { // Jika tidak ada $items tapi ada satu $produk
    $total_produk = (int) ($produk->harga ?? 0) * (int) $jumlah * (int) $durasi; // Hitung total produk = harga x jumlah x durasi
    } else { // Jika tidak ada data produk sama sekali
    $total_produk = 0; // Set total produk menjadi 0
    } // Akhir else
    } // Akhir if !isset($total_produk)

    $total_pembayaran = $total_pembayaran ?? ($total_produk + (int) $biaya_layanan); // Hitung total pembayaran dengan menambah biaya layanan

    $isMulti = count($items ?? []) > 1; // Flag boolean untuk cek apakah ini pesanan multi-produk
    $formAction = $isMulti ? route('pemesanan.confirm') : route('pemesanan.store'); // Tentukan aksi form: konfirmasi (multi) atau langsung simpan (single)

    $gambarProdukPath = isset($produk->gambar) && $produk->gambar // Cek apakah produk punya path gambar yang valid
    ? 'storage/' . ltrim($produk->gambar, '/') // Jika ada, gabungkan dengan 'storage/' dan hilangkan slash pertama
    : 'storage/produk/placeholder.png'; // Jika tidak, pakai gambar placeholder default
    @endphp <!-- Akhir blok PHP persiapan data -->

    <!-- Header Sticky -->
    <header class="bb-header"> <!-- Elemen header utama di bagian atas halaman -->
        <div class="bb-header-inner"> <!-- Wrapper konten header, mengatur lebar dan posisi -->
            <button onclick="window.history.back()" class="bb-header-back" aria-label="Kembali"> <!-- Tombol kembali, ketika diklik akan kembali ke halaman sebelumnya -->
                <span class="iconify" data-icon="mdi:chevron-left"></span> <!-- Ikon panah kiri dari Iconify -->
            </button>
            <h1 class="bb-header-title">Pemesanan</h1> <!-- Judul halaman yang tampil di header -->
        </div>
    </header>

    @if ($errors->any()) <!-- Blade: jika terdapat error validasi di session -->
    <div class="alert-error"> <!-- Container untuk menampilkan pesan error -->
        <ul class="list-error"> <!-- List bullet untuk menampilkan tiap pesan error -->
            @foreach ($errors->all() as $error) <!-- Loop semua error yang ada -->
            <li>{{ $error }}</li> <!-- Tampilkan satu pesan error dalam item list -->
            @endforeach <!-- Akhir loop error -->
        </ul>
    </div>
    @endif <!-- Akhir kondisi if error validasi -->

    @if (session('error')) <!-- Blade: jika ada pesan error umum di session -->
    <div class="alert-error"> <!-- Container untuk pesan error dari session -->
        {{ session('error') }} <!-- Menampilkan isi pesan error dari session -->
    </div>
    @endif <!-- Akhir kondisi if session error -->

    <main class="bb-main"> <!-- Area utama konten halaman pemesanan -->
        <form id="formPemesanan" action="{{ $formAction }}" method="POST" enctype="multipart/form-data"> <!-- Form utama pemesanan, method POST & support upload file -->
            @csrf <!-- Token CSRF Laravel untuk melindungi dari CSRF attack -->

            <!-- PRODUK -->
            <div class="card-section"> <!-- Card pertama untuk informasi produk yang dipesan -->
                <div class="card-header"> <!-- Header card produk -->
                    <i class="bi bi-cart3 icon-section"></i> <!-- Ikon keranjang belanja menggunakan Bootstrap Icons -->
                    <h2 class="section-title">Produk:</h2> <!-- Judul bagian card: "Produk:" -->
                </div>

                @if (!$isMulti) <!-- Jika bukan mode multi item (berarti hanya 1 produk) -->
                {{-- SINGLE ITEM --}} <!-- Komentar Blade penanda bagian mode single item -->
                <div class="single-product-wrapper"> <!-- Wrapper kartu produk tunggal -->
                    <img src="{{ asset($gambarProdukPath) }}" alt="{{ $produk->nama_produk ?? 'Produk' }}"
                        class="product-image-single"> <!-- Gambar produk utama, dengan fallback alt "Produk" -->

                    <div class="product-main-info"> <!-- Kolom teks info utama produk -->
                        <h3 class="product-name">{{ $produk->nama_produk }}</h3> <!-- Nama produk yang dipesan -->

                        <div class="product-meta-row"> <!-- Baris info tanggal sewa -->
                            <span class="iconify" data-icon="mdi:calendar-range"></span> <!-- Ikon kalender range -->
                            <p> <!-- Paragraf berisi teks tanggal sewa -->
                                Tanggal sewa: <!-- Label teks "Tanggal sewa:" -->
                                {{ $tanggalMulaiSewa && $tanggalPengembalian
                                        ? \Carbon\Carbon::parse($tanggalMulaiSewa)->translatedFormat('d F Y') .
                                            ' - ' .
                                            \Carbon\Carbon::parse($tanggalPengembalian)->translatedFormat('d F Y')
                                        : '-' }} <!-- Jika tanggal mulai & akhir tersedia, format menjadi "dd NamaBulan YYYY - dd NamaBulan YYYY", jika tidak tampil "-" -->
                            </p>
                        </div>

                        <div class="product-meta-row"> <!-- Baris info durasi sewa -->
                            <span class="iconify" data-icon="mdi:clock-outline"></span> <!-- Ikon jam untuk durasi -->
                            <p>Durasi {{ (int) ($durasi ?? 1) }} hari</p> <!-- Tulis "Durasi X hari", default 1 hari jika kosong -->
                        </div>
                    </div>

                    <div class="product-price-box"> <!-- Kolom harga dan jumlah produk -->
                        <p class="price-single">
                            Rp{{ number_format($produk->harga, 0, ',', '.') }} <!-- Harga satuan produk dalam format rupiah (tanpa desimal, dengan pemisah ribuan) -->
                        </p>
                        <p class="qty-single">
                            x{{ $produk->jumlah ?? 1 }} <!-- Menampilkan jumlah unit produk yang disewa, default 1 -->
                        </p>
                    </div>
                </div>

                <div class="total-row"> <!-- Baris menampilkan total untuk mode single produk -->
                    <span>Total {{ $produk->jumlah ?? 1 }} Produk</span> <!-- Teks total jumlah unit produk -->
                    <span><strong>Rp{{ number_format($total_produk, 0, ',', '.') }}</strong></span> <!-- Teks total harga semua unit produk -->
                </div>

                {{-- Hidden single --}} <!-- Field tersembunyi yang ikut dikirim untuk mode single -->
                <input type="hidden" name="id_produk" value="{{ $produk->id_produk }}"> <!-- Hidden input ID produk -->
                <input type="hidden" name="jumlah_sewa" value="{{ $produk->jumlah ?? 1 }}"> <!-- Hidden input jumlah sewa -->
                <input type="hidden" name="tanggal_mulai_sewa" value="{{ $tanggalMulaiSewa }}"> <!-- Hidden input tanggal mulai sewa -->
                <input type="hidden" name="tanggal_pengembalian" value="{{ $tanggalPengembalian }}"> <!-- Hidden input tanggal pengembalian -->
                @else <!-- Jika $isMulti true, berarti mode multi item -->
                {{-- MULTI ITEM --}} <!-- Komentar Blade penanda bagian multi item -->
                <div class="multi-list-wrapper"> <!-- Wrapper daftar banyak produk -->
                    @foreach ($items as $idx => $it) <!-- Loop setiap item produk di array $items -->
                    @php /* Blok PHP untuk menentukan path gambar tiap item */
                    $img = isset($it['gambar']) && $it['gambar'] // Jika key 'gambar' ada dan tidak kosong
                    ? 'storage/' . ltrim($it['gambar'], '/') // Pakai path dari storage + gambar yang sudah di-trim
                    : 'storage/produk/placeholder.png'; // Jika tidak ada, gunakan placeholder default
                    @endphp <!-- Akhir blok PHP gambar item -->

                    <div class="multi-product-card"> <!-- Kartu satu produk dalam mode multi item -->
                        <img src="{{ asset($img) }}" alt="{{ $it['nama'] ?? 'Produk' }}"
                            class="product-image-multi"> <!-- Gambar produk multi item dengan fallback alt "Produk" -->

                        <div class="product-main-info"> <!-- Kolom info utama produk multi -->
                            <h3 class="multi-product-name">{{ $it['nama'] }}</h3> <!-- Nama produk pada multi item -->

                            <div class="multi-product-meta"> <!-- Container info meta produk (tanggal & durasi) -->
                                <div class="product-meta-row"> <!-- Baris tanggal sewa produk -->
                                    <span class="iconify" data-icon="mdi:calendar-range"></span> <!-- Ikon kalender -->
                                    <span> <!-- Span text tanggal mulai dan akhir -->
                                        {{ \Carbon\Carbon::parse($it['mulai'])->translatedFormat('d F Y') }} <!-- Tanggal mulai sewa produk diformat lokal -->
                                        - <!-- Separator antara tanggal mulai dan akhir -->
                                        {{ \Carbon\Carbon::parse($it['akhir'])->translatedFormat('d F Y') }} <!-- Tanggal akhir sewa produk diformat lokal -->
                                    </span>
                                </div>
                                <div class="product-meta-row"> <!-- Baris durasi sewa produk -->
                                    <span class="iconify" data-icon="mdi:clock-outline"></span> <!-- Ikon jam -->
                                    <span>Durasi {{ $it['durasi'] }} hari</span> <!-- Teks "Durasi X hari" sesuai item -->
                                </div>
                            </div>
                        </div>

                        <div class="product-price-box"> <!-- Kolom harga dan subtotal produk multi -->
                            <p class="price-single">
                                Rp{{ number_format($it['harga'], 0, ',', '.') }} <!-- Harga satuan produk tersebut -->
                            </p>
                            <p class="qty-single">
                                x{{ $it['jumlah'] }} <!-- Jumlah unit produk tersebut -->
                            </p>
                            <p class="subtotal-text">
                                Rp{{ number_format($it['subtotal'], 0, ',', '.') }} <!-- Subtotal produk (harga x jumlah x durasi) -->
                            </p>
                        </div>
                    </div>

                    {{-- Hidden per item --}} <!-- Field tersembunyi per item agar detailnya terkirim -->
                    <input type="hidden" name="items[{{ $idx }}][id_produk]"
                        value="{{ $it['id_produk'] }}"> <!-- Hidden input ID produk untuk item ini -->
                    <input type="hidden" name="items[{{ $idx }}][jumlah]" value="{{ $it['jumlah'] }}"> <!-- Hidden jumlah sewa item -->
                    <input type="hidden" name="items[{{ $idx }}][mulai]" value="{{ $it['mulai'] }}"> <!-- Hidden tanggal mulai sewa item -->
                    <input type="hidden" name="items[{{ $idx }}][akhir]" value="{{ $it['akhir'] }}"> <!-- Hidden tanggal akhir sewa item -->
                    @endforeach <!-- Akhir loop semua item -->
                </div>

                @php /* Hitung total quantity semua produk pada mode multi */
                $totalQty = array_sum(array_map(fn($i) => (int) ($i['jumlah'] ?? 0), $items)); // Menjumlahkan semua jumlah item di array $items
                @endphp <!-- Akhir blok PHP totalQty -->

                <div class="total-row section-spacing-top"> <!-- Baris total semua produk pada mode multi -->
                    <span>Total {{ $totalQty }} Produk</span> <!-- Tampilkan total jumlah produk dari semua item -->
                    <span><strong>Rp{{ number_format($total_produk, 0, ',', '.') }}</strong></span> <!-- Tampilkan total harga semua produk -->
                </div>
                @endif <!-- Akhir kondisi if/else mode single atau multi -->

                {{-- PESAN TAMBAHAN --}} <!-- Komentar Blade untuk penanda bagian pesan tambahan -->
                <div class="message-container"> <!-- Container bagian pesan tambahan -->
                    <button type="button" id="togglePesan" class="message-toggle-btn"> <!-- Tombol untuk toggle textarea pesan -->
                        <span class="iconify" data-icon="mdi:message-text-outline"></span> <!-- Ikon pesan/komentar -->
                        Tinggalkan Pesan <!-- Teks pada tombol -->
                    </button>

                    <textarea id="pesanTextarea" name="catatan_tambahan"
                        class="message-textarea hidden"
                        placeholder="Tambahkan catatan (opsional)"></textarea> <!-- Textarea untuk catatan opsional, awalnya tersembunyi -->
                </div>
            </div>

            <!-- NAMA PENERIMA -->
            <div class="card-section"> <!-- Card untuk input nama penerima -->
                <div class="card-header"> <!-- Header card nama penerima -->
                    <span class="iconify icon-section" data-icon="mdi:account-outline"></span> <!-- Ikon akun/user -->
                    <h2 class="section-title">Nama Penerima</h2> <!-- Judul card "Nama Penerima" -->
                </div>

                <input type="text" id="namaPenerima" name="nama_penerima"
                    class="input-text"
                    placeholder="Masukkan nama penerima" required> <!-- Input teks nama penerima, wajib diisi -->
            </div>

            <!-- LOKASI PENGAMBILAN -->
            <div class="card-section"> <!-- Card untuk menunjukkan lokasi pengambilan barang -->
                <div class="card-header"> <!-- Header card lokasi -->
                    <span class="iconify icon-section" data-icon="mdi:map-marker-outline"></span> <!-- Ikon pin lokasi -->
                    <h2 class="section-title">Lokasi Pengambilan</h2> <!-- Judul card "Lokasi Pengambilan" -->
                </div>

                <p class="location-text">
                    Sumampir Kulon, Sumampir, Purwokerto Utara, Kabupaten Banyumas, Jawa Tengah 53125
                </p> <!-- Paragraf menampilkan alamat lokasi pengambilan yang fix -->

                <input type="hidden" name="lokasi_pengambilan"
                    value="Sumampir Kulon, Sumampir, Purwokerto Utara, Kabupaten Banyumas, Jawa Tengah 53125"> <!-- Hidden input untuk mengirimkan alamat lokasi pengambilan ke server -->
            </div>

            <!-- UPLOAD KTP -->
            <div class="card-section"> <!-- Card untuk fitur upload KTP -->
                <div class="card-header"> <!-- Header card upload KTP -->
                    <span class="iconify icon-section" data-icon="mdi:upload-outline"></span> <!-- Ikon upload -->
                    <h2 class="section-title">Upload KTP</h2> <!-- Judul card "Upload KTP" -->
                </div>

                <div id="dropZone" class="dropzone"> <!-- Area drag & drop upload file KTP -->
                    <div class="dropzone-circle"> <!-- Lingkaran yang berisi ikon upload -->
                        <span class="iconify" data-icon="mdi:upload" style="font-size: 1.75rem; color:#9ca3af;"></span> <!-- Ikon upload dengan ukuran besar dan warna abu -->
                    </div>
                    <p class="dropzone-title">Upload KTP Anda</p> <!-- Teks judul dropzone -->
                    <p class="dropzone-subtitle">
                        Drag &amp; drop KTP ke sini atau klik untuk memilih<br>Mendukung PNG &amp; JPG
                    </p> <!-- Teks instruksi format file dan cara upload -->

                    <label> <!-- Label yang membungkus tombol pilih file & input file -->
                        <span class="btn-choose-file">Pilih File</span> <!-- Tombol visual untuk memilih file -->
                        <input id="fileInput" type="file" name="ktp" class="hidden" accept=".png,.jpg,.jpeg"
                            required> <!-- Input file asli (disembunyikan), menerima PNG/JPG/JPEG dan wajib diisi -->
                    </label>
                </div>

                <div id="previewContainer" class="preview-container hidden"> <!-- Container preview KTP yang di-upload, awalnya hidden -->
                    <div class="preview-layout"> <!-- Layout yang berisi gambar preview dan tombol aksi -->
                        <img id="previewImage" src="" alt="Preview KTP" class="preview-image"> <!-- Elemen img untuk menampilkan preview KTP -->

                        <div class="preview-actions"> <!-- Kolom tombol aksi terhadap file KTP -->
                            <button type="button" id="btnGanti" class="btn-outline"> <!-- Tombol untuk mengganti file KTP -->
                                Ganti KTP <!-- Teks tombol ganti -->
                            </button>
                            <button type="button" id="btnHapus" class="btn-danger"> <!-- Tombol untuk menghapus file KTP yang sudah diupload -->
                                Hapus KTP <!-- Teks tombol hapus -->
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- METODE PEMBAYARAN -->
            <div class="card-section"> <!-- Card untuk memilih metode pembayaran -->
                <div class="card-header"> <!-- Header card metode pembayaran -->
                    <span class="iconify icon-section" data-icon="mdi:credit-card-outline"></span> <!-- Ikon kartu kredit -->
                    <h2 class="section-title">Metode Pembayaran</h2> <!-- Judul card "Metode Pembayaran" -->
                </div>

                <div class="payment-options"> <!-- Wrapper untuk daftar opsi pembayaran -->
                    <label class="payment-option"> <!-- Opsi pembayaran pertama: COD -->
                        <span class="payment-label"> <!-- Label teks & ikon COD -->
                            <span class="iconify" data-icon="mdi:truck-delivery-outline"
                                style="color:#6b7280; font-size:1.1rem;"></span> <!-- Ikon truk pengiriman untuk menggambarkan COD -->
                            Bayar di Tempat (COD) <!-- Teks label metode pembayaran COD -->
                        </span>
                        <input type="radio" name="metode_pembayaran" value="cod" class="payment-radio"> <!-- Radio button untuk memilih COD -->
                    </label>

                    <label class="payment-option"> <!-- Opsi pembayaran kedua: Midtrans (Online) -->
                        <span class="payment-label"> <!-- Label teks & ikon pembayaran online -->
                            <span class="iconify" data-icon="mdi:credit-card-scan-outline"
                                style="color:#7B0D1E; font-size:1.1rem;"></span> <!-- Ikon kartu kredit scan untuk online payment -->
                            Bayar Online (Midtrans) <!-- Teks label metode pembayaran online -->
                        </span>
                        <input type="radio" name="metode_pembayaran" value="midtrans" class="payment-radio"
                            required> <!-- Radio button untuk Midtrans, wajib salah satu dipilih sebelum submit -->
                    </label>
                </div>
            </div>

            <!-- RINCIAN PEMBAYARAN -->
            <div class="card-section"> <!-- Card untuk rincian perhitungan biaya -->
                <div class="card-header"> <!-- Header card rincian pembayaran -->
                    <span class="iconify icon-section" data-icon="mdi:cash-multiple"></span> <!-- Ikon uang kertas -->
                    <h2 class="section-title">Rincian Pembayaran</h2> <!-- Judul card "Rincian Pembayaran" -->
                </div>

                <div class="rincian-list"> <!-- Wrapper daftar baris rincian biaya -->
                    <div class="rincian-row"> <!-- Baris untuk subtotal pesanan -->
                        <span>Subtotal Pesanan</span> <!-- Label "Subtotal Pesanan" -->
                        <span>Rp{{ number_format($total_produk, 0, ',', '.') }}</span> <!-- Nilai subtotal semua produk -->
                    </div>
                    <div class="rincian-row"> <!-- Baris untuk biaya layanan -->
                        <span>Biaya Layanan</span> <!-- Label "Biaya Layanan" -->
                        <span>Rp{{ number_format($biaya_layanan, 0, ',', '.') }}</span> <!-- Nilai biaya layanan (misalnya Rp 1.000) -->
                    </div>
                    <div class="rincian-row rincian-total"> <!-- Baris untuk total pembayaran (subtotal + biaya layanan) -->
                        <span>Total Pembayaran</span> <!-- Label "Total Pembayaran" -->
                        <span>Rp{{ number_format($total_pembayaran, 0, ',', '.') }}</span> <!-- Nilai total semua yang harus dibayar -->
                    </div>
                </div>
            </div>

            <!-- TOMBOL -->
            <div class="submit-row"> <!-- Wrapper untuk tombol submit di bagian bawah -->
                <button type="submit" class="btn-submit"> <!-- Tombol submit form pemesanan -->
                    Buat Pesanan <!-- Teks di tombol submit -->
                </button>
            </div>
        </form>
    </main>

    <script>
        const toggleBtn = document.getElementById('togglePesan');
        const pesanTextarea = document.getElementById('pesanTextarea');
        toggleBtn?.addEventListener('click', () => {
            pesanTextarea.classList.toggle('hidden');
            if (!pesanTextarea.classList.contains('hidden')) pesanTextarea.focus();
        });

        // === Upload KTP ===
        let sedangGantiKTP = false;
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('fileInput');
        const previewContainer = document.getElementById('previewContainer');
        const previewImage = document.getElementById('previewImage');
        const btnGanti = document.getElementById('btnGanti');
        const btnHapus = document.getElementById('btnHapus');

        function handleSelectedFile(file) {
            if (!file) return;
            if (!['image/png', 'image/jpeg', 'image/jpg'].includes(file.type)) {
                alert('Hanya mendukung format PNG atau JPG.');
                return;
            }
            const reader = new FileReader();
            reader.onload = e => {
                previewImage.src = e.target.result;
                dropZone.classList.add('hidden');
                previewContainer.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }

        fileInput?.addEventListener('change', function() {
            const file = this.files[0];
            if (file) handleSelectedFile(file);
        });

        dropZone?.addEventListener('dragover', e => {
            e.preventDefault();
            dropZone.classList.add('border-[#7B0D1E]', 'bg-white');
        });

        dropZone?.addEventListener('dragleave', e => {
            e.preventDefault();
            dropZone.classList.remove('border-[#7B0D1E]', 'bg-white');
        });

        dropZone?.addEventListener('drop', e => {
            e.preventDefault();
            dropZone.classList.remove('border-[#7B0D1E]', 'bg-white');
            const file = e.dataTransfer.files[0];
            if (file) {
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                fileInput.files = dataTransfer.files;
                handleSelectedFile(file);
            }
        });

        btnGanti?.addEventListener('click', () => {
            sedangGantiKTP = true;
            previewContainer.classList.add('hidden');
            dropZone.classList.remove('hidden');
            fileInput.value = null;
            setTimeout(() => fileInput.click(), 50);
        });

        dropZone?.addEventListener('click', (e) => {
            if (e.target.tagName.toLowerCase() === 'label' || e.target.tagName.toLowerCase() === 'input') return;
            if (!sedangGantiKTP) fileInput.click();
            sedangGantiKTP = false;
        });

        btnHapus?.addEventListener('click', () => {
            fileInput.value = '';
            previewImage.src = '';
            previewContainer.classList.add('hidden');
            dropZone.classList.remove('hidden');
        });

        document.getElementById('formPemesanan').addEventListener('submit', function(e) {
            if (!fileInput.files.length) {
                e.preventDefault();
                alert('Silakan upload foto KTP terlebih dahulu.');
            }
        });

        if (fileInput.files && fileInput.files[0]) {
            handleSelectedFile(fileInput.files[0]);
        }
    </script>
</body>

</html>