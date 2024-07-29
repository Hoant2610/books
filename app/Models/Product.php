<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
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

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function order_details()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
