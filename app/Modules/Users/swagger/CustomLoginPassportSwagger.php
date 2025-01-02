<?php
namespace App\Modules\Users\swagger;

/**
 * @OA\Post(
 *     path="/api/oauth/sign-in",
 *     summary="Get an access token for logining the user for mobile app",
 *     tags={"Users"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="application/x-www-form-urlencoded",
 *             @OA\Schema(
 *                 @OA\Property(property="username", type="string", example="futureinventor@umail.uz"),
 *                 @OA\Property(property="password", type="string", example="123456"),
 *             ),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Access token generated successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="token_type", type="string", example="Bearer"),
 *             @OA\Property(property="expires_in", type="integer", example=3600),
 *             @OA\Property(property="access_token", type="string", example="generated-access-token"),
 *             @OA\Property(property="refresh_token", type="string", example="refresh-token-if-enabled"),
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
class CustomLoginPassportSwagger {}
