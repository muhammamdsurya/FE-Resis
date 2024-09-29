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


    public function kelas(Request $request)
    {
        $title = 'Data Kelas';
        $page = $request->input('page', 1); // Default to page 1 if not set

        // Fetch paginated courses
        $courses = $this->courseCtrl->getAllCourse($page);

        // Debugging the result to ensure the correct page is returned
        // dd($courses);

        return view('kelas', [
            'title' => $title,
            'courses' => $courses,  // Pass course data
            'pagination' => $courses->pagination,  // Pass pagination info
        ]);
    }

    public function detailKelas($courseId)
    {

        $title = 'Data Kelas';
        $course = $this->courseCtrl->getCourseById($courseId);
        $isLogin = 'n';
        if ($this->user != null) {
            $isLogin = 'y';
            // dd($course);
        } else {
            $isLogin = 'n';
        }


        return view('detailKelas', [
            "title" => $title,
            'course' => $course,
            'isLogin' => $isLogin
        ]);
    }
}
