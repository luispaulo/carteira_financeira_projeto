<?php

namespace App\Exceptions;

class TransactionNotFoundException extends BusinessException
{

    public function __construct(string $message = 'Transação não encontrada.', int $statusCode = 404, array $errors = [])
    {
        parent::__construct($message, $statusCode, $errors);
    }
}