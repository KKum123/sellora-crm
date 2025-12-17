<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Helpers\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;


class Handler extends ExceptionHandler
{
    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request, Throwable $exception)
    {
        // Handle validation exceptions
        if ($exception instanceof ValidationException) {
            return ApiResponse::error('Validation error', 422, $exception->errors());
        }

        // Handle authentication exceptions
        if ($exception instanceof AuthenticationException) {
            return ApiResponse::error('Unauthenticated', 401);
            // return response()->view('errors-404', [], 404);
        }

        // Handle authorization exceptions
        if ($exception instanceof AuthorizationException) {
            // return ApiResponse::error('Unauthorized', 403);
            return response()->view('page403', [], 403);
        }

        // Handle model not found exceptions
        if ($exception instanceof ModelNotFoundException) {
            // return ApiResponse::error('Resource not found', 404);
            return response()->view('page404', [], 404);
        }

        // Handle HTTP exceptions
        if ($exception instanceof HttpException) {
            return response()->view('page404', [], 404);
            // return ApiResponse::error($exception->getMessage(), $exception->getStatusCode());
        }

        // Handle any other exception as a generic server error
        return ApiResponse::error('Server Error', 500, config('app.debug') ? $exception->getMessage() : null);
    }

    /**
     * Convert an authentication exception into a response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return ApiResponse::error('Unauthenticated', 401);
    }
}
