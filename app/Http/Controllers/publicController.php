<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class publicController extends Controller
{
    private $courseCtrl;
    private $user;

    private $userCourseCtrl;

    public function __construct()
    {
        $this->courseCtrl = new courseController();
        $this->user = session('user');
        $this->userCourseCtrl = new userCourseController();
    }


    public function kelas(Request $request)
    {
        $title = 'Kelas';
        $page = $request->input('page', 1); // Default to page 1 if not set
        // Ambil nilai input 'q' dari form
        $query = $request->input('q');
        $free = $request->input('free');

        if ($query) {
            // Fetch courses dengan parameter query
            $courses = $this->courseCtrl->getSearchCourse(urlencode($query));
        } else if ($free) {
            $courses = $this->courseCtrl->getFreeCourse($page);
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
        $ratings = $this->courseCtrl->getCourseRating($courseId);
        $content = $this->courseCtrl->getCourseContentById($courseId);

        $isLogin = 'n';
        $alreadyCourse = 'n';
        if ($this->user != null) {
            $role = $this->user['role'];
            $isLogin = 'y';
            $userCourses = $this->userCourseCtrl->getCoursesUserByCourseId($courseId);

            // dd($userCourses);
            if ($userCourses) {
                $alreadyCourse = 'y';
            }
        } else {
            $role = '';
            $isLogin = 'n';
        }


        return view('detailKelas', [
            "title" => $title,
            'course' => $course,
            'role' => $role,
            'content' => $content,
            'isLogin' => $isLogin,
            'alreadyCourse' => $alreadyCourse,
            'ratings' => $ratings
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
        $ratings = [];
        if ($contentsId) {
            foreach ($contentsId as $row) {
                $contents[] = $this->courseCtrl->getCourseById($row);
                $ratings[] = $this->courseCtrl->getCourseRating($row);
            }
        }


        $isLogin = 'n';
        if ($this->user != null) {
            $role = $this->user['role'];
            $isLogin = 'y';
            // dd($course);
        } else {
            $role = '';
            $isLogin = 'n';
        }


        return view('detailBundling', [
            "title" => $title,
            'bundling' => $bundling,
            'ratings' => $ratings,
            'role' => $role,
            'contents' => $contents, // Pastikan ini adalah array
            'isLogin' => $isLogin
        ]);
    }
}
