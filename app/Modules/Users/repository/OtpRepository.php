<?php

namespace App\Modules\Users\repository;

use App\Models\Otp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtpRepository
{
    protected $model;

    public function __construct(Otp $model)
    {
        $this->model = $model::query();
    }

    public function create(array $dto, $code, $type)
    {
        $existingRecord = $this->model->firstOrNew([
            'email' => $dto['email'],
        ]);
        if ($existingRecord->exists) {
            $existingRecord->update([
                'code' => $code,
                'attempts' => $existingRecord->attempts + 1,
                'lifetime' => Carbon::now()->addMinutes(30),
            ]);
        } else {
            $this->model->create([
                'email' => $dto['email'],
                'payload' => json_encode($dto),
                'type' => $type,
                'code' => $code,
                'lifetime' => Carbon::now()->addMinutes(30),
                'attempts' => 1,
            ]);
        }
        return response()->json([
            'msg' => 'Request submitted to create user',
            'attempts' => $existingRecord->attempts,
        ], 201);

    }

    public function findByEmailAndCode($email, $code)
    {
        return $this->model
            ->where('email', $email)
            ->where('code', $code)
            ->first();
    }

    public function delete($id)
    {
        $otpRecord = $this->model->find($id);
        if ($otpRecord) {
            $otpRecord->delete();
        }
    }
}
