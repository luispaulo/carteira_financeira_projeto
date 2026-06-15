<?php

namespace App\DTO;

readonly class DepositDTO {

    public function __construct(
        public int $userId,
        public float $amount
    ){}

    
}
        