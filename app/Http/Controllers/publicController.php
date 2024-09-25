<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class publicController extends Controller
{
    private $courseCtrl;
    private $user;
    

    public function __construct()
    {
        $this->courseCtrl = new courseController();
        $this->user = session('user');
    }


    public function kelas()
    {

        $title = 'Data Kelas';

        $page = 0;

        $courses = $this->courseCtrl->getAllCourse($page);
        // dd($courses);

        return view('kelas', [
            "title" => $title,
            'courses' =>$courses
        ]);
    }
    public function detailKelas($courseId)
    {

        $title = 'Data Kelas';
        $course = $this->courseCtrl->getCourseById($courseId);
        $isLogin = 'n';
        if($this->user != null){
            $isLogin = 'y';
            // dd($course);
        }else{
            $isLogin = 'n';
        }


        return view('detailKelas', [
            "title" => $title,
            'course' =>$course,
            'isLogin' =>$isLogin
        ]);
    }
}
