<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manajemen Transaksi | Barbekuy</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
  <!-- Tambahan Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }
    body { background:#f5f6fa; display:flex; min-height:100vh; }

    /* Content */
    .content { flex:1; padding:30px 40px; }
    .content-box { background:#fff; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,0.05); padding:28px; }
    .content-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:25px; }
    .content-header h2 { font-size:20px; font-weight:600; color:#333; }
    .btn { border:none; padding:9px 16px; border-radius:6px; font-size:14px; cursor:pointer; font-weight:500; transition:0.3s; }
    .btn-primary { background:#751A25; color:#fff; } 
    .btn-primary:hover{background:#3d030a;}

    /* Filter */
    .filters { display:flex; justify-content:space-between; align-items:center; gap:10px; margin-bottom:25px; }
    .filter-group { display:flex; gap:10px; flex:1; }
    .filters select, .filters input { padding:9px 12px; border-radius:6px; border:1px solid #dcdcdc; font-size:13px; outline:none; background:#fff; }
    .filters input { flex:1; }

    /* Table */
    table { width:100%; border-collapse:collapse; }
    th, td { text-align:left; padding:12px 10px; border-bottom:1px solid #eee; font-size:14px; }
    th { color:#555; font-weight:500; }
    .status-badge { padding:4px 10px; border-radius:6px; font-size:12px; font-weight:500; display:inline-block; }
    .status-badge.disiapkan { background:#d2f7d0; color:#2e7d32; }
    .status-badge.siap-diambil { background:#fff7cc; color:#a77f00; }
    td a { color:#751A25; text-decoration:none; font-weight:500; cursor:pointer; }
    td a:hover { text-decoration:underline; }
    table tbody tr:hover { background-color: rgba(211,47,47,0.15); transform: scale(1.01); }

    /* Popup */
    .popup { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.6); justify-content:center; align-items:center; z-index:999; }
    .popup-content { background:#fff; border-radius:12px; width:600px; max-width:90%; padding:25px 30px; box-shadow:0 4px 15px rgba(0,0,0,0.2); animation:fadeIn 0.3s ease; }
    @keyframes fadeIn { from{opacity:0; transform:scale(0.9);} to{opacity:1; transform:scale(1);} }
    .popup-footer { margin-top:15px; display:flex; justify-content:flex-end; gap:10px; }
  </style>
</head>

<body>
  {{-- 🔹 Sidebar + Topbar --}}
  @include('layouts.navbarAdmin')

  <!-- Main Content -->
  <main class="main-content">
    <div class="content">
      <div class="content-box">
        <div class="content-header">
          <h2>Manajemen Transaksi Pemesanan</h2>
          <button class="btn btn-primary">Export Excel</button>
        </div>

        <div class="filters">
          <div class="filter-group">
            <select><option>Filter Tanggal</option></select>
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
            <tr>
              <td>TRX001</td>
              <td>12/10/2025</td>
              <td>Tom Anderson</td>
              <td><span class="status-badge disiapkan">Disiapkan</span></td>
              <td>Rp250.000</td>
              <td><a onclick="openPopup('popupDetail')">Detail</a></td>
            </tr>
            <tr>
              <td>TRX002</td>
              <td>12/10/2025</td>
              <td>Jayden Walker</td>
              <td><span class="status-badge siap-diambil">Siap Diambil</span></td>
              <td>Rp250.000</td>
              <td><a onclick="openPopup('popupDetail')">Detail</a></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </main>

  <!-- POPUP DETAIL -->
  <div class="popup" id="popupDetail">
    <div class="popup-content">
      <h3>Detail Pemesanan</h3>
      <p><label>Nama Pembeli:</label><br> Nia Novela</p>
      <p><label>Produk:</label><br> Paket Slice 4xtra</p>
      <p><label>Total:</label><br> Rp215.000</p>
      <p><label>Status Pesanan:</label><br>
        <select>
          <option>Ubah Status</option>
          <option>Disiapkan</option>
          <option>Siap Diambil</option>
          <option>Selesai</option>
        </select>
      </p>
      <div class="popup-footer">
        <button class="btn btn-primary">Simpan</button>
        <button class="btn btn-secondary" onclick="closePopup('popupDetail')">Batal</button>
      </div>
    </div>
  </div>

  <script>
    function openPopup(id){ document.getElementById(id).style.display='flex'; }
    function closePopup(id){ document.getElementById(id).style.display='none'; }
  </script>

</body>
</html>
