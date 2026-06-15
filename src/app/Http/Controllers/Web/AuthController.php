<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\RedirectResponse;
use App\Services\AuthService;
use App\DTO\UserRegisterDTO;
use App\Exceptions\BusinessException;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService,
    ) {}

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Credenciais inválidas.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $dto = new UserRegisterDTO(
            name: $request->validated('name'),
            email: $request->validated('email'),
            password: $request->validated('password'),
        );

        try {
            $result = $this->authService->register($dto);
            Auth::login($result['user']);
            $request->session()->regenerate();

            return redirect()->route('dashboard')
                ->with('success', 'Conta criada com sucesso! Bem-vindo.');
        } catch (BusinessException $e) {
            return back()->withInput($request->only('name', 'email'))
                ->withErrors(['email' => $e->getMessage()]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function dashboard()
    {
        return view('dashboard');
    }
}