<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = env('API_URL');
    }
    public function dashboard()
    {

        $title = 'Dashboard';
        $full_name = session('full_name');
        $id = session('id');
        $role = session('role');
        // Lakukan operasi lain yang diperlukan

        return view('admin.dashboard', [
            "title" => $title,
            "id" => $id,
            "full_name" => $full_name,
            "role" => $role,
        ]);
    }

    public function kelas()
    {
        // $client = new Client();
        // $response = $client->get('http://localhost:3000/api/v1/kelas');

        // $kelas = $response->getBody()->getContents();

        //['kelas' => json_decode($kelas)]
        $title = 'Data Kelas';
        $full_name = session('full_name');
        $id = session('id');
        $role = session('role');

        // Lakukan operasi lain yang diperlukan

        return view('admin.kelas', [
            "title" => $title,
            "id" => $id,
            "full_name" => $full_name,
            "role" => $role,
        ]);
    }

    public function profile()
    {
        // $client = new Client();
        // $response = $client->get('http://localhost:3000/api/v1/profile');

        // $kelas = $response->getBody()->getContents();

        //['kelas' => json_decode($kelas)]
        $title = 'Profile';
        $id = session('id');
        $full_name = session('full_name');
        $email = session('email');
        $role = session('role');
        $photo_profile = session('photo_profile');
        $created_at = session('created_at');
        $activated_at = session('activated_at');
        $updated_at = session('updated_at');

        // Lakukan operasi lain yang diperlukan

        return view('admin.profile', [
            "title" => $title,
            "id" => $id,
            "full_name" => $full_name,
            "email" => $email,
            "role" => $role,
            "photo_profile" => $photo_profile,
            "created_at" => $created_at,
            "activated_at" => $activated_at,
            "updated_at" => $updated_at,
        ]);
    }

    public function bundling()
    {
        // $client = new Client();
        // $response = $client->get('http://localhost:3000/api/v1/bundling');

        // $kelas = $response->getBody()->getContents();

        //['kelas' => json_decode($kelas)]
        $title = 'Data Bundling';
        $id = session('id');
        $role = session('role');
        $full_name = session('full_name');


        // Lakukan operasi lain yang diperlukan

        return view('admin.bundling', [
            "title" => $title,
            "id" => $id,
            "full_name" => $full_name,
            "role" => $role,
        ]);
    }

    public function sales()
    {
        // $client = new Client();
        // $response = $client->get('http://localhost:3000/api/v1/sales');

        // $kelas = $response->getBody()->getContents();

        //['kelas' => json_decode($kelas)]
        $title = 'Data Penjualan';
        $id = session('id');
        $role = session('role');
        $full_name = session('full_name');

        // Lakukan operasi lain yang diperlukan

        return view('admin.sales', [
            "title" => $title,
            "id" => $id,
            "full_name" => $full_name,
            "role" => $role,
        ]);
    }

    public function dataAdmin()
    {
        // $client = new Client();
        // $response = $client->get('http://localhost:3000/api/v1/data-admin');

        // $kelas = $response->getBody()->getContents();

        //['kelas' => json_decode($kelas)]
        $title = 'Data Admin';
        $id = session('id');
        $role = session('role');
        $full_name = session('full_name');

        // Lakukan operasi lain yang diperlukan
        return view('admin.dataAdmin', [
            "title" => $title,
            "id" => $id,
            "full_name" => $full_name,
            "role" => $role,
        ]);
    }

    public function dataPengajar()
    {
        // $client = new Client();
        // $response = $client->get('http://localhost:3000/api/v1/data-admin');

        // $kelas = $response->getBody()->getContents();

        //['kelas' => json_decode($kelas)]
        $title = 'Data Pengajar';
        $id = session('id');
        $role = session('role');
        $full_name = session('full_name');


        // Lakukan operasi lain yang diperlukan

        return view('admin.dataPengajar', [
            "title" => $title,
            "id" => $id,
            "full_name" => $full_name,
            "role" => $role,
        ]);
    }

    public function dataSiswa()
    {
        // $client = new Client();
        // $response = $client->get('http://localhost:3000/api/v1/data-admin');

        // $kelas = $response->getBody()->getContents();

        //['kelas' => json_decode($kelas)]
        $title = 'Data Siswa';
        $id = session('id');
        $role = session('role');
        $full_name = session('full_name');


        // Lakukan operasi lain yang diperlukan

        return view('admin.dataSiswa', [
            "title" => $title,
            "id" => $id,
            "full_name" => $full_name,
            "role" => $role,
        ]);
    }



    public function jenjang(Request $request)
    {

        $response = Http::withApiSession()->post($this->apiUrl . 'courses/categories', [
            'name' => $request->name // Include other necessary data here
        ]);


        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'data' => $response->json()
            ], $response->status());
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add category.'
            ], $response->status());
        }
    }
}
