{{-- resources/views/admin/pengaturan.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pengaturan Akun | Barbekuy</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }
    body { background:#f5f6fa; display:flex; min-height:100vh; }
    /* === Layout scrollable tanpa geser topbar === */
    .main-content { flex:1; display:flex; flex-direction:column; height:100vh; overflow:hidden; }
    .content { flex:1; padding:30px 40px; overflow-y:auto; scroll-behavior:smooth; }
    .content::-webkit-scrollbar { width:8px; }
    .content::-webkit-scrollbar-thumb { background:#bbb; border-radius:8px; }
    .content::-webkit-scrollbar-thumb:hover { background:#888; }

    .content-box { background:#fff; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,.05); padding:28px; }
    .tabs { display:flex; border-bottom:2px solid #eee; margin-bottom:25px; flex-wrap:wrap; gap:5px; }
    .tab-btn { padding:10px 18px; font-size:14px; cursor:pointer; border:none; background:none; color:#555; transition:.2s; }
    .tab-btn.active { color:#751A25; font-weight:600; border-bottom:3px solid #751A25; }
    .tab-content { display:none; animation:fadeIn .25s ease; }
    .tab-content.active { display:block; }
    @keyframes fadeIn { from {opacity:0; transform:translateY(8px);} to {opacity:1; transform:translateY(0);} }

    .profile-settings { display:flex; flex-direction:column; gap:25px; }
    .profile-left { text-align:center; }
    .profile-left img { width:120px; height:120px; border-radius:50%; object-fit:cover; border:3px solid #751A25; margin-bottom:12px; }
    .btn-upload, .btn-save { background:#751A25; color:#fff; border:none; padding:10px 16px; border-radius:6px; cursor:pointer; font-weight:500; }
    .btn-upload:hover, .btn-save:hover { background:#3d030a; }
    .profile-right { display:flex; flex-direction:column; gap:14px; width:100%; max-width:600px; margin:auto; }
    label { font-size:13px; color:#555; margin-bottom:6px; display:block; }
    input, select, textarea { width:100%; padding:10px; border:1px solid #ccc; border-radius:6px; font-size:13px; outline:none; resize:vertical; }
    input:focus, textarea:focus { border-color:#751A25; }
    .gender-group { display:flex; gap:20px; align-items:center; }

    .password-form, .notif-settings, .verification { display:flex; flex-direction:column; gap:16px; width:100%; max-width:600px; margin:auto; }
    .notif-item { display:flex; justify-content:space-between; align-items:center; padding:12px 16px; border:1px solid #eee; border-radius:8px; background:#fafafa; }
    .notif-item input[type=checkbox]{ width:20px; height:20px; accent-color:#751A25; }

    .alert { padding:10px 12px; border-radius:8px; margin-bottom:14px; font-size:14px; }
    .alert-success { background:#e7f7ee; color:#0f5132; border:1px solid #badbcc; }
    .alert-error { background:#fde2e1; color:#842029; border:1px solid #f5c2c7; }
  </style>
</head>
<body>
  {{-- Sidebar + Topbar --}}
  @include('layouts.navbarAdmin')

  <main class="main-content">
    <div class="content">
      {{-- Flash messages --}}
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      @if($errors->any())
        <div class="alert alert-error">
          <ul style="margin-left:18px">
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

        {{-- ==================== PROFILE ==================== --}}
        <div id="profile" class="tab-content active">
          <form class="profile-settings"
                action="{{ route('admin.settings.profile.update') }}"
                method="POST"
                enctype="multipart/form-data">
            @csrf

            <div class="profile-left">
              {{-- Jika DB pakai avatar_path, ganti auth()->user()->avatar -> avatar_path --}}
              <img src="{{ auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : asset('images/paket ber4 xtra.png') }}" alt="Avatar">
              <br>
              <button type="button" class="btn-upload" id="btnUpload">Upload Baru</button>
              <input type="file" id="uploadFoto" name="avatar" accept="image/*" style="display:none;">
            </div>

            <div class="profile-right">
              <div>
                <label>Nama Depan *</label>
                <input type="text" name="first_name" placeholder="Nama depan" value="{{ old('first_name', auth()->user()->first_name) }}">
              </div>
              <div>
                <label>Nama Belakang *</label>
                <input type="text" name="last_name" placeholder="Nama belakang" value="{{ old('last_name', auth()->user()->last_name) }}">
              </div>
              <div>
                <label>Email</label>
                <input type="email" name="email" placeholder="email@barbekuy.com" value="{{ old('email', auth()->user()->email) }}">
              </div>
              <div>
                <label>Nomor HP</label>
                <input type="text" name="phone" placeholder="+62 812 3456 7890" value="{{ old('phone', auth()->user()->phone) }}">
              </div>
              <div>
                <label>Jenis Kelamin</label>
                <div class="gender-group">
                  <label><input type="radio" name="gender" value="L" {{ old('gender', auth()->user()->gender) === 'L' ? 'checked' : '' }}> Laki-laki</label>
                  <label><input type="radio" name="gender" value="P" {{ old('gender', auth()->user()->gender) === 'P' ? 'checked' : '' }}> Perempuan</label>
                </div>
              </div>
              <div>
                <label>Alamat</label>
                <textarea name="address" placeholder="Jl. Soedirman No. 23, Purwokerto">{{ old('address', auth()->user()->address) }}</textarea>
              </div>

              <button class="btn-save" type="submit">Simpan Perubahan</button>
            </div>
          </form>
        </div>

        {{-- ==================== PASSWORD ==================== --}}
        <div id="password" class="tab-content">
          <form class="password-form" action="{{ route('admin.settings.password.update') }}" method="POST">
            @csrf
            <div>
              <label>Password Lama</label>
              <input type="password" name="old_password" placeholder="Masukkan password lama">
            </div>
            <div>
              <label>Password Baru</label>
              <input type="password" name="password" placeholder="Masukkan password baru">
            </div>
            <div>
              <label>Konfirmasi Password Baru</label>
              <input type="password" name="password_confirmation" placeholder="Konfirmasi password baru">
            </div>
            <button type="submit" class="btn-save">Simpan Password</button>
          </form>
        </div>

        {{-- ==================== NOTIFIKASI ==================== --}}
        <div id="notif" class="tab-content">
          <form class="notif-settings" action="{{ route('admin.settings.notif.update') }}" method="POST">
            @csrf
            <div class="notif-item">
              <span>Notifikasi Email</span>
              <input type="checkbox" name="notif_email" value="1" {{ old('notif_email', auth()->user()->notif_email) ? 'checked' : '' }}>
            </div>
            <div class="notif-item">
              <span>Notifikasi Pembayaran</span>
              <input type="checkbox" name="notif_payment" value="1" {{ old('notif_payment', auth()->user()->notif_payment) ? 'checked' : '' }}>
            </div>
            <button type="submit" class="btn-save" style="align-self:end;">Simpan</button>
          </form>
        </div>
      </div>
    </div>
  </main>

  <script>
    // Tabs handler
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

    // Upload avatar preview
    const btnUpload = document.getElementById("btnUpload");
    const inputUpload = document.getElementById("uploadFoto");
    if (btnUpload && inputUpload) {
      btnUpload.addEventListener("click", () => inputUpload.click());
      inputUpload.addEventListener("change", (event) => {
        const file = event.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = (e) => {
          const img = document.querySelector(".profile-left img");
          img.src = e.target.result;
        };
        reader.readAsDataURL(file);
      });
    }
  </script>
</body>
</html>
