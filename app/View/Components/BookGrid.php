<?php

namespace App\View\Components;

use Illuminate\View\Component;

class BookGrid extends Component
{
    public $books;

    public function __construct($books)
    {
        $this->books = $books;
    }

    public function render()
    {
        return view('components.book-grid');
    }
}
 