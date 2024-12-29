<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Response;

class JsonResponder
{
    public static function respond($message, $status, $data = null, $meta = null): \Illuminate\Http\JsonResponse
    {
        $responseBody = collect(['message' => $message, 'data' => $data, 'meta' => $meta]);

        return Response::json($responseBody, $status);
    }

    public static function created($message = 'Created', $data = [], $meta = []): \Illuminate\Http\JsonResponse
    {
        return self::respond($message, 201, $data, $meta);
    }

    public static function success($message = 'Success', $data = [], $meta = []): \Illuminate\Http\JsonResponse
    {
        return self::respond($message, 200, $data, $meta);
    }

    public static function unauthorized($message = 'Unauthorized'): \Illuminate\Http\JsonResponse
    {
        return self::respond($message, 401);
    }

    public static function forbidden($message = 'Forbidden'): \Illuminate\Http\JsonResponse
    {
        return self::respond($message, 403);
    }

    public static function validationError($message, $data)
    {
        return self::respond($message, 422, $data);
    }

    public static function error($message = 'Internal Server Error', $data = []): \Illuminate\Http\JsonResponse
    {
        return self::respond($message, 500, $data);
    }

    public static function notFound($message = 'Not Found')
    {
        return self::respond($message, 404);
    }

    public static function methodNotAllowed($message = 'The current method not allow for this route')
    {
        return self::respond($message, 405);
    }

    public static function noContent($message = 'No Content')
    {
        return self::respond($message, 204);
    }
}
