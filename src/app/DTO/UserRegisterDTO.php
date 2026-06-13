<?php

namespace App\DTO;

readonly class UserRegisterDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password
    ) {}
}