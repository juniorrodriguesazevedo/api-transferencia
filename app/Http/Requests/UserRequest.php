<?php

namespace App\Http\Requests;

use App\Enums\RoleEnum;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->cpf_cnpj) {
            $this->merge([
                'cpf_cnpj' => preg_replace('/[^0-9]/', '', $this->cpf_cnpj),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->isMethod('POST')) {
            return [
                'name' => ['required', 'string'],
                'email' => ['required', 'email', 'unique:users,email'],
                'cpf_cnpj' => ['required', 'unique:users,cpf_cnpj'],
                'password' => ['required', 'min:8'],
                'role' => [
                    'required',
                    'string',
                    Rule::in([
                        RoleEnum::CUSTOMER,
                        RoleEnum::SHOPKEEPER,
                    ]),
                ],
            ];
        }

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            return [
                'name' => ['sometimes', 'string'],
                'password' => ['sometimes', 'min:8'],
            ];
        }

        return [];
    }
}
