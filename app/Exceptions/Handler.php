<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            Log::error('Произошла ошибка: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTrace(),
            ]);
        });

        $this->renderable(function (ValidationException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Validation errors',
                    'errors' => $e->errors(),
                ], Response::HTTP_UNPROCESSABLE_ENTITY); // 422
            }
        });

        $this->renderable(function (Throwable $e, $request) {
            if ($request->expectsJson()) {
                $statusCode = method_exists($e, 'getStatusCode')
                    ? $e->getStatusCode()
                    : Response::HTTP_INTERNAL_SERVER_ERROR; // 500

                return response()->json([
                    'message' => 'Server Error',
                    'error' => config('app.debug') ? $e->getMessage() : 'Something went wrong',
                ], $statusCode);
            }
        });
    }
}
