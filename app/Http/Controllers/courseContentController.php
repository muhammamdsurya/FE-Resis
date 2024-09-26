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

    public function __construct()
    {
        $this->apiUrl = env('API_URL');
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
            'Content-Type'=> 'multipart/form-data',
            'Cookie' => 'session=' . $apiSession
        ];

        

        $jsonData = [
            'course_id' => $courseId,
            'content_title' => $contentTitle,
            'content_description' => $contentDesc,
            'content_type' => $contentType
        ];
        $body =[];

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

            // $jsonData = array_merge($jsonData, [
            //     'video_article_content' => $videoArticleContent,
            //     'video_duration' => intval($videoDuration),
            // ]);
            // $body = array_merge($body, [
            //     'video_content' => $videoContentFile,
            //     'video_thumbnail' => $videoContentThumbFile
            // ]);

           
        } else if($contentType == 'quiz'){

            

        }else if($contentType == "additional_source") {
            
        }else{
            return response()->json([
                'success' => false,
                'message' => 'invalid content type'
            ], 400);
        }

        // $body = array_merge($body, [
        //     'course_content_form' => $jsonData,
        // ]);

        $courseContentForm = json_encode($jsonData);
        
        // $response = Http::asForm()->contentType('multipart/form-data')->withHeaders($headers)->post($this->apiUrl . 'courses/' . $courseId . '/contents', [
            
        //         'course_content_form'=> $courseContentForm,
        //         'type' => 'application/json'
        //     ]);
        $response = Http::withHeaders($headers)->attach(
            'course_content_form', '{}'
        )->post($this->apiUrl . 'courses/' . $courseId . '/contents', [
                'form_params'=> [
                    'course_content_form'=> '{}'

                ]
            ]);

        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'data' => $response->body()
            ], $response->status());
        } else {
            return response()->json([
                'success' => false,
                'message' => $response->body() ,
                'error' => $response->json() 
            ], $response->status());
        }
    }
    public function courseContentList() {}
    public function courseContentById($courseId, $id) {}
    public function updateCourseContentById($courseId, $id) {}
    public function deleteCourseContentById($courseId, $id) {}
    public function courseContentVideo($courseId, $id) {}
    public function updateCourseContentVideo($courseId, $id) {}

    public function courseAdditionalSource($courseId, $id) {}
    public function updateCourseAdditionalSource($courseId, $id) {}
    public function courseQuizz($courseId, $id) {}
    public function updateCourseQuizz($courseId, $id) {}


 
}
