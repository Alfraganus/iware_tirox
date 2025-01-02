<?php

namespace App\Modules\Users\Controllers;

use App\Models\DeviceToken;
use App\Models\User;
use App\Modules\Users\Service\UserQueryService;
use App\Modules\Users\Validations\UserSignInValidation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\Routing\Controller as BaseController;


class CustomAuthController extends BaseController
{
    public function __invoke(
        Request                $request,
        UserQueryService       $userQueryService,
        ServerRequestInterface $serverRequest,
        UserSignInValidation   $signInValidation
    )
    {
        $validator = $signInValidation::rulesForSignIn($request);
        if ($validator->fails()) {
            return response()->json([
                'error' => "validation error",
                'errors' => $validator->errors()
            ], 401);
        }
        if (
            $userQueryService->validateUserCredentials($request) &&
            Auth::attempt(['email' => $request->input('username'), 'password' => $request->input('password')])
        ) {
          /*  DeviceToken::query()->create([
                'user_id' => Auth::id(),
                'device_token' => $request->input('device_token')
            ]);*/
            $user = User::query()->find( Auth::id());
            return [
                'data' => $request->user()->createToken('iware-token'),
                'type_user' =>$user->type_user,
                'email' =>$user->email,
            ];
        } else {
            return Response()->json([
                'error' => 'Username or password not correct!'
            ], 400);
        }

    }


    public function signOut(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

}
