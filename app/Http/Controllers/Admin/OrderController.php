<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private OrderService $orderService;
    public function __construct(OrderService $orderService){
        $this->orderService = $orderService;
    }
    public function showOrderView(){
        $orderDetails = $this->orderService->getAllOrderDetail();
        return view('admin.order')->with('orderDetails',$orderDetails);
        // return response()->json(['data'=>$orderDetails]);
    }
}
