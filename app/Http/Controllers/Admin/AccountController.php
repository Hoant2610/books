<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function viewAccounts(){
        $accounts = User::where('role','customer')->paginate(10);
        return view('admin.account')->with("accounts", $accounts);
    }
    public function viewAccountDetail($user_id,Request $request){
        $account = User::where('id',$user_id)->first();
        return view('admin.account-detail')->with("account", $account);
    }
}
