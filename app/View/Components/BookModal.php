<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Book;

class BookModal extends Component
{
    public $book;

    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    public function render()
    {
        return view('components.book-modal');
    }
}

