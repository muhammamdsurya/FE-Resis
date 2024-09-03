<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use PhpParser\Node\Stmt\Else_;

class Navbar extends Component
{
    /**
     * Create a new component instance.
     */
    private $user;
    public function __construct() {
        $this->user = session('user', null);
     }


     public function attribut($text = 'Login', $href = null) {
        // Use the route helper to assign a default value to $href if it's not provided
        if (is_null($href)) {
            $href = route('login');
        }

        return [
            'href' => $href,
            'text' => $text,
        ];
    }


     private function button() {


        if(!$this->user) {
            return $this->attribut();
        } else if ($this->user['role'] == 'user') {
            return $this->attribut('Dashboard', route('user.dashboard'));
        } else if ($this->user['role'] == 'admin') {
            return $this->attribut('Dashboard', route('dashboardAdmin'));
        } else if ($this->user['role'] == 'instructor') {
            return $this->attribut('Dashboard', route('instructor.dashboard'));
        }
     }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $button = $this->button();
        return view('components.navbar', [
            "href" => $button['href'],
            "text" => $button['text'],
            ] );
    }
}
