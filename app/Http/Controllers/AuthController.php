<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Models\User; // <-- corrected line

class AuthController extends Controller
{

    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = env('API_URL');
    }

    public function show()
    {
        return view('login');
    }

    public function login(Request $request)
    {

        // Validasi input
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        // Kirim permintaan POST ke API login
        $response = Http::post($this->apiUrl . 'users/auth/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        // Cek status respons dari API
        if ($response->successful()) {
            // Jika berhasil, lakukan sesuatu (misalnya menyimpan token ke session)
            $userData = $response->json(); // Ambil seluruh data dari respons JSON

            // get the cookies from the response
            $cookies = $response->cookies();
            Log::info('Login API Response Cookies: ', ['cookies' => $cookies]);
            // get the session cookie
            $sessionCookie = null;
            foreach ($cookies as $cookie) {
                if (strpos($cookie, 'session') !== false) {
                    $sessionCookie = $cookie;
                    break;
                }
            }

            if ($sessionCookie) {
                // parse the cookie string
                $parts = explode(';', $sessionCookie);
                $sessionValue = explode('=', $parts[0])[1];

                // set the session session to laravel session
                session(['api_session' => $sessionValue."="]);
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

            // Redirect ke halaman setelah login sukses
            return redirect()->route('user.dashboard');
        } else {
            // Jika gagal, kembalikan ke halaman login dengan pesan error
            return redirect()->route('login')->with('error', 'Login gagal. Coba lagi.');
        }
    }

    public function showAdmin()
    {
        return view('admin.login');
    }


    public function loginAdmin(Request $request)
    {
        // Validasi request
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Kirim permintaan POST ke API login
        $response = Http::post($this->apiUrl . 'admin/auth/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $cookies = $response->cookies();
        // Cek status respons dari API
        if ($response->successful()) {
            // Jika berhasil, lakukan sesuatu (misalnya menyimpan token ke session)
            $userData = $response->json(); // Ambil seluruh data dari respons JSON

            // get the cookies from the response
            $cookies = $response->cookies();
            Log::info('Login API Response Cookies: ', ['cookies' => $cookies]);
            // get the session cookie
            $sessionCookie = null;
            foreach ($cookies as $cookie) {
                if (strpos($cookie, 'session') !== false) {
                    $sessionCookie = $cookie;
                    break;
                }
            }

            if ($sessionCookie) {
                // parse the cookie string
                $parts = explode(';', $sessionCookie);
                $sessionValue = explode('=', $parts[0])[1];

                // set the session session to laravel session
                session(['api_session' => $sessionValue]);
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

            // Redirect ke halaman setelah login sukses
            return redirect()->route('admin.dashboard');
        } else {
            // Jika gagal, kembalikan ke halaman login dengan pesan error
            return redirect()->route('login.Admin')->with('error', 'Login gagal. Coba lagi.');
        }
    }

    public function showInstructor()
    {
        return view('instructor.login');
    }

    public function loginInstructor(Request $request)
    {
        // Validasi request
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);


        // Kirim permintaan POST ke API login
        $response = Http::post($this->apiUrl . 'instructors/auth/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            // Jika berhasil, lakukan sesuatu (misalnya menyimpan token ke session)
            $userData = $response->json(); // Ambil seluruh data dari respons JSON

            // get the cookies from the response
            $cookies = $response->cookies();
            Log::info('Login API Response Cookies: ', ['cookies' => $cookies]);
            // get the session cookie
            $sessionCookie = null;
            foreach ($cookies as $cookie) {
                if (strpos($cookie, 'session') !== false) {
                    $sessionCookie = $cookie;
                    break;
                }
            }

            if ($sessionCookie) {
                // parse the cookie string
                $parts = explode(';', $sessionCookie);
                $sessionValue = explode('=', $parts[0])[1];

                // set the session session to laravel session
                session(['api_session' => $sessionValue]);
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

            // Redirect ke halaman setelah login sukses
            return redirect()->route('instructor.dashboard');
        } else {
            // Jika gagal, kembalikan ke halaman login dengan pesan error
            return redirect()->route('login.instructor')->with('error', 'Login gagal. Coba lagi.');
        }
    }

    public function handleGoogleOauth(Request $request)
    {
        $targetUrl = $this->apiUrl . 'users/auth/google/login';
        return redirect($targetUrl);
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $request->validate([
                'code' => 'required|string',
                'state' => 'required|string',
            ]);

            $response = Http::get($this->apiUrl . 'users/auth/google/callback', [
                'code' => $request->code,
                'state' => $request->state,
            ]);

            if ($response->successful()) {
                // get the cookies from the response
                $cookies = $response->cookies();
                Log::info('Login API Response Cookies: ', ['cookies' => $cookies]);
                // get the session cookie
                $sessionCookie = null;
                foreach ($cookies as $cookie) {
                    if (strpos($cookie, 'session') !== false) {
                        $sessionCookie = $cookie;
                        break;
                    }
                }

                if ($sessionCookie) {
                    // parse the cookie string
                    $parts = explode(';', $sessionCookie);
                    $sessionValue = explode('=', $parts[0])[1];

                    // set the session session to laravel session
                    session(['api_session' => $sessionValue]);
                }

                // Redirect ke halaman setelah login sukses
                return redirect()->route('user.dashboard');
            } else {
                return redirect()->route('login')->with('error', 'Login gagal. Coba lagi.');
            }
        } catch (\Exception $e) {
            Log::error('Google OAuth error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Login gagal. Coba lagi.');
        }
    }

    public function logout(Request $request)
    {
        try {

            // Send a POST request to the API logout endpoint
            $response = Http::withApiSession()->post('https://staging.akuanalis.com/api/v1/auth/logout');

            if ($response->ok()) {
                // Clear session data
                session()->forget('api_session');
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')->with('status', 'Logged out successfully!');
            } else {
                // Handle a failed logout attempt
                $errorMessage = $response->json('error') ?? 'Logout failed. Please try again.';
                return response()->json(['error' => $errorMessage], $response->status());
            }
        } catch (\Exception $e) {
            // Log the exception for debugging purposes
            // \Log::error('Logout API error: ' . $e->getMessage());

            // Return a generic error response
            return response()->json(['error' => 'An unexpected error occurred.'], 500);
        }
    }

    public function activate()
    {
        return view('activation');
    }
    public function activation(Request $request)
    {
        // Ambil token dan email dari query string
        $token = $request->query('token');
        $email = $request->query('email');

        $url = $this->apiUrl . 'auth/activation/' . $token;

        $response = Http::post($url, ['email' => $email]);

        // Cek jika token dan email ada dalam query string
        if ($response->successful()) {
            return response()->json([
                'status_code' => $response->status(),
                'message' => 'Akun berhasil diaktifkan.',
            ], $response->status());
        } else {
            return response()->json([
                'status_code' => $response->status(),
                'message' => 'Token aktivasi tidak valid atau sudah kadaluarsa.',
            ], $response->status());
        }
    }
}
