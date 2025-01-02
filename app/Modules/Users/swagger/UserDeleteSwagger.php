<?php

namespace App\Modules\Users\swagger;

/**
 * @OA\Delete(
 *     path="/api/user/delete",
 *     summary="Delete a user",
 *     description="Deletes a user based on the provided user ID",
 *     operationId="deleteUser",
 *     security={{"bearer_token":{}}},
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="User deleted successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string", example="User deleted successfully")
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
 *         description="Internal server error",
 *         @OA\JsonContent(
 *             @OA\Property(property="error", type="string", example="Error occurred while deleting the user")
 *         )
 *     )
 * )
 */
class UserDeleteSwagger {}
