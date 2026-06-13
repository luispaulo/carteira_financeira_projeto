<?php

namespace App\DTO;

readonly class UserLoginDTO
{
    public function __construct(
        public string $email,
        public string $password
    ) {}
}