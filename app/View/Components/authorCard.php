<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AuthorCard extends Component
{
    public $author;

    /**
     * Create a new component instance.
     *
     * @param mixed $author
     */
    public function __construct($author = null)
    {
        $this->author = $author;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.author-card');
    }
}
