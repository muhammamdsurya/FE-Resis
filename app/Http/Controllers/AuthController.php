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

            // Mengonversi string tanggal menjadi objek Carbon
            $createdAt = Carbon::parse($userData['created_at']);
            $updatedAt = Carbon::parse($userData['updated_at']);


            session([
                'id' => $userData['id'],
                'full_name' => $userData['full_name'],
                'email' => $userData['email'],
                'role' => $userData['role'],
                'photo_profile' => $userData['photo_profile'],
                'created_at' => $createdAt->toDateTimeString(), // Format: 'YYYY-MM-DD HH:MM:SS'
                'updated_at' => $updatedAt->toDateTimeString(),
            ]);

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

            // Mengonversi string tanggal menjadi objek Carbon
            $createdAt = Carbon::parse($userData['created_at']);
            $updatedAt = Carbon::parse($userData['updated_at']);

            session([
                'id' => $userData['id'],
                'full_name' => $userData['full_name'],
                'email' => $userData['email'],
                'role' => $userData['role'],
                'photo_profile' => $userData['photo_profile'],
                'created_at' => $createdAt->toDateTimeString(), // Format: 'YYYY-MM-DD HH:MM:SS'
                'updated_at' => $updatedAt->toDateTimeString(), // Format: 'YYYY-MM-DD HH:MM:SS'
            ]);

            // Redirect ke halaman setelah login sukses
            return redirect()->route('dashboardAdmin');
        } else {
            // Jika gagal, kembalikan ke halaman login dengan pesan error

            return redirect()->route('loginAdmin')->with('error', 'Login gagal. Coba lagi.');
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

        // Cek status respons dari API
        if ($response->successful()) {
            // Jika berhasil, lakukan sesuatu (misalnya menyimpan token ke session)
            $userData = $response->json(); // Ambil seluruh data dari respons JSON
            session([
                'id' => $userData['id'],
                'full_name' => $userData['full_name'],
                'email' => $userData['email'],
                'role' => $userData['role'],
                'photo_profile' => $userData['photo_profile'],
                'created_at' => $userData['created_at'],
                'updated_at' => $userData['updated_at'],
                'activated_at' => $userData['activated_at'],
            ]);

            // Redirect ke halaman setelah login sukses
            return redirect()->route('/instructor/dashboard');
        } else {
            // Jika gagal, kembalikan ke halaman login dengan pesan error
            return redirect()->route('login')->with('error', 'Login gagal. Coba lagi.');
        }
    }

    public function logout(Request $request)
    {
        try {
            $response = Http::post('https://staging.akuanalis.com/api/v1/auth/logout');

            if ($response->ok()) {
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return response()->json(['message' => 'Logged out successfully!']);
            } else {
                return response()->json(['error' => 'Logout failed. Please try again.'], 500);
            }
        } catch (\Exception $e) {
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
