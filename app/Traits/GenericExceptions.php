<?php

namespace App\Traits;


use InvalidArgumentException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

trait GenericExceptions
{
    public function throwNotFoundException(string $message = 'Record not found'): void
    {
        throw new NotFoundHttpException($message);
    }

    public function throwAccessDeniedException(string $message = 'Access denied'): void
    {
        throw new AccessDeniedHttpException($message);
    }

    public function throwUnauthorizedException(string $message = 'Unauthorized'): void
    {
        throw new UnauthorizedHttpException('', $message);
    }

    public function throwHttpResponseException(string $message = 'Internal server error', int $statusCode = 500): void
    {
        throw new HttpResponseException(response()->json([
            'message' => $message
        ], $statusCode));
    }

    public function throwInvalidArgumentException(string $message = 'Invalid argument'): void
    {
        throw new InvalidArgumentException($message);
    }
}