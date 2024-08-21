<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'original_price',
        'sale_price',
        'image',
        'description',
        'status',
        'thumbnail',
        'quantity',
        'author',
        'publish',
    ];

    public function product()
    {
        return $this->belongsTo(Book::class);
    }
}
