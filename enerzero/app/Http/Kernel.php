<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string>
     */
    protected $middleware = [
        \App\Http\Middleware\TrustProxies::class, // Middleware untuk menangani proxy
        \Illuminate\Http\Middleware\HandleCors::class, // Middleware untuk menangani CORS
        \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class, // Middleware untuk maintenance
        \Illuminate\Http\Middleware\ValidatePostSize::class, // Middleware untuk memvalidasi ukuran post
        \App\Http\Middleware\TrimStrings::class, // Middleware untuk menghapus spasi berlebih
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class, // Middleware untuk mengubah string kosong jadi null
        \App\Http\Middleware\EncryptCookies::class, // Middleware untuk mengenkripsi cookie
        \Illuminate\Session\Middleware\StartSession::class, // Middleware untuk memulai session
        \Illuminate\View\Middleware\ShareErrorsFromSession::class, // Middleware untuk berbagi error dari session
        \Illuminate\Routing\Middleware\SubstituteBindings::class, // Middleware untuk substitusi binding
    ];

    /**
     * The application's route middleware groups.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, array<int, class-string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, class-string>
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
    ];
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $users = \App\Models\User::all();
            foreach ($users as $user) {
                $user->notify(new \App\Notifications\DailyChallengeNotification());
            }
        })->dailyAt('07:00');
    }
}