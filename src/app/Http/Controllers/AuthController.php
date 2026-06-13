<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use App\Http\Resources\UserResource;
use App\DTO\UserLoginDTO;
use App\DTO\UserRegisterDTO;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    ){}

    public function register(RegisterRequest $request)
    {
        $dto = new UserRegisterDTO(
            name: $request->validated('name'),
            email: $request->validated('email'),
            password: $request->validated('password')
        );

        $result = $this->authService->register($dto);

        return response()->json([
            'message' => 'Usuário cadastrado com sucesso.',
            'token' => $result['token'],
            'user' => new UserResource($result['user']),
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $dto = new UserLoginDTO(
            email: $request->validated('email'),
            password: $request->validated('password')
        );

        $result = $this->authService->login($dto);

        return response()->json([
            'message' => 'Usuário logado com sucesso.',
            'token' => $result['token'],
            'user' => new UserResource($result['user']),
        ]);

    }

    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());

        return response()->json([
            'message' => 'Logout realizado.'
        ]);
    }

    public function me(Request $request)
    {
        return response()->json(
            $request->user()
        );
    }
}