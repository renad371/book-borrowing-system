<?php

namespace App\View\Components;

use Illuminate\View\Component;

class BookCard extends Component
{
    public $book;
    public $showActions;

    /**
     * Create a new component instance.
     *
     * @param array|object $book
     * @param bool $showActions
     * @return void
     */
    public function __construct($book, $showActions = false)
    {
        $this->book = (array)$book; // تأكد من تحويل البيانات إلى array
        $this->showActions = $showActions;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.book-card');
    }
}