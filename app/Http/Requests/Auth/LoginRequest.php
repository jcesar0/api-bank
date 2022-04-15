<?php

namespace App\Http\Requests\Auth;

use App\Enums\AccountType;
use App\Rules\CpfRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cpf' => ['required', new CpfRule],
            'password' => ['required', 'min:5', 'max:22'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'cpf' => str_replace([',', '.', '-', ' ', '/'], '', $this->cpf)
        ]);
    }
}
