<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RegisController extends Controller
{

    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = env('API_URL');
    }

    public function show()
    {
        return view('register');
    }

}
