<?php

namespace App\Repositories;

use App\DTO\UserRegisterDTO;
use App\Models\User;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function create(UserRegisterDTO $dto): User
    {
        return User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => $dto->password,
        ]);
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function findById(int $id): ?User
    {
        return User::find($id);
    }
}
