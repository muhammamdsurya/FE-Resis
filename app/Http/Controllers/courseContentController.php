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



    // public function createCourseContent(Request $request, $courseId)
    // {
    //     try {
    //         // Ambil file dan data lainnya dari request
    //         $chunkFile = $request->file('video_content');
    //         $videoId = $request->get('video_id');
    //         $chunkIndex = $request->get('chunk_index');
    //         $totalChunks = $request->get('total_chunks');
    //         $videoContentThumbFile = $request->file('videoContentThumbFile');

    //         // Pastikan file chunk tidak null sebelum mengaksesnya
    //         if (!$chunkFile) {
    //             throw new \Exception('File chunk tidak ditemukan dalam request.');
    //         }

    //         // Pastikan file thumbnail juga tidak null (jika memang dikirim)
    //         if ($chunkIndex == $totalChunks - 1 && !$videoContentThumbFile) {
    //             throw new \Exception('File thumbnail tidak ditemukan dalam request.');
    //         }

    //         // // Log informasi untuk debugging
    //         // Log::info('Received video chunk:', [
    //         //     'video_id' => $videoId,
    //         //     'chunk_index' => $chunkIndex,
    //         //     'total_chunks' => $totalChunks,
    //         //     'video_content' => [
    //         //         'file_name' => $chunkFile->getClientOriginalName(),
    //         //         'file_size' => $chunkFile->getSize(),
    //         //         'file_path' => $chunkFile->getRealPath(),
    //         //     ],
    //         //     'video_thumbnail' => $videoContentThumbFile ? [
    //         //         'file_name' => $videoContentThumbFile->getClientOriginalName(),
    //         //         'file_size' => $videoContentThumbFile->getSize(),
    //         //         'file_path' => $videoContentThumbFile->getRealPath(),
    //         //     ] : null,
    //         // ]);
    //     } catch (\Exception $e) {
    //         Log::error('Error processing upload chunk: ', [
    //             'chunk_index' => $chunkIndex,
    //             'message' => $e->getMessage()
    //         ]);
    //         return response()->json(['error' => 'Gagal upload chunk'], 500);
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Video chunk received successfully',
    //     ]);
    // }


    public function createCourseContent(Request $request, $courseId)
    {
        Log::info('Request Data:', $request->except('video_content'));
        Log::info('File Uploaded:', [
            'video_content' => $request->hasFile('video_content') ? 'Yes' : 'No',
            'file_name' => $request->file('video_content') ? $request->file('video_content')->getClientOriginalName() : null,
        ]);
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

        if ($contentType == 'video') {

            $validator = Validator::make($request->all(), [
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


            try {

                // Ambil file dan data lainnya dari request
                $chunkFile = $request->file('video_content');
                $videoId = $request->get('video_id');
                $chunkIndex = $request->get('chunk_index');
                $totalChunks = $request->get('total_chunks');
                $videoContentThumbFile = $request->file('videoContentThumbFile');

                $videoContentThumbFile = $request->file('videoContentThumbFile');
                $videoArticleContent = $request->get('videoArticleContent');
                $videoDuration = $request->get('videoDuration');

                // Pastikan file chunk tidak null sebelum mengaksesnya
                if (!$chunkFile) {
                    throw new \Exception('File chunk tidak ditemukan dalam request.');
                }

                // Pastikan file thumbnail juga tidak null (jika memang dikirim)
                if ($chunkIndex == $totalChunks - 1 && !$videoContentThumbFile) {
                    throw new \Exception('File thumbnail tidak ditemukan dalam request.');
                }

                if (intval($chunkIndex) === ($totalChunks - 1)) {
                    // Pastikan jsonData sudah diinisialisasi sebagai array
                    if (!is_array($jsonData)) {
                        $jsonData = [];
                    }

                    // Pastikan semua variabel tidak NULL
                    $jsonData = array_merge($jsonData, [
                        'video_article_content' => $videoArticleContent ?? '',
                        'video_duration' => isset($videoDuration) ? intval($videoDuration) : 0,
                        'video_thumbnail' => $videoContentThumbFile ?? ''
                    ]);
                }

                // Log hasil merging untuk debugging
                // Log::info('Merged jsonData:', $jsonData);
                $response = $response
                    ->attach('video_content', fopen($chunkFile->getRealPath(), 'r'), $chunkFile->getClientOriginalName())
                    ->attach('video_thumbnail', fopen($videoContentThumbFile->getRealPath(), 'r'), $videoContentThumbFile->getClientOriginalName())
                    ->asMultipart()
                    ->post($this->apiUrl . 'courses/' . $courseId . '/contents', [
                        'video_id' => $videoId,
                        'chunk_index' => (int) $chunkIndex,
                        'total_chunks' => (int) $totalChunks,
                        'course_content_form' => json_encode($jsonData),

                    ]);

                if ($response->successful()) {
                    return response()->json([
                        'success' => true,
                        'data' => json_decode(json_encode($response->json()))
                    ], 200);
                } else {
                    return response()->json(['message' => $response->body()], 500);
                }
            } catch (\Exception $e) {
                Log::error('Error processing upload chunk: ', [
                    'chunk_index' => $chunkIndex,
                    'message' => $e->getMessage()
                ]);
                return response()->json(['message' => $e->getMessage()], 500);
            }
        } else if ($contentType == 'quiz') {

            $quizzes = json_decode($request->get('quizzes'), true);
            $jsonData = array_merge($jsonData, [
                'quiz' => $quizzes,
            ]);
        } else if ($contentType == "additional_source") {
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
        } else {
            return response()->json([
                'success' => false,
                'message' => $request
            ], 400);
        }

        $courseContentForm = json_encode($jsonData);

        $response = $response->attach('course_content_form', $courseContentForm)->post($this->apiUrl . 'courses/' . $courseId . '/contents');

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

    public function updateCourseContent(Request $request, $courseId, $contentId)
    {
        Log::info('Request Data:', $request->except('video_content'));
        Log::info('File Uploaded:', [
            'video_content' => $request->hasFile('video_content') ? 'Yes' : 'No',
            'file_name' => $request->file('video_content') ? $request->file('video_content')->getClientOriginalName() : null,
        ]);
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

        $response = Http::withHeaders($headers);

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
                    'videoArticleContent' => 'required|string',
                    'videoDuration' => 'required|integer',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'success' => false,
                        'message' => $validator->errors()->first(),
                    ], 400);
                }

                try {
                    // Ambil file dan data lainnya dari request
                    $chunkFile = $request->file('video_content');
                    $videoId = $request->get('video_id');
                    $chunkIndex = $request->get('chunk_index');
                    $totalChunks = $request->get('total_chunks');

                    $videoContentThumbFile = $request->file('videoContentThumbFile');
                    $videoArticleContent = $request->get('videoArticleContent');
                    $videoDuration = $request->get('videoDuration');


                    // Pastikan file chunk tidak null sebelum mengaksesnya
                    if (!$chunkFile) {
                        throw new \Exception('File chunk tidak ditemukan dalam request.');
                    }

                    // Pastikan file thumbnail juga tidak null (jika memang dikirim)
                    if ($chunkIndex == $totalChunks - 1 && !$videoContentThumbFile) {
                        throw new \Exception('File thumbnail tidak ditemukan dalam request.');
                    }

                    $bodyVideo = [
                        'article_content' => $videoArticleContent,
                        'video_duration' => intval($videoDuration),
                    ];

                    $response =  Http::withHeaders($headers)
                        ->attach('video_content', fopen($chunkFile->getRealPath(), 'r'), $chunkFile->getClientOriginalName())
                        ->attach('video_thumbnail', fopen($videoContentThumbFile->getRealPath(), 'r'), $videoContentThumbFile->getClientOriginalName())
                        ->asMultipart()
                        ->put($this->apiUrl . 'courses/' . $courseId . '/contents/' . $contentId . '/video', [
                            'video_id' => $videoId,
                            'chunk_index' => (int) $chunkIndex,
                            'total_chunks' => (int) $totalChunks,
                            'video_content_form' => json_encode($bodyVideo),

                        ]);

                    // if ($response->successful()) {
                    //     return response()->json([
                    //         'success' => true,
                    //         'message' => 'Video berhasil diubah!'
                    //     ], 200);
                    // } else {
                    //     return response()->json(['message' => 'Upload gagal, coba lagi!'], 500);
                    // }
                } catch (\Exception $e) {
                    Log::error('Error processing upload chunk: ', [
                        'chunk_index' => $chunkIndex,
                        'message' => $e->getMessage()
                    ]);
                    return response()->json(['error' => 'Gagal upload chunk'], 500);
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
