<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
    ];

    public function Review()
    {
        return $this->belongsTo(Review::class);
    }
}
