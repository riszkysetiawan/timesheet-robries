<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
        // Jika environment adalah production, tampilkan pesan error saja
        if (app()->environment('production')) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], $this->isHttpException($exception) ? $exception->getStatusCode() : 500);
        }

        // Default Laravel (untuk non-production)
        return parent::render($request, $exception);
    }
}
