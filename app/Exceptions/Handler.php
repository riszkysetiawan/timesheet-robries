<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Support\Facades\App;

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
    // public function register(): void
    // {
    //     $this->reportable(function (Throwable $e) {
    //         //
    //     });
    // }
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    // public function render($request, Throwable $exception)
    // {
    //     // Periksa apakah environment adalah 'production'
    //     if (App::environment('production')) {
    //         // Arahkan ke view `error.error` untuk semua jenis error
    //         return response()->view('error.error', [], 500);
    //     }

    //     // Jika bukan production, gunakan handler bawaan Laravel
    //     return parent::render($request, $exception);
    // }
}
