<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Define a macro for the Http facade
        Http::macro('withApiSession', function () {
            $apiSession = Session::get('api_session');
            $clientIp = request()->ip(); // Get the real client IP from the incoming request

            return $this->withHeaders([
                'Cookie' => 'session=' . $apiSession,
                'Client-User-IP' => $clientIp,

            ]);
        });

        //  // Define a macro for adding 'Client-User-IP' header to requests
        // Http::macro('withClientUserIP', function () {
        //     // Obtain the real IP address of the client making the request

        //     return Http::withHeaders([
        //     ]);
        // });
    }
}
