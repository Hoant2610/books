<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    private OrderService $orderService;
    public function __construct(OrderService $orderService){
        $this->orderService = $orderService;
    }
    public function showOrdersView(Request $request){
         if($request->has('status')){
            $status = $request->status;
            return response()->json(['orders'=>$this->orderService->getOrdersByUserIdAndStatus(Auth::user()->id,$status)]);
         }
         else{
            $user = Auth::user();
            $orders = $this->orderService->getOrdersByUser(Auth::user());
            return view('customer.order')->with('email',$user->email)->with('orders',$orders);
         }
    }
    public function createOrder(Request $request){
        $user = Auth::user();
        $address_id = $request->address_id_selected;
        $voucher_id = null;
        $shipment = $request->shipment;
        $payment = $request->payment;
        $phone = $request->phone;
        $note = $request->note;
        $items = session()->get('items');
        if(!$items){
            return response()->json(['error'=>'No products to pay for']);
        }
        return $this->orderService->createOrder($user,$address_id,$voucher_id,$shipment,$payment,$phone,$note,$items);
    }

    public function getOrdersByUserIdAndStatus(Request $request){
        $status = $request->status;
        return $this->orderService->getOrdersByUserIdAndStatus(Auth::user()->id,$status);
    }
}
