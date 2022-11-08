<?php

declare(strict_types=1);

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhoneNumberRule implements Rule
{
    /**
     * validate
     *
     * @param string $attribute
     * @param mixed $value
     */
    public function passes($attribute, $value): bool
    {
        $pattern = '/^\+[1-9]\d{1,14}$/';
        if (!preg_match($pattern, $value)) {
            return false;
        }

        return true;
    }

    public function message(): string
    {
        // :attribute :size :values :other
        // :input :min :max
        return 'The :attribute must comply with E.164';
    }
}
