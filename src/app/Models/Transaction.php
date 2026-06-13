<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['uuid', 'type', 'amount', 'sender_id', 'receiver_id', 'status', 'reversed_transaction_id'])]
class Transaction extends Model
{
    /** @use HasFactory<TransactionFactory> */
    use HasFactory;

    protected function casts(): array {
        return [
            'amount' => 'decimal:2',
            'created_at' => 'datetime',
        ];
    }   

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function reverseTransaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'reversed_transaction_id');
    }   
}   