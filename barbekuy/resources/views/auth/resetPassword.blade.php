<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Kata Sandi - Barbekuy</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fff;
        }

        .container-reset {
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
        }

        .card-reset {
            display: flex;
            width: 900px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .reset-left {
            flex: 1;
            padding: 40px;
        }

        .reset-left h2 {
            font-weight: 600;
            margin-bottom: 15px;
        }

        .reset-left p {
            text-align: justify;
        }

        .btn-submit {
            background-color: #731722;
            color: #fff;
            border: none;
            padding: 10px;
            font-weight: 500;
            border-radius: 5px;
            width: 100%;
        }

        .btn-submit:hover {
            background-color: #8e1e2a;
        }

        .reset-right {
            flex: 1;
            background-image: url('{{ asset("images/loginpage.png") }}');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
        }

        .logo {
            width: 120px;
            margin-bottom: 20px;
        }

        /* ==== Tombol kembali ala login ==== */
        .btn-back-reset {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #751A25;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            margin-bottom: 20px;
            transition: color 0.25s ease;
        }

        .btn-back-reset i {
            font-size: 1.05rem;
        }

        .btn-back-reset:hover {
            color: #a00000;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .card-reset {
                flex-direction: column;
                width: 95%;
                height: auto;
            }

            .reset-right {
                height: 200px;
            }
        }

        .link-back {
            color: #800000 !important;
            font-weight: 500;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .link-back:hover {
            color: #a00000 !important;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container-reset">
        <div class="card-reset">
            <div class="reset-left">
                <div class="logo-container">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Barbekuy" class="logo">
                </div>

                <a href="{{ route('login') }}" class="btn-back-reset">
                    <i class="bi bi-chevron-left"></i>
                    <span>Kembali</span>
                </a>

                <h2>Buat kata sandi baru</h2>
                <p>Kata sandi Anda sebelumnya telah diatur ulang. Silahkan buat kata sandi baru untuk akun Anda.</p>

                {{-- Error validation --}}
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    {{-- token reset wajib --}}
                    <input type="hidden" name="token" value="{{ $token }}">

                    {{-- Email tetap dikirim tapi tidak ditampilkan --}}
                    <input type="hidden" name="email" value="{{ $email ?? old('email') }}">

                    <div class="mb-3">
                        <label class="form-label">Kata sandi baru</label>
                        <input type="password"
                            class="form-control"
                            name="password"
                            placeholder="Minimal 8 karakter"
                            required
                            autocomplete="new-password">
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Konfirmasi kata sandi baru</label>
                        <input type="password"
                            class="form-control"
                            name="password_confirmation"
                            placeholder="Ulangi kata sandi"
                            required
                            autocomplete="new-password">
                    </div>

                    <button type="submit" class="btn-submit">Simpan kata sandi</button>
                </form>
            </div>

            <div class="reset-right"></div>
        </div>
    </div>
</body>

</html>