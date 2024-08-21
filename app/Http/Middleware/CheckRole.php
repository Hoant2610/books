<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,...$roles): Response
    {
                // Kiểm tra xem người dùng đăng nhập chưa
                if (!Auth::check()) {
                    return redirect('/');
                }
                $user = Auth::user();
                // Kiểm tra xem người dùng có vai trò được chỉ định hay không
                if (in_array($user->role, $roles)) {
                    return $next($request);
                }
                // Nếu không có quyền, bạn có thể redirect hoặc trả về lỗi 403
                return abort(403, 'Unauthorized.');
    }
}
