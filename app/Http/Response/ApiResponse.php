<?php

namespace Appp\Http\Response;

use Illuminate\Http\JsonResponse;

class ApiResponse extends JsonResponse
{
    public static function sucess(mixed $data = null, int $status = 200): ApiResponse
    {
        return self::rawResponse($data, $status);
    }

    public static function error(string $message = '', array $errors = null, int $status = 500): static
    {
        return self::rawResponse(['message' => $message,'errors' => $errors], $status);
    }

    public static function validation(array $errors = null): static
    {
        return self::rawResponse(['message' => 'Validation fails', 'errors' => $errors], 422);
    }

    public static function rawResponse(mixed $data = null, int $status, array $headers = [], int $options = 0): ApiResponse
    {
        return new static($data, $status, $headers, $options);
    }
}