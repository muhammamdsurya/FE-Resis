<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    private function getUserData()
    {
        return [
            'userId' => session('id'),
            'name' => session('full_name')
        ];
    }

    private function getProfileData()
    {
        return [
            'email' => session('email'),

            'photo_profile' => session('photo_profile'),
            'created_at' => session('created_at'),
            'updated_at' => session('updated_at'),
            'activated_at' => session('activated_at'),
        ];
    }
    public function dashboard()
    {
        $title = 'Dashboard';
        $userData = $this->getUserData();

        return view('user.dashboard', [
            "title" => $title,
            "userId" => $userData['userId'],
            "name" => $userData['name'],
        ]);
    }

    public function profile()
    {
        $title = 'Profile';
        $userData = $this->getUserData();
        $profileData = $this->getProfileData();

        return view('user.profile', [
            "title" => $title,
            "userId" => $userData['userId'],
            "name" => $userData['name'],
            "email" => $profileData['email'],
            "photo_profile" => $profileData['photo_profile'],
            "created_at" => $profileData['created_at'],
            "updated_at" => $profileData['updated_at'],
        ]);
    }

    public function kelas()
    {
        $title = 'Data Kelas';
        $userData = $this->getUserData();

        return view('user.kelas', [
            "title" => $title,
            "userId" => $userData['userId'],
            "name" => $userData['name'],
        ]);
    }

    public function transaksi()
    {
        $title = 'Data Transaksi';
        $userData = $this->getUserData();

        return view('user.transaksi', [
            "title" => $title,
            "userId" => $userData['userId'],
            "name" => $userData['name'],
        ]);
    }

    public function materi()
    {
        $title = 'Materi Praktikum Laboratorium Dasar';
        $userData = $this->getUserData();

        return view('user.materi', [
            "title" => $title,
            "userId" => $userData['userId'],
            "name" => $userData['name'],
        ]);
    }
    public function diskusi()
    {
        $title = 'Diskusi';
        $userId = 01;
        $name = 'Surya User';

        // Lakukan operasi lain yang diperlukan

        return view('user.diskusi', [
            "title" => $title,
            "userId" => $userId,
            "name" => $name,
        ]);
    }
}
