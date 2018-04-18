<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Valid2FASecret implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match('/^[A-Z0-9]{16}$|^[A-Z0-9]{32}$|^[A-Z0-9]{64}$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
