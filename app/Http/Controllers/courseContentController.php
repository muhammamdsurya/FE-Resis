<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;


class courseContentController extends Controller
{
    //CourseContent

    public function createCourseContent(Request $request, $courseId)
    {
        $contentTitle = $request->get('contentTitle');
        if (!$contentTitle) return;
        $contentDesc = $request->get('contentDesc') ?? '';
        $contentType = $request->get('contentType');
        if ($contentType != "video" || $contentType != "quiz" || $contentType != "additional_source") {
            return response()->json([
                'success' => false,
                'message' => 'invalid content type'
            ], 400);
        }
        

        $body = [];
        if($contentType == 'video'){
            $videoContentFile = $request->file('videoContentFile');
            $videoArticleContent = $request->get('videoArticleContent');
            $videoDuration = $request->get('videoDuration');

            $body = [
                'course_id' => $courseId,
                'content_title' => $contentTitle,
                'content_description' => $contentDesc,
                'video_article_content' => $videoArticleContent,
                'video_duration' => $videoDuration,
            ];
        } else if($contentType == 'quiz'){

        }else if($contentType == "additional_source") {
            
        }else{
            return response()->json([
                'success' => false,
                'message' => 'invalid content type'
            ], 400);
        }
        
        $response = Http::withApiSession()->attach("file  here....")->post($this->apiUrl . 'courses/' . $courseId . '/contents',$body);


        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'data' => $response->json()
            ], $response->status());
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create courses content.'
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
