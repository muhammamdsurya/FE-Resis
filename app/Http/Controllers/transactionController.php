<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class transactionController extends Controller
{
    private $user;
    private $apiUrl;
    public function __construct()
    {
        $this->user = session('user');
        $this->apiUrl = env('API_URL');
    }

    function checkout(Request $request) {
        $courseId = $request->get('courseId');
              if (!$courseId) {
                     return response()->json([
                            'success' => false,
                            'message' => 'Invalid Course'
                     ], 400);
              }

              $apiSession = session('api_session');

              $headers = [
                     'Content-Type' => 'application/json',
                     'Cookie' => 'session=' . $apiSession
                 ];

                 $body =[
                    'course_id' => $courseId
                 ];

                 $response = Http::withHeaders($headers)->post($this->apiUrl. 'courses/transactions/token', $body);

                 if ($response->successful()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Berhasil membuat  invoice pembayaran',
                        'data' => json_decode($response->getBody()->getContents())
                    ], 200);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Gagal membeli kelas' ,
                        'error' => $response->body() // Include error details if available
                    ], $response->status());
                }
    }


    function helo() {
        // $response = Http::withApiSession()->get(env('API_URL'). 'user/'.$this->user['id'].'/courses');
        $response = Http::withApiSession()->get(env('API_URL'). 'user/'.$this->user['id'].'/courses');
        dd(json_decode($response->body()));
    }
}
