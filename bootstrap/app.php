<?php

use App\Http\Middleware\adminRole;
use App\Http\Middleware\authCheck;
use Illuminate\Foundation\Application;
use App\Http\Middleware\VerifyCsrfToken;
use App\Http\Middleware\WhoAmIMiddleware;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->group('web', [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':500,1', // 500 requests per minute

        ]);
        $middleware->alias([
            'whoami' => App\Http\Middleware\WhoAmIMiddleware::class,
            'redirect.if.authenticated' => App\Http\Middleware\RedirectIfAuthenticated::class,
            'completed.data' => App\Http\Middleware\CompletedData::class,
            /* 'adminRole' => adminRole::class, */
            /* 'authCheck' => authCheck::class */
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
