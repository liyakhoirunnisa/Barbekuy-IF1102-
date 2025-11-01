<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pengaturan Akun | Barbekuy</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

  {{-- Bootstrap --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: #f5f6fa;
      min-height: 100vh;
      display: block;
      line-height: 1.6;
    }

    /* Hilangkan sidebar lama */
    .sidebar, .sidebar-wrapper, .sidebar-left, .sidenav {
      display: none !important;
    }

    .with-sidebar, .has-sidebar, .content-wrap {
      margin-left: 0 !important;
    }

    /* Layout utama */
    .main-content {
      display: block;
      min-height: calc(100vh - 64px);
    }

    .content {
      padding: 30px 20px;
      max-width: 880px;
      margin: 0 auto;
      overflow-y: visible;
    }

    .content-box {
      background: #fff;
      border-radius: 14px;
      box-shadow: 0 1px 8px rgba(0,0,0,0.08);
      padding: 32px 36px;
      max-width: 780px;
      margin: 0 auto;
    }

    /* Tabs */
    .tabs {
      display: flex;
      justify-content: center;
      border-bottom: 2px solid #eee;
      margin-bottom: 40px; /* 🔹 lebih lebar jaraknya */
      gap: 24px; /* 🔹 jarak antar tombol diperlebar */
      flex-wrap: wrap;
    }

    .tab-btn {
      padding: 14px 24px; /* 🔹 tombol lebih besar */
      font-size: 15px;
      cursor: pointer;
      border: none;
      background: none;
      color: #555;
      font-weight: 500;
      transition: 0.25s;
    }

    .tab-btn:hover {
      color: #751A25;
      background-color: #f7f2f3;
      border-radius: 6px;
    }

    .tab-btn.active {
      color: #751A25;
      font-weight: 600;
      border-bottom: 3px solid #751A25;
    }

    .tab-content {
      display: none;
      animation: fadeIn 0.25s ease;
    }

    .tab-content.active {
      display: block;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* Profile Section */
    .profile-settings {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 28px;
    }

    .profile-left {
      text-align: center;
    }

    .profile-left img {
      width: 110px;
      height: 110px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #751A25;
      margin-bottom: 12px;
    }

    .btn-upload {
      background: #751A25;
      color: #fff;
      border: none;
      padding: 9px 16px;
      border-radius: 6px;
      cursor: pointer;
      font-size: 13.5px;
    }

    .btn-upload:hover {
      background: #3d030a;
    }

    .profile-right {
      width: 100%;
      max-width: 540px;
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    label {
      font-size: 13.5px;
      color: #444;
      margin-bottom: 6px;
      font-weight: 500;
    }

    input, select, textarea {
      width: 100%;
      padding: 10px 12px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 13.5px;
      outline: none;
      resize: vertical;
      background: #fff;
    }

    input:focus, textarea:focus {
      border-color: #751A25;
      box-shadow: 0 0 0 2px rgba(117,26,37,.08);
    }

    .gender-group {
      display: flex;
      gap: 25px;
      align-items: center;
      margin-top: 5px;
    }

    .btn-save {
      align-self: center;
      background: #751A25;
      color: #fff;
      border: none;
      padding: 10px 28px;
      border-radius: 6px;
      cursor: pointer;
      font-weight: 500;
      margin-top: 10px;
    }

    .btn-save:hover {
      background: #3d030a;
    }

    /* Password */
    .password-form {
      display: flex;
      flex-direction: column;
      gap: 22px;
      width: 100%;
      max-width: 480px;
      margin: 0 auto;
    }

    .password-form button {
      align-self: center;
      background: #751A25;
      color: #fff;
      padding: 10px 28px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-weight: 500;
    }

    .password-form button:hover {
      background: #3d030a;
    }

    /* Notifikasi */
    .notif-settings {
      display: flex;
      flex-direction: column;
      gap: 18px;
      width: 100%;
      max-width: 540px;
      margin: 0 auto;
    }

    .notif-item {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 14px 18px;
      border: 1px solid #eee;
      border-radius: 8px;
      background: #fafafa;
    }

    .notif-item span {
      color: #333;
      font-weight: 500;
    }

    .notif-item input[type=checkbox] {
      width: 18px;
      height: 18px;
      accent-color: #751A25;
    }

    /* Alert */
    .alert {
      padding: 12px 14px;
      border-radius: 8px;
      margin-bottom: 18px;
      font-size: 14px;
    }

    .alert-success {
      background: #e7f7ee;
      color: #0f5132;
      border: 1px solid #badbcc;
    }

    .alert-error {
      background: #fde2e1;
      color: #842029;
      border: 1px solid #f5c2c7;
    }

    @media (max-width: 576px) {
      .content { padding: 16px; }
      .content-box { padding: 18px; }
      .tabs { gap: 12px; margin-bottom: 30px; }
      .tab-btn { padding: 10px 14px; font-size: 14px; }
    }
  </style>
</head>
<body>

  {{-- ✅ Navbar atas --}}
  @include('layouts.navbar')

  <main class="main-content">
    <div class="content">
      {{-- Flash messages --}}
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      @if($errors->any())
        <div class="alert alert-error">
          <ul style="margin-left:18px;">
            @foreach($errors->all() as $e)
              <li>{{ $e }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <div class="content-box">
        <div class="tabs">
          <button class="tab-btn active" data-tab="profile">Pengaturan Profil</button>
          <button class="tab-btn" data-tab="password">Pengaturan Password</button>
          <button class="tab-btn" data-tab="notif">Pengaturan Notifikasi</button>
        </div>

        {{-- PROFILE --}}
        <div id="profile" class="tab-content active">
          <form class="profile-settings"
                action="{{ route('pengaturan.profile.update') }}"
                method="POST" enctype="multipart/form-data">
            @csrf
            <div class="profile-left">
              <img src="{{ auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : asset('images/paket ber4 xtra.png') }}" alt="Avatar">
              <br>
              <button type="button" class="btn-upload" id="btnUpload">Upload Baru</button>
              <input type="file" id="uploadFoto" name="avatar" accept="image/*" style="display:none;">
            </div>

            <div class="profile-right">
              <label>Nama Depan *</label>
              <input type="text" name="first_name" placeholder="Nama depan" value="{{ old('first_name', auth()->user()->first_name) }}">

              <label>Nama Belakang *</label>
              <input type="text" name="last_name" placeholder="Nama belakang" value="{{ old('last_name', auth()->user()->last_name) }}">

              <label>Email</label>
              <input type="email" name="email" placeholder="email@barbekuy.com" value="{{ old('email', auth()->user()->email) }}">

              <label>Nomor HP</label>
              <input type="text" name="phone" placeholder="+62 812 3456 7890" value="{{ old('phone', auth()->user()->phone) }}">

              <label>Jenis Kelamin</label>
              <div class="gender-group">
                <label><input type="radio" name="gender" value="L" {{ old('gender', auth()->user()->gender) === 'L' ? 'checked' : '' }}> Laki-laki</label>
                <label><input type="radio" name="gender" value="P" {{ old('gender', auth()->user()->gender) === 'P' ? 'checked' : '' }}> Perempuan</label>
              </div>

              <label>Alamat</label>
              <textarea name="address" placeholder="Jl. Soedirman No. 23, Purwokerto">{{ old('address', auth()->user()->address) }}</textarea>

              <button class="btn-save" type="submit">Simpan Perubahan</button>
            </div>
          </form>
        </div>

        {{-- PASSWORD --}}
        <div id="password" class="tab-content">
          <form class="password-form" action="{{ route('pengaturan.password.update') }}" method="POST">
            @csrf
            <label>Password Lama</label>
            <input type="password" name="old_password" placeholder="Masukkan password lama">

            <label>Password Baru</label>
            <input type="password" name="password" placeholder="Masukkan password baru">

            <label>Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" placeholder="Konfirmasi password baru">

            <button type="submit">Simpan Password</button>
          </form>
        </div>

        {{-- NOTIFIKASI --}}
        <div id="notif" class="tab-content">
          <form class="notif-settings" action="{{ route('pengaturan.notif.update') }}" method="POST">
            @csrf
            <div class="notif-item">
              <span>Notifikasi Email</span>
              <input type="checkbox" name="notif_email" value="1" {{ old('notif_email', auth()->user()->notif_email) ? 'checked' : '' }}>
            </div>
            <div class="notif-item">
              <span>Notifikasi Pesan Masuk</span>
              <input type="checkbox" name="notif_message" value="1" {{ old('notif_message', auth()->user()->notif_message) ? 'checked' : '' }}>
            </div>
            <div class="notif-item">
              <span>Notifikasi Pembayaran</span>
              <input type="checkbox" name="notif_payment" value="1" {{ old('notif_payment', auth()->user()->notif_payment) ? 'checked' : '' }}>
            </div>
            <button class="btn-save" type="submit">Simpan</button>
          </form>
        </div>
      </div>
    </div>
  </main>

  {{-- Bootstrap JS --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // Tabs
    document.querySelectorAll(".tab-btn").forEach(btn=>{
      btn.addEventListener("click",()=>{
        document.querySelectorAll(".tab-btn").forEach(b=>b.classList.remove("active"));
        document.querySelectorAll(".tab-content").forEach(c=>c.classList.remove("active"));
        btn.classList.add("active");
        document.getElementById(btn.dataset.tab).classList.add("active");
      });
    });

    // Upload preview
    const btnUpload = document.getElementById("btnUpload");
    const inputUpload = document.getElementById("uploadFoto");
    if (btnUpload && inputUpload) {
      btnUpload.addEventListener("click", ()=> inputUpload.click());
      inputUpload.addEventListener("change", (e)=>{
        const file = e.target.files && e.target.files[0];
        if (!file) return;
        const r = new FileReader();
        r.onload = ev => {
          const img = document.querySelector(".profile-left img");
          if (img) img.src = ev.target.result;
        };
        r.readAsDataURL(file);
      });
    }
  </script>
</body>
</html>
