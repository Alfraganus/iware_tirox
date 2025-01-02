<?php

namespace App\Modules\Users\Service;

use App\Models\User;
use App\Modules\Users\Validations\UserValidationByEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class GetUserByIdService
{

    const TYPE_USER_EMAIL = 'EMAIL';
    const TYPE_USER_SOCIAL = 'SOCIAL';
    const TYPE_USER_ADMIN = 'ADMIN';

    public function getUserById(Request $request)
    {
        User::query()->findOrFail($request->get('id'));
    }
}
