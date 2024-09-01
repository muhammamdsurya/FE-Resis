<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class adminRole
{

    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = env('API_URL');  // Ambil URL API yang dapat diakses

    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

         // Cek apakah peran pengguna adalah 'admin'
         if (session('role') !== 'admin') {
            // Redirect ke halaman beranda jika peran tidak sesuai
            return redirect()->route('login')->withErrors(['message' => 'You do not have access to this area.']);
        }

        // Lanjutkan permintaan ke rute berikutnya jika peran sesuai
        return $next($request);
    }
}
