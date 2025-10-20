LUPA SANDI
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi - Barbekuy</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fff;
        }

        .container-forgot {
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
        }

        .card-forgot {
            display: flex;
            width: 900px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            background-color: #fff;
        }

        .forgot-left {
            flex: 1;
            padding: 40px;
        }

        .forgot-left p {
        text-align: justify;
        }


        .forgot-left h2 {
            font-weight: 600;
            margin-bottom: 15px;
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

        .forgot-right {
            flex: 1;
            background-image: url('{{ asset("images/forgot-password.jpg") }}');
            background-size: cover;
            background-position: center;
        }

        .logo {
            width: 120px;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .card-forgot {
                flex-direction: column;
                width: 95%;
                height: auto;
            }

            .forgot-right {
                height: 200px;
            }
        }

        .link-back {
        color: #800000 !important; /* Merah Barbekuy */
        font-weight: 500;
        text-decoration: none;
        transition: color 0.3s ease;
        }

        .link-back:hover {
        color: #a00000 !important; /* Lebih terang saat hover */
        text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container-forgot">
        <div class="card-forgot">
            <div class="forgot-left">
                <a href="{{ route('login') }}" class="d-block mb-3 link-back">&larr; Kembali</a>
                <img src="{{ asset('images/logo.png') }}" alt="Logo Barbekuy" class="logo">
                
                <h2>Lupa kata sandi Anda?</h2>
                <p>Jangan khawatir, ini terjadi pada kita semua. Masukkan email anda dibawah ini untuk memulihkan kata sandi anda.</p>

                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Masukkan email" required>
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn-submit">Kirim</button>
                </form>
            </div>

            <div class="forgot-right"></div>
        </div>
    </div>
</body>
</html>