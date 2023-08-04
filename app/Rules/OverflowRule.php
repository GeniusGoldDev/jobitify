<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class OverflowRule implements Rule
{

    public $min_value, $max_value;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($min, $max)
    {
        $this->min_value = $min;
        $this->max_value = $max;
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
        return $value > $this->min_value && $value < $this->max_value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('general.overflow_error', ['min' => $this->min_value, 'max' => $this->max_value]);
    }
}
