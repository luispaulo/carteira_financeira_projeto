<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'type' => $this->type,
            'amount' => number_format((float) $this->amount, 2, '.', ''),
            'sender_id' => $this->sender_id,
            'receiver_id' => $this->receiver_id,
            'status' => $this->status,
            'reversed_transaction_id' => $this->reversed_transaction_id,
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}