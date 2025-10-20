<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Barbekuy</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fff;
        }

        .register-container {
            display: flex;
            min-height: 100vh; /* ubah dari height: 100vh ke min-height */
            align-items: center;
            justify-content: center;
            padding: 20px; /* tambahkan padding agar konten tidak terpotong */
        }

        .register-card {
            display: flex;
            flex-direction: row;
            max-width: 950px; /* tetap sama */
            width: 100%;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            background-color: #fff;
            overflow: hidden; /* agar tidak meluap */
        }

        .register-left {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start; /* ubah dari center supaya logo tidak hilang */
            overflow-y: auto; /* bisa scroll kalau konten terlalu tinggi */
        }

        /* ✅ Logo spacing */
        .logo-container {
            margin-top: 30px;
            margin-bottom: 25px;
            text-align: left;
        }

        .logo {
            width: 120px;
        }

        .register-right {
            flex: 1;
            height: 768px; /* hanya 70% tinggi layar */
            align-self: center; /* biar gambar di tengah vertikal */
            margin-right: 40px; /* ✅ jarak dari sisi kanan */
            margin-left: 20px; /* ✅ jarak dari sisi kiri dalam kartu */
            border-radius: 15px; /* biar lembut di pinggir */
            background-image: url('{{ asset("images/loginpage.png") }}');
            background-size: contain; /* tampil utuh */
            background-repeat: no-repeat;
            background-position: center;
        }


        /* ✅ Tombol utama */
        .btn-register {
            background-color: #800000;
            color: #fff;
            border: none;
            padding: 10px;
            font-weight: 500;
            border-radius: 5px;
            width: 100%;
            transition: 0.3s ease;
        }

        .btn-register:hover {
            background-color: #a00000;
        }

        /* ✅ Tombol kembali tanpa kotak */
        .btn-back {
            display: inline-block;
            color: #800000;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s ease;
        }

        .btn-back:hover {
            color: #a00000;
            text-decoration: underline;
        }

        /* ✅ Semua tautan merah */
        a {
            color: #800000;
            text-decoration: none;
            transition: 0.3s ease;
        }

        a:hover {
            color: #a00000;
            text-decoration: underline;
        }

        .error-text {
            color: #d9534f;
            font-size: 0.85rem;
            margin-top: 5px;
        }

        .google-btn {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 8px 16px;
            background: white;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .google-btn:hover {
            background-color: #f8f8f8;
            transform: scale(1.03);
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 20px 0;
            color: #666;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #ddd;
        }

        .divider:not(:empty)::before { margin-right: 0.75em; }
        .divider:not(:empty)::after { margin-left: 0.75em; }

        @media (max-width: 768px) {
            .register-card {
                flex-direction: column;
                width: 95%;
                height: auto;
            }
            .register-right {
                height: 200px;
            }
        }
    </style>
</head>
<body>
<div class="register-container">
    <div class="register-card">
        <div class="register-left">
            <!-- ✅ Logo -->
            <div class="logo-container">
                <img src="{{ asset('images/logo.png') }}" alt="Logo Barbekuy" class="logo">
            </div>

            <!-- ✅ Tombol kembali -->
            <a href="{{ url('/login') }}" class="btn-back mb-3">&larr; Kembali</a>

            <h2>Daftar</h2>
            <p>Mari kita siapkan agar anda dapat mengakses akun anda.</p>

            <form method="POST" action="{{ route('daftar') }}">
                @csrf
                <div class="mb-3">
                    <label>Nama Lengkap</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Nama lengkap" required>
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Masukkan email" required>
                    @error('email')
                        <div class="error-text d-flex align-items-center mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#d9534f" class="bi bi-exclamation-circle me-1" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14z"/>
                                <path d="M7.002 11a1 1 0 1 0 2 0 1 1 0 0 0-2 0zm.93-6.481-.082 3.993a.5.5 0 0 0 .992.09l.082-3.993a.5.5 0 0 0-.992-.09z"/>
                            </svg>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Kata Sandi</label>
                    <input type="password" class="form-control" name="password" placeholder="Masukkan kata sandi" required>
                </div>

                <div class="mb-3">
                    <label>Konfirmasi Kata Sandi</label>
                    <input type="password" class="form-control" name="password_confirmation" placeholder="Ulangi kata sandi" required>
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="terms" required>
                    <label class="form-check-label" for="terms">
                        Saya setuju dengan semua <a href="#">Syarat</a> dan <a href="#">Kebijakan Privasi</a>
                    </label>
                </div>

                <button type="submit" class="btn-register">Buat Akun</button>
            </form>

            <div class="text-center mt-3">
                <p>Sudah punya akun? <a href="{{ url('/login') }}">Masuk</a></p>

                <div class="divider"><span>Atau daftar dengan</span></div>

                <button class="google-btn">
                    <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" width="20" alt="Google Logo">
                </button>
            </div>
        </div>

        <div class="register-right"></div>
    </div>
</div>
</body>
</html>
