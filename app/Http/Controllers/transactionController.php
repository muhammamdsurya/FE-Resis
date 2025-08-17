<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

    function checkout(Request $request)
    {
        $courseId = $request->get('courseId');
        $bundleId = $request->get('bundleId');

        if (!$courseId && !$bundleId) {
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

        if ($courseId) {
            $body = [
                'course_id' => $courseId
            ];
        } else {
            $body = [
                'course_bundle_id' => $bundleId
            ];
        }

        Log::info('Checkout Body', $body);
        Log::info('Checkout Headers', $headers);


        $response = Http::withHeaders($headers)->post($this->apiUrl . 'courses/transactions/token', $body);
        Log::info('Checkout Response', [
    'status' => $response->status(),
    'body'   => $response->body(),
]);


        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil membuat  invoice pembayaran',
                'data' => json_decode($response->getBody()->getContents())
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membeli kelas',
                'error' => $response->body() // Include error details if available
            ], $response->status());
        }
    }

    function getTransactions($page, $status)
    {
        $response = Http::withApiSession()->get($this->apiUrl . 'courses/transactions?status=' . $status . '&page=' . $page);

        return  json_decode($response->getBody()->getContents());
    }
    function getTransactionsActive()
    {
        $response = Http::withApiSession()->get($this->apiUrl . 'courses/transactions/active');

        return  json_decode($response->getBody()->getContents());
    }


    function helo()
    {
        // $response = Http::withApiSession()->get(env('API_URL'). 'user/'.$this->user['id'].'/courses');
        $response = Http::withApiSession()->get(env('API_URL') . 'courses/9fc1f3e6-be61-424e-9c09-414f9a39b4da/forums');
        dd($response->body());
    }
}
