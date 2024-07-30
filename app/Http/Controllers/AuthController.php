<?php

namespace App\Http\Controllers;

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
    public function show() {
        return view('login');

    }

    public function login(Request $request) {

        // Validasi input
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

         // Kirim permintaan POST ke API login
         $response = Http::post('http://localhost:3000/api/v1/users/auth/login', [
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
            return redirect()->route('userDashboard');

        } else {
            // Jika gagal, kembalikan ke halaman login dengan pesan error
            return redirect()->route('login')->with('error', 'Login gagal. Coba lagi.');
        }

    }

    public function showAdmin() {
        return view('admin.login');

    }


    public function loginAdmin(Request $request) {
        // Validasi request
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Kirim permintaan POST ke API login
        $response = Http::post('http://localhost:3000/api/v1/admin/auth/login', [
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
            return redirect()->route('dashboardAdmin');

        } else {
            // Jika gagal, kembalikan ke halaman login dengan pesan error
            return redirect()->route('login')->with('error', 'Login gagal. Coba lagi.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Menghapus semua sesi yang terkait dengan pengguna yang sedang login

        $request->session()->invalidate(); // Menghapus sesi saat ini

        $request->session()->regenerateToken(); // Regenerasi token CSRF

        return redirect()->route('login'); // Redirect ke halaman login
    }
}
