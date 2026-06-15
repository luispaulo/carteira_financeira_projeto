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

    .auth-link {
        display: block;
        text-align: center;
        margin-top: 1.2rem;
        font-size: 0.88rem;
        color: #64748b;
    }

    .auth-link a {
        color: #818cf8;
        text-decoration: none;
        font-weight: 600;
    }

    .auth-link a:hover {
        text-decoration: underline;
    }
</style>

<div class="login-wrapper">
    <div class="login-card">
        <h2 class="login-title">Criar conta</h2>
        <p class="login-subtitle">Preencha os dados abaixo para se registrar</p>

        @if ($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">Nome completo</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    class="form-control"
                    value="{{ old('name') }}"
                    placeholder="Seu nome"
                    required
                    autofocus
                >
                @error('name')
                    <span class="input-error">{{ $message }}</span>
                @enderror
            </div>

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
                    placeholder="Mínimo 8 caracteres"
                    required
                >
                @error('password')
                    <span class="input-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirmar senha</label>
                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    class="form-control"
                    placeholder="Repita a senha"
                    required
                >
            </div>

            <button type="submit" class="btn-login">Criar conta</button>
        </form>

        <span class="auth-link">
            Já tem uma conta? <a href="{{ route('login') }}">Entrar</a>
        </span>
    </div>
</div>
@endsection