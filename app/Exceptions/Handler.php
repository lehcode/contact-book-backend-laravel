<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation'
    ];

    public function register(): void {
        $this->renderable(function (Throwable $e, Request $request)) {
            if ($request->is('api/*')) {
                return $this->handleApiException($request, $e);
            }
        }
    }

    // /**
    //  * Render the exception as an HTTP response.
    //  */
    // public function render($request, Throwable $exception): Response
    // {
    //     if ($request->is('api/*')) {
    //         return $this->handleApiException($request, $exception);
    //     }

    //     return parent::render($request, $exception);
    // }

    private function handleApiException($request, Throwable $exception) {
        $statusCode = method_exists($exception, 'getStatusCode')
        ? $exception->getStatusCode()
        : Response::HTTP_INTERNAL_SERVER_ERROR;

        $response = [
            'success' => true,
            'message' => $exception->getMessage()
        ];

        if (config('app.debug')) {
            $response['trace'] = $exception->getTrace();
        }

        return response()->json($response, $statusCode);
    }
}
