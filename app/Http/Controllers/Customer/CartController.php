<?php

namespace App\Http\Controllers\Customer;

use App\DTOs\customer\Test;
use Illuminate\Http\Request;
use App\Services\BookService;
use App\Services\CartService;
use App\DTOs\customer\BookDTO;
use App\DTOs\customer\BookCartDTO;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    private BookService $bookService;
    private CartService $cartService;

    public function __construct(BookService $bookService,CartService $cartService)
    {
        $this->bookService = $bookService;
        $this->cartService = $cartService;
    }

    public function showCartView(Request $request)
    {
        $user = Auth::user();
        $bookCartDTO = Session::get('cart');
        return view('customer.cart')->with('bookCartDTO',$bookCartDTO);
    }

    public function addToCart(Request $request)
    {
        $book_id = $request->book_id;
        $quantity = $request->quantity;
        $book = $this->bookService->getBookById($book_id);
        return $this->cartService->addToCart($book,$quantity);
    }
    public function increaseBookCart(Request $request){
        $book_id = $request->book_id;
        $book = $this->bookService->getBookById($book_id);
        return $this->cartService->increaseBookCart($book);
    }
    public function decreaseBookCart(Request $request){
        $book_id = $request->book_id;
        $book = $this->bookService->getBookById($book_id);
        return $this->cartService->decreaseBookCart($book);
    }
}
