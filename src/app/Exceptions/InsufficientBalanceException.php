<?php

namespace App\Exceptions;

class InsufficientBalanceException extends BusinessException
{
    public function __construct(string $message = 'Saldo insuficiente.', int $statusCode = 400, array $errors = [])
    {
        parent::__construct($message, $statusCode, $errors);
    }
}