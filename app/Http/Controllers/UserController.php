<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function dashboard (){
        $title = 'Dashboard';
        $userId = 01;
        $name = 'Surya User';

        // Lakukan operasi lain yang diperlukan

        return view('user.dashboard', [
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

        return view('user.profile', [
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

        return view('user.kelas', [
            "title" => $title,
            "userId" => $userId,
            "name" => $name,
            ]);
    }

    public function transaksi (){
        $title = 'Data Kelas';
        $userId = 01;
        $name = 'Surya User';

        // Lakukan operasi lain yang diperlukan

        return view('user.transaksi', [
            "title" => $title,
            "userId" => $userId,
            "name" => $name,
            ]);
    }
}
