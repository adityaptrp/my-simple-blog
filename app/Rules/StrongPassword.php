<?php

namespace App\Rules;

use Illuminate\Support\Str;
use Illuminate\Contracts\Validation\Rule;

class StrongPassword implements Rule
{
    public $lengthPasses = true;
    public $uppercasePasses = true;
    public $numericPasses = true;
    public $lowerPasses = true;
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
    public function passes($attribute, $value)
    {
        $this->lengthPasses = (Str::length($value) >= 8);
        $this->uppercasePasses = (Str::lower($value) !== $value);
        $this->lowerPasses = ((bool)preg_match('/[a-z]/', $value));
        $this->numericPasses = ((bool)preg_match('/[0-9]/', $value));

        return ($this->lengthPasses && $this->uppercasePasses && $this->numericPasses && $this->lowerPasses);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        switch (true) {
            case !$this->uppercasePasses
                && $this->numericPasses
                && $this->lowerPasses:
                return 'The :attribute must contain at least 1 uppercase character.';
            
            case !$this->numericPasses
                && $this->uppercasePasses
                && $this->lowerPasses:
                return 'The :attribute must contain at least 1 number.';

            case !$this->lowerPasses
                && $this->uppercasePasses
                && $this->numericPasses:
                return 'The :attribute must contain at least 1 lower character.';

            case !$this->uppercasePasses
                && !$this->numericPasses
                && $this->lowerPasses:
                return 'The :attribute must contain at least 1 uppercase character and 1 number.';

            case !$this->uppercasePasses
                && !$this->lowerPasses
                && $this->numericPasses:
                return 'The :attribute must contain at least 1 uppercase character and 1 lower character.';

            case !$this->uppercasePasses
                && !$this->numericPasses
                && !$this->lowerPasses:
                return 'The :attribute must contain at least 1 uppercase character, 1 number, and 1 lower character.';

            default:
                return 'The :attribute must be at least 8 characters.';
        }
    }
}
