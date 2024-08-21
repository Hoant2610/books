<?php

use App\DTOs\customer\Test;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Customer\OrderController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\CustomerController;

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

Route::get('/', [HomeController::class,'viewHome'])->name('index');

Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::middleware(['role:customer'])->group(function () {
        Route::get('/home', [CustomerController::class,"showCustomerHome"])->name('customer-home');
        Route::get('/cart', [CartController::class,"showCartView"])->name('customer-cart');
        Route::get('/buyer/books', [CustomerController::class,"showCustomerBook"])->name('customer-book');
        Route::get('/buyer/books/{slug}', [CustomerController::class,"showCustomerBookDetail"])->name('customer-book-detail');
        Route::post('/cart', [CartController::class,"addToCart"])->name('add-to-cart');
        Route::put('/cart/increase', [CartController::class,"increaseBookCart"])->name('increase-cart');
        Route::put('/cart/decrease', [CartController::class,"decreaseBookCart"])->name('decrease-cart');
        Route::get('/checkout', [CheckoutController::class,"showCheckoutView"])->name('checkout');
        Route::post('/checkout', [CheckoutController::class,"checkout"])->name('checkout');
        Route::post('/order', [OrderController::class,"createOrder"]);
        Route::get('/buyer/orders', [OrderController::class,"showOrdersView"]);
        // Route::get('/buyer/orders', [OrderController::class,"getOrdersByUserIdAndStatus"]);
    });

    Route::prefix('admin')->group(function () {
        Route::middleware(['role:admin'])->group(function () {
            Route::get('/dashboard', function () {
                // $user = Auth::user();
                // $token = $user->createToken('Personal access token')->accessToken;
                // $cookie = cookie('access_token', $token, 60 * 24);
                return view('admin.dashboard');
            })->name('admin-home');
            Route::get('/books', [AccountController::class,"viewAccounts"]);
            Route::get('/books', [BookController::class,"viewBooks"]);
            Route::post('/book', [BookController::class,"createBook"]);
            Route::get('/book/create-book', [BookController::class,"viewCreateBook"]);
            Route::get('/categories', [CategoryController::class,"viewCategories"]);
            Route::post('/category', [CategoryController::class,"addNewCategory"]);
            Route::put('/category', [CategoryController::class,"editCategory"]);
            Route::get('/books/search', [BookController::class,"findBook"])->name('find-book');
            Route::get('/books/{slug}', [BookController::class,"viewDetailBook"])->name('book-detail');
            Route::post('/books/{slug}', [BookController::class,"updateDetailBook"]);
            Route::get('/imgs',[BookController::class,'getImgs']);
            Route::post('/upload-image',[BookController::class,'uploadImage']);
            Route::post('/change-thumbnail',[BookController::class,'changeThumbnail']);
        });
    });
});