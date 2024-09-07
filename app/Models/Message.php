<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    protected $fillable = ['conversation_id', 'sender_id', 'message'];
    public $timestamps = true;
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
}

