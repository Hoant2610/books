<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home.index');
})->name('index');

Route::get('/books', function () {
    return view('home.product');
});

Route::post('/login',[UserController::class,'login'])->name('login');
Route::post('/logout',[UserController::class,'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', function(){
        $user = Auth::user();
        $token = $user->createToken('Personal access token')->accessToken;
        $cookie = cookie('access_token', $token, 60 * 24);
        return response()->view('customer.index',['name'=>$user->name])->withCookie($cookie);
    })->name('customer-home');
});

