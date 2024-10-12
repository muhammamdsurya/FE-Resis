<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class InstructorController extends Controller
{

    private $user;
    private $apiUrl;
    private $courseForumCtrl;
    private $courseContentCtrl;


    public function __construct()
    {
        $this->user = session('user');
        $this->apiUrl = env('API_URL');
        $this->courseContentCtrl = new courseContentController();
        $this->courseForumCtrl = new courseForumController();
    }


    protected function fetchApiData($url)
    {
        $response = Http::withApiSession()->get($url);

        // Check if the response is successful
        if ($response->successful()) {
            return $response->json();
        } else {
            // Log the error with more context
            Log::error('Failed to fetch data from API: ' . $response->status() . ' - ' . $response->body());
        }
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
            "role" => $profileData['role'],
            "photo_profile" => $profileData['photo_profile'],
            "created_at" => $profileData['created_at'],
            "activated_at" => $profileData['activated_at'],
            "updated_at" => $profileData['updated_at'],
            ]);
    }

    public function kelas (Request $request){
        $title = 'Data Kelas';

        $page = $request->input('page', 1); // Default ke halaman 1 jika tidak ada

        // Ambil nilai input 'q' dari form
        $query = $request->input('q');

        if ($query) {
            // Fetch courses dengan parameter query
            $courses = $this->fetchApiData($this->apiUrl . 'courses/search?q=' . urlencode($query));
        } else {
            // Fetch courses tanpa pencarian
            $courses = $this->fetchApiData($this->apiUrl . 'courses?page=' . $page);
        }


        return view('instructor.kelas', [
            "title" => $title,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
            "courses" => $courses,
            "role" => $this->user['role'],
            "pagination" => $courses['pagination'] ?? null,
            ]);
    }

    public function detailKelas(Request $request,$id) {
        $title = 'Detail Kelas';

        $selectedCourseContentId = $request->get("selectedCourseContentId") ?? '';
        $course = $this->fetchApiData($this->apiUrl . 'courses/' . $id);
        // Initialize course contents, assuming it's fetched properly
        $courseContents = $this->courseContentCtrl->courseContents($id) ?? []; // Fetch course contents safely
        $courseContent = null;
        $previousCourseContentId = '';
        $nextCourseContentId = '';

        $courseContent = null;
        $previousCourseContentId = '';
        $nextCourseContentId = '';

        $videoType = 'video';
        $addSrcType = 'additional_source';
        $quizType= 'quiz';

        if($selectedCourseContentId != ''){
            if ($selectedCourseContentId != '' ) {
                $selectedIndex = -1; // Use -1 to indicate not found initially
                foreach ($courseContents as $index => $content) {
                    if ($content->id === $selectedCourseContentId) {
                        $selectedIndex = $index; // Set the selected index
                        $courseContent = $content; // Assign selected course content
                        break;
                    }
                }


                // NEXT PREVIOUS

                  // Initialize next and previous IDs
            if ($selectedIndex !== -1) { // Ensure we found the selected index
                if ($selectedIndex > 0) {
                    $previousCourseContentId = $courseContents[$selectedIndex - 1]->id;
                }
                if ($selectedIndex < count($courseContents) - 1) {
                    $nextCourseContentId = $courseContents[$selectedIndex + 1]->id;
                }
            }

            if ($courseContent) {
                if ($courseContent->content_type == $videoType) {
                    $courseContentVideo = $this->courseContentCtrl->courseContentVideo($id, $selectedCourseContentId);
                    $courseContent->video = $courseContentVideo;
                } elseif ($courseContent->content_type == $addSrcType) {
                    $courseContentSrc = $this->courseContentCtrl->courseContentSrc($id, $selectedCourseContentId);
                    $courseContent->src = $courseContentSrc;
                } elseif ($courseContent->content_type == $quizType) {
                    $courseContentQuiz = $this->courseContentCtrl->courseContentQuiz($id, $selectedCourseContentId);
                    $courseContent->quiz = $courseContentQuiz;



                }
            }
            }
        }

        // dd($courseContent);answer

        return view('instructor.detailKelas', [
            "title" => $title,
            "courseId" => $id,
            "selectedCourseContentId" => $selectedCourseContentId,
            "previousCourseContentId" => $previousCourseContentId,
            "nextCourseContentId" => $nextCourseContentId,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
            "role" => $this->user['role'],
            "course" => json_decode(json_encode($course)), // Encode the categories for JS
            "courseContents" => $courseContents, // Encode the categories for JS
            "courseContent" => $courseContent, // Encode the categories for JS
            "videoType"=>$videoType,
            "addSrcType"=>$addSrcType,
            "quizType"=>$quizType,
        ]);
    }

    public function diskusi ($courseId){
        $title = 'Diskusi ';

        $courseForums = $this->courseForumCtrl->courseForums($courseId);
        foreach ($courseForums->data as $courseForum){
            $courseForum->course_forum_reply = $this->courseForumCtrl->courseForumsReply($courseId, $courseForum->course_forum_question->id) ?? [];

            $courseForum->reply_count = count($courseForum->course_forum_reply);
        };


        // dd($courseForum);    
        // Lakukan operasi lain yang diperlukan

        return view('instructor.diskusi', [
            "title" => $title,
            "id" => $this->user['id'],
            "courseId" => $courseId,
            "courseForums" => $courseForums,
            "full_name" => $this->user['full_name'],
            ]);
    }


}
