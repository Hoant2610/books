<?php

namespace App\Http\Controllers\Customer;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function showViewProfile(){
        $user = Auth::user();
        return view('customer.account')->with('user',$user);
    }
    public function updateAccount(Request $request){
        $user_id = $request->user_id;
        $phone = $request->phone;
        $name = $request->name;
        $user = User::find($user_id);
        $user->name = $name;
        $user->phone = $phone;
        $user->save();
        return response()->json(['user' => $user], 200);
    }
    public function changePassword(Request $request){
        $user_id = $request->user_id;
        $oldPass = $request->oldPass;
        $newPass = $request->newPass;
        $user = User::find($user_id);
        if ($user && Hash::check($oldPass, $user->password)) {
            $user->password = Hash::make($newPass);
            $user->save;
            return response()->json(['user' => $user], 200);
        } else {
            // Mật khẩu sai
            return response()->json(['message' => 'Invalid password'], 401);
        }
    }
}
