<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class CompletedData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $session = session('user');
        $id = $session['id'];


        $apiUrl = config('services.backend_api.url') . 'users/auth/data/' . $id;

        $response = Http::withApiSession()->get($apiUrl);


        if ($response->status() === 500) {
            if ($request->routeIs('user.data') || $request->routeIs('complete.post')) {
                return $next($request);
            }
            return redirect()->route('user.data')->with('warning', 'Isi data terlebih dahulu.');
        }

        if ($response->ok()) {
            $userData = $response->json();

            // Periksa kolom tertentu dalam respons
            $isDataComplete = !empty($userData['birth']); // Ganti 'profile_picture' dengan kolom yang relevan

            if (!$isDataComplete) {
                // Jika tidak lengkap, arahkan ke halaman penyelesaian data
                if ($request->routeIs('user.data') || $request->routeIs('complete.post')) {
                    return $next($request);
                }

                return redirect()->route('user.data')->with('warning', 'Lengkapi semua data');
            }
        } else {
            // Tangani jika API gagal
            return redirect()->route('user.data')->with('error', 'Unable to fetch user data.');
        }
        return $next($request);
    }
}
