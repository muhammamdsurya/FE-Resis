<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class UserController extends Controller
{
    private $user;
    public function __construct() {
        $this->user = session('user');
    }

    private function getProfileData()
    {
        return [
            'id' => $this->user['id'],
            'full_name' => $this->user['full_name'],
            'email' => $this->user['email'],
            'photo_profile' => $this->user['photo_profile'],
            'created_at' => $this->user['created_at'],
            'updated_at' => $this->user['updated_at'],
            'activated_at' => $this->user['activated_at'],
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

        return view('user.profile', [
            "title" => $title,
            "id" => $profileData['id'],
            "full_name" => $profileData['full_name'],
            "email" => $profileData['email'],
            "photo_profile" => $profileData['photo_profile'],
            "created_at" => $profileData['created_at'],
            "updated_at" => $profileData['updated_at'],
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
        $id = 01;
        $full_name = 'Surya User';

        // Lakukan operasi lain yang diperlukan

        return view('user.diskusi', [
            "title" => $title,
            "id" => $id,
            "full_name" => $full_name,
        ]);
    }
}
