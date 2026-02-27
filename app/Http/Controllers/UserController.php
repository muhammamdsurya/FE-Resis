<?php

namespace App\Http\Controllers;

use DateTime;
use stdClass;
use DateTimeZone;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Http;


class UserController extends Controller
{
    private $user;
    private $apiUrl;
    private $transactionCtrl;
    private $userCourseCtrl;
    private $courseForumCtrl;
    private $courseContentCtrl;
    private $courseCtrl;
    public function __construct()
    {
        $this->user = session('user');
        $this->apiUrl = env('API_URL');
        $this->transactionCtrl = new transactionController();
        $this->userCourseCtrl = new userCourseController();
        $this->courseForumCtrl = new courseForumController();
        $this->courseContentCtrl = new courseContentController();
        $this->courseCtrl = new courseController();
    }


    private function getDetailData()
    {
        $id = $this->user['id'];
        $api = $this->apiUrl . 'users/auth/data/' . $id;

        $response = Http::withApiSession()->get($api);

        return $response->json();
    }


    protected function fetchApiData($url)
    {
        $response = Http::withApiSession()->get($url);

        // Check if the response is successful
        if ($response->successful()) {
            return $response->json(); // Decode JSON response into an object
        } else {
            // Log the error with more context
            Log::error('Failed to fetch data from API: ' . $response->status() . ' - ' . $response->body());
        }
    }

    public function completeData()
    {
        return view('user.completeData', [
            "title" => 'Isi Data',
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
        ]);
    }

    private function getProfileData()
    {


        return [
            'id' => $this->user['id'],
            'full_name' => $this->user['full_name'],
            'email' => $this->user['email'],
        ];
    }
    public function dashboard()
    {
        $userCourses = $this->userCourseCtrl->getCoursesUser('active');
        $expired = $this->userCourseCtrl->getCoursesUser('expired');


        return view('user.dashboard', [
            "id" => $this->user['id'],
            'userCourses' => $userCourses,
            'expired' => $expired,
            "full_name" => $this->user['full_name'],
        ]);
    }


    public function formatDateToView($input)
    {
        $date = new DateTime($input, new DateTimeZone('UTC'));
        $date->setTimezone(new DateTimeZone('Asia/Jakarta')); // Ubah ke UTC+7
        return $date->format('Y-m-d'); // Format ke YYYY-MM-DD
    }

    public function profile()
    {
        $profileData = $this->getProfileData();
        $detailData = $this->getDetailData();

        $birth = Carbon::parse($detailData['birth']);
        $wib = $birth->setTimezone('Asia/Jakarta');
        $format = $wib->format('d-m-Y');



        return view('user.profile', [
            "full_name" => $profileData['full_name'],
            "email" => $profileData['email'],
            "birth" => $format,
            "birth_edit" => $this->formatDateToView($detailData['birth']),
            'study_level' => Str::upper($detailData['study_level']), // Mengubah 'study_level' menjadi 'studyLevel'
            "institution" => Str::upper($detailData['institution'])

        ]);
    }

    public function kelas(Request $request)
    {
        $filter = $request->get('filter') ?? 'all';
        $page = $request->get('page') ?? 0;
        $userCourses = $this->userCourseCtrl->getCoursesUserFilter($filter, $page);

        // dd($userCourses);

        return view('user.kelas', [
            "filter" => $filter,
            "userCourses" => $userCourses,
            "page" => $page,
            "filter" => $filter,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
        ]);
    }

    public function transaksi(Request $request)
    {

        $filter = $request->get('filter') ?? 'active';
        $page = $request->get('page') ?? 0;
        $transactions = new stdClass();

        if ($filter != 'active') {
            $transactions = $this->transactionCtrl->getTransactions($page, $filter);
        } else {
            $transactions->data = $this->transactionCtrl->getTransactionsActive() ?? [];
            foreach ($transactions->data as $transaction) {
                $transaction->course = $this->courseCtrl->getCourseById($transaction->course_id)->course;
            }
        }
        // dd($transactions);

        return view('user.transaksi', [
            "filter" => $filter,
            "id" => $this->user['id'],
            'transactions' => $transactions,
            "full_name" => $this->user['full_name'],
        ]);
    }

