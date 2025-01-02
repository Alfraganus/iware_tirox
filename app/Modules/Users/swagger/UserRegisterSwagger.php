<?php
namespace App\Modules\Users\swagger;

/**
 * @OA\Info(
 *     version="1.0",
 *     title="Inware app API endpoints"
 * )
 * @OA\Post(
 *     path="/api/oauth/create-user-by-email",
 *     summary="Create a new user by email",
 *     tags={"Users"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="type_user", type="string", example="email"),
 *             @OA\Property(property="email", type="string", example="futureinventor@umail.uz"),
 *             @OA\Property(property="name", type="string", example="Alfra"),
 *             @OA\Property(property="password", type="string", example="123456"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User created successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="data", type="object",
 *                 @OA\Property(property="type_user", type="string", example="admin"),
 *                 @OA\Property(property="email", type="string", example="user@example.com"),
 *                 @OA\Property(property="name", type="string", example="john_doe"),
 *                 @OA\Property(property="password", type="string", example="hashed_password")
 *             ),
 *             @OA\Property(property="message", type="string", example="User created successfully.")
 *         ),
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             @OA\Property(property="errors", type="object",
 *                 @OA\Property(property="email", type="array", @OA\Items(type="string", example="The email field is required.")),
 *                 @OA\Property(property="username", type="array", @OA\Items(type="string", example="The username field is required.")),
 *                 @OA\Property(property="password", type="array", @OA\Items(type="string", example="The password field is required."))
 *             )
 *         ),
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Internal Server Error",
 *         @OA\JsonContent(
 *             @OA\Property(property="errors", type="array", @OA\Items(type="string", example="Unexpected error occurred."))
 *         ),
 *     ),
 * )
 */
class UserRegisterSwagger {}
