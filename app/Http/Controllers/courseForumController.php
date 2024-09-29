<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;


class courseForumController extends Controller
{
       private $apiUrl;

       public function __construct()
       {
           $this->apiUrl = env('API_URL');
       }

       //CourseForum
       public function createCourseForum(Request $request, $courseId)
       {
              $questionTitle = $request->get('questionTitle');
              if (!$questionTitle) {
                     return response()->json([
                            'success' => false,
                            'message' => 'Invalid Title'
                     ], 400);
              }
              $questionContent = $request->get('questionContent');
              if (!$questionContent) {
                     return response()->json([
                            'success' => false,
                            'message' => 'Invalid Message'
                     ], 400);
              }

              $apiSession = session('api_session');

              $headers = [
                     'Content-Type' => 'application/json',
                     'Cookie' => 'session=' . $apiSession
                 ];

              $body= [
                     'question_title'=>$questionTitle,
                     'question_content'=>$questionContent,
              ];

              // Kirimkan request POST
              $response = Http::withHeaders($headers)->post($this->apiUrl. 'courses/'.$courseId.'/forums', $body);
              
              if ($response->successful()) {
                     return response()->json([
                         'success' => true,
                         'message' => 'Berhasil memposting diskusi',
                         'data' => $response->json() // Include the response data
                     ], 200);
                 } else {
                     return response()->json([
                         'success' => false,
                         'message' => $response->body() ,
                         'error' => $response->json() // Include error details if available
                     ], $response->status());
                 }
       }
       public function replyCourseForum(Request $request, $courseId)
       {
              $reply = $request->get('reply');
              if (!$reply) {
                     return response()->json([
                            'success' => false,
                            'message' => 'Invalid Jawaban'
                     ], 400);
              }
              $forumId = $request->get('forumId');
              if (!$forumId) {
                     return response()->json([
                            'success' => false,
                            'message' => 'Invalid forum'
                     ], 400);
              }


              $apiSession = session('api_session');

              $headers = [
                     'Content-Type' => 'application/json',
                     'Cookie' => 'session=' . $apiSession
                 ];

              $body= [
                     'reply'=>$reply
              ];

              // Kirimkan request POST
              $response = Http::withHeaders($headers)->post($this->apiUrl. 'courses/'.$courseId.'/forums/'.$forumId.'/replies', $body);
              
              if ($response->successful()) {
                     return response()->json([
                         'success' => true,
                         'message' => 'Berhasil menjawab diskusi',
                         'data' => $response->json() // Include the response data
                     ], 200);
                 } else {
                     return response()->json([
                         'success' => false,
                         'message' => $response->body() ,
                         'error' => $response->json() // Include error details if available
                     ], $response->status());
                 }
       }
       public function courseForums($courseId) {
              $response = Http::withApiSession()->get($this->apiUrl. 'courses/'.$courseId.'/forums');


              return  json_decode(json_encode($response->json()));
       }
       public function courseForumById($courseId, $id) {}
       public function deleteCourseForumById($courseId, $id) {}
}
