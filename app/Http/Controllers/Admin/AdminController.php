<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use App\Models\User;
use App\Models\Order;
use App\Models\Category;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    function viewAdmin(){
        $user_quantity = User::count();
        $category_quantity = Category::count();
        $book_quantity = Book::count();
        $order_quantity = Order::count();
        return view('admin.dashboard', [
            'user_quantity' => $user_quantity,
            'category_quantity' => $category_quantity,
            'book_quantity' => $book_quantity,
            'order_quantity' => $order_quantity
        ]);
    }

    function getRevenueByYear(Request $request){
        $yearCurrent = $request->year;
        $a = [];
        for($i = 1; $i <= 12; $i++){
            $totalOrders = OrderDetail::whereYear('updated_at', $yearCurrent)
                ->whereMonth('updated_at', $i) 
                ->where('status', 4)
                ->sum('current_sale_price');
            $a[] = $totalOrders;
        }
        return response()->json(['arr'=>$a]);
    }

    function getSoldQuantityByYear(Request $request){
        $yearCurrent = $request->year;
        $a = [];
        for($i = 1; $i <= 12; $i++){
            $totalOrders = OrderDetail::whereYear('updated_at', $yearCurrent)
                ->whereMonth('updated_at', $i) 
                ->where('status', 4)
                ->sum('quantity');
            $a[] = $totalOrders;
        }
        return response()->json(['arr'=>$a]);
    }
}
