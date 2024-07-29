<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cookie;

class UserController extends Controller
{
    public function login(Request $request){
        try{
            $credentials = $request->only('email', 'password');
            // dd($credentials);
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if($user->role == "customer"){
                return redirect()->route('customer-home');
            }
            if($user->role == "admin"){
                return view('admin.dashboard');
            }

        }
        else{
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        }
        catch(Exception $e){
            return response()->json(['error'=>$e]);
        }
    }

    public function register(Request $request)
    {
        try {
            // Validate data
            $request->validate([
                "name" => "required|min:6",
                "password" => "required|min:6",
                "email" => "required|max:50",
            ]);
            // kiểm tra email đã tồn tại chưa
            $checkuser = User::where("email", $request->email)->first();
            if ($checkuser) {
                return back()->withErrors([
                    'error' => 'Email is already exits!',
                ])->withInput($request->only('error'));
            }
            // tạo user mới
            $user = new User();
            $user->name = trim($request->name);
            $user->email = trim($request->email);
            $user->password = Hash::make(trim($request->password));
            $user->role = "student";
            $user->save();
            Auth::login($user);
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;
            $token->save();
            $access_token = $tokenResult->accessToken;
            
            // Lưu token vào cookie
            $cookie = cookie('access_token_encrypted', Crypt::encrypt($access_token), 1440);
                return redirect()->route('customer-home')->withCookie($cookie);
        } catch (Exception $e) {
            return response()->json(['error' => $e]);
        }
    }

    public function logout(Request $request){
        Cookie::queue(Cookie::forget('access_token'));
        // Cookie::queue(Cookie::forget('name'));
        // Đăng xuất người dùng
        Auth::logout();

        // Xóa session của người dùng (nếu có)
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Chuyển hướng người dùng đến trang đăng nhập (hoặc trang nào đó)
        return redirect('/login');
    }
}
