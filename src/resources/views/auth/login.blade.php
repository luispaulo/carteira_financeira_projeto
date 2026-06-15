@extends('layouts.app')

@section('content')
<style>
    .login-wrapper {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem 1rem;
        background: #ffffff;
    }

    .login-card {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(16px);
        border-radius: 20px;
        padding: 2.5rem;
        width: 100%;
        max-width: 420px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
        animation: fadeUp 0.4s ease-out;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .login-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #6366f1, #a855f7);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        margin: 0 auto 1.5rem;
    }

    .login-title {
        font-size: 1.6rem;
        font-weight: 700;
        text-align: center;
        background: linear-gradient(to right, #818cf8, #c084fc);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 0.4rem;
    }

    .login-subtitle {
        text-align: center;
        color: #64748b;
        font-size: 0.88rem;
        margin-bottom: 2rem;
    }

    .form-group {
        margin-bottom: 1.2rem;
    }

    .form-label {
        display: block;
        font-size: 0.85rem;
        margin-bottom: 0.4rem;
        font-weight: 500;
    }

    .form-control {
        width: 100%;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-control::placeholder {
        color: #475569;
    }

    .form-control:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
    }

    .input-error {
        display: block;
        color: #f87171;
        font-size: 0.8rem;
        margin-top: 0.4rem;
    }

    .remember-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .remember-group input {
        accent-color: #6366f1;
        cursor: pointer;
        width: 15px;
        height: 15px;
    }

    .remember-label {
        font-size: 0.88rem;
        color: #64748b;
        cursor: pointer;
        user-select: none;
    }

    .btn-login {
        width: 100%;
        padding: 0.85rem;
        background: linear-gradient(135deg, #6366f1, #a855f7);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: opacity 0.2s, transform 0.1s;
        letter-spacing: 0.3px;
    }

    .btn-login:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }

    .btn-login:active {
        transform: translateY(0);
    }

    .alert-error {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: #f87171;
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 0.88rem;
        margin-bottom: 1.2rem;
    }
</style>

<div class="login-wrapper">
    <div class="login-card">
        <h2 class="login-title">Bem-vindo</h2>
        <p class="login-subtitle">Entre na sua conta para acessar o sistema</p>

        @if ($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">E-mail</label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    class="form-control"
                    value="{{ old('email') }}"
                    placeholder="seu@email.com"
                    required
                    autofocus
                >
                @error('email')
                    <span class="input-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Senha</label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control"
                    placeholder="••••••••"
                    required
                >
                @error('password')
                    <span class="input-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="remember-group">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember" class="remember-label">Lembrar de mim</label>
            </div>

            <button type="submit" class="btn-login">Entrar</button>
        </form>

    </div>
</div>
@endsection