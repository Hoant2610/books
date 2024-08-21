<?php

namespace App\DTOs\customer;

use App\Models\Address;
use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class BookCheckoutDTO implements \JsonSerializable
{
    private $bookCartDTOs = [];
    private int $totalQuantity;
    private int $totalPrice;
    private User $user;
    private Address $addressDefault;
    public function __construct($bookCartDTOs,$totalQuantity,$totalPrice,$user,$addressDefault) {
        $this->bookCartDTOs = $bookCartDTOs;
        $this->totalQuantity = $totalQuantity;
        $this->totalPrice = $totalPrice;
        $this->user = $user;
        $this->addressDefault = $addressDefault;
    }
    public function getBookCartDTOs(){
        return $this->bookCartDTOs;
    }
    public function getTotalQuantity(){
        return $this->totalQuantity;
    }
    public function getTotalPrice(){
        return $this->totalPrice;
    }
    public function getUser(){
        return $this->user;
    }
    public function getAddressDefault(){
        return $this->addressDefault;
    }
    public function jsonSerialize()
    {
        return [
            'bookCartDTOs' => $this->bookCartDTOs,
            'totalQuantity' => $this->totalQuantity,
            'totalPrice' => $this->totalPrice,
            'user' => $this->user,
            'addressDefault' => $this->addressDefault,
        ];
    }
}