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

    public function updateCourseContent(Request $request, $courseId, $contentId)  {

        $contentTitle = $request->get('contentTitle');
        if (!$contentTitle) return response()->json([
            'success' => false,
            'message' => 'invalid content title'
        ], 400);

        $contentDesc = $request->get('contentDesc') ?? '';

        $courseContent = $this->courseContentsById($courseId, $contentId);
        if(!isset($courseContent)){
            return response()->json([
                'success' => false,
                'message' => 'Course Content tidak ditemukan'
            ], 400);
        }

        $apiSession = session('api_session');
        $headers = [
            'Cookie' => 'session=' . $apiSession
        ];
        
        $jsonData = [
            'content_title' => $contentTitle,
            'content_description' => $contentDesc,
        ];

        $videoType = 'video';
        $addSrcType = 'additional_source';
        $quizType = 'quiz';


        $isUpdateContentFile = $request->get('isUpdateContentFile') ?? false;



        if($courseContent->content_type == $videoType){
            if($isUpdateContentFile == 'true'){
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
                
                $bodyVideoUpdateJson =[
                    'article_content' => $videoArticleContent,
                    'video_duration' => intval( $videoDuration),
                ];

                $response =  Http::withHeaders($headers)->attach('video_content', fopen($videoContentFile->getRealPath(), 'r'), $videoContentFile->getClientOriginalName())->attach('video_thumbnail', fopen($videoContentThumbFile->getRealPath(), 'r'), $videoContentThumbFile->getClientOriginalName())->attach('video_content_form',  json_encode($bodyVideoUpdateJson))->put($this->apiUrl . 'courses/' . $courseId . '/contents/'.$contentId.'/video');

                if (!$response->successful()) {
                    return response()->json([
                        'success' => false,
                        'message' => $response->body()  ,
                        'error' => $response->json() 
                    ], $response->status());
                }
            }
        } else if ($courseContent->content_type == $addSrcType){
            if($isUpdateContentFile == 'true'){
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


                $response =  Http::withHeaders($headers)->attach('additional_source', fopen($additionalSrcFile->getRealPath(), 'r'), $additionalSrcFile->getClientOriginalName())->put($this->apiUrl . 'courses/' . $courseId . '/contents/'.$contentId.'/additional_source');

                if (!$response->successful()) {
                    return response()->json([
                        'success' => false,
                        'message' => $response->body()  ,
                        'error' => $response->json() 
                    ], $response->status());
                }
    
            }
        } else if ($courseContent->content_type == $quizType){
            $quizzes = $request->get('quizzes');     
            $quizzes = json_decode($request->get('quizzes'), true);
            $passGrade = $quizzes['passing_grade'];
            $quizContent = $quizzes['quizz_content'];
            $jsonQuiz = [
                'passing_grade'=>$passGrade,
                'quizz_content' => $quizContent
            ];
            $response = Http::withHeaders($headers)->put($this->apiUrl . 'courses/' . $courseId . '/contents/'.$contentId.'/quiz',$jsonQuiz);
            if (!$response->successful()) {
                return response()->json([
                    'success' => false,
                    'message' => $response->body()  ,
                    'error' => $response->json() 
                ], $response->status());
            }
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Tipe Konten tidak diketahui'
            ], 400);
        }



        $response = Http::withHeaders($headers)->put($this->apiUrl . 'courses/' . $courseId . '/contents/'.$contentId,$jsonData);
        
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

        return  json_decode(json_encode($response->json()));
    }
    public function courseContentQuiz($courseId, $id) {
        $response = Http::withApiSession()->get($this->apiUrl. 'courses/'.$courseId.'/contents/'.$id.'/quiz');

        return  json_decode(json_encode($response->json()));
    }
    public function courseContentSrc($courseId, $id) {
        $response = Http::withApiSession()->get($this->apiUrl. 'courses/'.$courseId.'/contents/'.$id.'/additional_source');

        return  json_decode(json_encode($response->json()));
    }

   


 
}
