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
    html,
    body {
      margin: 0;
      padding: 0;
    }

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
      margin: 30px 0 10px 0;
    }

    .judul-menu {
      display: inline-block;
      font-weight: 600;
      letter-spacing: 0.3px;
      margin: 0 0 30px 0;
    }

    /* ============================
     CARD MENU – LAYOUT DESKTOP
     ============================ */
    article {
      border: 1px solid #eee;
      border-radius: 16px;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
      background-color: #fff;
      padding: 20px;
      height: 100%;

      display: grid;
      grid-template-columns: 1fr auto;
      grid-template-rows: auto auto auto auto;
      /* ⬇ Desktop: title → desc → price → actions */
      grid-template-areas:
        "title   image"
        "desc    image"
        "price   image"
        "actions image";
      column-gap: 18px;
      align-items: center;

      transition: transform 0.2s ease;
    }

    article:hover {
      transform: translateY(-4px);
    }

    /* mapping area grid */
    .menu-title {
      grid-area: title;
    }

    .menu-price {
      grid-area: price;
    }

    .menu-desc {
      grid-area: desc;
    }

    .menu-actions {
      grid-area: actions;
    }

    .menu-image {
      grid-area: image;
    }

    .menu-desc {
      text-align: justify;
    }

    /* gambar di dalam card */
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

    .ikon-keranjang {
      color: #751A25;
      text-decoration: none;
      transition: 0.3s;
    }

    .ikon-keranjang:hover {
      color: #9c2833;
    }

    .btn-beli {
      background-color: #751A25 !important;
      color: #ffffff !important;
      border-radius: 6px;
      padding: 6px 14px;
      font-weight: 600;
      font-size: 0.9rem;
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

    /* ============================
     PADDING RESPONSIVE (bukan desktop)
     ============================ */
    @media (max-width: 992px) {
      .responsive-padding {
        padding-left: 18px !important;
        padding-right: 18px !important;
      }
    }

    /* ============================
     LAYAR ≤ 768px (HP)
     Urutan: nama → gambar → deskripsi → harga → tombol
     ============================ */
    @media (max-width: 768px) {

      h2 {
        font-size: 1.6rem;
        margin: 30px 0 40px 0;
      }

      article {
        grid-template-columns: 1fr;
        grid-template-areas:
          "title"
          "image"
          "desc"
          "price"
          "actions";
        text-align: center;
        padding: 15px;
      }

      .menu-image {
        justify-self: center;
        margin: 8px 0;
      }

      article img {
        width: 120px;
        height: 120px;
      }

      .menu-title {
        font-size: 1.1rem;
      }

      .menu-desc {
        text-align: center !important;
        margin-bottom: 6px;
      }

      .menu-price {
        margin-bottom: 8px;
        justify-self: center;
      }

      .menu-actions {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        margin-top: 4px;
      }

      .badge-price {
        top: 8px;
        right: 8px;
        font-size: 0.75rem;
        padding: 3px 6px;
      }

      .col-md-6 {
        width: 100%;
      }
    }

    /* ============================
     LAYAR SANGAT KECIL (≤ 430px)
     ============================ */
    @media (max-width: 430px) {

      article img {
        width: 100px;
        height: 100px;
      }

      .btn-beli {
        padding: 6px 12px;
        font-size: 0.85rem;
      }

      .ikon-keranjang i {
        font-size: 1.3rem;
      }
    }
  </style>


</head>

<body>

  {{-- Navbar --}}
  @include('layouts.navbar')

  <div class="container mt-5 mb-5 responsive-padding">
    <h2><span class="judul-menu">Pilih Paket Barbekuy<br>Sesuaikan dengan Selera Kamu</span></h2>

    <div class="row gy-4 align-items-stretch">
      @foreach ($produk as $item)
      <div class="col-md-6">
        <article>
          <!-- NAMA PAKET -->
          <h5 class="fw-semibold mb-1 menu-title">
            {{ $item->nama_produk }}
          </h5>

          <!-- DESKRIPSI -->
          <small class="text-muted d-block mb-2 menu-desc">
            {{ $item->deskripsi }}
          </small>

          <!-- HARGA -->
          <p class="fw-bold mb-1 menu-price" style="color: #751A25;">
            Rp{{ number_format($item->harga, 0, ',', '.') }}
          </p>

          <!-- BUTTON KERANJANG & BELI -->
          <div class="d-flex align-items-center gap-2 mt-2 menu-actions">
            <button
              type="button"
              class="ikon-keranjang border-0 bg-transparent"
              data-produk="{{ $item->id_produk }}"
              data-harga="{{ $item->harga }}">
              <i class="bi bi-cart3 fs-5"></i>
            </button>

            <button
              type="button"
              class="btn-beli btn-tanggal"
              data-produk="{{ $item->id_produk }}"
              data-harga="{{ $item->harga }}">
              Beli
            </button>
          </div>

          <!-- GAMBAR -->
          <div class="position-relative menu-image">
            <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama_produk }}">
            <span class="badge-price">{{ number_format($item->harga/1000, 0) }}K</span>
          </div>
        </article>
      </div>
      @endforeach

    </div>
  </div>

  {{-- Footer --}}
  <footer id="kontak" class="responsive-padding" style="background-color: #751A25; color: white; padding: 50px 0 20px 0;">
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
            <a href="https://wa.me/6287746567500"
              target="_blank"
              class="text-white text-decoration-none d-flex align-items-center justify-content-center justify-content-md-start mt-1">
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

      </div>
    </div>
    </div>
  </footer>

  {{-- Bootstrap JS --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
          <button type="button" class="btn px-4" style="background-color:#751A25; color:white;" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  {{-- ====== SCRIPT ====== --}}
  @php
  $loginUrl = \Illuminate\Support\Facades\Route::has('login')
  ? route('login')
  : url('/login');

  $keranjangUrl = \Illuminate\Support\Facades\Route::has('keranjang')
  ? route('keranjang')
  : url('/keranjang');

  $pemesananBase = url('/pemesanan');
  @endphp

  <script>
    // ---- FLAG LOGIN DARI SERVER ----
    const IS_LOGGED_IN = @json(auth()->check());
    const LOGIN_URL = @json($loginUrl);
    const KERANJANG_URL = @json($keranjangUrl);
    const PEMESANAN_BASE = @json($pemesananBase); // <-- TANPA SPASI, AMAN

    // mode aksi saat user membuka modal: 'cart' (ikon keranjang) atau 'buy' (tombol Beli)
    let CURRENT_ACTION = 'cart';

    // ---- UTIL TANGGAL & FORMAT ----
    const toDateUTC = (yyyyMMdd) => {
      return new Date(yyyyMMdd + 'T00:00:00Z');
    };

    const hitungDurasiHari = (mulaiRaw, akhirRaw) => {
      const start = toDateUTC(mulaiRaw);
      const end = toDateUTC(akhirRaw);
      const MS_PER_DAY = 24 * 60 * 60 * 1000;
      const diff = (end - start) / MS_PER_DAY;
      return Math.max(1, Math.round(diff)); // minimal 1 hari
    };

    const formatTanggal = (tanggal) => {
      if (!tanggal) return '';
      const [tahun, bulan, hari] = tanggal.split('-');
      return `${hari}-${bulan}-${tahun}`;
    };

    // ---- STATE PRODUK YANG DIPILIH ----
    let currentProdukId = '';
    let currentProdukNama = '';
    let currentHargaSatuan = 0;

    function bukaModalTanggal(idProduk, namaProduk, hargaSatuan) {
      currentProdukId = idProduk;
      currentProdukNama = namaProduk;
      currentHargaSatuan = Number(hargaSatuan) || 0;

      document.getElementById('selectedItem').innerText = namaProduk;
      document.getElementById('stokInfo').innerHTML = '';
      document.getElementById('tanggalMulaiSewa').value = '';
      document.getElementById('tanggalPengembalian').value = '';
      document.getElementById('jumlahSewa').value = 1;

      if (window.bootstrap && bootstrap.Modal) {
        new bootstrap.Modal(document.getElementById('calendarModal')).show();
      } else {
        console.error('Bootstrap JS belum ter-load.');
        alert('Terjadi kesalahan memuat modal. Silakan refresh halaman.');
      }
    }

    // ---- DAFTARKAN EVENT LISTENER SETELAH DOM SIAP ----
    document.addEventListener('DOMContentLoaded', () => {
      console.log('Menu JS initialized. Logged in?', IS_LOGGED_IN);

      // Klik IKON KERANJANG → mode 'cart'
      document.querySelectorAll('.ikon-keranjang').forEach(btn => {
        btn.addEventListener('click', function() {
          if (!IS_LOGGED_IN) {
            window.location = LOGIN_URL;
            return;
          }
          CURRENT_ACTION = 'cart';

          const idProduk = this.getAttribute('data-produk');
          const harga = this.getAttribute('data-harga') || '0';
          const namaProduk = this.closest('article')?.querySelector('h5')?.innerText || '';

          bukaModalTanggal(idProduk, namaProduk, harga);
        });
      });

      // Klik TOMBOL BELI → mode 'buy'
      document.querySelectorAll('.btn-tanggal').forEach(btn => {
        btn.addEventListener('click', function() {
          if (!IS_LOGGED_IN) {
            window.location = LOGIN_URL;
            return;
          }
          CURRENT_ACTION = 'buy';

          const idProduk = this.getAttribute('data-produk');
          const harga = this.getAttribute('data-harga') || '0';
          const namaProduk = this.closest('article')?.querySelector('h5')?.innerText || '';

          bukaModalTanggal(idProduk, namaProduk, harga);
        });
      });
    });

    // ---- FUNGSI CEK STOK ----
    async function cekStok() {
      const mulaiRaw = document.getElementById('tanggalMulaiSewa').value;
      const pengembalianRaw = document.getElementById('tanggalPengembalian').value;
      const jumlahInput = document.getElementById('jumlahSewa');
      let jumlah = Number(jumlahInput.value || 1);
      const info = document.getElementById('stokInfo');

      if (!mulaiRaw || !pengembalianRaw) {
        info.innerHTML = '<div class="text-danger fw-semibold">Pilih kedua tanggal terlebih dahulu.</div>';
        return;
      }

      if (toDateUTC(pengembalianRaw) <= toDateUTC(mulaiRaw)) {
        info.innerHTML = `
          <div class="text-danger fw-semibold">
            Tanggal pengembalian harus setelah tanggal sewa (minimal H+1).
          </div>`;
        return;
      }

      info.innerHTML = '<div class="text-muted">Mengecek stok...</div>';

      try {
        const res = await fetch(`/produk/${encodeURIComponent(currentProdukId)}/stok-tersedia`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({
            tanggal_mulai: mulaiRaw,
            tanggal_pengembalian: pengembalianRaw,
            jumlah: jumlah
          })
        });

        const ct = res.headers.get('content-type') || '';
        if (!ct.includes('application/json')) {
          throw new Error('Respon bukan JSON');
        }

        const data = await res.json();
        if (!res.ok || !data) {
          throw new Error(data?.message || 'Gagal cek stok');
        }

        const stokTersedia = data.stok_tersedia ?? null;
        const bisaDipesan = (data.bisa_dipesan !== false);

        const durasiHari = hitungDurasiHari(mulaiRaw, pengembalianRaw);
        const mulai = formatTanggal(mulaiRaw);
        const pengembalian = formatTanggal(pengembalianRaw);

        // clamp jumlah jika stok tidak cukup
        if (!bisaDipesan) {
          const maxQty = typeof stokTersedia === 'number' ? stokTersedia : 0;
          jumlahInput.value = maxQty > 0 ? maxQty : 1;

          info.innerHTML = `
            <div class="alert alert-danger py-2">
              Maaf, stok tidak mencukupi. Tersedia: <strong>${stokTersedia ?? 0}</strong>.
            </div>`;
          return;
        }

        // kalau stok cukup
        if (typeof stokTersedia === 'number' && stokTersedia > 0) {
          jumlahInput.max = stokTersedia;
          if (jumlah > stokTersedia) {
            jumlah = stokTersedia;
            jumlahInput.value = stokTersedia;
          }
        }

        const btnHTML = (CURRENT_ACTION === 'buy') ?
          `<button class="btn mt-2" style="background-color:#751A25; color:white;"
                 onclick="redirectToPemesanan('${currentProdukId}', '${mulaiRaw}', '${pengembalianRaw}', ${jumlah})">
               Lanjut ke Pemesanan
             </button>` :
          `<button class="btn mt-2" style="background-color:#751A25; color:white;"
                 onclick="tambahKeKeranjang('${currentProdukId}', '${mulaiRaw}', '${pengembalianRaw}', ${jumlah}, ${durasiHari})">
               Tambah ke Keranjang
             </button>`;

        info.innerHTML = `
          <div class="alert alert-success py-2">
            Stok tersedia ${stokTersedia !== null ? `(<strong>${stokTersedia}</strong>)` : ''}
            untuk <strong>${mulai}</strong> s/d <strong>${pengembalian}</strong><br>
            Lama sewa: <strong>${durasiHari} hari</strong>
          </div>
          ${btnHTML}
        `;
      } catch (e) {
        console.error(e);
        info.innerHTML = '<div class="alert alert-danger py-2">Terjadi kesalahan saat cek stok.</div>';
      }
    }

    // ---- REDIRECT KE HALAMAN PEMESANAN ----
    function redirectToPemesanan(idProduk, mulaiRaw, pengembalianRaw, jumlah) {
      if (!mulaiRaw || !pengembalianRaw || !jumlah) {
        alert('Lengkapi tanggal sewa, pengembalian, dan jumlah.');
        return;
      }

      const base = PEMESANAN_BASE;

      const url =
        `${base}/${encodeURIComponent(idProduk)}` +
        `?tanggal_mulai_sewa=${encodeURIComponent(mulaiRaw)}` +
        `&tanggal_pengembalian=${encodeURIComponent(pengembalianRaw)}` +
        `&jumlah=${encodeURIComponent(jumlah)}`;

      // tutup modal lalu redirect
      const modalEl = document.getElementById('calendarModal');
      if (window.bootstrap && bootstrap.Modal && modalEl) {
        const modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
      }

      window.location.href = url;
    }

    // ---- TAMBAH KE KERANJANG ----
    function tambahKeKeranjang(idProduk, mulaiRaw, pengembalianRaw, jumlah, durasiHari) {
      const total = currentHargaSatuan * Number(durasiHari) * Number(jumlah || 1);
      console.log('Total (client-side, info saja):', total);

      fetch(`/keranjang/tambah/${encodeURIComponent(idProduk)}`, {
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
            jumlah: jumlah,
            lama_hari: durasiHari
          })
        })
        .then(async (res) => {
          if (res.redirected) {
            window.location = res.url;
            return;
          }
          if (res.status === 401 || res.status === 419) {
            window.location = LOGIN_URL;
            return;
          }

          const text = await res.text();
          let data = {};
          try {
            data = JSON.parse(text);
          } catch (_) {}

          if (!res.ok || data.success !== true) {
            throw new Error(data.message || 'Gagal menambahkan ke keranjang.');
          }

          const modalEl = document.getElementById('calendarModal');
          if (window.bootstrap && bootstrap.Modal && modalEl) {
            const calModal = bootstrap.Modal.getInstance(modalEl);
            if (calModal) calModal.hide();
          }

          // Langsung ke halaman keranjang
          window.location.href = KERANJANG_URL;

          // Update badge kalau ada
          if (data.count != null) {
            const badge = document.getElementById('cart-badge');
            if (badge) {
              badge.textContent = data.count;
              badge.style.display = Number(data.count) > 0 ? 'inline-block' : 'none';
            }
          }
        })
        .catch(() => alert('Terjadi kesalahan saat menambahkan ke keranjang.'));
    }
  </script>
</body>

</html>