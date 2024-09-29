<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class userCourseController extends Controller
{

    private $user;
    private $apiUrl;


    public function __construct()
    {
        $this->user = session('user');
        $this->apiUrl = env('API_URL');
    }

    function getCoursesUser()  {
        $response = Http::withApiSession()->get($this->apiUrl. 'user/'.$this->user['id'].'/courses');

        return  json_decode(json_encode($response->json()));
    }
    function getCoursesUserByCourseId($courseId)  {
        $response = Http::withApiSession()->get($this->apiUrl. 'user/'.$this->user['id'].'/courses/student/'.$courseId);

        return  json_decode(json_encode($response->json()));
    }
    function getCoursesUserContents($studentId)  {
        $response = Http::withApiSession()->get($this->apiUrl. 'user/'.$this->user['id'].'/courses/'.$studentId.'/contents');

        return  json_decode(json_encode($response->json()));
    }

    public function userCourseContentVideo($studentId, $contentId) {
        $response = Http::withApiSession()->get($this->apiUrl. 'user/'.$this->user['id'].'/courses/'.$studentId.'/contents/'.$contentId.'/video');

        return  json_decode(json_encode($response->json()));
    }
    public function userCourseContentSrc($studentId, $contentId) {
        $response = Http::withApiSession()->get($this->apiUrl. 'user/'.$this->user['id'].'/courses/'.$studentId.'/contents/'.$contentId.'/additional_source');

        return  json_decode(json_encode($response->json()));
    }
    public function userCourseContentQuiz($studentId, $contentId) {
        $response = Http::withApiSession()->get($this->apiUrl. 'user/'.$this->user['id'].'/courses/'.$studentId.'/contents/'.$contentId.'/quiz');

        return  json_decode(json_encode($response->json()));
    }

    function markDoneContent($studentId,$contentId)  {
        $response = Http::withApiSession()->post($this->apiUrl. 'user/'.$this->user['id'].'/courses/'.$studentId.'/contents/'.$contentId);

        return  $response->status();
    }


    public function answerQuiz($contentId, Request $request) {
        $answer =$request->get('answers');
        $studentId =$request->get('studentId');

        $response = Http::withApiSession()->post($this->apiUrl. 'user/'.$this->user['id'].'/courses/'.$studentId.'/contents/'.$contentId.'/quiz', [
          'answers' =>   json_decode($answer)
        ]);

           

        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'title' => json_decode(json_encode($response->json()))->passed_status == true ? 'Selamat anda lulus kuis ini': 'Maaf kamu belum lulus kuis ini',
                    'content' => 'Skor yang kamu dapatkan adalah '. json_decode(json_encode($response->json()))->score
                ],
                'dataServer' => json_decode(json_encode($response->json()))
            ], $response->status());
        } else {
            return response()->json([
                'success' => false,
                'message' => $response->body()  ,
                'error' => $response->json() 
            ], $response->status());
        }
    }


    
}
