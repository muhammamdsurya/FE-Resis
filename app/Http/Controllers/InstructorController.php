<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InstructorController extends Controller
{
    public function dashboard (){
        $title = 'Dashboard';
        $userId = session('id');
        $name = session('full_name');

        // Lakukan operasi lain yang diperlukan

        return view('instructor.dashboard', [
            "title" => $title,
            "userId" => $userId,
            "name" => $name,
            ]);
    }

    public function profile (){
        $title = 'Profile';
        $userId = session('id');
        $name = session('full_name');
        $email = session('email');
        $created_at = session('created_at');
        $updated_at = session('updated_at');

        // Lakukan operasi lain yang diperlukan
        return view('instructor.profile', [
            "title" => $title,
            "userId" => $userId,
            "name" => $name,
            "email" => $email,
            "created_at" => $created_at,
            "updated_at" => $updated_at,
            ]);
    }

    public function kelas (){
        $title = 'Data Kelas';
        $userId = session("id");
        $name = session("full_name");

        // Lakukan operasi lain yang diperlukan

        return view('instructor.kelas', [
            "title" => $title,
            "userId" => $userId,
            "name" => $name,
            ]);
    }

    public function diskusi (){
        $title = 'Diskusi ';
        $userId = session("id");
        $name = session("full_name");

        // Lakukan operasi lain yang diperlukan

        return view('instructor.diskusi', [
            "title" => $title,
            "userId" => $userId,
            "name" => $name,
            ]);
    }


}
