<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function badRequest(string $message, string $code = 'badRequest'): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'code' => $code,
        ], 400);
    }

    public static function unauthorized(string $message = 'Unauthorized', string $code = 'UNAUTHORIZED'): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'code' => $code,
        ], 401);
    }

    public static function forbidden(string $message, string $code = 'FORBIDDEN'): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'code' => $code,
        ], 403);
    }

    public static function validationError(array $errors, string $message = 'Validation failed'): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'errors' => $errors,
        ], 422);
    }

    public static function success(string $message, string $code = 'SUCCESS'): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'code' => $code,
        ], 200);
    }
}