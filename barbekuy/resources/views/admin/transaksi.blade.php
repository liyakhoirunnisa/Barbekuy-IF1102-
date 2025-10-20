<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manajemen Transaksi| Barbekuy</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
  <style>
    * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }
    body { background:#f5f6fa; display:flex; min-height:100vh; }

      /* === SIDEBAR (SAMA PERSIS DENGAN DASHBOARD) === */
.sidebar {
  width: 240px;
  background: #751A25;
  color: #fff;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding-top: 20px;
}

.logo {
  height: 110px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #751A25;
}

.logo img {
  width: 190px;
  height: auto;
  object-fit: contain;
  position: relative;
  top: -18px;
}

.menu {
  width: 100%;
  margin-top: -3px; /* <── ini biar sejajar kayak Dashboard */
}

.menu-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 14px 26px;
  color: #fff;
  font-size: 14px;
  text-decoration: none;
  transition: 0.3s;
}

.menu-item img {
  width: 20px;
  height: 20px;
  object-fit: contain;
  filter: brightness(0) invert(1);
}

.menu-item:hover,
.menu-item.active {
  background: rgba(255,255,255,0.15);
  border-radius: 10px;
}

.notif {
  background: #fff;
  color: #751A25;
  font-size: 11px;
  padding: 2px 8px;
  border-radius: 12px;
  margin-left: auto;
  font-weight: 600;
}


    /* === MAIN & TOPBAR === */
    .main-content { flex:1; display:flex; flex-direction:column; height:100vh; overflow:hidden; }
    .topbar {
      height:110px;
      background:#751A25;
      display:flex;
      align-items:center;
      justify-content:flex-end;
      padding:0 40px;
      box-shadow:0 2px 5px rgba(0,0,0,0.1);
      gap:25px;
    }
    .topbar a { display:flex; align-items:center; justify-content:center; height:55px; }
    .topbar a img { width:28px; height:28px; filter:brightness(0) invert(1); cursor:pointer; transition:0.3s; position:relative; top:2px; }
    .topbar a img:hover { transform:scale(1.1); }
    .profile { height:55px; display:flex; align-items:center; gap:10px; background:#fff; color:#751A25; padding:6px 14px; border-radius:30px; font-weight:500; }
    .avatar { background:#751A25; color:#fff; width:32px; height:32px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:600; }

    /* Content */
    .content { flex:1; padding:30px 40px; }
    .content-box { background:#fff; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,0.05); padding:28px; }
    .content-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:25px; }
    .content-header h2 { font-size:20px; font-weight:600; color:#333; }
    .header-actions { display:flex; gap:10px; }
    .btn { border:none; padding:9px 16px; border-radius:6px; font-size:14px; cursor:pointer; font-weight:500; transition:0.3s; }
    .btn-primary { background:#751A25; color:#fff; } 
    .btn-primary:hover{background:#3d030a;}
    .btn-secondary { background:#fff; border:1px solid #ccc; color:#333; }

    /* Filter */
    .filters { display:flex; justify-content:space-between; align-items:center; gap:10px; margin-bottom:25px; }
    .filter-group { display:flex; gap:10px; flex:1; }
    .filters select, .filters input { padding:9px 12px; border-radius:6px; border:1px solid #dcdcdc; font-size:13px; outline:none; background:#fff; }
    .filters input { flex:1; }
    .icon-actions { display:flex; gap:12px; }
    .icon-actions img { width:24px; cursor:pointer; transition:0.3s; }
    .icon-actions img:hover { transform:scale(1.1); }

    /* Table */
    table { width:100%; border-collapse:collapse; }
    th, td { text-align:left; padding:12px 10px; border-bottom:1px solid #eee; font-size:14px; }
    th { color:#555; font-weight:500; }
    td strong { color:#000; }
    .status { padding:4px 10px; border-radius:6px; font-size:12px; font-weight:500; display:inline-block; }
    .status.active { background:#d2f7d0; color:#2e7d32; }
    .status.inactive { background:#f9d2d0; color:#b71c1c; }
    td a { color:#751A25; text-decoration:none; font-weight:500; cursor:pointer; }
    td a:hover { text-decoration:underline; }
    table tbody tr { transition: background-color 0.2s ease, transform 0.1s ease; cursor:pointer; }
    table tbody tr:hover { background-color: rgba(211, 47, 47, 0.15); transform: scale(1.01); }

    /* Popup umum */
    .popup { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.6); justify-content:center; align-items:center; z-index:999; }
    .popup-content { background:#fff; border-radius:12px; width:600px; max-width:90%; padding:25px 30px; box-shadow:0 4px 15px rgba(0,0,0,0.2); animation:fadeIn 0.3s ease; }
    @keyframes fadeIn { from{opacity:0; transform:scale(0.9);} to{opacity:1; transform:scale(1);} }
    .popup-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; }
    .popup-header h3 { font-size:18px; color:#751A25; }
    .close-btn { background:none; border:none; font-size:20px; cursor:pointer; color:#751A25; }
    .popup-footer { margin-top:15px; display:flex; justify-content:flex-end; gap:10px; }

    /* Popup Hapus */
    .popup-hapus .popup-content { border-top:8px solid #751A25; text-align:center; padding:30px 20px; }
    .popup-hapus h3 { color:#751A25; font-size:20px; margin-bottom:10px; }
    .popup-hapus p { color:#444; margin-bottom:20px; }
    .popup-hapus .btn-primary { background:#751A25; } 
    .popup-hapus .btn-primary:hover{background:#3d030a;}

    /* Popup Edit */
    #popupEdit .popup-content form { display:flex; flex-direction:column; gap:15px; }
    #popupEdit .popup-content form input, #popupEdit .popup-content form select, #popupEdit .popup-content form textarea { width:100%; padding:10px 12px; border:1px solid #dcdcdc; border-radius:6px; font-size:14px; outline:none; background:#fff; }
    #popupEdit .popup-content form textarea { min-height:80px; resize:vertical; }
    #popupEdit .popup-footer { justify-content:flex-end; gap:10px; margin-top:10px; }

    /* Popup Tambah (disamakan dengan Edit) */
    #popupTambah .popup-content { background:#fff; border-radius:12px; width:500px; max-width:90%; padding:25px 30px; display:flex; flex-direction:column; gap:15px; }
    #popupTambah .popup-header h3 { color:#751A25; font-size:18px; font-weight:600; }
    #popupTambah form { display:flex; flex-direction:column; gap:12px; }
    #popupTambah form input, #popupTambah form select, #popupTambah form textarea { width:100%; padding:10px 12px; border:1px solid #dcdcdc; border-radius:6px; font-size:14px; outline:none; background:#fff; }
    #popupTambah form textarea { min-height:80px; resize:vertical; }
    #popupTambah .popup-footer { display:flex; justify-content:flex-end; gap:10px; margin-top:10px; }
    #popupTambah .btn-primary { background:#751A25; color:#fff; } 
    #popupTambah .btn-primary:hover{background:#3d030a;}
    #popupTambah .btn-secondary { background:#fff; color:#751A25; border:1px solid #751A25; } 
    #popupTambah .btn-secondary:hover{background:#f4f0f0;}
  </style>
</head>

<body>
  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="logo">
      <img src="{{ asset('images/logoputih.png') }}" alt="Logo Barbekuy">
    </div>
    <div class="menu">
      <a href="{{ route('beranda') }}" class="menu-item"><img src="{{ asset('images/beranda.png') }}"> Beranda</a>
      <a href="#" class="menu-item active"><img src="{{ asset('images/transaksi.png') }}"> Transaksi</a>
      <a href="{{ route('produk') }}" class="menu-item">
        <img src="{{ asset('images/produk.png') }}"> Produk</a>
      <a href="{{ route('pembayaran') }}" class="menu-item">
        <img src="{{ asset('images/pembayaran.png') }}"> Pembayaran</a>
      <a href="{{ route('pesan') }}" class="menu-item">
        <img src="{{ asset('images/chat.png') }}"> Pesan</a>
      <a href="{{ route('pengaturan') }}" class="menu-item">
        <img src="{{ asset('images/settings.png') }}"> Pengaturan</a>
    </div>
  </aside>

  <!-- Main Content -->
  <main class="main-content">
    <div class="topbar">
      <a href="{{ route('notifikasi') }}">
      <img src="{{ asset('images/bell.png') }}" alt="Notifikasi"></a>
      <div class="profile">
        <div class="avatar">A</div>
        <span>Admin Barbekuy</span>
      </div>
    </div>

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
