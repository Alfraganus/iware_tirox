<?php

namespace App\Modules\Users\Controllers;

use App\Modules\Users\repository\OtpRepository;
use App\Modules\Users\repository\UserRepository;
use App\Modules\Users\Service\AuthService;
use App\Modules\Users\Service\MailService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class RestorePasswordController extends BaseController
{
    private $userRepository;
    private $authService;

    public function __construct(
        UserRepository $userRepository,
        AuthService $authService
    )
    {
        $this->userRepository = $userRepository;
        $this->authService = $authService;
    }

    public function sendCodeToUser(Request $request)
    {
        $code = rand(100000, 999999);
        $user = $this->userRepository->findByEmail($request->input('email'));
        if(!$user) return Response(['error'=>'User not found'],404);
//        $this->otbRepository->create($user,$code,Otp::TYPE_RECOVERY);
        MailService::sendMail(
            'emails.password_restore_code',
            $code,
            $user,
            'Password-restore code from Avlo Muslim App'
        );
        return Response([
            'success'=>true,
            'code'=>$code
        ]);
    }

    public function changePassword(Request $request)
    {
        return $this->authService->changePassword($request);
    }
}
