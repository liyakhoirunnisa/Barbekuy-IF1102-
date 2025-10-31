<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu | Barbekuy</title>

  {{-- Bootstrap CSS --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #fff;
      color: #000;
    }

    h2 {
      color: #000000;
      font-weight: 800;
      font-size: 2rem;
      text-align: center;
      margin: 50px 0 60px 0;
    }

    .judul-menu {
      display: inline-block;
      font-weight: 600;
      letter-spacing: 0.3px;
      margin: 0px 0 30px 0;
    }

    article {
      border: 1px solid #eee;
      border-radius: 16px;
      box-shadow: 0 3px 8px rgba(0,0,0,0.05);
      transition: transform 0.2s ease;
      padding: 20px;
      background-color: #fff;
      height: 100%; /* penting agar ikut tinggi kolom */
      display: flex;
      flex-direction: row; /* konten tetap horizontal */
      justify-content: space-between;
      align-items: center;
    }

    /* Bagian kiri card (teks produk) */
    article .flex-grow-1 {
      display: flex;
      flex-direction: column;
      height: 100%;
    }

    /* Deskripsi isi produk */
    article small.text-muted {
      text-align: justify;
      flex-grow: 1; /* biar deskripsi isi ruang tengah */
    }

    /* Tombol dan ikon selalu di bawah */
    article .d-flex.align-items-center.gap-2.mt-2 {
      margin-top: auto; /* posisi di bawah */
    }

    article:hover {
      transform: translateY(-4px);
    }

    article img {
      width: 110px;
      height: 110px;
      object-fit: contain;
      border-radius: 10px;
      background: #fafafa;
    }

    .badge-price {
      position: absolute;
      top: 6px;
      right: 6px;
      background-color: #751A25;
      color: white;
      font-size: 11px;
      padding: 2px 8px;
      border-radius: 10px;
    }

    /* Ikon keranjang */
    .ikon-keranjang {
      color: #751A25;
      text-decoration: none;
      transition: 0.3s;
    }

    .ikon-keranjang:hover {
      color: #9c2833;
    }

    /* Tombol utama Beli Sekarang (versi lebih kecil) */
    /* Tombol utama Beli Sekarang (ukuran sedang, pas proporsinya) */
    .btn-beli {
    background-color: #751A25 !important;
    color: #ffffff !important;
    border-radius: 6px;
    padding: 6px 14px; /* ukuran sedang */
    font-weight: 600;
    font-size: 0.9rem; /* sedikit lebih besar dari sebelumnya */
    border: none !important;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 2px 6px rgba(117, 26, 37, 0.25);
    display: inline-block;
    line-height: 1.2;
    }

    .btn-beli:hover {
    background-color: #9c2833 !important;
    color: #ffffff !important;
    transform: translateY(-1px);
    box-shadow: 0 3px 8px rgba(117, 26, 37, 0.35);
    }



    /* Footer */
    footer {
      background-color: #751A25;
      color: white;
      padding: 30px 0;
      text-align: center;
    }

    footer a {
      color: white;
      text-decoration: none;
    }

    footer a:hover {
      text-decoration: underline;
    }

     article small.text-muted {
      text-align: justify;
    }
  </style>
</head>
<body>

  {{-- Navbar --}}
  @include('layouts.navbar')

  <div class="container mt-5 mb-5">
    <h2><span class="judul-menu">Pilih Paket Barbekuy<br>Sesuaikan dengan Selera Kamu</span></h2>

    <div class="row gy-4 align-items-stretch">
      @foreach ($produk as $item)
        <div class="col-md-6" display: flex;>
          <article class="d-flex align-items-center justify-content-between">
            <div class="flex-grow-1 me-3">
              <h5 class="fw-semibold mb-1">{{ $item->nama_produk }}</h5>
              <p class="fw-bold mb-1" style="color: #751A25;">Rp{{ number_format($item->harga, 0, ',', '.') }}</p>
              <small class="text-muted d-block mb-2">{{ $item->deskripsi }}</small>
              <div class="d-flex align-items-center gap-2 mt-2">
                <!-- Ikon Troli -->
                <button type="button" class="ikon-keranjang border-0 bg-transparent" data-produk="{{ $item->id_produk }}">
                  <i class="bi bi-cart3 fs-5"></i>
                </button>

                <!-- Tombol utama: Beli Sekarang -->
                <button type="button" class="btn-beli btn-tanggal" data-produk="{{ $item->id_produk }}">
                  Beli
                </button>
              </div>
            </div>

            <div class="position-relative">
              <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama_produk }}">
              <span class="badge-price">{{ number_format($item->harga/1000, 0) }}K</span>
            </div>
          </article>
        </div>
      @endforeach
    </div>

  </div>

  {{-- Footer --}}
  <footer id="kontak" style="background-color: #751A25; color: white; padding: 50px 0 20px 0;">
    <div class="container">
      <div class="row align-items-start mb-4">
        <!-- Logo -->
        <div class="col-md-4 text-center text-md-start mb-4 mb-md-0">
          <img src="{{ asset('images/logoputih.png') }}" alt="Barbekuy Logo" style="width: 160px;">
          <p class="mt-2 small mb-0">HOME SERVICE<br>TASTY • EASY • AFFORDABLE</p>
        </div>

        <!-- Jam Buka -->
        <div class="col-md-4 text-md-start mb-4 mb-md-0">
          <h6 class="fw-bold mb-2">Jam Buka Kami</h6>
          <p class="mb-0">Setiap Hari : 08.00 - 22.00 WIB</p>
        </div>

        <!-- Kontak Kami -->
        <div class="col-md-4 text-md-start">
          <h6 class="fw-bold mb-2">Kontak Kami</h6>
          <p class="mb-0">
            <a href="https://maps.app.goo.gl/2JV4KyWNrhMcZGN6A?g_st=aw" target="_blank" class="text-white text-decoration-none">
              Sumampir Kulon, Sumampir, Purwokerto Utara, Banyumas Regency, Central Java 53125
            </a><br>
            <a href="https://wa.me/6287746567500" target="_blank" class="text-white text-decoration-none d-flex align-items-center mt-1">
              <i class="bi bi-whatsapp me-2"></i>
              <span>+6287746567500</span>
            </a>
          </p>
        </div>
      </div>

      <hr style="border-top: 2px dotted #fff; margin: 30px 0;">

      <div class="d-flex justify-content-between align-items-center flex-column flex-md-row">
        <div class="mb-2 mb-md-0">
          <a href="https://instagram.com/barbekuy.purwokerto" target="_blank" class="text-white text-decoration-none d-flex align-items-center">
            <i class="bi bi-instagram me-2" style="font-size: 1.2rem;"></i>
            <span>@barbekuy.purwokerto</span>
          </a>
        </div>

        <div>
          <a href="{{ url('/chat') }}" class="text-white text-decoration-none d-flex align-items-center justify-content-center">
            <span class="me-2">Chat kami</span>
            <i class="bi bi-chat-dots"></i>
          </a>
        </div>
      </div>
    </div>
  </footer>

  {{-- Bootstrap JS --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  {{-- Modal Kalender --}}
  {{-- Modal Pilih Tanggal & Jumlah --}}
<div class="modal fade" id="calendarModal" tabindex="-1" aria-labelledby="calendarModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#751A25; color:white;">
        <h5 class="modal-title" id="calendarModalLabel">Pilih Detail Sewa</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body text-center">
        <p id="selectedItem" class="fw-semibold mb-3"></p>

        <div class="d-flex flex-column align-items-center gap-3 mb-3">
          <div class="w-75">
            <label class="form-label fw-semibold">Tanggal Mulai Sewa</label>
            <input type="date" id="tanggalMulaiSewa" class="form-control">
          </div>

          <div class="w-75">
            <label class="form-label fw-semibold">Tanggal Pengembalian</label>
            <input type="date" id="tanggalPengembalian" class="form-control">
          </div>

          <div class="w-75">
            <label class="form-label fw-semibold">Jumlah Barang</label>
            <input type="number" id="jumlahSewa" class="form-control" min="1" value="1">
          </div>
        </div>

        <div id="stokInfo"></div>
      </div>

      <div class="modal-footer d-flex justify-content-between">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn" style="background-color:#751A25; color:white;" onclick="cekStok()">Cek Stok</button>
      </div>
    </div>
  </div>
</div>


  {{-- Modal Notifikasi Sukses --}}
  <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content text-center border-0 shadow">
        <div class="modal-body py-5">
          <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
               style="width: 70px; height: 70px; background-color: #eaf8ec;">
            <i class="bi bi-check-circle-fill" style="font-size: 2.5rem; color: #28a745;"></i>
          </div>
          <h5 class="fw-bold mb-2">Pesanan Berhasil Ditambahkan!</h5>
          <p class="text-muted mb-4" id="successText">Item berhasil masuk ke keranjang Anda.</p>
          <button type="button" class="btn px-4" style="background-color:#751A25; color:white;"
                  data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>


 <script>
   const IS_LOGGED_IN = {{ auth()->check() ? 'true' : 'false' }};
  const LOGIN_URL = '{{ route('login') }}';
  let currentProdukId = '';
  let currentProdukNama = '';

  function bukaModalTanggal(idProduk, namaProduk) {
    currentProdukId = idProduk;
    currentProdukNama = namaProduk;

    document.getElementById('selectedItem').innerText = namaProduk;
    document.getElementById('stokInfo').innerHTML = '';
    document.getElementById('tanggalMulaiSewa').value = '';
    document.getElementById('tanggalPengembalian').value = '';
    document.getElementById('jumlahSewa').value = 1;

    new bootstrap.Modal(document.getElementById('calendarModal')).show();
  }

  document.querySelectorAll('.ikon-keranjang, .btn-tanggal').forEach(btn => {
    btn.addEventListener('click', function () {
      if (!IS_LOGGED_IN) {
        // arahkan ke page login
        window.location = LOGIN_URL;
        return;
      }
      const idProduk = this.getAttribute('data-produk');
      const namaProduk = this.closest('article').querySelector('h5').innerText;
      bukaModalTanggal(idProduk, namaProduk);
    });
  });


  // 🗓️ Fungsi format tanggal dari yyyy-mm-dd → dd-mm-yyyy
  function formatTanggal(tanggal) {
    if (!tanggal) return '';
    const [tahun, bulan, hari] = tanggal.split('-');
    return `${hari}-${bulan}-${tahun}`;
  }

  function cekStok() {
    const mulaiRaw = document.getElementById('tanggalMulaiSewa').value;
    const pengembalianRaw = document.getElementById('tanggalPengembalian').value;
    const jumlah = document.getElementById('jumlahSewa').value;
    const info = document.getElementById('stokInfo');

    if (!mulaiRaw || !pengembalianRaw) {
      info.innerHTML = `<div class="text-danger fw-semibold">Pilih kedua tanggal terlebih dahulu.</div>`;
      return;
    }
    if (new Date(pengembalianRaw) < new Date(mulaiRaw)) {
      info.innerHTML = `<div class="text-danger fw-semibold">Tanggal pengembalian tidak boleh sebelum tanggal sewa.</div>`;
      return;
    }

    // Format ke dd-mm-yyyy untuk ditampilkan
    const mulai = formatTanggal(mulaiRaw);
    const pengembalian = formatTanggal(pengembalianRaw);

    // Simulasi stok tersedia
    const tersedia = Math.random() > 0.2;

    if (tersedia) {
      info.innerHTML = `
        <div class="alert alert-success py-2">
          Stok tersedia untuk <strong>${mulai}</strong> s/d <strong>${pengembalian}</strong> (${jumlah} unit)
        </div>
        <button class="btn mt-2" style="background-color:#751A25; color:white;"
          onclick="tambahKeKeranjang('${currentProdukId}', '${mulaiRaw}', '${pengembalianRaw}', '${jumlah}')">
          Tambah ke Keranjang
        </button>`;
    } else {
      info.innerHTML = `
        <div class="alert alert-danger py-2">
          Maaf, stok habis untuk tanggal <strong>${mulai}</strong> - <strong>${pengembalian}</strong> 😢
        </div>`;
    }
  }

 function tambahKeKeranjang(idProduk, mulaiRaw, pengembalianRaw, jumlah) {
    const mulaiIndo = formatTanggal(mulaiRaw);
    const pengembalianIndo = formatTanggal(pengembalianRaw);

    fetch(`/keranjang/tambah/${idProduk}`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      credentials: 'same-origin',
      body: JSON.stringify({
        tanggal_mulai: mulaiRaw,
        tanggal_pengembalian: pengembalianRaw,
        jumlah: jumlah
      })
    })
    .then(async (res) => {
      // Redirect (belum login)
      if (res.redirected) { window.location = res.url; return; }
      if (res.status === 401 || res.status === 419) { window.location = LOGIN_URL; return; }

      const text = await res.text();
      let data = {};
      try { data = JSON.parse(text); } catch (_) {}

      if (!res.ok || data.success !== true) {
        throw new Error(data.message || 'Gagal menambahkan ke keranjang.');
      }

      // ✅ sukses
      bootstrap.Modal.getInstance(document.getElementById('calendarModal')).hide();
      new bootstrap.Modal(document.getElementById('successModal')).show();
      document.getElementById('successText').innerText =
        `Sewa dari ${mulaiIndo} sampai ${pengembalianIndo} (${jumlah} unit) berhasil ditambahkan ke keranjang.`;

      // 🔄 update badge langsung
      if (data.count != null) {
        const badge = document.getElementById('cart-badge');
        if (badge) {
          badge.textContent = data.count;
          // tampilkan/sembunyikan sesuai count
          badge.style.display = Number(data.count) > 0 ? 'inline-block' : 'none';
        }
      }
    })
    .catch(() => alert('Terjadi kesalahan saat menambahkan ke keranjang.'));
  }
</script>
</body>
</html>