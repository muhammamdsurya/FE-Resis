<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class authCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $role = $request->session()->get('role');
            if ($role === 'admin') {
                return redirect()->route('admin.dashboard');
            } else if ($role === 'user') {
                return redirect()->route('user.dashboard');
            }
        return $next($request);
    }
}
