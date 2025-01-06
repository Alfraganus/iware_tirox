<?php

use App\Modules\Users\Controllers\AppleController;
use App\Modules\Users\Controllers\ScanController;
use Illuminate\Support\Facades\Route;
use App\Modules\Users\Controllers\CustomAuthController;
use App\Modules\Users\Controllers\DeleteUserController;
use App\Modules\Users\Controllers\GetAllUsersController;
use App\Modules\Users\Controllers\GetUserByIdController;
use App\Modules\Users\Controllers\GetUserByTokenController;
use App\Modules\Users\Controllers\GoogleController;
use App\Modules\Users\Controllers\RegisterController;
use App\Modules\Users\Controllers\RestorePasswordController;
use App\Modules\Users\Controllers\SettingsController;
use App\Modules\Users\Controllers\UpdateUserController;

Route::post('/user/restore-password/step-otp', [RestorePasswordController::class, 'sendCodeToUser']);
Route::post('/user/restore-password/step-change-password', [RestorePasswordController::class, 'changePassword']);
Route::post('/oauth/confirm-user-by-code', [RegisterController::class, 'conformUserByCode']);
Route::post('/oauth/sign-in', [CustomAuthController::class, '__invoke']);

Route::post('/auth/google', [GoogleController::class, '__invoke']);
Route::get('/auth/signin', [CustomAuthController::class, 'signIn']);
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::post('/oauth/create-user-by-email', [RegisterController::class, 'createUserByEmail']);
Route::get('/user/find-by-id', [GetUserByIdController::class, '__invoke']);
Route::get('/user/get-all-users', [GetAllUsersController::class, '__invoke']);
Route::get('/user/find-by-token/{token_number}', [ScanController::class, 'findUserByScanToken']);


Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/generate-qrcode', [ScanController::class, 'generate']);
    Route::post('/user/update/{id}', [UpdateUserController::class, '__invoke']);
    Route::delete('/user/delete', [DeleteUserController::class, '__invoke']);
});
