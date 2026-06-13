@extends('layouts.auth')

@section('title', 'Login Sensasi Coffee')

@push('style')
    <link rel="stylesheet" href="{{ asset('library/bootstrap-social/bootstrap-social.css') }}">
    <style>
        body {
            background: #FAF6F1;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .login-row {
            width: 100%;
            max-width: 800px;
            display: flex;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
        }

        .login-side {
            flex: 1;
            background: linear-gradient(135deg, #A67B5B, #6F4E37);
            color: #fff;
            padding: 3rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-side .logo-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            font-size: 24px;
        }

        .login-side h3 {
            font-weight: 700;
            margin-bottom: 0.75rem;
        }

        .login-side p {
            opacity: 0.85;
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .login-form-side {
            flex: 1;
            background: #fff;
            padding: 3rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-form-side h4 {
            font-weight: 700;
            margin-bottom: 0.25rem;
            color: #4A3225;
        }

        .login-form-side .subtitle {
            color: #8898aa;
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
        }

        .login-form-side .form-control {
            border-radius: 10px;
            padding: 0.65rem 1rem;
            border: 1px solid #e3e6f0;
        }

        .login-form-side .form-control:focus {
            border-color: #A67B5B;
            box-shadow: 0 0 0 0.15rem rgba(166, 123, 91, 0.15);
        }

        .login-form-side label {
            font-weight: 600;
            font-size: 0.85rem;
            color: #5a5c69;
        }

        .login-form-side .btn-primary {
            background: linear-gradient(135deg, #A67B5B, #6F4E37);
            border: none;
            border-radius: 10px;
            padding: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.3px;
            color: #fff;
        }

        .login-form-side .btn-primary:hover {
            opacity: 0.9;
            color: #fff;
        }

        @media (max-width: 768px) {
            .login-row {
                flex-direction: column;
            }

            .login-side {
                display: none;
            }
        }
    </style>
@endpush

@section('main')
    <div class="login-wrapper">
        <div class="login-row">
            <div class="login-side">
                <div class="logo-icon">
                    <i class="fas fa-coffee"></i>
                </div>
                <h3>Sensasi Coffee</h3>
                <p>
                    Kelola pesanan, stok, dan transaksi cafe Anda
                    dengan lebih mudah dan efisien dalam satu sistem.
                </p>
            </div>

            <div class="login-form-side">
                <h4>Selamat Datang</h4>
                <p class="subtitle">Masuk untuk melanjutkan ke dashboard</p>

                <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            name="email" tabindex="1" autofocus placeholder="nama@email.com">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="control-label">Password</label>
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            name="password" tabindex="2" placeholder="••••••••">
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember" tabindex="3">
                        <label class="form-check-label" for="remember">Ingat saya</label>
                    </div>

                    <div class="form-group mb-0">
                        <button type="submit" class="btn btn-primary btn-block" tabindex="4">
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush