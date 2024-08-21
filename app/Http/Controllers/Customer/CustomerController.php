<?php

namespace App\Http\Controllers\Customer;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Services\BookService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    private BookService $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }
    public function showCustomerHome(Request $request){
        $user = Auth::user();
        return view('customer.index');
    }
    public function showCustomerBook(Request $request){
        $user = Auth::user();
        $bookDTOs = $this->bookService->getPaginateBookDTO(Book::All(),12);
        return view('customer.book')->with('bookDTOs',$bookDTOs);
    }

    public function showCustomerBookDetail($slug){
        $user = Auth::user();
        $bookDTO = $this->bookService->findBookBySlug($slug);
        return view('customer.book-detail')->with('bookDTO',$bookDTO);
    }

    public function showCustomerBookFindByKey(Request $request){

    }

}
