<?php

namespace App\Repositories;

use App\DTO\UserRegisterDTO;
use App\Models\User;

interface UserRepositoryInterface
{
    public function create(UserRegisterDTO $dto): User;

    public function findByEmail(string $email): ?User;
    
    public function findById(int $id): ?User;
}