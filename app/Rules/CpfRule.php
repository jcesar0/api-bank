<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CpfRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        if (blank($value) || strlen($value) !== 11)
        {
            return false;
        }

        $fistDigitValidate = (($value[0] * 10 + $value[1] * 9 + $value[2] * 8 + $value[3] * 7 +
            $value[4] * 6 + $value[5] * 5 + $value[6] * 4 + $value[7] * 3 + $value[8] * 2) * 10) % 11;
        $fistDigitValidate !== 10 ?: $fistDigitValidate = 0;

        $secondDigitValidate = (($value[0] * 11 + $value[1] * 10 + $value[2] * 9 + $value[3] * 8 +
            $value[4] * 7 + $value[5] * 6 + $value[6] * 5 + $value[7] * 4 + $value[8] * 3 + $value[9] * 2) * 10) % 11;

        return $fistDigitValidate == $value[9] && $secondDigitValidate == $value[10];
    }

    public function message(): string
    {
        return 'Attribute :attribute is invalid';
    }
}
