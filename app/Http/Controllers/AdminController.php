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
    private $user;
    private $apiUrl;


    public function __construct()
    {
        $this->user = session('user');
        $this->apiUrl = env('API_URL');
    }
    private function getProfileData()
    {
        return [
            'id' => $this->user['id'],
            'email' => $this->user['email'],
            'full_name' => $this->user['full_name'],
            'role' => $this->user['role'],
            'photo_profile' => $this->user['photo_profile'],
            'created_at' => $this->user['created_at'],
            'activated_at' => $this->user['activated_at'],
            'updated_at' => $this->user['updated_at'],
        ];
    }
        public function dashboard()
    {

        $title = 'Dashboard';

        // Lakukan operasi lain yang diperlukan

        return view('admin.dashboard', [
            "title" => $title,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
            "role" => $this->user['role'],
        ]);
    }

    public function kelas()
    {

        $title = 'Data Kelas';


        return view('admin.kelas', [
            "title" => $title,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
            "role" => $this->user['role'],
        ]);
    }

    public function profile()
    {

        $title = 'Profile';
        $profileData = $this->getProfileData();

        // Lakukan operasi lain yang diperlukan

        return view('admin.profile', [
            "title" => $title,
            "full_name" => $profileData['full_name'],
            "role" => $profileData['role'],
            "email" => $profileData['email'],
            "photo_profile" => $profileData['photo_profile'],
            "created_at" => $profileData['created_at'],
            "activated_at" => $profileData['activated_at'],
            "updated_at" => $profileData['updated_at'],
        ]);
    }

    public function bundling()
    {

        $title = 'Data Bundling';

        return view('admin.bundling', [
            "title" => $title,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
            "role" => $this->user['role'],
        ]);
    }

    public function sales()
    {

        $title = 'Data Penjualan';


        return view('admin.sales', [
            "title" => $title,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
            "role" => $this->user['role'],
        ]);
    }

    public function dataAdmin()
    {

        $title = 'Data Admin';

        // Lakukan operasi lain yang diperlukan
        return view('admin.dataAdmin', [
            "title" => $title,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
            "role" => $this->user['role'],
        ]);
    }

    public function dataPengajar()
    {

        $title = 'Data Pengajar';

        // Lakukan operasi lain yang diperlukan

        return view('admin.dataPengajar', [
            "title" => $title,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
            "role" => $this->user['role'],
        ]);
    }

    public function dataSiswa()
    {

        $title = 'Data Siswa';

        return view('admin.dataSiswa', [
            "title" => $title,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
            "role" => $this->user['role'],
        ]);
    }



}
