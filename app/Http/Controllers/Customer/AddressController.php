<?php

namespace App\Http\Controllers\Customer;

use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AddressController extends Controller
{   
    public function getAllAddress(Request $request){
        $user_id = $request->user_id;
        $addresses = Address::where('user_id', $user_id)->get();
        return response()->json(['addresses' => $addresses]);
    }
    public function addNewAddress(Request $request){
        $user_id = $request->user_id;
        $city = $request->city;
        $district = $request->district;
        $ward = $request->ward;
        $city_code = $request->city_code;
        $district_code = $request->district_code;
        $ward_code = $request->ward_code;
        $detail = $request->detail;
        $default = 0;
        $addresses = Address::where('user_id', $user_id)->get();
        if ($addresses->isEmpty()){
            $default = 1;
        }
        $newAddress = Address::create([
            'user_id' => $user_id,
            'city' => $city,
            'district' => $district,
            'ward' => $ward,
            'city_code' => $city_code,
            'district_code' => $district_code,
            'ward_code' => $ward_code,
            'detail' => $detail,
            'default' => $default
        ]);
        return response()->json(['newAddress' => Address::where('user_id', $user_id)->get()], 200);
    }
    public function getAddressById(Request $request){
        return response()->json(['address' => Address::where('id', $request->address_id)->where('user_id', $request->user_id)->first()], 200);
    }
    public function editAddress(Request $request){
        $user_id = $request->user_id;
        $address_id = $request->address_id;
        $city = $request->city;
        $district = $request->district;
        $ward = $request->ward;
        $city_code = $request->city_code;
        $district_code = $request->district_code;
        $ward_code = $request->ward_code;
        $detail = $request->detail;
        $default = $request->default;
        $address = Address::where('id', $address_id)->where('user_id', $user_id)->first();
        if($default = 1){
            Address::where('user_id', $user_id)
            ->update([
                'default' => 0
            ]);
        }
        if ($address) {
            $address->city = $city;
            $address->district = $district;
            $address->ward = $ward;
            $address->city_code = $city_code;
            $address->district_code = $district_code;
            $address->ward_code = $ward_code;
            $address->detail = $detail;
            $address->default = $default;
            $address->save();
            return response()->json(['newAddress' => Address::where('user_id', $user_id)->get()], 200);
        } else {
            return response()->json(['error' => 'Address not found or does not belong to the user'], 404);
        }
    }
    public function deleteAddress(Request $request){
        $user_id = $request->user_id;
        $address_id = $request->address_id;
        $address = Address::where('id', $address_id)->where('user_id', $user_id)->first();
        $address->delete();
        return response()->json(['addresses' => Address::where('user_id', $user_id)->get()], 200);
    }
}
