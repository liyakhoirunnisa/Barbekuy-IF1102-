<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Notifikasi | Barbekuy</title>
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

    /* Notifikasi Section */
    .notif-actions { display:flex; justify-content:space-between; align-items:center; margin-bottom:25px; }
    .notif-actions select { padding:8px 12px; border-radius:6px; border:1px solid #ccc; font-size:13px; outline:none; }
    .notif-actions .filter-right { color:#751A25; border:1px solid #751A25; background:#fff; }

    .notif-section { margin-bottom:25px; }
    .notif-section h4 { font-size:15px; margin-bottom:12px; color:#751A25; font-weight:500; }

    .notif-item { 
      background:#fff; 
      border-radius:8px; 
      box-shadow:0 1px 3px rgba(0,0,0,0.1); 
      padding:14px 20px; 
      display:grid;
      grid-template-columns: 1fr 130px 100px;
      align-items:center; 
      margin-bottom:10px; 
      transition:0.2s;
      column-gap:30px;
    }
    .notif-item:hover { background:#f8f8f8; }

    .notif-left { display:flex; align-items:center; gap:12px; }
    .notif-left input[type="checkbox"] { transform:scale(1.2); cursor:pointer; }

    .notif-message { font-size:14px; color:#333; }
    .notif-message b { color:#751A25; }

    .notif-time { 
      font-size:13px; 
      color:gray; 
      text-align:right; 
      margin-right:10px;
    }

    .notif-status { 
      font-size:13px; 
      font-weight:500; 
      text-align:right; 
      min-width:90px;
    }
    .notif-status.baca { color:gray; }
    .notif-status.belum { color:#751A25; }

    /* Popup */
    .popup-overlay {
      position: fixed;
      top:0; left:0;
      width:100%; height:100%;
      background: rgba(0,0,0,0.4);
      display:none;
      justify-content:center;
      align-items:center;
      z-index:999;
    }
    .popup-box {
      background:#fff;
      border-radius:16px;
      width:380px;
      padding:30px 28px;
      text-align:center;
      box-shadow:0 6px 18px rgba(0,0,0,0.15);
      animation: fadeIn 0.3s ease;
    }
    @keyframes fadeIn { from{opacity:0; transform:translateY(-10px);} to{opacity:1; transform:translateY(0);} }

    .popup-box h3 { color:#751A25; font-size:18px; margin-bottom:12px; font-weight:600; }
    .popup-box p { color:#555; font-size:14px; margin-bottom:25px; }

    .popup-buttons {
      display:flex;
      justify-content:center;
      gap:15px;
    }
    .popup-buttons button {
      border:none;
      padding:8px 20px;
      border-radius:8px;
      font-size:14px;
      cursor:pointer;
      transition:0.3s;
    }
    .btn-cancel {
      background:#fff;
      color:#751A25;
      border:1px solid #751A25;
    }
    .btn-cancel:hover {
      background:#f4f4f4;
    }
    .btn-delete {
      background:#751A25;
      color:#fff;
    }
    .btn-delete:hover {
      opacity:0.9;
    }
  </style>
</head>

<body>
  <!-- Sidebar -->
  <aside class="sidebar">
    <div class="logo">
      <img src="{{ asset('images/logoputih.png') }}" alt="Logo Barbekuy">
    </div>
    <div class="menu">
      <a href="{{ route('beranda') }}" class="menu-item">
        <img src="{{ asset('images/beranda.png') }}"> Beranda</a>
      <a href="{{ route('transaksi') }}" class="menu-item">
        <img src="{{ asset('images/transaksi.png') }}"> Transaksi</a>
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
      <!-- 🔔 Tambahkan link ke halaman notifikasi -->
      <a href="{{ route('notifikasi') }}">
        <img src="{{ asset('images/bell.png') }}" alt="Notifikasi">
      </a>
      <div class="profile">
        <div class="avatar">A</div>
        <span>Admin Barbekuy</span>
      </div>
    </div>

    <div class="content">
      <div class="content-box">
        <div class="content-header">
          <h2>Notifikasi</h2>
        </div>

        <div class="notif-actions">
          <select id="notif-action">
            <option>Pilih</option>
            <option>Tandai semua dibaca</option>
            <option value="hapus">Hapus</option>
          </select>
          <select class="filter-right">
            <option>Semua</option>
            <option>Belum dibaca</option>
            <option>Sudah dibaca</option>
          </select>
        </div>

        <!-- Hari ini -->
        <div class="notif-section">
          <h4>Hari ini</h4>
          <div class="notif-item">
            <div class="notif-left">
              <input type="checkbox">
              <div class="notif-message"><b>Zahra Poetri</b> melakukan pemesanan <b>#PR001</b></div>
            </div>
            <div class="notif-time">6 jam yang lalu</div>
            <div class="notif-status baca">Baca</div>
          </div>

          <div class="notif-item">
            <div class="notif-left">
              <input type="checkbox">
              <div class="notif-message"><b>Zahra Poetri</b> melakukan pembayaran <b>#PAY001</b></div>
            </div>
            <div class="notif-time">6 jam yang lalu</div>
            <div class="notif-status baca">Baca</div>
          </div>
        </div>

        <!-- Kemarin -->
        <div class="notif-section">
          <h4>Kemarin</h4>
          <div class="notif-item">
            <div class="notif-left">
              <input type="checkbox">
              <div class="notif-message"><b>Zahra Poetri</b> melakukan pembayaran <b>#PAY001</b></div>
            </div>
            <div class="notif-time">1 hari yang lalu</div>
            <div class="notif-status belum">Belum dibaca</div>
          </div>

          <div class="notif-item">
            <div class="notif-left">
              <input type="checkbox">
              <div class="notif-message"><b>Zahra Poetri</b> melakukan pemesanan <b>#PR001</b></div>
            </div>
            <div class="notif-time">1 hari yang lalu</div>
            <div class="notif-status baca">Baca</div>
          </div>
        </div>

      </div>
    </div>
  </main>

  <!-- Popup Konfirmasi Hapus -->
  <div class="popup-overlay" id="popupHapus">
    <div class="popup-box">
      <h3>Hapus Notifikasi?</h3>
      <p>Apakah Anda yakin ingin menghapus notifikasi yang dipilih?</p>
      <div class="popup-buttons">
        <button class="btn-cancel" onclick="closePopup()">Batal</button>
        <button class="btn-delete" onclick="hapusData()">Hapus</button>
      </div>
    </div>
  </div>

  <script>
    const selectAction = document.getElementById("notif-action");
    const popup = document.getElementById("popupHapus");

    selectAction.addEventListener("change", function(){
      if(this.value === "hapus"){
        popup.style.display = "flex";
        this.value = "Pilih";
      }
    });

    function closePopup(){
      popup.style.display = "none";
    }

    function hapusData(){
      alert("Notifikasi berhasil dihapus!");
      popup.style.display = "none";
    }
  </script>

</body>
</html>
