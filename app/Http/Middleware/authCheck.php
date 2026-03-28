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
       // Cek apakah session role tersedia
    if ($request->session()->has('role')) {
        $role = $request->session()->get('role');

        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        } 
        
        if ($role === 'user') {
            return redirect()->route('user.dashboard');
        }
    }

    // Jika tidak ada session (berarti tamu/guest), lanjutkan ke halaman register/login
    return $next($request);
    }
}
