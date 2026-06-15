<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferRequest extends FormRequest 
{

    public function authorize(): bool {
        return true;
    }

    public function rules(): array
    {
        return [
            'receiver_id' => [
                'required',
                'integer',
                'exists:users,id',
                function ($attribute, $value, $fail) {
                    if ($value == $this->user()?->id) {
                        $fail('Não é permitido realizar transferências para si próprio.');
                    }
                },
            ],
            'amount' => ['required', 'numeric', 'gt:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'receiver_id.required' => 'O campo destinatário é obrigatório.',
            'receiver_id.exists' => 'O destinatário informado não existe.',
            'amount.required' => 'O campo valor é obrigatório.',
            'amount.numeric' => 'O campo valor deve ser um número.',
            'amount.gt' => 'O valor da transferência deve ser maior que zero.',
        ];
    }
}