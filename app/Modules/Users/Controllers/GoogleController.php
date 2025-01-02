<?php

namespace App\Modules\Users\Controllers;

use App\Models\DeviceToken;
use App\Modules\Users\dto\UserDTO;
use App\Modules\Users\Service\AuthService;
use App\Modules\Users\Service\UserQueryService;
use App\Modules\Users\Validations\UserSignInValidation;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Psr\Http\Message\ServerRequestInterface;


class GoogleController extends BaseController
{
    public function __invoke(
        Request                $request,
        AuthService            $authService,
    )
    {
        return $authService->googleAuth($request);
    }
}
