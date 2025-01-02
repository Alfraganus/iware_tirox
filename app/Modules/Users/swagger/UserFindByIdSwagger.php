<?php

namespace App\Modules\Users\swagger;

/**
 * @OA\Get(
 *     path="/api/user/find-by-id",
 *     summary="Get user by ID",
 *     description="Get a user by their ID.",
 *     operationId="getUserById",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="id",
 *         in="query",
 *         description="ID of the user",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="User not found",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="User not found.")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Invalid input",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="User ID is missing.")
 *         )
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="User",
 *     title="User",
 *     description="User model",
 *     @OA\Property(property="id", type="integer", format="int64"),
 *     @OA\Property(property="name", type="string"),
 * )
 */
class UserFindByIdSwagger {}

