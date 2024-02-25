<?php

namespace App\Http\Requests\Transfers;

use Illuminate\Foundation\Http\FormRequest;

class TransferStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'value' => ['required', 'numeric'],
            'payee' => ['required', 'exists:users,id']
        ];
    }

    public function attributes(): array
    {
        return [
            'value' => 'valor',
            'payee' => 'recebedor'
        ];
    }
}
