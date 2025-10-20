<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pengaturan Akun | Barbekuy</title>
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

    .tabs { display:flex; border-bottom:2px solid #eee; margin-bottom:25px; flex-wrap:wrap; gap:5px; }
    .tab-btn {
      padding:10px 18px; font-size:14px; cursor:pointer;
      border:none; background:none; outline:none; color:#555; transition:0.3s;
    }
    .tab-btn.active { color:#751A25; font-weight:600; border-bottom:3px solid #751A25; }

    .tab-content { display:none; animation:fadeIn 0.3s ease; }
    .tab-content.active { display:block; }

    @keyframes fadeIn {
      from { opacity:0; transform:translateY(10px); }
      to { opacity:1; transform:translateY(0); }
    }

    /* Profile Settings - diperbaiki jadi vertikal dan rapi */
    .profile-settings { display:flex; flex-direction:column; gap:25px; }
    .profile-left { text-align:center; }
    .profile-left img { width:120px; height:120px; border-radius:50%; object-fit:cover; border:3px solid #751A25; margin-bottom:12px; }
    .btn-upload { background:#751A25; color:#fff; border:none; padding:8px 14px; border-radius:6px; cursor:pointer; transition:0.3s; }
    .btn-upload:hover { background:#3d030a; }

    .profile-right { display:flex; flex-direction:column; gap:18px; width:100%; max-width:600px; margin:auto; }
    label { font-size:13px; color:#555; margin-bottom:5px; display:block; }
    input, select, textarea {
      width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;
      font-size:13px; outline:none; resize:vertical;
    }
    input:focus, textarea:focus { border-color:#751A25; }

    .gender-group { display:flex; gap:20px; align-items:center; }
    .btn-save { align-self:end; background:#751A25; color:#fff; border:none; padding:10px 20px; border-radius:6px; cursor:pointer; font-weight:500; transition:0.3s; }
    .btn-save:hover { background:#3d030a; }

    /* Password */
    .password-form { display:flex; flex-direction:column; gap:20px; width:100%; max-width:500px; margin:auto; }
    .password-form input { padding:10px; border:1px solid #ccc; border-radius:6px; }
    .password-form button { align-self:end; background:#751A25; color:#fff; padding:10px 20px; border:none; border-radius:6px; cursor:pointer; font-weight:500; transition:0.3s; }
    .password-form button:hover { background:#3d030a; }

    /* Notification */
    .notif-settings { display:flex; flex-direction:column; gap:15px; width:100%; max-width:600px; margin:auto; }
    .notif-item { display:flex; justify-content:space-between; align-items:center; padding:14px 18px; border:1px solid #eee; border-radius:8px; background:#fafafa; }
    .notif-item span { color:#333; font-weight:500; }
    .notif-item input[type=checkbox] { width:20px; height:20px; accent-color:#751A25; }

    /* Verification */
    .verification { max-width:400px; margin:auto; display:flex; flex-direction:column; gap:18px; background:#fafafa; padding:20px; border-radius:8px; border:1px solid #eee; }
    .verification input { padding:10px; border:1px solid #ccc; border-radius:6px; }
    .verification button { background:#751A25; color:#fff; border:none; padding:10px 20px; border-radius:6px; cursor:pointer; font-weight:500; transition:0.3s; }
    .verification button:hover { background:#3d030a; }

    /* === Tambahan agar konten bisa discroll tanpa mengubah topbar === */
.main-content {
  flex: 1;
  display: flex;
  flex-direction: column;
  height: 100vh;
  overflow: hidden; /* tetap, biar topbar gak ikut scroll */
}

.content {
  flex: 1;
  padding: 30px 40px;
  overflow-y: auto;         /* ⬅️ bikin area konten scrollable */
  scroll-behavior: smooth;
}

.content::-webkit-scrollbar {
  width: 8px;
}

.content::-webkit-scrollbar-thumb {
  background: #bbb;
  border-radius: 8px;
}

.content::-webkit-scrollbar-thumb:hover {
  background: #888;
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
      <a href="#" class="menu-item active"><img src="{{ asset('images/settings.png') }}"> Pengaturan</a>
    </div>
  </aside>

  <!-- Main -->
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
        <div class="tabs">
          <button class="tab-btn active" data-tab="profile">Pengaturan Profil</button>
          <button class="tab-btn" data-tab="password">Pengaturan Password</button>
          <button class="tab-btn" data-tab="notif">Pengaturan Notifikasi</button>
          <button class="tab-btn" data-tab="verify">Pengaturan Verifikasi</button>
        </div>

        <!-- Profile -->
        <div id="profile" class="tab-content active">
          <div class="profile-settings">
            <div class="profile-left">
              <img src="{{ asset('images/paket ber4 xtra.png') }}" alt="Avatar">
              <br>
              <button class="btn-upload">Upload Baru</button>
            </div>
            <div class="profile-right">
              <label>Nama Depan *</label>
              <input type="text" placeholder="Nama depan">
              <label>Nama Belakang *</label>
              <input type="text" placeholder="Nama belakang">
              <label>Email</label>
              <input type="email" placeholder="email@barbekuy.com">
              <label>Nomor HP</label>
              <input type="text" placeholder="+62 812 3456 7890">
              <label>Jenis Kelamin</label>
              <div class="gender-group">
                <label><input type="radio" name="gender"> Laki-laki</label>
                <label><input type="radio" name="gender"> Perempuan</label>
              </div>
              <label>ID</label>
              <input type="text" placeholder="1599 000 7788 8DER">
              <label>Alamat</label>
              <textarea placeholder="Jl. Soedirman No. 23, Purwokerto"></textarea>
              <button class="btn-save">Simpan Perubahan</button>
            </div>
          </div>
        </div>

        <!-- Password -->
        <div id="password" class="tab-content">
          <form class="password-form">
            <label>Password Lama</label>
            <input type="password" placeholder="Masukkan password lama">
            <label>Password Baru</label>
            <input type="password" placeholder="Masukkan password baru">
            <label>Konfirmasi Password Baru</label>
            <input type="password" placeholder="Konfirmasi password baru">
            <button>Simpan Password</button>
          </form>
        </div>

        <!-- Notifikasi -->
        <div id="notif" class="tab-content">
          <div class="notif-settings">
            <div class="notif-item">
              <span>Notifikasi Email</span>
              <input type="checkbox" checked>
            </div>
            <div class="notif-item">
              <span>Notifikasi Pesan Masuk</span>
              <input type="checkbox">
            </div>
            <div class="notif-item">
              <span>Notifikasi Pembayaran</span>
              <input type="checkbox" checked>
            </div>
          </div>
        </div>

        <!-- Verifikasi -->
        <div id="verify" class="tab-content">
          <form class="verification">
            <label>Kode Verifikasi</label>
            <input type="text" placeholder="Masukkan kode 6 digit">
            <button>Verifikasi Akun</button>
          </form>
        </div>
      </div>
    </div>
  </main>

  <script>
    const tabs = document.querySelectorAll(".tab-btn");
    const contents = document.querySelectorAll(".tab-content");

    tabs.forEach(tab => {
      tab.addEventListener("click", () => {
        tabs.forEach(t => t.classList.remove("active"));
        contents.forEach(c => c.classList.remove("active"));
        tab.classList.add("active");
        document.getElementById(tab.dataset.tab).classList.add("active");
      });
    });
  </script>
  <input type="file" id="uploadFoto" accept="image/*" style="display:none;">

<script>
  // tombol upload di tab profil
  const btnUpload = document.querySelector(".btn-upload");
  const inputUpload = document.getElementById("uploadFoto");

  if (btnUpload && inputUpload) {
    btnUpload.addEventListener("click", () => {
      inputUpload.click(); // buka dialog choose file
    });

    // tampilkan preview foto setelah dipilih
    inputUpload.addEventListener("change", (event) => {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
          const img = document.querySelector(".profile-left img");
          img.src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    });
  }
</script>

</body>
</html>
