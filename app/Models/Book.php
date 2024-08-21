<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;
    use Sluggable, SluggableScopeHelpers;
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
        'category_id', 
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function images()
    {
        return $this->hasMany(BookImage::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function order_details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
                'onUpdate' => true, // Tạo slug mới khi cập nhật
            ]
        ];
    }
}
