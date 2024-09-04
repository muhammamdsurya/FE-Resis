<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;


class UserController extends Controller
{
    private $user;
    public function __construct()
    {
        $this->user = session('user');
    }

    private function getProfileData()
    {
        // Mengonversi setiap timestamp ke objek Carbon
        $created = Carbon::parse($this->user['created_at']);
        $updated = Carbon::parse($this->user['updated_at']);
        $activated = Carbon::parse($this->user['activated_at']);

        // Mengubah zona waktu ke WIB (Asia/Jakarta)
        $createdWIB = $created->setTimezone('Asia/Jakarta');
        $updatedWIB = $updated->setTimezone('Asia/Jakarta');
        $activatedWIB = $activated->setTimezone('Asia/Jakarta');

        // Format tanggal sesuai kebutuhan
        $created_at = $createdWIB->format('d-m-Y H:i:s');
        $updated_at = $updatedWIB->format('d-m-Y H:i:s');
        $activated_at = $activatedWIB->format('d-m-Y H:i:s');

        return [
            'id' => $this->user['id'],
            'full_name' => $this->user['full_name'],
            'email' => $this->user['email'],
            'photo_profile' => $this->user['photo_profile'],
            'created_at' => $created_at,
            'updated_at' => $updated_at,
            'activated_at' => $activated_at,
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

        // Lakukan operasi lain yang diperlukan

        return view('user.diskusi', [
            "title" => $title,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
        ]);
    }
}
