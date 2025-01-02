<?php
namespace App\Modules\Users\swagger;

/**
 * @OA\Post(
 *     path="/api/auth/google",
 *     summary="Get an access token for google auth",
 *     tags={"Users"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/x-www-form-urlencoded",
 *             @OA\Schema(
 *                 @OA\Property(property="email", type="string", example="futureinventor@umail.uz"),
 *                 @OA\Property(property="google_id", type="string", example="123456"),
 *                 @OA\Property(property="displayName", type="string", example="Alfra"),
 *             ),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Access token generated successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="token", type="string", example="Bearer"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="invalid_credentials"),
 *             @OA\Property(property="message", type="string", example="The user credentials were incorrect."),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="invalid_request"),
 *             @OA\Property(property="message", type="string", example="The request is missing a required parameter, includes an unsupported parameter, or is otherwise malformed."),
 *         ),
 *     ),
 * )
 */
class GoogleAuthLoginSwagger {}
