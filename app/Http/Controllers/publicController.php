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
        $title = 'Kelas';
        $page = $request->input('page', 1); // Default to page 1 if not set
          // Ambil nilai input 'q' dari form
          $query = $request->input('q');

          if ($query) {
              // Fetch courses dengan parameter query
              $courses = $this->courseCtrl->getSearchCourse(urlencode($query));
          } else {
              // Fetch courses tanpa pencarian
              $courses = $this->courseCtrl->getAllCourse($page);
            }

        // Fetch paginated courses

        // Debugging the result to ensure the correct page is returned
        // dd($courses);

        return view('kelas', [
            'title' => $title,
            'courses' => $courses,  // Pass course data
            'pagination' => $courses->pagination ?? null,  // Pass pagination info
        ]);
    }

    public function detailKelas($courseId)
    {

        $title = 'Kelas';
        $course = $this->courseCtrl->getCourseById($courseId);
        $content = $this->courseCtrl->getCourseContentById($courseId);

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
            'content' => $content,
            'isLogin' => $isLogin
        ]);
    }

    public function bundling(Request $request)
    {
        $title = 'Paket Bundling';
        $page = $request->input('page', 1); // Default to page 1 if not set

        // Fetch paginated courses
        $bundling = $this->courseCtrl->getAllBundling($page);

        // Debugging the result to ensure the correct page is returned
        // dd($bundling);

        return view('bundling', [
            'title' => $title,
            'bundling' => $bundling,  // Pass course data
            'pagination' => $bundling->pagination,  // Pass pagination info
        ]);
    }

    public function detailBundling($courseId)
    {

        $title = 'Paket Bundling';
        $bundling = $this->courseCtrl->getBundlingById($courseId);
        $contentsId = $this->courseCtrl->getBundlingContentById($courseId);

        $contents = [];
        foreach ($contentsId as $row) {
            $contents[] = $this->courseCtrl->getCourseById($row);
        }

        $isLogin = 'n';
        if ($this->user != null) {
            $isLogin = 'y';
            // dd($course);
        } else {
            $isLogin = 'n';
        }


        return view('detailBundling', [
            "title" => $title,
            'bundling' => $bundling,
            'contents' => $contents, // Pastikan ini adalah array
            'isLogin' => $isLogin
        ]);
    }
}
