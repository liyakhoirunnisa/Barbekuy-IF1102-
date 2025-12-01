<!DOCTYPE html> <!-- Deklarasi dokumen HTML5 -->
<html lang="id"> <!-- Bahasa dokumen Indonesia -->

<head> <!-- Bagian head untuk metadata & style -->
  <meta charset="UTF-8"> <!-- Set encoding karakter -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Responsif di semua device -->
  <title>Pengaturan Akun | Barbekuy</title> <!-- Judul halaman -->
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}"> <!-- Favicon Barbekuy -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> <!-- CDN Font Awesome -->

  {{-- Google Font --}}
  <!-- Import font Poppins dari Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
    * {
      /* Reset dan default styling */
      margin: 0;
      /* Hilangkan margin */
      padding: 0;
      /* Hilangkan padding */
      box-sizing: border-box;
      /* Hitung ukuran termasuk border */
      font-family: 'Poppins', sans-serif;
      /* Gunakan font Poppins */
    }

    /* Kunci tinggi & hilangkan scroll besar */
    html,
    body {
      height: 100%;
      /* Kunci tinggi halaman */
      overflow: hidden;
      /* Nonaktifkan scroll besar */
    }

    body {
      background: #f5f6fa;
      /* Warna background halaman */
      display: flex;
      /* Layout flex */
      min-height: 100vh;
      /* Minimal tinggi layar penuh */
    }

    /* === Layout: body -> (sidebar + main-content) === */
    .main-content {
      flex: 1;
      /* Isi seluruh ruang selain sidebar */
      display: flex;
      /* Flex layout */
      flex-direction: column;
      /* Tata secara vertikal */
      min-height: calc(100vh - 90px);
      /* Batasi area konten di bawah topbar */
    }

    .content {
      flex: 1;
      /* Isi ruang tersisa */
      padding: 30px 40px;
      /* Jarak dalam konten */
      scroll-behavior: smooth;
      /* Scroll halus */
    }

    /* Card utama yang membungkus tab + isi */
    .content-box {
      background: #fff;
      /* Card berwarna putih */
      border-radius: 12px;
      /* Sudut melengkung */
      box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
      /* Shadow lembut */
      display: flex;
      /* Flex layout */
      flex-direction: column;
      /* Susunan ke bawah */
      height: calc(100vh - 90px - 60px);
      /* Tinggi penuh dikurangi topbar */
    }

    /* Tab di bagian atas card */
    .tabs {
      display: flex;
      /* Barisan tab */
      border-bottom: 2px solid #eee;
      /* Garis bawah tab */
      flex-wrap: wrap;
      /* Tab melipat jika sempit */
      gap: 5px;
      /* Jarak antar tombol tab */
      padding: 20px 28px 0 28px;
      /* Padding atas tab */
    }

    .tab-btn {
      padding: 10px 18px;
      /* Ukuran tombol tab */
      font-size: 14px;
      /* Ukuran teks */
      cursor: pointer;
      /* Pointer klik */
      border: none;
      /* Tanpa border */
      background: none;
      /* Tanpa background */
      color: #555;
      /* Warna teks */
      transition: .2s;
      /* Animasi hover */
    }

    .tab-btn.active {
      color: #751A25;
      /* Warna tab aktif */
      font-weight: 600;
      /* Teks tebal */
      border-bottom: 3px solid #751A25;
      /* Garis bawah tab aktif */
    }

    /* Area isi tab yang boleh scroll */
    .tab-scroll {
      flex: 1;
      /* Isi ruang tab */
      overflow-y: auto;
      /* Scroll vertikal */
      padding: 20px 28px 28px 28px;
      /* Padding isi tab */
    }

    .tab-scroll::-webkit-scrollbar {
      width: 8px;
      /* Lebar scrollbar */
    }

    .tab-scroll::-webkit-scrollbar-thumb {
      background: #bbb;
      /* Warna scrollbar */
      border-radius: 8px;
      /* Radius thumb */
    }

    .tab-scroll::-webkit-scrollbar-thumb:hover {
      background: #888;
      /* Warna saat hover */
    }

    .tab-content {
      display: none;
      /* Default tab disembunyikan */
      animation: fadeIn .25s ease;
      /* Animasi muncul */
    }

    .tab-content.active {
      display: block;
      /* Tampilkan tab aktif */
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        /* Transparan awal */
        transform: translateY(8px);
        /* Bergerak dari bawah */
      }

      to {
        opacity: 1;
        /* Tampak penuh */
        transform: translateY(0);
        /* Posisi normal */
      }
    }

    .profile-settings {
      display: flex;
      /* Layout flex */
      flex-direction: column;
      /* Susunan kolom */
      gap: 25px;
      /* Jarak antar elemen */
    }

    .profile-left {
      text-align: center;
      /* Foto dan tombol rata tengah */
    }

    .profile-left img {
      width: 120px;
      /* Lebar foto profil */
      height: 120px;
      /* Tinggi foto profil */
      border-radius: 50%;
      /* Bentuk lingkaran */
      object-fit: cover;
      /* Crop sesuai lingkaran */
      border: 3px solid #751A25;
      /* Border warna brand */
      margin-bottom: 12px;
      /* Jarak bawah */
    }

    /* Semua tombol utama seragam */
    .btn-upload,
    .btn-save {
      background: #751A25;
      /* Warna tombol */
      color: #fff;
      /* Warna teks */
      border: none;
      /* Tanpa border */
      padding: 6px 14px;
      /* Ukuran tombol */
      border-radius: 6px;
      /* Sudut membulat */
      cursor: pointer;
      /* Pointer klik */
      font-weight: 500;
      /* Ketebalan teks */
      font-size: 13px;
      /* Ukuran teks */
    }

    .btn-upload:hover,
    .btn-save:hover {
      background: #3d030a;
      /* Warna hover */
    }

    .btn-cancel {
      background: #ccc;
      /* Warna tombol cancel */
      color: #333;
      /* Warna teks cancel */
    }

    .btn-cancel:hover {
      background: #b5b5b5;
      /* Hover tombol cancel */
      color: #333;
      /* Teks tetap */
    }

    /* Tombol di form password */
    .password-form .btn-save {
      align-self: flex-end;
      /* Tempatkan tombol kanan bawah */
      width: auto;
      /* Ukuran otomatis */
    }

    .profile-right {
      display: flex;
      /* Layout flex */
      flex-direction: column;
      /* Susunan vertikal */
      gap: 14px;
      /* Jarak antar input */
      width: 100%;
      /* Lebar penuh */
      max-width: 600px;
      /* Batas lebar */
      margin: auto;
      /* Tengah secara horizontal */
    }

    label {
      font-size: 13px;
      /* Ukuran teks label */
      color: #555;
      /* Warna label */
      margin-bottom: 6px;
      /* Jarak ke input */
      display: block;
      /* Biar turun baris */
    }

    input,
    select,
    textarea {
      width: 100%;
      /* Full width */
      padding: 10px;
      /* Ruang dalam */
      border: 1px solid #ccc;
      /* Border abu */
      border-radius: 6px;
      /* Sudut lembut */
      font-size: 13px;
      /* Ukuran teks */
      outline: none;
      /* Hilangkan outline */
      resize: vertical;
      /* Hanya resize vertikal */
    }

    input:focus,
    textarea:focus {
      border-color: #751A25;
      /* Warna saat fokus */
    }

    .gender-group {
      display: flex;
      /* Input gender horizontal */
      gap: 20px;
      /* Jarak antar gender */
      align-items: center;
      /* Rata tengah */
    }

    .password-form,
    .verification {
      display: flex;
      /* Flex layout */
      flex-direction: column;
      /* Susunan kolom */
      gap: 16px;
      /* Jarak antar elemen */
      width: 100%;
      /* Full width */
      max-width: 600px;
      /* Batas lebar */
      margin: auto;
      /* Tengah */
    }

    .profile-actions {
      display: flex;
      /* Tombol sejajar */
      gap: 10px;
      /* Jarak tombol */
      justify-content: flex-end;
      /* Posisi kanan */
      margin-top: 10px;
      /* Jarak atas */
    }

    .hidden-input {
      display: none;
      /* Sembunyikan input */
    }

    .error-list {
      margin-left: 18px;
      /* Geser daftar error */
    }

    .alert {
      padding: 10px 12px;
      /* Padding alert */
      border-radius: 8px;
      /* Sudut membulat */
      margin-bottom: 14px;
      /* Jarak antar alert */
      font-size: 14px;
      /* Ukuran teks alert */
    }

    .alert-success {
      background: #e7f7ee;
      /* Warna sukses */
      color: #0f5132;
      /* Teks hijau */
      border: 1px solid #badbcc;
      /* Border hijau muda */
    }

    .alert-error {
      background: #fde2e1;
      /* Warna error */
      color: #842029;
      /* Teks merah tua */
      border: 1px solid #f5c2c7;
      /* Border merah muda */
    }

    /* === RESPONSIVE: Tabs dapat di-scroll ke kanan di HP === */
    @media (max-width: 768px) {
      .tabs {
        flex-wrap: nowrap;
        /* Tidak melipat */
        overflow-x: auto;
        /* Scroll ke kanan */
        overflow-y: hidden;
        /* Nonaktif scroll vertikal */
        -webkit-overflow-scrolling: touch;
        /* Smooth scroll */
      }

      .tab-btn {
        flex: 0 0 auto;
        /* Tetap ukuran */
        white-space: nowrap;
        /* Jangan pecah baris */
      }
    }
  </style>
