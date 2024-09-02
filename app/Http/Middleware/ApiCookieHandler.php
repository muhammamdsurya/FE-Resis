<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class ApiCookieHandler
{

    public function handle(Request $request, Closure $next)
    {
        // Add the session cookie to the request if it exists
        if (session()->has('api_session')) {
            $request->headers->set('Cookie', 'session=' . session('api_session'));
        }

        Log::info('ApiCookieHandler Request Cookie: ', ['cookies' => $request->headers->get('Cookie')]);

        $response = $next($request);

        // If there's a new session cookie in the response, update it
        $cookies = $response->headers->getCookies();
        foreach ($cookies as $cookie) {
            if ($cookie->getName() === 'session') {
                session(['api_session' => $cookie->getValue()]);
                $response->headers->setCookie(Cookie::make('session', $cookie->getValue(), $cookie->getExpiresTime(), $cookie->getPath(), $cookie->getDomain(), $cookie->isSecure(), $cookie->isHttpOnly()));
                break;
            }
        }

        return $response;
    }
}

