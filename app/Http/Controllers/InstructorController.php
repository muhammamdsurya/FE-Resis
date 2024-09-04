<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InstructorController extends Controller
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


    public function dashboard (){
        $title = 'Dashboard';

        // Lakukan operasi lain yang diperlukan

        return view('instructor.dashboard', [
            "title" => $title,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
            ]);
    }

    public function profile (){

        $title = 'Profile';
        $profileData = $this->getProfileData();

        // Lakukan operasi lain yang diperlukan
        return view('instructor.profile', [
            "title" => $title,
            "full_name" => $profileData['full_name'],
            "email" => $profileData['email'],
            "photo_profile" => $profileData['photo_profile'],
            "created_at" => $profileData['created_at'],
            "activated_at" => $profileData['activated_at'],
            "updated_at" => $profileData['updated_at'],
            ]);
    }

    public function kelas (){
        $title = 'Data Kelas';

        // Lakukan operasi lain yang diperlukan

        return view('instructor.kelas', [
            "title" => $title,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
            ]);
    }

    public function diskusi (){
        $title = 'Diskusi ';

        // Lakukan operasi lain yang diperlukan

        return view('instructor.diskusi', [
            "title" => $title,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
            ]);
    }


}
