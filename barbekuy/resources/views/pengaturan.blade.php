<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Akun | Barbekuy</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    {{-- Icon --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        /* ✨ TAMBAHAN: kunci tinggi & matikan scroll besar */
        html,
        body {
            height: 100%;
            overflow: hidden;
            /* << ini yang menghilangkan scroll besar */
        }

        body {
            background: #f5f6fa;
            min-height: 100vh;
        }

        .main-content {
            min-height: calc(100vh - 56px);
            display: flex;
            flex-direction: column;
        }

        .content {
            flex: 1;
            padding: 30px 40px;
            /* jangan pakai overflow-y di sini */
            scroll-behavior: smooth;
        }

        .content-box {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            /* padding: 28px;  <- biarkan pakai layout baru */
            display: flex;
            flex-direction: column;
            height: calc(100vh - 56px - 60px);
            /* kira-kira tinggi card */
        }

        .tabs {
            display: flex;
            border-bottom: 2px solid #eee;
            flex-wrap: wrap;
            gap: 5px;
            padding: 20px 28px 0 28px;
        }

        .tab-scroll {
            flex: 1;
            overflow-y: auto;
            /* hanya ini yang boleh scroll */
            padding: 20px 28px 28px 28px;
        }

        .tab-btn {
            padding: 10px 18px;
            font-size: 14px;
            cursor: pointer;
            border: none;
            background: none;
            outline: none;
            color: #555;
            transition: 0.3s;
        }

        .tab-btn.active {
            color: #751A25;
            font-weight: 600;
            border-bottom: 3px solid #751A25;
        }

        .tab-content {
            display: none;
            animation: fadeIn 0.3s ease;
        }

        .tab-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .profile-settings {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .profile-left {
            text-align: center;
        }

        .profile-left img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #751A25;
            margin-bottom: 12px;
        }

        .btn-upload {
            background: #751A25;
            color: #fff;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            transition: 0.3s;
        }

        .btn-upload:hover {
            background: #3d030a;
        }

        .profile-right {
            display: flex;
            flex-direction: column;
            gap: 18px;
            width: 100%;
            max-width: 600px;
            margin: auto;
        }

        label {
            font-size: 13px;
            color: #555;
            margin-bottom: 5px;
            display: block;
        }

        /* HANYA untuk form di konten pengaturan, bukan navbar */
        .main-content input,
        .main-content select,
        .main-content textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 13px;
            outline: none;
            resize: vertical;
        }

        input:focus,
        textarea:focus {
            border-color: #751A25;
        }

        .gender-group {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .btn-save {
            align-self: end;
            background: #751A25;
            color: #fff;
            border: none;
            padding: 6px 14px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            font-size: 13px;
            transition: 0.3s;
        }

        .btn-save:hover {
            background: #3d030a;
        }

        .password-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
            width: 100%;
            max-width: 500px;
            margin: auto;
        }

        .password-form input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .password-form button {
            align-self: end;
            background: #751A25;
            color: #fff;
            padding: 6px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            font-size: 13px;
            transition: 0.3s;
        }

        .password-form button:hover {
            background: #3d030a;
        }

        .notif-settings {
            display: flex;
            flex-direction: column;
            gap: 15px;
            width: 100%;
            max-width: 600px;
            margin: auto;
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
            width: 20px;
            height: 20px;
            accent-color: #751A25;
        }

        .verification {
            max-width: 400px;
            margin: auto;
            display: flex;
            flex-direction: column;
            gap: 18px;
            background: #fafafa;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #eee;
        }

        .verification input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .verification button {
            background: #751A25;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: 0.3s;
        }

        .verification button:hover {
            background: #3d030a;
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

        .alert {
            padding: 10px 12px;
            border-radius: 8px;
            margin-bottom: 14px;
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
    </style>
</head>

<body>
    @include('layouts.navbar')

    <main class="main-content">
        <div class="content">
            <div class="container">
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
                    </div>

                    <div class="tab-scroll">
                        {{-- PROFILE --}}
                        <div id="profile" class="tab-content active">
                            <form class="profile-settings" action="{{ route('pengaturan.profil.update') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="profile-left">
                                    <img
                                        src="{{ auth()->user()->avatar_path ? asset('storage/'.auth()->user()->avatar_path) : asset('images/paket ber4 xtra.png') }}"
                                        alt="Avatar">
                                    <br>
                                    <button type="button" class="btn-upload">Upload Baru</button>
                                    <input type="file" id="uploadFoto" name="avatar" accept="image/*" style="display:none;">
                                </div>

                                <div class="profile-right">
                                    <label>Nama Depan *</label>
                                    <input type="text" name="first_name" placeholder="Nama depan"
                                        value="{{ old('first_name', auth()->user()->first_name) }}"
                                        readonly class="readonly-field">

                                    <label>Nama Belakang *</label>
                                    <input type="text" name="last_name" placeholder="Nama belakang"
                                        value="{{ old('last_name', auth()->user()->last_name) }}"
                                        readonly class="readonly-field">

                                    <label>Email</label>
                                    <input type="email" name="email" placeholder="email@gmail.com"
                                        value="{{ old('email', auth()->user()->email) }}"
                                        readonly class="readonly-field">

                                    <label>Nomor HP</label>
                                    <input type="text" name="phone" placeholder="Nomor HP"
                                        value="{{ old('phone', auth()->user()->phone) }}"
                                        readonly class="readonly-field">
                                    <label>Jenis Kelamin</label>
                                    <div class="gender-group">
                                        <label>
                                            <input type="radio" name="gender" value="L"
                                                {{ old('gender', auth()->user()->gender) === 'L' ? 'checked' : '' }}
                                                disabled>
                                            Laki-laki
                                        </label>
                                        <label>
                                            <input type="radio" name="gender" value="P"
                                                {{ old('gender', auth()->user()->gender) === 'P' ? 'checked' : '' }}
                                                disabled>
                                            Perempuan
                                        </label>
                                    </div>

                                    <label>Alamat</label>
                                    <textarea name="address" placeholder="Alamat"
                                        readonly class="readonly-field">{{ old('address', auth()->user()->address) }}</textarea>

                                    <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:10px;">
                                        <button type="button" id="btnEdit" class="btn-save">Edit</button>
                                        <button type="submit" id="btnSave" class="btn-save" style="display:none;">Simpan</button>
                                        <button type="button" id="btnCancel" class="btn-save"
                                            style="background:#ccc;color:#333;display:none;">Batal</button>
                                    </div>
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
                    </div>
                </div>
            </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Tabs
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
        const btnUpload = document.querySelector(".btn-upload");
        const inputUpload = document.getElementById("uploadFoto");
        if (btnUpload && inputUpload) {
            btnUpload.addEventListener("click", () => inputUpload.click());
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

        // Mode Edit Profil
        const btnEdit = document.getElementById('btnEdit');
        const btnSave = document.getElementById('btnSave');
        const btnCancel = document.getElementById('btnCancel');

        if (btnEdit && btnSave && btnCancel) {
            const profileFields = document.querySelectorAll(
                "#profile .profile-right input, #profile .profile-right textarea, #profile .profile-right select"
            );

            btnEdit.addEventListener("click", () => {
                profileFields.forEach(f => {
                    f.removeAttribute("readonly");
                    f.removeAttribute("disabled");
                });

                btnEdit.style.display = "none";
                btnSave.style.display = "inline-block";
                btnCancel.style.display = "inline-block";
            });

            btnCancel.addEventListener("click", () => {
                window.location.reload();
            });
        }
    </script>
</body>

</html>