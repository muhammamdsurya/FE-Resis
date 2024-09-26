<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class userCourseController extends Controller
{

    private $user;
    private $apiUrl;


    public function __construct()
    {
        $this->user = session('user');
        $this->apiUrl = env('API_URL');
    }

    function getCoursesUser()  {
        $response = Http::withApiSession()->get($this->apiUrl. 'user/'.$this->user['id'].'/courses');

        return  json_decode($response->getBody()->getContents());
    }


    
}
