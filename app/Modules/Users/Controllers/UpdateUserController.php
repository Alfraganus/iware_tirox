<?php

namespace App\Modules\Users\Controllers;

use App\Modules\Users\repository\UserRepository;
use App\Modules\Users\Service\AuthService;
use App\Modules\Users\Service\UserQueryService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;


class UpdateUserController extends BaseController
{
    public function __invoke(Request $request, UserRepository $userRepository,$id)
    {
        return $userRepository->update($id, $request);
    }
}
