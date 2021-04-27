<?php

namespace App\Rules;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class Fio implements Rule
{
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
     * Show the application registration form.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View|View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return preg_match('/^([\w]+) ([\w]+) ([\w]+)$/u', $value) !== 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Не верный формат ФИО';
    }
}
