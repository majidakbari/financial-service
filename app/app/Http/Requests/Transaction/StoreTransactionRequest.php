<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'source_wallet_id' => ['required', 'int', Rule::exists('wallets', 'id')->where('is_active', true)],
            'destination_wallet_id' => ['required', 'int', Rule::exists('wallets', 'id')->where('is_active', true)],
            'amount' => ['required', 'numeric', 'min:0.1', 'regex:/^\d+(\.\d{1,2})?$/'],
            'description' => ['nullable', 'string', 'max:65535']
        ];
    }
}
