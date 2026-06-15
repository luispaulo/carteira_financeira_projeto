<?php

namespace App\DTO;

readonly class TransferDTO {

    public function __construct(
        public int $senderId,
        public int $receiverId,
        public float $amount
    ) {}
}