<?php

namespace App\Exceptions;

class WalletNotFoundException extends BusinessException
{
    public function __construct(string $message = 'Carteira não encontrada.', int $statusCode = 404, array $errors = [])
    {
        parent::__construct($message, $statusCode, $errors);
    }
}
