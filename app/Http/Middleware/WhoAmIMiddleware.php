<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;


class WhoAmIMiddleware

{
    /**
     * Handle an incoming request.

     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role = null): Response
    {

        try {
            $apiSession = Session::get('api_session');
            // dd($apiSession);
            if (!$apiSession) {
                throw new \Exception('Silahkan login kembali');
            }

            // Log the session cookie that will be sent
            Log::info('Session Cookie:', ['session_cookie' => $apiSession]);

            $response = Http::withHeaders([
                'Cookie' => 'session=' . $apiSession,
            ])->get(config('services.backend_api.url') . 'auth/whoami');

            // dd($response->body());

            // Make the WhoAmI API request
            // Log the response headers for debugging
            Log::info('Response Headers:', ['headers' => $response->headers()]);

            if ($response->successful()) {
                $userData = $response->json();

                // Check the role of the user
                if ($role != $userData['role']) {
                    return redirect()->route('beranda')->with('error', 'Your session has expired. Please log in again.');
                }

                // Validate and ensure all required fields are present in the response
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
                // If the WhoAmI request fails, clear the session and redirect to login
                session()->forget('api_session');

                // Determine the redirect route based on the user's role
                switch ($role) {
                    case 'admin':
                        $route = 'show.login.admin';
                        break;
                    case 'instructor':
                        $route = 'login.instructor';
                        break;
                    default:
                        $route = 'login';
                }

                return redirect()->route($route)->with('error', 'Silahkan login kembali!');
            }
        } catch (\Exception $e) {
            // Clear the session and redirect to login
            session()->forget('api_session');
            return redirect()->route('login')->with('error', $e->getMessage());
        }
    }
}
