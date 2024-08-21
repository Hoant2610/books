<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function viewAccounts(){
        $books = $this->bookService->getPaginateBookDTO(Book::All(),10);
        return view('admin.account')->with("books", $books);
    }
}
