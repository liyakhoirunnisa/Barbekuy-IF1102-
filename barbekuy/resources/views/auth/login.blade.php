<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Barbekuy</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fff;
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            width: 100%;
            max-width: 950px;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }

        .login-card {
            display: flex;
            flex-direction: row;
            width: 100%;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .login-left {
            flex: 1;
            padding: 50px 40px;
        }

        .login-left h2 {
            font-weight: 600;
            margin-bottom: 15px;
        }

        .login-left a {
            color: #800000;
            text-decoration: none;
        }

        .login-left a:hover {
            text-decoration: underline;
        }

        .btn-login {
            background-color: #800000;
            color: #fff;
            border: none;
            padding: 10px;
            font-weight: 500;
            border-radius: 5px;
            width: 100%;
        }

        .btn-login:hover {
            background-color: #a00000;
        }

        .login-right {
            flex: 1;
            height: 768px;
            align-self: center;
            margin-right: 40px;
            margin-left: 20px;
            border-radius: 15px;
            background-image: url('{{ asset("images/loginpage.png") }}');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
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

        .error-text {
            color: #d9534f;
            font-size: 0.85rem;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .error-text i {
            color: #d9534f;
            font-size: 1rem;
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

        .divider:not(:empty)::before {
            margin-right: 0.75em;
        }

        .divider:not(:empty)::after {
            margin-left: 0.75em;
        }

        .logo-container {
            margin-top: 10px;
            margin-bottom: 25px;
            text-align: left;
        }

        .logo {
            width: 120px;
        }

        @media (max-width: 768px) {
            body {
                align-items: flex-start;
                padding-top: 30px;
            }

            .login-card {
                flex-direction: column;
                width: 95%;
                height: auto;
            }

            .login-right {
                height: 220px;
                background-size: cover;
                border-top-left-radius: 0;
                border-top-right-radius: 0;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-left">
                <div class="logo-container">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Barbekuy" class="logo">
                </div>

                <a href="{{ url('/') }}" class="d-block mb-3">&larr; Kembali ke beranda</a>

                <h2>Masuk</h2>
                <p>Masuk untuk mengakses akun anda</p>

                {{-- Alert global --}}
                @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ route('login.process') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Masukkan email" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kata Sandi</label>
                        <input type="password" class="form-control" name="password" placeholder="Masukkan kata sandi" required>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Ingat saya</label>
                        </div>
                        <a href="#">Lupa kata sandi?</a>
                    </div>

                    <button type="submit" class="btn-login">Masuk</button>
                </form>

                <div class="text-center mt-3">
                    <p>Belum punya akun? <a href="{{ route('daftar.form') }}">Daftar</a></p>

                    <div class="divider"><span>Atau masuk dengan</span></div>

                    <button class="google-btn" type="button">
                        <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" width="20" height="20" alt="Google Logo">
                        Google
                    </button>
                </div>
            </div>

            <div class="login-right"></div>
        </div>
    </div>
</body>

</html>