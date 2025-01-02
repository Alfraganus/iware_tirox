<?php
namespace App\Modules\Users\Validations;

use Illuminate\Validation\Rule;

class UserValidationByEmail
{
    public static function rulesForRegistration()
    {
        return [
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ];
    }
}
