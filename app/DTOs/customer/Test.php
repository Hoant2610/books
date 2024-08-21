<?php

namespace App\DTOs\customer;

use App\Models\Book;
use Illuminate\Database\Eloquent\Model;

class Test
{
    private int $quantity;
    public function __construct($quantity) {
        $this->quantity = $quantity;
    }
}