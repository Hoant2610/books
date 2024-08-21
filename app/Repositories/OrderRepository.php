<?php

namespace App\Repositories;

use App\Models\Order;
use Exception;

class OrderRepository
{
    public function createOrder($user_id,$voucher_id,$current_address,$phone,$note,$payment,$shipment){
        try{
            return Order::create([
                'user_id'=>$user_id,
                'voucher_id'=>$voucher_id,
                'status'=>1,
                'current_address'=>$current_address,
                'phone'=>$phone,
                'note'=>$note,
                'payment'=>$payment,
                'shipment'=>$shipment
            ]);
        }
        catch(Exception $e){
            throw new Exception('Failed to create Order: ' . $e->getMessage());
        }
    }

    public function getOrdersByUserId($user_id){
        return Order::where('user_id',$user_id)->get();
    }
    public function getOrdersByUserIdAndStatus($user_id,$status){
        return Order::where('user_id',$user_id)
                    ->where('status',$status)        
                    ->get();
    }
}
