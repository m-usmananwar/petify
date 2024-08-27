<?php

namespace App\Exceptions;

use Throwable;
use App\Http\Response\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (Throwable $e) {
            $message = $e->getMessage();

            if ($e instanceof HttpExceptionInterface) {
                return ApiResponse::rawResponse(["message" => $message], $e->getStatusCode());
            }

            return ApiResponse::rawResponse(["message" => $message], 500);
        });
    }

    public function report(Throwable $exception)
    {
        return parent::report($exception);
    }

    public function render($request, Throwable $exception)
    {
        if(strpos(get_class($exception), 'Illuminate\Database') === 0) {
            return parent::render($request, new \Exception('Database error, please try later'));
        }
        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if($request->expectsJson()) {
            return ApiResponse::rawResponse(['message' => 'User is not logged in. Please redirect user to login screen and send token with further requests.'], 401);
        }

        return redirect()->guest('login');
    }
}
