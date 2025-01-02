<?php
namespace App\Modules\Users\swagger;

/**
 * @OA\Post(
 *     path="/api/auth/apple",
 *     summary="Authenticate with Apple",
 *     tags={"Users"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"userIdentifier"},
 *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
 *             @OA\Property(property="userIdentifier", type="string", example="unique-user-identifier"),
 *             @OA\Property(property="fullName", type="string", example="John Doe")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful authentication",
 *         @OA\JsonContent(
 *             @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Bad request"
 *     )
 * )
 */
class AppleAuthLoginSwagger {}
