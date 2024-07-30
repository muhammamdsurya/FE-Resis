<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class adminLayout extends Component
{


    // Constructor untuk menerima data dari view utama
    public function __construct()
    {

    }
    // Render method untuk menampilkan view Blade komponen
    public function render()
    {
    return view('components.adminLayout');
    }
}
