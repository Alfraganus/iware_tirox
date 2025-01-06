<?php

namespace App\Modules\Users\Controllers;

use App\Modules\Users\repository\UserRepository;
use App\Modules\Users\Service\AuthService;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Routing\Controller as BaseController;

class ScanController extends BaseController
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
    public function generate()
    {

        $qrCode = QrCode::size(300)->generate(sprintf("/api/user/find-by-token/%d",$this->authService->getUserTokenNumber()));

        return response($qrCode);
    }

    public function findUserByScanToken($tokenNumber)
    {
        return $this->authService->findUserByToken($tokenNumber);
    }

}
