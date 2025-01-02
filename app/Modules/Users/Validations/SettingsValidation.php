<?php

namespace App\Modules\Users\Validations;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingsValidation
{
    public static function userSettings(Request $request)
    {
        return Validator::make($request->all(), [
            'key' => 'required:settings|max:50',
            'value' => 'required|max:500',
        ]);
    }
}
