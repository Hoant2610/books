<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function showCustomerHome(Request $request){
        return view('customer.index');
    }
}
