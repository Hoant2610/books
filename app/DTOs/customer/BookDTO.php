<?php

namespace App\DTOs\customer;

use App\Models\Book;

class BookDTO implements \JsonSerializable
{
    private Book $book;
    private int $star;
    private int $sold;
    public function __construct($book) {
        $this->book = $book;
        $this->star = rand(1,5);
        $this->sold = rand(1,500);
    }
    public function getBook(){
        return  $this->book;
    }
    public function getStar(){
        return  $this->star;
    }
    public function getSold(){
        return  $this->sold;
    }
    public function jsonSerialize():mixed
    {
        return [
            'book' => $this->book,
            'star' => $this->star,
            'sold' => $this->sold
        ];
    }
}