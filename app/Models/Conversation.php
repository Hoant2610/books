<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    public $timestamps = false;
    public function messages()
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'asc');
    }
}

