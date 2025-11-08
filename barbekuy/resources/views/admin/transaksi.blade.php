<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manajemen Transaksi | Barbekuy</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif
    }

    body {
      background: #f5f6fa;
      display: flex;
      min-height: 100vh
    }

    /* Content */
    .content {
      flex: 1;
      padding: 30px 40px
    }

    /* kotak utama jadi kolom biar area tabel bisa ambil tinggi tersisa */
    .content-box {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
      display: flex;
      flex-direction: column;
      height: 78vh;
      /* sesuaikan 74–82vh kalau kepanjangan */
      min-height: 0;
      padding: 28px
    }


    /* area khusus yg scroll */
    .table-scroll {
      flex: 1 1 auto;
      min-height: 0;
      overflow-y: auto;
      border: 1px solid #eee;
      border-radius: 8px;
    }

    /* header tabel lengket di atas saat scroll */
    .table-scroll thead th {
      position: sticky;
      top: 0;
      background: #fff;
      z-index: 5;
    }


    .content-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 25px
    }

    .content-header h2 {
      font-size: 20px;
      font-weight: 600;
      color: #333
    }

    .btn {
      border: none;
      padding: 9px 16px;
      border-radius: 6px;
      font-size: 14px;
      cursor: pointer;
      font-weight: 500;
      transition: .3s
    }

    .btn-primary {
      background: #751A25;
      color: #fff
    }

    .btn-primary:hover {
      background: #3d030a
    }

    /* Filter */
    .filters {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 10px;
      margin-bottom: 25px
    }

    .filter-group {
      display: flex;
      gap: 10px;
      flex: 1
    }

    .filters select,
    .filters input {
      padding: 9px 12px;
      border-radius: 6px;
      border: 1px solid #dcdcdc;
      font-size: 13px;
      outline: none;
      background: #fff
    }

    .filters input {
      flex: 1
    }

    .filters select#fStatus {
      flex: 0 0 150px;
      /* fix width utk status */
      width: 150px;
    }

    .filters input[type="date"] {
      flex: 0 0 135px;
      /* tanggal jadi lebih “press” */
      width: 135px;
      padding: 8px 10px;
    }

    .filters span.sep {
      /* "s.d." */
      align-self: center;
      color: #666;
      margin: 0 2px;
    }


    /* Table */
    table {
      width: 100%;
      border-collapse: collapse
    }

    th,
    td {
      text-align: left;
      padding: 12px 10px;
      border-bottom: 1px solid #eee;
      font-size: 14px
    }

    th {
      color: #555;
      font-weight: 500
    }

    td a {
      color: #751A25;
      text-decoration: none;
      font-weight: 500;
      cursor: pointer
    }

    td a:hover {
      text-decoration: underline
    }

    table tbody tr:hover {
      background-color: rgba(211, 47, 47, .15);
    }

    .status-select {
      appearance: none;
      border: 0;
      padding: 4px 12px;
      border-radius: 999px;
      font-size: 12px;
      font-weight: 500;
      line-height: 1.6;
      cursor: pointer;
    }

    .status-select.st-belum-bayar {
      background: #ffe3e3;
      color: #b71c1c;
    }

    .status-select.st-sedang-proses {
      background: #fff7cc;
      color: #a77f00;
    }

    .status-select.st-disiapkan {
      background: #d2f7d0;
      color: #2e7d32;
    }

    .status-select.st-disewa {
      background: #e0f2ff;
      color: #0b6aa1;
    }

    .status-select.st-selesai {
      background: #d2f7d0;
      color: #2e7d32;
    }

    .status-select.st-dibatalkan {
      background: #eee;
      color: #666;
    }

    /* Pill yang tampil di tabel (pengganti select tertutup) */
    .status-pill {
      border: 0;
      border-radius: 999px;
      padding: 4px 12px;
      font-size: 12px;
      font-weight: 500;
      cursor: pointer;
    }

    /* Menu dropdown kustom */
    .status-dd {
      position: relative;
      display: inline-block;
    }

    .status-menu {
      position: absolute;
      top: 115%;
      left: 0;
      min-width: 160px;
      background: #fff;
      border: 1px solid #eaeaea;
      border-radius: 10px;
      box-shadow: 0 12px 24px rgba(0, 0, 0, .1);
      padding: 6px;
      margin: 0;
      list-style: none;
      display: none;
      z-index: 20;
    }

    .status-dd.open .status-menu {
      display: block;
    }

    /* item: netral, compact, teks center */
    .status-item {
      --dot: #999;
      /* default color dot */
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      width: 100%;
      padding: 8px 10px;
      /* compact */
      font-size: 12px;
      font-weight: 600;
      border: 1px solid transparent;
      border-radius: 8px;
      background: #fff;
      color: #333;
      cursor: pointer;
      transition: .15s ease;
    }

    .status-item:hover {
      background: #f7f7f7;
      border-color: #eee;
      transform: translateY(-1px);
    }

    /* dot warna di kiri */
    .status-item::before {
      content: "";
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: var(--dot);
    }

    /* item aktif (status sekarang) */
    .status-item.is-active {
      background: #f0f3ff;
      border-color: #e3e8ff;
    }

    .status-item.is-active::after {
      content: "\f00c";
      /* Font Awesome check */
      font-family: "Font Awesome 6 Free";
      font-weight: 900;
      font-size: 10px;
      margin-left: 6px;
      color: #6473ff;
    }

    /* Map warna DOT per status (tidak ubah background) */
    .status-item.st-belum-bayar {
      --dot: #e53935;
    }

    /* merah */
    .status-item.st-sedang-proses {
      --dot: #f5a524;
    }

    /* oranye */
    .status-item.st-disiapkan {
      --dot: #0ea5e9;
    }

    /* biru muda */
    .status-item.st-disewa {
      --dot: #6366f1;
    }

    /* indigo */
    .status-item.st-selesai {
      --dot: #22c55e;
    }

    /* hijau */
    .status-item.st-dibatalkan {
      --dot: #9ca3af;
    }

    /* abu */

    /* pill di tabel (chip berwarna yang kamu punya) – tambahkan caret */
    .status-pill {
      display: inline-block;
      border: 1px solid transparent;
      border-radius: 6px;
      /* seperti .status di produk */
      padding: 4px 10px;
      /* lebih compact */
      font-size: 12px;
      font-weight: 500;
      cursor: pointer;
      position: relative;
      line-height: 1.2;
    }

    .status-pill::after {
      content: "\f107";
      font-family: "Font Awesome 6 Free";
      font-weight: 900;
      font-size: 10px;
      margin-left: 6px;
    }

    /* warna netral saat dropdown dibuka */
    /* Saat dropdown dibuka: jangan ubah warna pill, hanya tampilkan caret-up */
    .status-dd.open .status-pill {
      outline: 1px solid #e5e7eb;
    }

    .status-dd.open .status-pill::after {
      content: "\f106";
    }


    /* caret-up */

    /* Warna per status (pill & item) */
    /* — Warna per status: nuansa pastel & teks kontras — */
    .status-pill.st-belum-bayar {
      background: #f9d2d0;
      color: #b71c1c;
      border-color: #f3b5b2;
    }

    .status-pill.st-sedang-proses {
      background: #fff3bf;
      color: #a77f00;
      border-color: #ffe7a0;
    }

    .status-pill.st-disiapkan {
      background: #e0f2ff;
      color: #0b6aa1;
      border-color: #cfe8ff;
    }

    .status-pill.st-disewa {
      background: #ebe9ff;
      color: #3b3bb3;
      border-color: #ddd9ff;
    }

    .status-pill.st-selesai {
      background: #d2f7d0;
      color: #2e7d32;
      border-color: #b9efb6;
    }

    .status-pill.st-dibatalkan {
      background: #f0f0f0;
      color: #666;
      border-color: #e3e3e3;
    }

    /* Alerts */
    .alert {
      margin-bottom: 16px;
      padding: 10px 12px;
      border-radius: 8px;
      border: 1px solid transparent
    }

    .alert-success {
      background: #eaf8ec;
      color: #1d7a3d;
      border-color: #cbeed3
    }

    .alert-error {
      background: #fdeaea;
      color: #9b1c1c;
      border-color: #f5c2c2
    }

    /* Small select in table */
    .table-select {
      padding: 6px 10px;
      border-radius: 6px;
      border: 1px solid #dcdcdc;
      font-size: 13px;
      background: #fff
    }

    .row-actions {
      display: flex;
      gap: 8px;
      align-items: center
    }

    /* ==== Modal Detail ==== */
    .modal {
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, .45);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 1500;
    }

    .modal.open {
      display: flex;
    }

    .modal-card {
      width: 720px;
      max-width: 92vw;
      background: #fff;
      border-radius: 14px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, .15);
      overflow: hidden;
    }

    .modal-head {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 16px 18px;
      border-bottom: 1px solid #eee;
      background: #fafafa;
    }

    .modal-head .modal-close {
      width: 28px;
      height: 28px;
      padding: 0;
      font-size: 16px;
      line-height: 1;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border: none;
      border-radius: 6px;
      background: transparent;
      color: #751A25;
      cursor: pointer;
      transition: 0.2s;
    }

    .modal-head .modal-close:hover {
      background: #f3f4f6;
    }

    .modal-head h3 {
      font-size: 16px;
      font-weight: 600;
    }

    .modal-close {
      width: 28px;
      /* kotak tombol */
      height: 28px;
      padding: 0;
      /* hilangkan padding bawaan */
      font-size: 16px;
      /* ukuran simbol × */
      line-height: 1;
      /* biar tidak terlalu tinggi */
      display: inline-flex;
      /* pusatkan simbol */
      align-items: center;
      justify-content: center;
      border-radius: 6px;
      /* sudut lembut */
      color: #751A25;
    }

    .modal-body {
      padding: 18px;
      max-height: 70vh;
      overflow: auto;
    }

    .modal-section {
      margin-bottom: 14px;
    }

    .modal-section h4 {
      font-size: 13px;
      font-weight: 600;
      color: #444;
      margin-bottom: 6px;
    }

    .kv {
      display: grid;
      grid-template-columns: 140px 1fr;
      gap: 8px 12px;
      font-size: 13px;
    }

    .kv div {
      padding: 3px 0;
    }

    .items-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 13px;
      margin-top: 6px;
    }

    .items-table th,
    .items-table td {
      border-bottom: 1px solid #eee;
      text-align: left;
      padding: 8px 6px;
    }

    .items-table th {
      color: #666;
      font-weight: 600;
    }

    .modal-foot {
      padding: 14px 18px;
      display: flex;
      justify-content: flex-end;
      gap: 10px;
      border-top: 1px solid #eee;
    }

    .modal-foot .modal-close {
      width: auto;
      /* penting: jangan 28px */
      height: auto;
      padding: 8px 16px;
      font-size: 14px;
      border: none;
      border-radius: 8px;
      background: #751A25;
      color: #fff;
      cursor: pointer;
      transition: 0.2s;
    }

    .modal-foot .modal-close:hover {
      background: #500f19;
    }

    .modal-foot .btn {
      padding: 8px 12px;
      border-radius: 8px;
      background: #751A25;
      color: #fff;
      border: 0;
      cursor: pointer;
    }

    /* — Detail link: tampil seperti link pada contoh produk — */
    .detail-link {
      background: transparent;
      border: 0;
      padding: 0;
      /* tampil seperti teks */
      color: #751A25;
      /* tebal seperti contoh */
      font-size: 15px;
      line-height: 1;
      cursor: pointer;
    }

    .detail-link:hover,
    .detail-link:focus {
      text-decoration: underline;
      /* underline saat hover/focus */
      outline: none;
    }
  </style>
