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
        $response = Http::withClientUserIP()->post($this->apiUrl . 'users/auth/login', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        // Cek status respons dari API
        if ($response->successful()) {
            // Jika berhasil, lakukan sesuatu (misalnya menyimpan token ke session)
            $userData = $response->json(); // Ambil seluruh data dari respons JSON

            // get the cookies from the response
            $cookies = $response->cookies();
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
            return redirect()->route('user.dashboard');
        } else {
            // Jika gagal, kembalikan ke halaman login dengan pesan error
            return redirect()->route('login')->with('error', 'Username atau Password salah');
        }
    }

    public function showAdmin()
    {
        return view('admin.login');
    }

    public function regisAdmin(Request $request)
    {

        // Hit API users/auth/register
        $response = Http::withApiSession()->post($this->apiUrl . 'admin/auth/register', [
            'email' => $request->email,
            'password' => $request->password,
            'password_confirm' => $request->password_confirm,
            'full_name' => $request->full_name,
        ]);

        // Cek jika API mengembalikan sukses
        if ($response->successful()) {
            if ($response->json('activated_at') != null) {
                return redirect()->route('data.admin')->with('message', 'Data Berhasil Dipulihkan');
            } else {
                $personId = $response->json('id');
                // Simpan person_id ke sesi
                session(['person_id' => $personId]);

                // Redirect ke halaman yang diinginkan
                return redirect()->route('admin.data');
            }
        } else {
            return redirect()->route('data.admin')->with('error', $response->body());
        }
    }

    public function loginAdmin(Request $request)
    {
        // Validasi request
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Kirim permintaan POST ke API login
        $response = Http::withClientUserIP()->post($this->apiUrl . 'admin/auth/login', [
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
            return redirect()->route('login.admin')->with('error', 'Username atau Password salah');
        }
    }

    public function showInstructor()
    {
        return view('instructor.login');
    }

    public function editPengajar(Request $request, $id)
    {

        $apiSession = session('api_session');

        // Definisikan headers
        $headers = [
            'Content-Type' => 'application/json',
            'Cookie' => 'session=' . $apiSession
        ];

        // Definisikan body sebagai array associative
        $body = [
            'person_id' => $request->id,
            'education' => $request->education,
            'experience' => $request->experience,
        ];


        $apiUrl = $this->apiUrl . 'instructors/auth/data';

        // Kirimkan request PUT
        $response = Http::withHeaders($headers)->put($apiUrl, $body);

        if ($response->successful()) {
            // Check if a new thumbnail was uploaded
            // Prepare for the image upload (second API request)
            if ($request->hasFile('image')) {
                // Use the attach method for a multipart/form-data request
                $imageResponse = Http::withHeaders(['Cookie' => 'session=' . $apiSession])
                    ->attach(
                        'photo_profile',
                        fopen($request->file('image')->getRealPath(), 'r'), // Open the file for reading
                        $request->file('image')->getClientOriginalName() // Get the original filename
                    )
                    ->put($this->apiUrl . "instructors/" . $id . "/photo_profile");
                // Check if the image upload was successful

                // Cek respons API
                if ($imageResponse->successful()) {
                    // Debugging: Print response body to see if image upload succeeded
                    return back()->with('message', 'Data dan thumbnail berhasil diperbarui.');
                } else {
                    return back()->withErrors(['msg' => 'Data berhasil diperbarui, tetapi gagal mengunggah thumbnail.']);
                }
            }
            // If no thumbnail is uploaded, only update the body
            return back()->with('message', 'Data berhasil diperbarui.');
        } else {
            // Handle case where the bundle data update fails
            return redirect()->back()->withErrors(['msg' => 'Gagal memperbarui data.']);
        }
    }
    public function regisInstructor(Request $request)
    {
        $apiSession = session('api_session');

        // Definisikan headers
        $headers = [
            'Content-Type' => 'application/json',
            'Cookie' => 'session=' . $apiSession
        ];

        $body = [
            'email' => $request->email,
            'password' => $request->password,
            'password_confirm' => $request->password_confirm,
            'full_name' => $request->full_name
        ];


        // Hit API users/auth/register
        $api = $this->apiUrl . 'instructors/auth/register';
        $response = Http::withHeaders($headers)->post($api, $body);

        // Use the attach method for a multipart/form-data request
        // Cek jika API mengembalikan sukses
        if ($response->successful()) {
            if ($response->json('activated_at') != null) {
                return back()->with('message', 'Data Berhasil Dipulihkan');
            } else {
                $personId = $response->json('id');
                // Simpan person_id ke sesi
                session(['person_id' => $personId]);
                if ($request->hasFile('image')) {
                    // Use the attach method for a multipart/form-data request
                    $imageResponse = Http::withHeaders(['Cookie' => 'session=' . $apiSession])
                        ->attach(
                            'photo_profile',
                            fopen($request->file('image')->getRealPath(), 'r'), // Open the file for reading
                            $request->file('image')->getClientOriginalName() // Get the original filename
                        )
                        ->put($this->apiUrl . "instructors/" . $personId . "/photo_profile");

                    // Cek respons API
                    if ($imageResponse->successful()) {
                        // Debugging: Print response body to see if image upload succeeded
                        return redirect()->route('instructor.data')->with('success', 'Data dan photo berhasil ditambahkan.');
                    } else {
                        return back()->withErrors(['error' => 'Data berhasil ditambah, tetapi gagal mengunggah photo.']);
                    }
                } else {
                    return back()->with('error', 'Masukan foto profil terlebih dahulu');
                }
            }
        } else {
            // Handle case where the bundle data update fails
            return back()->with('error', $request->body());
        }
    }
    public function loginInstructor(Request $request)
    {
        // Validasi request
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);


        // Kirim permintaan POST ke API login
        $response = Http::withClientUserIP()->post($this->apiUrl . 'instructors/auth/login', [
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
                session(['api_session' => $sessionValue . '=']);
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
            return redirect()->route('login.instructor')->with('error', 'Username atau Password salah');
        }
    }

    public function register(Request $request)
    {

        // Hit API users/auth/register
        $response = Http::withClientUserIP()->post($this->apiUrl . 'users/auth/register', [
            'email' => $request->email,
            'password' => $request->password,
            'password_confirm' => $request->password_confirm,
            'full_name' => $request->full_name,
        ]);

        // Cek jika API mengembalikan sukses
        if ($response->successful()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Silahkan aktivasi akunmu di email!'
            ]);
        }

        // Handle error dari API
        return response()->json([
            'status' => 'error',
            'message' => 'Email sudah terdaftar atau terjadi kesalahan.',
            'body' => $response->body(),
            'email' => $request->email
        ], 400);
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

            $response = Http::withClientUserIP()->get($this->apiUrl . 'users/auth/google/callback', [
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
            $response = Http::withApiSession()->post($this->apiUrl . 'auth/logout');

            if ($response->ok()) {
                // Clear session data
                session()->forget('api_session');
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                $message = $response->json('success') ?? 'Logout Success.';
                return response()->json(['success' => $message], $response->status());
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
    public function getResetPublic()
    {
        return view('resetForm');
    }
    public function activation(Request $request, $token)
    {

        $url = $this->apiUrl . 'auth/activation/' . $token;

        $response = Http::withClientUserIP()->post($url, ['email' => $request->email]);

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

    public function resetPassword(Request $request)
    {
        $url = $this->apiUrl . 'auth/password/forgot';

        $response = Http::withClientUserIP()->post($url, ['email' => $request->email]);

        // Cek jika token dan email ada dalam query string
        if ($response->successful()) {
            return response()->json(['status' => 'success', 'message' => 'Cek email untuk reset password. Link untuk reset password hanya aktif dalam 5 menit']);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => $response->body(),
            ], $response->status());
        }
    }

    public function putPassword(Request $request, $token)
    {
        $url = $this->apiUrl . 'auth/password/' . $token;

        // $responseVerify = Http::get($verify, $request->email);
        // if($responseVerify->status() == 400){
        //     return response()->json(['message' => $responseVerify->body()], 404);
        // } else if($responseVerify->status() == 200){
        //     return response()->json(['message' => 'Token reset password telah ditemukan.'], 200);
        // }

        $headers = [
            'Content-Type' => 'application/json',
        ];
        $body = [
            "email" => $request->email,
            "new_password" => $request->new_password,
            "new_password_confirm" => $request->new_password_confirm
        ];

        $response = Http::withHeaders($headers)->put($url, $body);
        // Cek jika token dan email ada dalam query string
        if ($response->successful()) {
            return response()->json(['status' => 'success', 'message' => 'Password berhasil diubah!']);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => $response->body(),
            ], $response->status());
        }
    }
    public function getReset()
    {
        return view('resetPassword');
    }
}
