<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
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
    public function updateStatusOrder(Request $request){
        $orderDetail_id = $request->orderDetail_id;
        $status = $request->status;
        $orderDetail = OrderDetail::find($orderDetail_id);
        $orderDetail->status = $status;
        $orderDetail->save();
        return response()->json(['order'=>$orderDetail],200);
    }
}
