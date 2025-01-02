<?php

namespace App\Modules\Users\swagger;

/**
 * @OA\Post(
 *     path="/api/user/restore-password/step-change-password",
 *     tags={"Users"},
 *     summary="Send code to user for restoring password",
 *     operationId="changePassword",
 *     @OA\RequestBody(
 *         required=true,
 *         description="User email",
 *         @OA\JsonContent(
 *             required={"email"},
 *             @OA\Property(property="email", type="string", example="uzpsychologist@gmail.com"),
 *             @OA\Property(property="password", type="string", example="123456"),
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="Code sent successfully")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="User not found")
 *         )
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Server error",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Internal server error")
 *         )
 *     )
 * )
 */


class RestorePasswordChangeSwagger {}
