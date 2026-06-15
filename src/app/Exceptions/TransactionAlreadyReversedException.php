<?php

namespace App\Exceptions;

class TransactionAlreadyReversedException extends BusinessException
{
    public function __construct(string $message = 'Esta transação já foi revertida.', int $statusCode = 400, array $errors = [])
    {
        parent::__construct($message, $statusCode, $errors);
    }
}
