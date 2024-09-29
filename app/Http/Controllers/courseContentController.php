<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;


class courseContentController extends Controller
{
    //CourseContent
    private $apiUrl;
    private $user;

    public function __construct()
    {
        $this->apiUrl = env('API_URL');
        $this->user = session('user');
    }

    public function createCourseContent(Request $request, $courseId)
    {

        $contentTitle = $request->get('contentTitle');
        if (!$contentTitle) return response()->json([
            'success' => false,
            'message' => 'invalid content title'
        ], 400);

        $contentDesc = $request->get('contentDesc') ?? '';

        $contentType = $request->get('contentType');
        if ($contentType != "video" && $contentType != "quiz" && $contentType != "additional_source") {
            return response()->json([
                'success' => false,
                'message' => 'invalid content type'
            ], 400);
        }


        $apiSession = session('api_session');
        $headers = [
            // 'Content-Type'=> 'application/x-www-form-urlencoded',
            'Cookie' => 'session=' . $apiSession
        ];


        $response = Http::withHeaders($headers);
        

        $jsonData = [
            'course_id' => $courseId,
            'content_title' => $contentTitle,
            'content_description' => $contentDesc,
            'content_type' => $contentType
        ];

        if($contentType == 'video'){

            $validator = Validator::make($request->all(), [
                'videoContentFile' => 'required|file|mimes:mp4,mov,avi,wmv,flv', 
                'videoContentThumbFile' => 'required|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'videoArticleContent' => 'required|string',
                'videoDuration' => 'required|integer',
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ], 400);
            }
    

            $videoContentFile = $request->file('videoContentFile');
            $videoContentThumbFile = $request->file('videoContentThumbFile');
            $videoArticleContent = $request->get('videoArticleContent');
            $videoDuration = $request->get('videoDuration');


            //Merge 

            $jsonData = array_merge($jsonData, [
                'video_article_content' => $videoArticleContent,
                'video_duration' => intval($videoDuration),
            ]);

            $response->attach('video_content', fopen($videoContentFile->getRealPath(), 'r'), $videoContentFile->getClientOriginalName())->attach('video_thumbnail', fopen($videoContentThumbFile->getRealPath(), 'r'), $videoContentThumbFile->getClientOriginalName());

           
        } else if($contentType == 'quiz'){

            $quizzes = json_decode($request->get('quizzes'), true); 
            $jsonData = array_merge($jsonData, [
                'quiz' => $quizzes,
            ]);

        }else if($contentType == "additional_source") {
            $validator = Validator::make($request->all(), [
                'additionalSrcFile' => 'required|file|mimes:pdf', 
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ], 400);
            }
    

            $additionalSrcFile = $request->file('additionalSrcFile');


            //Merge
            $response->attach('additional_source', fopen($additionalSrcFile->getRealPath(), 'r'), $additionalSrcFile->getClientOriginalName());
            
        }else{
            return response()->json([
                'success' => false,
                'message' => 'invalid content type'
            ], 400);
        }

        $courseContentForm = json_encode($jsonData);
        

        $response = $response->attach('course_content_form', $courseContentForm) ->post($this->apiUrl . 'courses/' . $courseId . '/contents');

        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'data' => json_decode(json_encode($response->json()))
            ], $response->status());
        } else {
            return response()->json([
                'success' => false,
                'message' => $response->body()  ,
                'error' => $response->json() 
            ], $response->status());
        }
    }
    public function courseContents($courseId) {
        $response = Http::withApiSession()->get($this->apiUrl. 'courses/'.$courseId.'/contents');

        return  json_decode(json_encode($response->json()));
    }
    public function deleteContent($courseId, $id) {
        $response = Http::withApiSession()->delete($this->apiUrl. 'courses/'.$courseId.'/contents/'.$id);

        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'data' => json_decode(json_encode($response->json()))
            ], $response->status());
        } else {
            return response()->json([
                'success' => false,
                'message' => $response->body()  ,
                'error' => $response->json() 
            ], $response->status());
        }
    }
    public function courseContentsById($courseId, $id) {
        $response = Http::withApiSession()->get($this->apiUrl. 'courses/'.$courseId.'/contents/'.$id);

        return  json_decode(json_encode($response->json()));
    }
    public function courseContentVideo($courseId, $id) {
        $response = Http::withApiSession()->get($this->apiUrl. 'courses/'.$courseId.'/contents/'.$id.'/video');

        return $response->body();
    }
    public function courseContentQuiz($courseId, $id) {
        $response = Http::withApiSession()->get($this->apiUrl. 'courses/'.$courseId.'/contents/'.$id.'/quiz');

        return  json_decode(json_encode($response->json()));
    }
    public function courseContentSrc($courseId, $id) {
        $response = Http::withApiSession()->get($this->apiUrl. 'courses/'.$courseId.'/contents/'.$id.'/additional_source');

        return $response->body();
    }

    public function answerQuiz($contentId, Request $request) {
        $answer =$request->get('answers');

        $response = Http::withApiSession()->delete($this->apiUrl. 'user/'.$this->user['id'].'/courses/'.$id.'/contents/'.$contentId.'/quiz');

           

        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'data' =>$answer,
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
