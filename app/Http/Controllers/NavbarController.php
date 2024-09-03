<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NavbarController extends Controller
{
    private $user;
    public function __construct() {
        $this->user = session('user', null);
     }
}
