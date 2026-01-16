<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class AuthenticateAnyGuard
{
    /**
     * 处理多 Guard 认证逻辑
     */
    public function handle($request, Closure $next, ...$guards)
    {
        // 未指定 Guard 时，默认校验 web/manager/volunteer
        $guards = empty($guards) ? ['web', 'manager', 'volunteer'] : $guards;

        foreach ($guards as $guard) {
            // 校验当前 Guard 是否已登录
            if (Auth::guard($guard)->check()) {
                // 将当前请求的默认 Guard 设为已认证的 Guard
                Auth::shouldUse($guard);
                return $next($request);
            }
        }

        // 所有 Guard 均未认证，抛出异常（跳登录页）
        throw new AuthenticationException('Unauthenticated.', $guards);
    }
}