</head>

<body> {{-- Tag pembuka body halaman --}}

  {{-- Sidebar + Topbar --}}
  @include('layouts.navbarAdmin') {{-- Sertakan navbar & sidebar admin --}}

  <main class="main-content"> {{-- Kontainer utama konten utama --}}
    <div class="content"> {{-- Wrapper konten untuk padding dan scroll --}}

      {{-- Flash messages --}}
      {{-- Area notifikasi sukses --}}
      @if(session('success')) {{-- Jika ada pesan sukses --}}
      <div class="alert alert-success">
        {{ session('success') }} {{-- Tampilkan pesan sukses --}}
      </div>
      @endif {{-- Tutup pengecekan success --}}

      {{-- Area notifikasi error --}}
      @if($errors->any()) {{-- Jika ada error validasi --}}
      <div class="alert alert-error"> {{-- Container error --}}
        <ul class="error-list"> {{-- Daftar error --}}
          @foreach($errors->all() as $e) {{-- Loop setiap error --}}
          <li>{{ $e }}</li> {{-- Tampilkan item error --}}
          @endforeach {{-- Tutup foreach --}}
        </ul>
      </div>
      @endif {{-- Tutup error section --}}

      <div class="content-box"> {{-- Box utama berisi tabs --}}

        <div class="tabs"> {{-- Container tombol tab --}}
          <button class="tab-btn active" data-tab="profile">Pengaturan Profil</button>
          <button class="tab-btn" data-tab="password">Pengaturan Password</button>
        </div>

        <div class="tab-scroll"> {{-- Area scroll isi tab --}}

          {{-- ==================== PROFILE ==================== --}}
          <div id="profile" class="tab-content active"> {{-- Tab profil tampil default --}}

            {{-- Form pengaturan profil --}}
            <form
              class="profile-settings"
              action="{{ route('admin.settings.profile.update') }}" {{-- Route untuk update profil --}}
              method="POST" {{-- Form metode POST --}}
              enctype="multipart/form-data" {{-- Enctype untuk upload gambar --}}>
              @csrf {{-- Token CSRF wajib untuk keamanan --}}

              <div class="profile-left"> {{-- Kolom kiri untuk avatar --}}

                {{-- Menampilkan avatar user (jika ada) atau fallback --}}
                <img
                  src="{{ auth()->user()->avatar ? asset('storage/'.auth()->user()->avatar) : asset('images/paket ber4 xtra.png') }}"
                  alt="Avatar">

                <br> {{-- Jarak vertikal --}}

                {{-- Tombol trigger untuk memilih foto --}}
                <button type="button" class="btn-upload" id="btnUpload">Upload Baru</button>

                {{-- Input file tersembunyi untuk upload avatar --}}
                <input
                  type="file"
                  id="uploadFoto"
                  name="avatar"
                  accept="image/*"
                  class="hidden-input">
              </div>

              <div class="profile-right"> {{-- Kolom kanan untuk detail profil --}}

                {{-- Input nama depan --}}
                <div>
                  <label>Nama Depan *</label>
                  <input
                    type="text"
                    name="first_name"
                    placeholder="Nama depan"
                    value="{{ old('first_name', auth()->user()->first_name) }}"
                    readonly {{-- Tidak bisa diedit sebelum klik Edit --}}>
                </div>

                {{-- Input nama belakang --}}
                <div>
                  <label>Nama Belakang *</label>
                  <input
                    type="text"
                    name="last_name"
                    placeholder="Nama belakang"
                    value="{{ old('last_name', auth()->user()->last_name) }}"
                    readonly>
                </div>

                {{-- Input email --}}
                <div>
                  <label>Email</label>
                  <input
                    type="email"
                    name="email"
                    placeholder="email@gmail.com"
                    value="{{ old('email', auth()->user()->email) }}"
                    readonly>
                </div>

                {{-- Input nomor HP --}}
                <div>
                  <label>Nomor HP</label>
                  <input
                    type="text"
                    name="phone"
                    placeholder="Nomor HP"
                    value="{{ old('phone', auth()->user()->phone) }}"
                    readonly>
                </div>

                {{-- Radio gender --}}
                <div>
                  <label>Jenis Kelamin</label>
                  <div class="gender-group">

                    {{-- Gender Laki-laki --}}
                    <label>
                      <input
                        type="radio"
                        name="gender"
                        value="L"
                        {{ old('gender', auth()->user()->gender) === 'L' ? 'checked' : '' }}
                        disabled>
                      Laki-laki
                    </label>

                    {{-- Gender Perempuan --}}
                    <label>
                      <input
                        type="radio"
                        name="gender"
                        value="P"
                        {{ old('gender', auth()->user()->gender) === 'P' ? 'checked' : '' }}
                        disabled>
                      Perempuan
                    </label>
                  </div>
                </div>

                {{-- Input alamat --}}
                <div>
                  <label>Alamat</label>
                  <textarea
                    name="address"
                    placeholder="Alamat"
                    readonly>{{ old('address', auth()->user()->address) }}</textarea>
                </div>

                {{-- Tombol aksi --}}
                <div class="profile-actions">
                  <button type="button" id="btnEdit" class="btn-save">Edit</button>
                  <button type="submit" id="btnSave" class="btn-save hidden-input">Simpan</button>
                  <button type="button" id="btnCancel" class="btn-save btn-cancel hidden-input">Batal</button>
                </div>

              </div> {{-- End profile-right --}}
            </form>
          </div> {{-- End profile tab --}}

          {{-- ==================== PASSWORD ==================== --}}
          <div id="password" class="tab-content"> {{-- Tab password --}}

            {{-- Form password --}}
            <form
              class="password-form"
              action="{{ route('admin.settings.password.update') }}"
              method="POST">
              @csrf {{-- Token CSRF --}}

              {{-- Input password lama --}}
              <div>
                <label>Password Lama</label>
                <input type="password" name="old_password" placeholder="Masukkan password lama">
              </div>

              {{-- Input password baru --}}
              <div>
                <label>Password Baru</label>
                <input type="password" name="password" placeholder="Masukkan password baru">
              </div>

              {{-- Konfirmasi password --}}
              <div>
                <label>Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" placeholder="Konfirmasi password baru">
              </div>

              {{-- Submit --}}
              <button type="submit" class="btn-save">Simpan Password</button>
            </form>
          </div> {{-- End password tab --}}

        </div> {{-- End tab-scroll --}}
      </div> {{-- End content-box --}}

    </div> {{-- End content --}}
  </main>

  {{-- Script interaksi halaman --}}
  <script>
    // --- Handler tab switching ---
    const tabs = document.querySelectorAll(".tab-btn"); // Semua tombol tab
    const contents = document.querySelectorAll(".tab-content"); // Semua konten tab

    tabs.forEach(tab => { // Loop semua tombol tab
      tab.addEventListener("click", () => { // Event klik tab

        tabs.forEach(t => t.classList.remove("active")); // Hilangkan active
        contents.forEach(c => c.classList.remove("active")); // Sembunyikan konten

        tab.classList.add("active"); // Aktifkan tab diklik
        document.getElementById(tab.dataset.tab).classList.add("active"); // Tampilkan konten sesuai data-tab
      });
    });

    // --- Upload avatar preview ---
    const btnUpload = document.getElementById("btnUpload"); // Tombol upload
    const inputUpload = document.getElementById("uploadFoto"); // Input file

    if (btnUpload && inputUpload) {
      btnUpload.addEventListener("click", () => inputUpload.click()); // Klik tombol → buka file picker

      inputUpload.addEventListener("change", (event) => { // Ketika file dipilih
        const file = event.target.files[0]; // Ambil file
        if (!file) return;

        const reader = new FileReader(); // Buat pembaca file
        reader.onload = (e) => {
          const img = document.querySelector(".profile-left img"); // Pilih elemen gambar
          img.src = e.target.result; // Tampilkan preview avatar
        };
        reader.readAsDataURL(file); // Baca file
      });
    }
  </script>

</body>

</html>