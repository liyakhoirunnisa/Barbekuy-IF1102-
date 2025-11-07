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

    .content-box {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
      padding: 28px
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
      border: 0;
      border-radius: 999px;
      padding: 6px 12px 6px 12px;
      font-size: 12px;
      font-weight: 600;
      cursor: pointer;
      position: relative;
    }

    .status-pill::after {
      content: "\f107";
      /* caret-down */
      font-family: "Font Awesome 6 Free";
      font-weight: 900;
      font-size: 10px;
      margin-left: 6px;
    }

    /* warna netral saat dropdown dibuka */
    /* Saat dropdown dibuka: jangan ubah warna pill, hanya tampilkan caret-up */
    .status-dd.open .status-pill {
      outline: 1px solid #e5e7eb;
      /* opsional: garis tipis biar terasa fokus */
    }

    .status-dd.open .status-pill::after {
      content: "\f106";
      /* caret-up */
    }

    /* caret-up */

    /* Warna per status (pill & item) */
    /* Warna khusus untuk PILL (chip di tabel) */
    .status-pill.st-belum-bayar {
      background: #ffe3e3;
      color: #b71c1c;
    }

    .status-pill.st-sedang-proses {
      background: #fff7cc;
      color: #a77f00;
    }

    .status-pill.st-disiapkan {
      background: #e0f2ff;
      color: #0b6aa1;
    }

    .status-pill.st-disewa {
      background: #ebe9ff;
      color: #3b3bb3;
    }

    .status-pill.st-selesai {
      background: #d2f7d0;
      color: #2e7d32;
    }

    .status-pill.st-dibatalkan {
      background: #eee;
      color: #666;
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
          <div class="filter-group">
            <select>
              <option>Filter Tanggal</option>
            </select>
            <input type="text" placeholder="Cari Transaksi...">
          </div>
        </div>

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
          <tbody>
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
              <td><a onclick="openPopup('popupDetail')">Detail</a></td>
            </tr>
            @empty
            <tr>
              <td colspan="6" style="text-align:center;color:#777;">Belum ada transaksi.</td>
            </tr>
            @endforelse
          </tbody>
        </table>

        {{-- Pagination (kalau pakai paginate) --}}
        @if(method_exists($orders, 'links'))
        <div style="margin-top:16px;">{{ $orders->links() }}</div>
        @endif

      </div>
    </div>
  </main>

  <script>
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
  </script>
</body>

</html>