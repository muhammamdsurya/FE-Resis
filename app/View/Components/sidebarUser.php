<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Session;

class sidebarUser extends Component
{
    /**
     * Create a new component instance.
     */
    public $name;
    public function __construct($name)
    {
        $user = Session::get('user');
        $this->name = $user['full_name'];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebarUser');
    }
}