    public function cvmenu() {

        return view('user.cvmenu', [
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
    public function diskusi(Request $request, $courseId)
    {
        $title = 'Diskusi';

        $userCourse = $this->userCourseCtrl->getCoursesUserByCourseId($courseId);


        $page = $request->get('page') ?? 0;


        $courseForums = $this->courseForumCtrl->courseForums($courseId, $page);
        if (isset($courseForums->data)) {
            foreach ($courseForums->data as $courseForum) {
                $courseForum->course_forum_reply = $this->courseForumCtrl->courseForumsReply($courseId, $courseForum->course_forum_question->id) ?? [];

                $courseForum->reply_count = count($courseForum->course_forum_reply);
            }
        }

        // Lakukan operasi lain yang diperlukan

        return view('user.diskusi', [
            "title" => $title,
            "id" => $this->user['id'],
            "userCourse" => $userCourse,
            "courseId" => $courseId,
            "courseForums" => $courseForums,
            "full_name" => $this->user['full_name'],
        ]);
    }
    public function detailKelas(Request $request, $courseId)
    {

        $course = $this->fetchApiData($this->apiUrl . 'courses/' . $courseId);
        if (isset($course)) {
            $title = json_decode(json_encode($course))->course->name;
        }
        $selectedCourseContentId = $request->get("selectedCourseContentId") ?? '';
        $userCourse = $this->userCourseCtrl->getCoursesUserByCourseId($courseId);
        $userRate = $this->userCourseCtrl->getRate($userCourse->id);
        $courseContents = $this->userCourseCtrl->getCoursesUserContents($userCourse->id);
        if (isset($courseContents)) {
            // MENDAPATKAN DETAILNYA
            $idHigher = null;
            foreach ($courseContents as $index => $content) {
                $content->courseDetail = $this->courseContentCtrl->courseContentsById($courseId, $content->content_id);
                if ($content->is_completed == true) {
                    $idHigher = $content->content_id;
                }
            }
            //DEFAULT ID
            if ($selectedCourseContentId == '') {
                $selectedCourseContentId = $idHigher ?? $courseContents[0]->content_id;
            }
        }

        $courseContent = null;
        $previousCourseContentId = '';
        $nextCourseContentId = '';

        $videoType = 'video';
        $addSrcType = 'additional_source';
        $quizType = 'quiz';



        if ($selectedCourseContentId != '') {
            $courseContent = $this->courseContentCtrl->courseContentsById($courseId, $selectedCourseContentId);

            $courseContent->is_completed = false;

            if (!$courseContent) {
                $selectedCourseContentId = '';
            }


            if ($selectedCourseContentId != '') {
                $selectedIndex = -1; // Use -1 to indicate not found initially
                foreach ($courseContents as $index => $content) {
                    if ($content->content_id === $selectedCourseContentId) {
                        $selectedIndex = $index; // Set the selected index
                        $courseContent->is_completed = $content->is_completed;
                        break;
                    }
                }


                // NEXT PREVIOUS

                $nextCourseContentId = null;
                $previousCourseContentId = null;

                if ($selectedIndex !== -1) { // Ensure we found the selected index
                    // Check for previous and next content
                    if ($selectedIndex > 0) {
                        $previousCourseContentId = $courseContents[$selectedIndex - 1]->content_id;
                    }

                    if ($selectedIndex < count($courseContents) - 1) {
                        $nextCourseContentId = $courseContents[$selectedIndex + 1]->content_id;
                    }
                }

                // LENGKAPI DATA
                if ($courseContent->content_type != $quizType) {
                    $markdone = $this->userCourseCtrl->markDoneContent($userCourse->id, $selectedCourseContentId);
                    if ($markdone == 200) {
                        $courseContent->is_completed = true;
                    }
                }

                if ($courseContent->content_type == $videoType) {
                    $courseContentVideo = $this->userCourseCtrl->userCourseContentVideo($userCourse->id, $selectedCourseContentId);
                    //Merge
                    $courseContent->video = $courseContentVideo;
                } else if ($courseContent->content_type == $addSrcType) {
                    $courseContentSrc = $this->userCourseCtrl->userCourseContentSrc($userCourse->id, $selectedCourseContentId);
                    //Merge
                    $courseContent->src = $courseContentSrc;
                } else if ($courseContent->content_type == $quizType) {
                    $courseContentQuiz = $this->userCourseCtrl->userCourseContentQuiz($userCourse->id, $selectedCourseContentId);
                    $courseContent->quiz = $courseContentQuiz;

                    if ($courseContent->quiz->questions) {
                        foreach ($courseContent->quiz->questions as $index => $question) {
                            $question->index = $index;
                            foreach ($question->Options as $indexOption => $option) {
                                $question->Options[$indexOption] = json_decode(json_encode([
                                    'name' => $option,
                                    'index' => $indexOption
                                ]));
                            }

                            //Harus di random setelah index dicatat
                            shuffle($question->Options);
                        }

                        //Harus di random setelah index dicatat
                        shuffle($courseContent->quiz->questions);

                        $courseContent->quiz->questionTotal =  count($courseContent->quiz->questions);
                    }
                }
            }
        }





        return view('user.detailKelas', [
            "title" => $title,
            "courseId" => $courseId,
            "userRate" => $userRate,
            "selectedCourseContentId" => $selectedCourseContentId,
            "previousCourseContentId" => $previousCourseContentId,
            "nextCourseContentId" => $nextCourseContentId,
            "id" => $this->user['id'],
            "full_name" => $this->user['full_name'],
            "role" => $this->user['role'],
            "course" => json_decode(json_encode($course)), // Encode the categories for JS
            "courseContents" => $courseContents, // Encode the categories for JS
            "courseContent" => $courseContent, // Encode the categories for JS
            "videoType" => $videoType,
            "addSrcType" => $addSrcType,
            "quizType" => $quizType,
            "userCourse" => $userCourse,
        ]);
    }
}
