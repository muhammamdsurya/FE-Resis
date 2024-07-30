<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisController extends Controller
{
    public function show(){
        return view('register');
    }
}
