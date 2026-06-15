<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Financeiro</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #ffffff;
            color: #e2e8f0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* HEADER */
        .app-header {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .app-logo {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            text-decoration: none;
        }

        .app-logo-icon {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .app-logo-text {
            font-size: 1.2rem;
            font-weight: 700;
            background: linear-gradient(to right, #818cf8, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .app-logo-sub {
            font-size: 0.7rem;
            color: #64748b;
            display: block;
            line-height: 1;
        }

        .header-nav {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header-nav a {
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.2s;
        }

        .header-nav a:hover {
            color: #e2e8f0;
        }

        /* MAIN */
        .app-main {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* FOOTER */
        .app-footer {
            text-align: center;
            padding: 1.2rem;
            font-size: 0.8rem;
            color: #334155;
            border-top: 1px solid rgba(255,255,255,0.05);
        }
    </style>
</head>
<body>

    <header class="app-header">
        <a href="/" class="app-logo">
            <div class="app-logo-icon">💰</div>
            <div>
                <span class="app-logo-text">FinanceApp</span>
                <span class="app-logo-sub">Sistema Financeiro</span>
            </div>
        </a>

        <nav class="header-nav">
            @auth
                <span style="color: #64748b; font-size: 0.85rem;">Olá, {{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" style="background: rgba(239,68,68,0.15); color: #f87171; border: 1px solid rgba(239,68,68,0.3); padding: 0.4rem 1rem; border-radius: 8px; cursor: pointer; font-size: 0.85rem; transition: all 0.2s;">
                        Sair
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
            @endauth
        </nav>
    </header>

    <main class="app-main">
        @yield('content')
    </main>

    <footer class="app-footer">
        &copy; {{ date('Y') }} FinanceApp — Todos os direitos reservados.
    </footer>

</body>
</html>