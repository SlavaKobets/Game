<?php

namespace App\Rules;

use App\Models\User;
use App\Traits\Formatter;
use Illuminate\Contracts\Validation\Rule;

class UserExistsRule implements Rule
{
    use Formatter;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return User::query()
            ->where('name', 'LIKE', $value['name'])
            ->where('phone', 'LIKE', $this->formatPhone($value['phone']))
            ->where('expired_at', '>', now())
            ->doesntExist();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The user already exists';
    }
}