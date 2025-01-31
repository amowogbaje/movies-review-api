<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;

use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        // Log the exception details for debugging
        Log::error('Exception occurred: ', ['exception' => $exception]);

        // Handle unauthenticated exceptions
        if ($exception instanceof AuthenticationException) {
            return $this->unauthenticated($request, $exception);
        }

        // Handle authorization exceptions
        if ($exception instanceof AuthorizationException) {
            return response()->json(['message' => 'This action is unauthorized.'], 403);
        }

        // Handle model not found exceptions
        if ($exception instanceof ModelNotFoundException) {
            return response()->json(['message' => 'Resource not found.'], 404);
        }

        // Handle validation exceptions
        if ($exception instanceof ValidationException) {
            return response()->json(['message' => 'Validation failed.', 'errors' => $exception->errors()], 422);
        }

        // Handle method not allowed exceptions
        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json(['message' => 'Method not allowed.'], 405);
        }

        // Handle not found exceptions
        if ($exception instanceof NotFoundHttpException) {
            return response()->json(['message' => 'Not found.'], 404);
        }

        // Handle throttling exceptions
        if ($exception instanceof ThrottleRequestsException) {
            return response()->json(['message' => 'Too many requests. Please try again later.'], 429);
        }

        // Handle query exceptions
        if ($exception instanceof QueryException) {
            return response()->json(['message' => 'Database query error.', 'errors' => $exception->getMessage()], 500);
        }

        // Handle HTTP exceptions
        if ($exception instanceof HttpException) {
            return response()->json(['message' => $exception->getMessage() ?: 'HTTP error.'], $exception->getStatusCode());
        }

        

        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Unauthenticated'
        ], 401);
    }
}
