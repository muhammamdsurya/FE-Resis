<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;


class WhoAmIMiddleware

{
    /**
     * Handle an incoming request.

     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next , $role = null): Response
    {


        $sessionCookie = 'session=' . session('api_session');
        // Log the cookies being sent
        Log::info('WhoAmI API Request Cookies: ', ['cookies' => $sessionCookie]);

        try {
            $response = Http::withHeaders([
                'Cookie' => 'session=' . session('api_session'),
            ])->get(config('services.backend_api.url') . 'auth/whoami');

            if ($response->successful()) {
                $userData = $response->json();

                // dd($userData);
                if ($role != $userData['role']) {

                    return redirect()->route('beranda')->with('error', 'Your session has expired. Please log in again.');
                }


                // Validate the response structure
                $requiredFields = ['id', 'email', 'full_name', 'photo_profile', 'role', 'created_at', 'updated_at', 'activated_at'];
                foreach ($requiredFields as $field) {
                    if (!isset($userData[$field])) {
                        $userData[$field] = '';
                    }
                }

                // Store user data in the request for use in the controller
                $request->merge(['user' => $userData]);

                // Optionally, store in session if needed across requests
                session(['user' => $userData]);

                return $next($request);
            } else {
                // If the whoami request fails, clear the session and redirect to login

                session()->forget('api_session');

                if ( $role == 'user') {
                    return redirect()->route('login')->with('error', 'Your session has expired. Please log in again.');
                } else if ($role == 'admin') {
                    return redirect()->route('loginAdmin')->with('error', 'Your session has expired. Please log in again.');
                } else if ($role == 'instructor') {
                    return redirect()->route('loginInstructor')->with('error', 'Your session has expired. Please log in again.');
                }



            }
        } catch (\Exception $e) {
            // Log the error
            // \Log::error('WhoAmI API error: ' . $e->getMessage());

            // Clear the session and redirect to login
            session()->forget('api_session');
            return redirect()->route('login')->with('error', 'An error occurred. Please log in again.');
        }
    }
}