</head>

<body>
  {{-- 🔹 Sidebar + Topbar --}}
  @include('layouts.navbarAdmin')

  @php
  // Map status -> kelas badge (untuk tampilan)
  $statusClass = [
  'Belum Bayar' => 'belum-bayar',
  'Sedang Proses' => 'sedang-proses',
  'Disiapkan' => 'disiapkan',
  'Disewa' => 'disewa',
  'Selesai' => 'selesai',
  'Dibatalkan' => 'dibatalkan',
  ];
  @endphp

  <!-- Main Content -->
  <main class="main-content">
    <div class="content">
      <div class="content-box">

        <div class="content-header">
          <h2>Manajemen Transaksi Pemesanan</h2>
          <button class="btn btn-primary" type="button">Export Excel</button>
        </div>

        {{-- Flash & Error --}}
        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
        <div class="alert alert-error">{{ $errors->first() }}</div>
        @endif

        <div class="filters">
          <form method="GET" class="filter-group" id="txFilterForm">
            {{-- STATUS (utama) --}}
            <select name="status" id="fStatus">
              <option value="">Semua Status</option>
              @foreach ($statuses as $st)
              <option value="{{ $st }}" {{ request('status')===$st ? 'selected' : '' }}>
                {{ $st }}
              </option>
              @endforeach
            </select>

            {{-- RENTANG TANGGAL --}}
            <input type="date" name="from" id="fFrom" value="{{ request('from') }}">
            <span style="align-self:center;color:#666;">s.d.</span>
            <input type="date" name="to" id="fTo" value="{{ request('to') }}">

            {{-- PENCARIAN (ID / Nama penerima) --}}
            <input
              type="text"
              name="q"
              id="fQ"
              placeholder="Cari ID Transaksi / Nama penerima…"
              value="{{ request('q') }}"
              autocomplete="off"
              style="flex:1" />
          </form>
        </div>
        <div class="table-scroll">
          <table>
            <thead>
              <tr>
                <th>ID Transaksi</th>
                <th>Tanggal Pemesanan</th>
                <th>Nama</th>
                <th>Status Pemesanan</th>
                <th>Total</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody id="txBody">
              @forelse ($orders as $order)
              <tr>
                <td>{{ $order->no_pesanan }}</td>
                <td>{{ optional($order->created_at)->format('d/m/Y') }}</td>
                <td>{{ $order->nama_penerima ?? optional($order->user)->name ?? '-' }}</td>

                {{-- STATUS: dropdown bergaya badge, auto-submit saat diubah --}}
                <td>
                  <form method="POST" action="{{ route('admin.transaksi.updateStatus', $order) }}" class="status-form">
                    @csrf
                    @method('PATCH')

                    <div class="status-dd">
                      {{-- tombol pill yang kelihatan di tabel --}}
                      <button type="button"
                        class="status-pill {{ 'st-'.Str::of($order->status_pesanan)->lower()->replace(' ', '-') }}">
                        {{ $order->status_pesanan ?? '-' }}
                      </button>

                      {{-- nilai yang akan dikirim --}}
                      <input type="hidden" name="status_pesanan" value="{{ $order->status_pesanan }}">

                      {{-- menu opsi berwarna --}}
                      <ul class="status-menu">
                        @foreach ($statuses as $st)
                        @php
                        $cls = 'st-'.\Illuminate\Support\Str::of($st)->lower()->replace(' ', '-');
                        @endphp
                        <li>
                          <button type="button" class="status-item {{ $cls }}" data-value="{{ $st }}">
                            {{ $st }}
                          </button>
                        </li>
                        @endforeach
                      </ul>
                    </div>
                  </form>
                </td>

                <td>Rp{{ number_format($order->total_harga, 0, ',', '.') }}</td>

                {{-- Aksi tetap: link Detail (atau nanti popup) --}}
                <td>
                  @php
                  $items = $order->details->map(function($d){
                  return [
                  'nama' => optional($d->product)->nama_produk ?? 'Produk',
                  'qty' => (int)($d->jumlah ?? 1),
                  'harga' => (int)($d->harga_satuan ?? $d->harga_sewa ?? 0),
                  'subtotal' => (int)($d->subtotal ?? (($d->harga_satuan ?? $d->harga_sewa ?? 0) * ($d->jumlah ?? 1))),
                  ];
                  })->values()->toArray();

                  $payload = [
                  'id' => $order->id_pesanan,
                  'no' => $order->no_pesanan,
                  'nama' => $order->nama_penerima ?? optional($order->user)->name,
                  'tgl_pesan' => optional($order->created_at)?->format('d/m/Y'),
                  'tgl_sewa' => optional($order->tanggal_sewa)?->format('d/m/Y'),
                  'tgl_kembali' => optional($order->tanggal_pengembalian)?->format('d/m/Y'),
                  'status' => $order->status_pesanan,
                  'total' => (int)($order->total_harga ?? 0),
                  'items' => $items,
                  ];
                  @endphp

                  <button type="button"
                    class="detail-link"
                    data-order='@json($payload)'>
                    Detail
                  </button>
                </td>


              </tr>
              @empty
              <tr>
                <td colspan="6" style="text-align:center;color:#777;">Belum ada transaksi.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <!-- ========== Modal Detail Pesanan ========== -->
        <div class="modal" id="orderModal" aria-hidden="true">
          <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="md-title">
            <div class="modal-head">
              <h3 id="md-title">Detail Pemesanan</h3>
              <button type="button" class="modal-close" aria-label="Tutup">
                &times;
              </button>
            </div>

            <div class="modal-body">
              <div class="modal-section">
                <h4>Informasi Pesanan</h4>
                <div class="kv" id="md-kv">
                  <!-- diisi via JS -->
                </div>
              </div>

              <div class="modal-section">
                <h4>Item</h4>
                <table class="items-table" id="md-items">
                  <thead>
                    <tr>
                      <th>Produk</th>
                      <th>Qty</th>
                      <th>Harga</th>
                      <th>Subtotal</th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
              </div>
            </div>

            <div class="modal-foot">
              <button type="button" class="btn modal-close">Tutup</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script>
    // ===== VARIABEL FORM & INPUT =====
    const form = document.getElementById('txFilterForm');
    const fStatus = document.getElementById('fStatus');
    const fFrom = document.getElementById('fFrom');
    const fTo = document.getElementById('fTo');
    const fQ = document.getElementById('fQ');

    // ===== NORMALISASI TEKS =====
    const norm = (s) => (s || '')
      .toString()
      .toLowerCase()
      .normalize('NFD')
      .replace(/[\u0300-\u036f]/g, '');

    // auto-submit saat status / tanggal berubah
    [fStatus, fFrom, fTo].forEach(el =>
      el.addEventListener('change', () => form.requestSubmit ? form.requestSubmit() : form.submit())
    );
    // ===== AUTO FILTER CLIENT-SIDE SAAT KETIK =====
    const txBody = document.getElementById('txBody');

    function filterTransaksi() {
      const q = norm(fQ.value || '');
      if (!txBody) return;

      const rows = txBody.querySelectorAll('tr:not(#txEmptyRow)');
      let visible = 0;

      rows.forEach(row => {
        // Kolom 0: ID, 1: Tanggal, 2: Nama
        const idTx = norm(row.children[0]?.textContent);
        const tgl = norm(row.children[1]?.textContent);
        const nama = norm(row.children[2]?.textContent);

        const match = !q || idTx.includes(q) || tgl.includes(q) || nama.includes(q);
        row.style.display = match ? '' : 'none';
        if (match) visible++;
      });

      // Tampilkan/hilangkan baris “kosong”
      let emptyRow = document.getElementById('txEmptyRow');
      if (visible === 0) {
        if (!emptyRow) {
          emptyRow = document.createElement('tr');
          emptyRow.id = 'txEmptyRow';
          emptyRow.innerHTML = `
      <td colspan="6" style="text-align:center;color:#777;padding:16px;">
        Tidak ada transaksi yang cocok
      </td>`;
          txBody.appendChild(emptyRow);
        } else {
          // penting: kalau sebelumnya sempat di-hide, tampilkan lagi
          emptyRow.style.display = '';
          // opsional: pastikan di paling bawah
          txBody.appendChild(emptyRow);
        }
      } else if (emptyRow) {
        emptyRow.remove();
      }
    }

    // ketik = langsung filter (tanpa submit)
    fQ.addEventListener('input', filterTransaksi);

    // jalankan saat load (kalau ada nilai q dari server)
    document.addEventListener('DOMContentLoaded', filterTransaksi);

    // --- FILTER STATUS/TANGGAL tetap submit server ---
    [fStatus, fFrom, fTo].forEach(el =>
      el.addEventListener('change', () =>
        form.requestSubmit ? form.requestSubmit() : form.submit()
      )
    );

    // toggle buka/tutup dropdown
    document.addEventListener('click', function(e) {
      // buka
      if (e.target.closest('.status-pill')) {
        const dd = e.target.closest('.status-dd');
        document.querySelectorAll('.status-dd.open').forEach(x => x.classList.remove('open'));
        dd.classList.toggle('open');
        return;
      }
      // pilih status
      const item = e.target.closest('.status-item');
      if (item) {
        const dd = item.closest('.status-dd');
        const form = dd.closest('form');
        const input = form.querySelector('input[name="status_pesanan"]');
        const pill = dd.querySelector('.status-pill');

        // set value
        input.value = item.dataset.value;
        pill.textContent = item.dataset.value;

        // update warna pill
        pill.className = 'status-pill ' + item.className.replace('status-item', '').trim();

        // tutup menu & submit
        dd.classList.remove('open');
        form.submit();
        return;
      }
      // klik di luar → tutup semua
      document.querySelectorAll('.status-dd.open').forEach(x => x.classList.remove('open'));
    });

    function statusClass(v) {
      switch ((v || '').toLowerCase()) {
        case 'belum bayar':
          return 'st-belum-bayar';
        case 'sedang proses':
          return 'st-sedang-proses';
        case 'disiapkan':
          return 'st-disiapkan';
        case 'disewa':
          return 'st-disewa';
        case 'selesai':
          return 'st-selesai';
        case 'dibatalkan':
          return 'st-dibatalkan';
        default:
          return 'st-belum-bayar';
      }
    }

    // set kelas awal untuk semua dropdown status
    document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('.status-select').forEach(function(sel) {
        sel.classList.add(statusClass(sel.value));
      });
    });

    function openPopup(id) {
      document.getElementById(id).style.display = 'flex';
    }

    function closePopup(id) {
      document.getElementById(id).style.display = 'none';
    }

    const rupiah = n => 'Rp' + (n || 0).toString()
      .replace(/[^0-9\-]/g, '')
      .replace(/\B(?=(\d{3})+(?!\d))/g, '.');

    // buka modal & render
    document.addEventListener('click', function(e) {
      const btn = e.target.closest('.detail-link');
      if (!btn) return;
      const data = JSON.parse(btn.dataset.order || '{}');

      // judul
      document.getElementById('md-title').textContent =
        `Detail Pemesanan • ${data.no || '-'}`;

      // key-values
      const kv = document.getElementById('md-kv');
      kv.innerHTML = [
        ['Nama', data.nama || '-'],
        ['Tanggal Pesan', data.tgl_pesan || '-'],
        ['Tanggal Sewa', data.tgl_sewa || '-'],
        ['Pengembalian', data.tgl_kembali || '-'],
        ['Status', data.status || '-'],
        ['Total', rupiah(data.total || 0)],
      ].map(([k, v]) => `<div>${k}</div><div><strong>${v}</strong></div>`).join('');

      // items
      const tbody = document.querySelector('#md-items tbody');
      const items = Array.isArray(data.items) ? data.items : [];
      tbody.innerHTML = items.length ?
        items.map(it => `
          <tr>
            <td>${it.nama || '-'}</td>
            <td>${it.qty ?? '-'}</td>
            <td>${rupiah(it.harga || 0)}</td>
            <td>${rupiah(it.subtotal || 0)}</td>
          </tr>`).join('') :
        `<tr><td colspan="4" style="text-align:center;color:#777;">Tidak ada item.</td></tr>`;

      // buka
      document.getElementById('orderModal').classList.add('open');
    });

    // tutup modal (klik tombol X, tombol Tutup, atau overlay)
    document.querySelectorAll('#orderModal .modal-close').forEach(el => {
      el.addEventListener('click', () => document.getElementById('orderModal').classList.remove('open'));
    });
    document.getElementById('orderModal').addEventListener('click', (e) => {
      if (e.target.id === 'orderModal') e.currentTarget.classList.remove('open');
    });

    // opsional: tutup saat ESC
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') document.getElementById('orderModal').classList.remove('open');
    });
  </script>
</body>

</html>