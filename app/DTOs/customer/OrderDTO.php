<?php

namespace App\DTOs\customer;

use App\Models\Order;

class OrderDTO implements \JsonSerializable
{
    private $thumbnail;
    private $name;
    private $category_name;
    private $original_price;
    private $sale_price;
    private $quantity;
    private $status;
    private $created_at;
    private $order_total;
    public function __construct($thumbnail, $name, $category_name, $original_price, $sale_price, $quantity, $status, $created_at, $order_total) {
        $this->thumbnail = $thumbnail;
        $this->name = $name;
        $this->category_name = $category_name;
        $this->original_price = $original_price;
        $this->sale_price = $sale_price;
        $this->quantity = $quantity;
        $this->status = $status;
        $this->created_at = $created_at;
        $this->order_total = $order_total;
    }

    public function jsonSerialize()
    {
        return [
            'thumbnail' => $this->thumbnail,
            'name' => $this->name,
            'category_name' => $this->category_name,
            'original_price' => $this->original_price,
            'sale_price' => $this->sale_price,
            'quantity' => $this->quantity,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'order_total' => $this->order_total,
        ];
    }
}