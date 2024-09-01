<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InstructorController extends Controller
{
    public function dashboard (){
        $title = 'Dashboard';
        $userId = 01;
        $name = 'Surya User';

        // Lakukan operasi lain yang diperlukan

        return view('instructor.dashboard', [
            "title" => $title,
            "userId" => $userId,
            "name" => $name,
            ]);
    }

    public function profile (){
        $title = 'Profile';
        $userId = 01;
        $name = 'Surya User';

        // Lakukan operasi lain yang diperlukan

        return view('instructor.profile', [
            "title" => $title,
            "userId" => $userId,
            "name" => $name,
            ]);
    }

    public function kelas (){
        $title = 'Data Kelas';
        $userId = 01;
        $name = 'Surya User';

        // Lakukan operasi lain yang diperlukan

        return view('instructor.kelas', [
            "title" => $title,
            "userId" => $userId,
            "name" => $name,
            ]);
    }

    public function diskusi (){
        $title = 'Diskusi ';
        $userId = 01;
        $name = 'Surya User';

        // Lakukan operasi lain yang diperlukan

        return view('instructor.diskusi', [
            "title" => $title,
            "userId" => $userId,
            "name" => $name,
            ]);
    }


}
