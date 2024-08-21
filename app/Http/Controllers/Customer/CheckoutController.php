<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Services\BookService;
use App\Services\UserService;
use App\DTOs\customer\BookCartDTO;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\DTOs\customer\BookCheckoutDTO;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    private BookService $bookService;
    private UserService $userService;
    public function __construct(BookService $bookService,UserService $userService){
        $this->bookService = $bookService;
        $this->userService = $userService;
    }
    public function showCheckoutView(Request $request)
    {   
        $user = Auth::user();
        $items = session()->get('items');
        if(!$items){
            return view('customer.checkout');
        }
        $bookCartDTOs = []        ;
        $totalQuantity = 0;
        $totalPrice = 0;
        foreach($items as $item){
            $book = $this->bookService->getBookById($item['book_id']);
            $quantity = $item['quantity'];
            $bookCartDTO = new BookCartDTO($book,$quantity);
            $bookCartDTOs[] = $bookCartDTO;
            $totalQuantity += $quantity;
            $totalPrice += $quantity * $book->sale_price;
        }
        $bookCheckoutDTO = new BookCheckoutDTO($bookCartDTOs,$totalQuantity,$totalPrice,$user,$this->userService->getAddressDefault($user->id));
        
        return view('customer.checkout')->with('bookCheckoutDTO',$bookCheckoutDTO);
    }

    public function checkout(Request $request){
        $items = $request->input();
        session()->put('items',$items);
        return response()->json(['message'=>$items]);
    }
}
