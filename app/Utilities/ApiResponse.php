<?php

namespace App\Utilities;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

class ApiResponse
{
    public static function created(mixed $data, string $message = ''): JsonResponse
    {
        return static::success($data, $message, Response::HTTP_CREATED);
    }

    public static function success(
        mixed  $data,
        string $message = '',
        int    $statusCode = Response::HTTP_OK
    ): JsonResponse
    {
        return static::json($data, $message, $statusCode);
    }

    public static function json(
        mixed  $data = null,
        string $message = '',
        int    $statusCode = Response::HTTP_OK
    ): JsonResponse
    {
        $payload = [
            'message' => $message,
        ];

        if ($data ?? false) {
            $payload['data'] = $data;
        }

        if ($data instanceof JsonResource && $data->resource instanceof CustomPaginator) {
            $payload['meta'] = $data->resource->toArray();
        }


        return new JsonResponse($payload, $statusCode);
    }

    public static function noContent(string $message = ''): JsonResponse
    {
        return static::json([], $message, Response::HTTP_NO_CONTENT);
    }

    public static function badRequest(string $message = ''): JsonResponse
    {
        return static::error($message, Response::HTTP_BAD_REQUEST);
    }

    public static function error(
        string $message = '',
        int    $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR
    ): JsonResponse
    {
        return static::json(
            null,
            $message ?: Response::$statusTexts[$statusCode],
            $statusCode
        );
    }

    public static function unauthorized(string $message = ''): JsonResponse
    {
        return static::error($message, Response::HTTP_UNAUTHORIZED);
    }

    public static function forbidden(string $message = ''): JsonResponse
    {
        return static::error($message, Response::HTTP_FORBIDDEN);
    }

    public static function notFound(string $message = ''): JsonResponse
    {
        return static::error($message, Response::HTTP_NOT_FOUND);
    }

    public static function unprocessable(string $message = ''): JsonResponse
    {
        return static::error($message, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public static function tooManyRequests($message = 'تعداد درخواست های شما بیش از حد مجاز است!'): JsonResponse
    {
        return static::error($message, Response::HTTP_TOO_MANY_REQUESTS);
    }
}
