<?php

namespace App\Rules;

use Exception;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class FakeEmail implements Rule
{
    protected $domain = [
        'gmail','google','twitter'
    ];

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
        $url = 'https://open.kickbox.com/v1/disposable/' . Str::after($value, '@');
        try {
            return ! json_decode(file_get_contents($url), true)
                    ['disposable'];
        } catch (Exception $ex) {
            // return ($this->parameters[0] ?? false) ? false : true;
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a valid, non-disposable domain';
    }
}
