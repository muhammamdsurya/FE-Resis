<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RegisController extends Controller
{

    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = env('API_URL');
    }

    public function show()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        // Kirim data ke API eksternal
        $response = Http::post($this->apiUrl . 'users/auth/register', [
            'email' => $request->email,
            'password' => $request->password,
            'password_confirm' => $request->password_confirm,
            'full_name' => $request->full_name,
        ]);

        if ($response->successful()) {
            return response()->json([
                'status_code' => $response->status(),
                'data' => $response->json()
            ], $response->status());
        } else {
            return response()->json([
                'status_code' => $response->status(),
                'message' => 'Registration failed',
                'errors' => $response->json() // Mengirimkan detail kesalahan jika ada
            ], $response->status());
        }
    }
}
