<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use App\DTO\UserRegisterDTO;
use App\DTO\UserLoginDTO;
use App\Exceptions\BusinessException;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AuthService
{

    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {}

    public function register(UserRegisterDTO $dto): array
    {
        return DB::transaction(function () use ($dto) {

            if ($this->userRepository->findByEmail($dto->email)) {
                throw new BusinessException('E-mail já cadastrado.', 422);
            }

            $user = $this->userRepository->create($dto);

            $token = $user->createToken('api-token')->plainTextToken;

            return [
                'user' => $user,
                'token' => $token,
            ];
        });
    }

    public function login(UserLoginDTO $dto): array
    {
        $user = $this->userRepository->findByEmail($dto->email);

        if (! $user || ! Hash::check($dto->password, $user->password)) {
            throw new BusinessException('Credenciais inválidas.', 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }

    public function me(User $user): User
    {
        return $request->user();
    }
}