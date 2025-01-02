<?php

namespace App\Modules\Users\Service;

use App\Mail\ConfirmationCodeMail;
use App\Models\Otp;
use App\Models\User;
use App\Modules\Users\repository\OtpRepository;
use App\Modules\Users\repository\UserRepository;
use App\Modules\Users\Validations\UserValidationByEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class AuthService
{
    private $userRepository;
    private $otbRepository;

    public function __construct(UserRepository $userRepository, OtpRepository $otbRepository)
    {
        $this->userRepository = $userRepository;
        $this->otbRepository = $otbRepository;
    }

    const TYPE_USER_EMAIL = 'EMAIL';
    const TYPE_USER_SOCIAL = 'SOCIAL';
    const TYPE_USER_ADMIN = 'ADMIN';

    public function createUserByEmail($dto)
    {
        $validator = Validator::make($dto, UserValidationByEmail::rulesForRegistration());

        if ($validator->fails()) {
            $error = implode(' ', array_values($validator->errors()->toArray())[0]);
            return json_encode(['error' => $error]);
        }
        try {
            $code = rand(100000, 999999);
            MailService::sendMail(
                'emails.confirmation_code',
                $code,
                $dto,
                'Confirmation Code from Avlo Muslim App'
            );
            return $this->otbRepository->create($dto, $code, Otp::TYPE_REGISTRATION);
        } catch (\Exception $exception) {
            return ['error' => $exception->getMessage()];
        }
    }

    public function confirmUserByCode(Request $request)
    {
        $otpRecord = $this->otbRepository->findByEmailAndCode(
            $request->input('email'),
            $request->input('code'),
        );

        if ($otpRecord) {
            if ($otpRecord->lifetime >= now()) {
                $payload = json_decode($otpRecord->payload, true);
                $this->userRepository->create($payload);
                Auth::attempt(['email' => $payload['email'], 'password' => $payload['password_raw']]);
                $this->otbRepository->delete($otpRecord->id);
                return response()->json([
                    'message' => 'User confirmed successfully.',
                    'token' => $request->user()->createToken('avlo-muslim-token'),
                ], 200);
            } else {
                return response()->json([
                    'error' => 'Code has expired.',
                ], 422);
            }
        } else {
            return response()->json([
                'error' => 'Invalid email or code.',
            ], 422);
        }
    }

    public function getPassportClient()
    {
        $client = DB::table('oauth_clients')
            ->where('password_client', 1)
            ->first();
        if (isset($client)) {
            return [
                'client_id' => $client->id,
                'client_secret' => $client->secret,
            ];
        }
        throw new \Exception("Password client not found");
    }

    public function getUserByToken(Request $request)
    {
        $token = $request->input('token');
        $getToken = PersonalAccessToken::findToken($token);
        if (!$getToken) {
            return Response()->json([
                'error' => 'Token not found'
            ], status: 404);
        }
        return [
            'user' => $this->userRepository->findById($getToken->tokenable_id),
        ];
    }

    public function changePassword(Request $request)
    {
        try {
            $field = [
                'password' => Hash::make($request->input('password'))
            ];
            $user = $this->userRepository->findByEmail($request->input('email'));

            $this->userRepository->update($user['id'], $field);
            return Response([
                'success' => true,
                'msg' => 'User password has been updated'
            ]);
        } catch (\Exception $exception) {
            return Response([
                'error' => $exception->getMessage(),
            ]);
        }
    }

    public function googleAuth(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'google_id' => 'required',
        ]);

        $user = User::where('email', $request->input('email'))
            ->where('google_id', $request->input('google_id'))
            ->first();

        if (!$user) {
            $user = $this->userRepository->create([
                'email' => $request->input('email'),
                'google_id' => $request->input('google_id'),
                'displayName' => $request->input('displayName'),
                'name' => $request->input('displayName'),
                'password' => '',
                'type_user' =>self::TYPE_USER_SOCIAL ?? null,
            ]);
        }

        $token = $user->createToken('avlo-muslim-token')->plainTextToken;

        return response()->json(['token' => $token]);
    }

    public function appleAuth(Request $request)
    {
        $request->validate([
            'email' => 'email',
            'userIdentifier' => 'string|required',
            'fullName' => 'string',
        ]);

        $user = User::where('apple_user_identifier', $request->input('userIdentifier'))
            ->first();
        if (!$user) {

            $user = $this->userRepository->create([
                'email' => $request->input('email') ?? null,
                'apple_user_identifier' => $request->input('userIdentifier'),
                'name' => $request->input('fullName') ?? null,
                'password' =>" " ?? null,
                'type_user' =>self::TYPE_USER_SOCIAL ?? null,
            ]);
            return $user ??['no'];

        }

        $token = $user->createToken('avlo-muslim-token')->plainTextToken;

        return response()->json(['token' => $token]);
    }

}

