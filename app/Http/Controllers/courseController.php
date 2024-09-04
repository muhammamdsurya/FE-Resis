<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class courseController extends Controller
{
    private $user;
    private $apiUrl;


    public function __construct()
    {
        $this->user = session('user');
        $this->apiUrl = env('API_URL');
    }
    public function jenjang(Request $request)
    {

        $response = Http::withApiSession()->post($this->apiUrl . 'courses/categories', [
            'name' => $request->name // Include other necessary data here
        ]);


        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'data' => $response->json()
            ], $response->status());
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add category.'
            ], $response->status());
        }
    }

    public function kelas(Request $request)

    {
        $response = Http::withApiSession()->post($this->apiUrl . 'courses', [
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->level,
            'price' => $request->price,
            'purpose'  => $request->purpose,
            'instructor_id' => $request->instrutor_id,
        ]);


        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'data' => $response->json()
            ], $response->status());
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add courses.'
            ], $response->status());
        }
    }

    public function getKelas () {
        $response = Http::withApiSession()->get($this->apiUrl. 'courses');

        if ($response->successful()) {
            return response()->json([
               'success' => true,
                'data' => $response->json()
            ], $response->status());
        } else {
            return response()->json([
               'success' => false,
               'message' => 'Failed to get courses.'
            ], $response->status());
        }
    }

}
