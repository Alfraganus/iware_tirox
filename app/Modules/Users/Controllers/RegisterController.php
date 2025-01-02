<?php

namespace App\Modules\Users\Controllers;

use App\Models\User;
use App\Modules\Users\dto\UserDTO;
use App\Modules\Users\Service\AuthService;
use App\Modules\Users\Validations\UserValidationByEmail;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class RegisterController extends BaseController
{
    public function __invoke(Request $request, AuthService $authService)
    {
        return $authService->createUserByEmail(
            UserDTO::createFromRequest($request)->toArray()
        );
    }

    public function createUserByEmail(Request $request)
    {
        $dto = UserDTO::createFromRequest($request);

        $validator = Validator::make((array)$dto, UserValidationByEmail::rulesForRegistration());

        if ($validator->fails()) {
            $error = implode(' ', array_values($validator->errors()->toArray())[0]);
            return json_encode(['error' => $error]);
        }

        try {
            $userData = $dto->toArray();
            $userData['token'] = time();

            $user = User::create($userData);

            return json_encode([
                'message' => 'User created successfully',
                'user' => $user
            ]);
        } catch (\Exception $exception) {
            return json_encode(['error' => $exception->getMessage()]);
        }
    }

}
