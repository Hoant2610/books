<?php

namespace App\Repositories;

use App\Models\Address;

class UserRepository
{
    public function getAddressDefault($user_id){
        $address = Address::where('user_id', $user_id)
                ->where('default', 1)
                ->first();
        if($address == null){
            return new Address();
        }
        return $address;
    }
}
