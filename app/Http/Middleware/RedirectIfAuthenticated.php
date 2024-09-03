<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, $role = null ): Response
    {
        // Check if 'api_session' exists in the session
        if (Session::has('api_session')) {
            // Redirect to the previous page if the session exists
            /* return redirect()->back(); */
            $user = Session::get('user');
            if ($user['role'] != $role) {
                return redirect()->route('beranda');  // Replace 'home' with the desired route for unauthorized users.
            } else if ($user['role'] == 'admin') {
                return redirect()->route('dashboardAdmin');
            } else if ($user['role'] == 'user'){
                return redirect()->route('user.dashboard');
            } else if ($user['role'] == 'instructor') {
                return redirect()->route('instructor.dashboard');
            }
        }

        // Proceed to the next middleware or request handler
        return $next($request);
    }
}

