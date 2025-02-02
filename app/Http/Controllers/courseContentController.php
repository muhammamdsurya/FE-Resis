<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        try {
            // Process upload
            // Extract the form data
            $chunkFile = $request->file('video_content');
            $videoId = $request->get('video_id');
            $chunkIndex = $request->get('chunk_index');
            $totalChunks = $request->get('total_chunks');
            $videoContentThumbFile = $request->file('videoContentThumbFile');

            // Create a log entry
            Log::info('Received video chunk:', [
                'video_id' => $videoId,
                'chunk_index' => $chunkIndex,
                'total_chunks' => $totalChunks,
                'video_content' => [
                    'file_name' => $chunkFile->getClientOriginalName(),
                    'file_size' => $chunkFile->getSize(),
                    'file_path' => $chunkFile->getRealPath(), // Be cautious logging real paths
                ],
                'video_thumbnail' => [
                    'file_name' => $videoContentThumbFile->getClientOriginalName(),
                    'file_size' => $videoContentThumbFile->getSize(),
                    'file_path' => $videoContentThumbFile->getRealPath(), // Be cautious logging real paths
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Error processing upload chunk: ', [
                'chunk_index' => $chunkIndex,
                'message' => $e->getMessage()
            ]);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }

        // Continue processing...

        return response()->json([
            'success' => true,
            'message' => 'Video chunk received successfully',
        ]);
    }



    // public function createCourseContent(Request $request, $courseId)
    // {



    //     $contentTitle = $request->get('contentTitle');
    //     // if (!$contentTitle) return response()->json([
    //     //     'success' => false,
    //     //     'message' => 'invalid content title'
    //     // ], 400);

    //     $contentDesc = $request->get('contentDesc') ?? '';

    //     $contentType = $request->get('contentType');
    //     // if ($contentType != "video" && $contentType != "quiz" && $contentType != "additional_source") {
    //     //     return response()->json([
    //     //         'success' => false,
    //     //         'message' => 'invalid content type'
    //     //     ], 400);
    //     // }


    //     $apiSession = session('api_session');
    //     $headers = [
    //         'Cookie' => 'session=' . $apiSession
    //     ];


    //     $response = Http::withHeaders($headers);


    //     $jsonData = [
    //         'course_id' => $courseId,
    //         'content_title' => $contentTitle,
    //         'content_description' => $contentDesc,
    //         'content_type' => $contentType
    //     ];

    //     if ($contentType == 'video') {

    //         $validator = Validator::make($request->all(), [
    //             'video_content' => 'required|file|mimes:mp4,mov,avi,wmv,flv',
    //             'videoContentThumbFile' => 'required|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //             'videoArticleContent' => 'required|string',
    //             'videoDuration' => 'required|integer',
    //         ]);

    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => $validator->errors()->first(),
    //             ], 400);
    //         }


    //         // Ambil data dari request
    //         $chunkFile = $request->file('video_content');
    //         $videoId = $request->get('video_id');  // Ambil video ID
    //         $chunkIndex = $request->get('chunk_index');  // Ambil chunk index
    //         $totalChunks = $request->get('total_chunks');  // Ambil total chunk

    //         $videoContentThumbFile = $request->file('videoContentThumbFile');
    //         $videoArticleContent = $request->get('videoArticleContent');
    //         $videoDuration = $request->get('videoDuration');



    //         //Merge
    //         if ($chunkIndex == $totalChunks - 1) {
    //             $jsonData = array_merge($jsonData, [
    //                 'video_article_content' => $videoArticleContent,
    //                 'video_duration' => intval($videoDuration),
    //                 'video_thumbnail' => $videoContentThumbFile
    //             ]);
    //         }

    //         $detail = [
    //             'video_id' => $videoId,
    //             'chunk_index' => (int) $chunkIndex,
    //             'total_chunks' => (int) $totalChunks
    //         ];

    //         // Log the attachment details
    //         Log::info('Attachment details:', [
    //             'video_content' => [
    //                 'file_name' => $chunkFile->getClientOriginalName(),
    //                 'file_size' => $chunkFile->getSize(),
    //                 'file_path' => $chunkFile->getRealPath(),
    //             ],
    //             'video_thumbnail' => [
    //                 'file_name' => $videoContentThumbFile->getClientOriginalName(),
    //                 'file_size' => $videoContentThumbFile->getSize(),
    //                 'file_path' => $videoContentThumbFile->getRealPath(),
    //             ],
    //             'video_id' => $videoId,
    //             'chunk_index' => $chunkIndex,
    //             'total_chunks' => $totalChunks,  // Log the chunk index and total chunks
    //             'video_content_form' => $detail // Log the form data
    //         ]);

    //         // $response = $response
    //         //     ->attach('video_content', fopen($chunkFile->getRealPath(), 'r'), $chunkFile->getClientOriginalName())
    //         //     ->attach('video_thumbnail', fopen($videoContentThumbFile->getRealPath(), 'r'), $videoContentThumbFile->getClientOriginalName())
    //         //     ->asMultipart()
    //         //     ->post($this->apiUrl . 'courses/' . $courseId . '/contents', [
    //         //         'video_id' => $videoId,
    //         //         'chunk_index' => (int) $chunkIndex,
    //         //         'total_chunks' => (int) $totalChunks,
    //         //         'course_content_form' => json_encode($jsonData),

    //         //     ]);
    //         // ->attach('video_id', (string) $videoId) // Konversi ke string sebelum attach
    //         // // ->attach('chunk_index', (int) $chunkIndex) // Konversi ke string
    //         // ->attach('total_chunks', (int) $totalChunks) // Konversi ke string
    //         // ->attach('course_content_form', json_encode($jsonData))->post($this->apiUrl . 'courses/' . $courseId . '/contents');
    //         // ->attach('video_content_form', json_encode($jsonData));


    //         return response()->json([
    //             'success' => true,
    //             'message' => $response
    //         ], 200);
    //     } else if ($contentType == 'quiz') {

    //         $quizzes = json_decode($request->get('quizzes'), true);
    //         $jsonData = array_merge($jsonData, [
    //             'quiz' => $quizzes,
    //         ]);
    //     } else if ($contentType == "additional_source") {
    //         $validator = Validator::make($request->all(), [
    //             'additionalSrcFile' => 'required|file|mimes:pdf',
    //         ]);

    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => $validator->errors()->first(),
    //             ], 400);
    //         }


    //         $additionalSrcFile = $request->file('additionalSrcFile');

    //         //Merge
    //         $response->attach('additional_source', fopen($additionalSrcFile->getRealPath(), 'r'), $additionalSrcFile->getClientOriginalName());
    //     } else {
    //         return response()->json([
    //             'success' => false,
    //             'message' => $request
    //         ], 400);
    //     }

    //     // $courseContentForm = json_encode($jsonData);

    //     // $response = $response->attach('course_content_form', $courseContentForm)->post($this->apiUrl . 'courses/' . $courseId . '/contents');

    //     // if ($response->successful()) {
    //     //     return response()->json([
    //     //         'success' => true,
    //     //         'data' => json_decode(json_encode($response->json()))
    //     //     ], $response->status());
    //     // } else {
    //     //     return response()->json([
    //     //         'success' => false,
    //     //         'message' => $response->body(),
    //     //         'error' => $response->json()
    //     //     ], $response->status());
    //     // }
    // }

    // public function updateCourseContent(Request $request, $courseId, $contentId)
    // {

    //     $contentTitle = $request->get('contentTitle');
    //     // $contentDesc = $request->get('contentDesc') ?? '';
    //     // Ambil data dari request
    //     $chunkFile = $request->file('video_content');
    //     $videoId = $request->get('video_id');  // Ambil video ID
    //     $chunkIndex = $request->get('chunk_index');  // Ambil chunk index
    //     $totalChunks = $request->get('total_chunks');  // Ambil total chunk

    //     $videoContentThumbFile = $request->file('videoContentThumbFile');
    //     $videoArticleContent = $request->get('videoArticleContent');
    //     $videoDuration = $request->get('videoDuration');



    // }


    public function updateCourseContent(Request $request, $courseId, $contentId)
    {

        $contentTitle = $request->get('contentTitle');
        if (!$contentTitle) return response()->json([
            'success' => false,
            'message' => 'invalid content title'
        ], 400);

        $contentDesc = $request->get('contentDesc') ?? '';

        $courseContent = $this->courseContentsById($courseId, $contentId);
        if (!isset($courseContent)) {
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



        if ($courseContent->content_type == $videoType) {
            if ($isUpdateContentFile == 'true') {
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

                $bodyVideoUpdateJson = [
                    'article_content' => $videoArticleContent,
                    'video_duration' => intval($videoDuration),
                ];

                $response =  Http::withHeaders($headers)
                    ->attach('video_content', fopen($videoContentFile->getRealPath(), 'r'), $videoContentFile->getClientOriginalName())
                    ->attach('video_thumbnail', fopen($videoContentThumbFile->getRealPath(), 'r'), $videoContentThumbFile->getClientOriginalName())
                    ->attach('video_content_form',  json_encode($bodyVideoUpdateJson))->put($this->apiUrl . 'courses/' . $courseId . '/contents/' . $contentId . '/video');

                if (!$response->successful()) {
                    return response()->json([
                        'success' => false,
                        'message' => $response->body(),
                        'error' => $response->json()
                    ], $response->status());
                }
            }
        } else if ($courseContent->content_type == $addSrcType) {
            if ($isUpdateContentFile == 'true') {
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


                $response =  Http::withHeaders($headers)->attach('additional_source', fopen($additionalSrcFile->getRealPath(), 'r'), $additionalSrcFile->getClientOriginalName())->put($this->apiUrl . 'courses/' . $courseId . '/contents/' . $contentId . '/additional_source');

                if (!$response->successful()) {
                    return response()->json([
                        'success' => false,
                        'message' => $response->body(),
                        'error' => $response->json()
                    ], $response->status());
                }
            }
        } else if ($courseContent->content_type == $quizType) {
            $quizzes = $request->get('quizzes');
            $quizzes = json_decode($request->get('quizzes'), true);
            $passGrade = $quizzes['passing_grade'];
            $quizContent = $quizzes['quizz_content'];
            $jsonQuiz = [
                'passing_grade' => $passGrade,
                'quizz_content' => $quizContent
            ];
            $response = Http::withHeaders($headers)->put($this->apiUrl . 'courses/' . $courseId . '/contents/' . $contentId . '/quiz', $jsonQuiz);
            if (!$response->successful()) {
                return response()->json([
                    'success' => false,
                    'message' => $response->body(),
                    'error' => $response->json()
                ], $response->status());
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Tipe Konten tidak diketahui'
            ], 400);
        }



        $response = Http::withHeaders($headers)->put($this->apiUrl . 'courses/' . $courseId . '/contents/' . $contentId, $jsonData);

        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'data' => json_decode(json_encode($response->json()))
            ], $response->status());
        } else {
            return response()->json([
                'success' => false,
                'message' => $response->body(),
                'error' => $response->json()
            ], $response->status());
        }
    }

    public function courseContents($courseId)
    {
        $response = Http::withApiSession()->get($this->apiUrl . 'courses/' . $courseId . '/contents');

        return  json_decode(json_encode($response->json()));
    }
    public function deleteContent($courseId, $id)
    {
        $response = Http::withApiSession()->delete($this->apiUrl . 'courses/' . $courseId . '/contents/' . $id);

        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'data' => json_decode(json_encode($response->json()))
            ], $response->status());
        } else {
            return response()->json([
                'success' => false,
                'message' => $response->body(),
                'error' => $response->json()
            ], $response->status());
        }
    }
    public function courseContentsById($courseId, $id)
    {
        $response = Http::withApiSession()->get($this->apiUrl . 'courses/' . $courseId . '/contents/' . $id);

        return  json_decode(json_encode($response->json()));
    }
    public function courseContentVideo($courseId, $id)
    {
        $response = Http::withApiSession()->get($this->apiUrl . 'courses/' . $courseId . '/contents/' . $id . '/video');

        return  json_decode(json_encode($response->json()));
    }
    public function courseContentQuiz($courseId, $id)
    {
        $response = Http::withApiSession()->get($this->apiUrl . 'courses/' . $courseId . '/contents/' . $id . '/quiz');

        return  json_decode(json_encode($response->json()));
    }
    public function courseContentSrc($courseId, $id)
    {
        $response = Http::withApiSession()->get($this->apiUrl . 'courses/' . $courseId . '/contents/' . $id . '/additional_source');

        return  json_decode(json_encode($response->json()));
    }
}
