<?php

namespace App\DTOs\customer;

use App\Models\Book;
use Illuminate\Database\Eloquent\Model;

class BookCartDTO implements \JsonSerializable
{
    private Book $book;
    private int $quantity;
    public function __construct($book,$quantity) {
        $this->book = $book;
        $this->quantity = $quantity;
    }
    public function getBook(){
        return  $this->book;
    }
    public function getQuantity(){
        return  $this->quantity;
    }
    public function setQuantity($quantity){
          $this->quantity  = $quantity;
    }
    public function jsonSerialize()
    {
        return [
            'book' => $this->book,
            'quantity' => $this->quantity
        ];
    }
}