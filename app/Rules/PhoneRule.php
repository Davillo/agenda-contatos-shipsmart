<?php

namespace App\Rules;

use App\Traits\ValidationTrait;
use Illuminate\Contracts\Validation\Rule;

class PhoneRule implements Rule
{
    use ValidationTrait;

    public function passes($attribute, $value)
    {
        return $this->phoneValidation($value);
    }

    public function message()
    {
        return "Invalid phone number";
    }
}
