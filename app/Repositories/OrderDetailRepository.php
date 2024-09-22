<?php

namespace App\Repositories;

use App\Models\OrderDetail;
use Exception;

class OrderDetailRepository
{
    public function createOrderDetail($book_id,$order_id,$quantity,$current_original_price,$current_sale_price){
        try{
            return OrderDetail::create([
                'book_id'=>$book_id,
                'order_id'=>$order_id,
                'quantity'=>$quantity,
                'current_original_price'=>$current_original_price,
                'current_sale_price'=>$current_sale_price,
                'status' => '1'
            ]);
        }
        catch(Exception $e){
            throw new Exception('Failed to create OrderDetail: ' . $e->getMessage());
        }
    }
    public function getAllOrderDetail(){
        return OrderDetail::paginate(10);
    }
}
