<?php

namespace App\Services;

use App\DTOs\customer\BookCartDTO;
use Illuminate\Support\Facades\Auth;

class CartService{
    public function addToCart($book, $quantity){
        $cart = session()->get('cart', []); // Đảm bảo có giá trị mặc định là mảng rỗng
    
        $book_id = $book->id;
        $isBookFound = false;
    
        foreach ($cart as $item) {
            if ($item->getBook()->id == $book_id) {
                if ($quantity + $item->getQuantity() > $item->getBook()->quantity) {
                    return response()->json([
                        'message' => 'The quantity you are trying to add exceeds the maximum purchase limit.'
                    ]);
                }
                $item->setQuantity($quantity + $item->getQuantity());
                $isBookFound = true;
                break; // Đã cập nhật thành công, thoát khỏi vòng lặp
            }
        }
    
        // Nếu sách chưa có trong giỏ hàng, thêm mới
        if (!$isBookFound) {
            if ($quantity > $book->quantity) {
                return response()->json([
                    'message' => 'The quantity you are trying to add exceeds the maximum purchase limit.'
                ]);
            }
            $bookCartDTO = new BookCartDTO($book, $quantity);
            $cart[] = $bookCartDTO;
            $quantityCart = session()->get('quantityCart');
            session()->put('quantityCart', $quantityCart + 1);    
        }
    
        session()->put('cart', $cart);
    
        return response()->json([
            'message' => 'successfully'
        ]);
    }
    
    public function increaseBookCart($book){
        $cart = session()->get('cart');
        foreach($cart as $item){
            if($item->getBook()->id == $book->id){
                if($item->getQuantity() >= $item->getBook()->quantity){
                    return response()->json(['message'=>'You have reached the maximum quantity available for this book']);
                }
                else{
                    $item->setQuantity($item->getQuantity() + 1) ;
                }
            }
        }
        session()->put('cart',$cart);
        return response()->json([
            'message' => 'successfully'
        ]);
    }
    public function decreaseBookCart($book){
        $book_id = $book->id;
        $cart = session()->get('cart', []); // Đảm bảo có giá trị mặc định là mảng rỗng
    
        $cart = array_filter($cart, function($item) use ($book_id) {
            if ($item->getBook()->id == $book_id) {
                if ($item->getQuantity() == 1) {
                    // Nếu số lượng = 1, xóa đối tượng khỏi mảng
                    $quantityCart = session()->get('quantityCart');
                    session()->put('quantityCart', $quantityCart - 1); 
                    return false; // array_filter sẽ loại bỏ đối tượng này
                } else {
                    // Giảm số lượng đối tượng
                    $item->setQuantity($item->getQuantity() - 1);
                }
            }
            // Giữ lại đối tượng khác
            return true;
        });
    
        session()->put('cart', array_values($cart)); // array_values để loại bỏ các chỉ số không liên tiếp
    
        return response()->json([
            'message' => 'successfully'
        ]);
    }
    public function getQuantityBook(){
        $cart = session()->get('cart', []);
        return (string) count($cart);
    }
}