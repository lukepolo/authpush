<?php

namespace App\Rules;

use App\Models\Device;
use Illuminate\Contracts\Validation\Rule;

class ValidDeviceType implements Rule
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
        return in_array($value, Device::TYPES);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Must submit a valid device type.';
    }
}
