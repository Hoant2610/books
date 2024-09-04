<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'city',
        'district',
        'ward',
        'city_code',
        'district_code',
        'ward_code',
        'detail',
        'default',
    ];
    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function toString(){
        if (empty($this->detail)) {
            return "{$this->city}, {$this->district}, {$this->ward}";
        }
        return "{$this->city}, {$this->district}, {$this->ward} ({$this->detail})";
    }
}
