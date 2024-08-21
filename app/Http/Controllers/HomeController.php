<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Services\BookService;

class HomeController extends Controller
{
    private BookService $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function viewHome(){
        return view('home.index');
    }

    public function viewBook(){
        $books = $this->bookService->getPaginateBookDTO(Book::getAll(),10);
        return view('home.book')->with('books',$books);
    }
}
