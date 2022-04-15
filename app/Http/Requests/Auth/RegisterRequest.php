<?php

namespace App\Http\Requests\Auth;

use App\Enums\AccountType;
use App\Rules\CpfRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'min:3', 'max:120'],
            'cpf' => ['required', new CpfRule, 'unique:users'],
            'password' => ['required', 'min:5', 'max:22'],
            'account_type' => [new Enum(AccountType::class)],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'cpf' => str_replace([',', '.', '-', ' ', '/'], '', $this->cpf)
        ]);
    }
}
