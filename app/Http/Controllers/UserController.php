<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;



class UserController extends Controller
{
    private $user;
    private $apiUrl;
    public function __construct()
    {
        $this->user = session('user');
        $this->apiUrl = env('API_URL');
    }


    private function getDetailData()
    {
        $id = $this->user['id'];
        $api = $this->apiUrl . 'users/auth/data/' . $id;

        $response = Http::withApiSession()->get($api);


        return $response->json();

    }

    public function completeData()
    {
        return view('user.completeData', [
            "title" => 'Complete Data',
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
        ]);
    }

    private function getProfileData()
    {


        return [
            'id' => $this->user['id'],
            'full_name' => $this->user['full_name'],
            'email' => $this->user['email'],
        ];
    }
    public function dashboard()
    {
        $title = 'Dashboard';

        return view('user.dashboard', [
            "title" => $title,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
        ]);
    }

    public function profile()
    {
        $title = 'Profile';
        $profileData = $this->getProfileData();
        $detailData = $this->getDetailData();

        $birth = Carbon::parse($detailData['birth']);
        $wib = $birth->setTimezone('Asia/Jakarta');
        $format = $wib->format('d-m-Y');



        return view('user.profile', [
            "title" => $title,
            "full_name" => $profileData['full_name'],
            "email" => $profileData['email'],
            "birth" => $format,
            "study_level" => $detailData['study_level'],
            "institution" => $detailData['institution']

        ]);
    }

    public function kelas()
    {
        $title = 'Data Kelas';

        return view('user.kelas', [
            "title" => $title,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
        ]);
    }

    public function transaksi()
    {
        $title = 'Data Transaksi';

        return view('user.transaksi', [
            "title" => $title,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
        ]);
    }

    public function materi()
    {
        $title = 'Materi Praktikum Laboratorium Dasar';

        return view('user.materi', [
            "title" => $title,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
        ]);
    }
    public function diskusi()
    {
        $title = 'Diskusi';

        // Lakukan operasi lain yang diperlukan

        return view('user.diskusi', [
            "title" => $title,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
        ]);
    }
}
