<!DOCTYPE html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
    <title>Daftar</title>

    <meta name="deskripsi" content=""/>

    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon/favicon.ico') }}"/>
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin/>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="{{ asset('vendor/fonts/boxicons.css') }}"/>
    <link rel="stylesheet" href="{{ asset('vendor/css/core.css') }}"/>
    <link rel="stylesheet" href="{{ asset('vendor/css/theme-default.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/demo.css') }}"/>
    <link rel="stylesheet" href="{{ asset('vendor/css/pages/page-auth.css') }}"/>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>

    <style>
        body {
            background: url("{{ asset('assets/img/favicon/kasir.jfif') }}") no-repeat center center fixed;
            background-size: cover;
        }

        .card {
            background: rgba(255, 255, 255, 0.7); /* Warna putih dengan transparansi */
            backdrop-filter: blur(10px); /* Efek blur untuk memperhalus background */
            border-radius: 15px; /* Biar lebih rounded */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Bayangan biar lebih elegan */
        }
    </style>
</head>

<body>
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card p-4" style="width: 100%; max-width: 450px;">
            <div class="card-body">
                <div class="text-center mb-3">
                    <a href="{{ route('pages.register') }}">
                        <img src="{{ asset('assets/img/favicon/logo apk.png') }}" alt="Logo" width="150px" class="mx-auto d-block">
                    </a>
                </div>

                <!-- Pesan Error -->
                @if (session('error'))
                    <div class="alert alert-danger mt-3">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Validasi Form -->
                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="formAuthentication" class="mb-3" action="{{ url('/register') }}" method="POST" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Masukkan nama lengkap" required value="{{ old('name') }}"/>
                        @error('name')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan email" required value="{{ old('email') }}"/>
                        @error('email')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password" required/>

                        @error('password')
                            <div class="invalid-feedback d-block">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input class="form-check-input" type="checkbox" id="showPassword">
                        <label class="form-check-label" for="showPassword">
                            Tampilkan password
                        </label>
                    </div>

                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            document.getElementById('showPassword').addEventListener('change', function() {
                                document.getElementById('password').type = this.checked ? 'text' : 'password';
                            });
                        });
                    </script>

                    <div class="mt-2">
                        <button class="btn btn-primary d-grid w-100" type="submit">Daftar</button>
                    </div>
                </form>

                <div class="text-center mt-3">
                    <small>Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
