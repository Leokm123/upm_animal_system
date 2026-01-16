<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\Manager;
use App\Models\Volunteer;
use App\Models\UPMUser;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * 检查任意Guard是否有用户登录（兼容web/manager/volunteer）
     */
    protected function isAnyGuardLoggedIn(): bool
    {
        foreach (['web', 'manager', 'volunteer'] as $guard) {
            if (Auth::guard($guard)->check()) {
                return true;
            }
        }
        return false;
    }

    /**
     * 获取当前登录用户（兼容多Guard）
     */
    protected function getLoggedInUser()
    {
        foreach (['web', 'manager', 'volunteer'] as $guard) {
            if (Auth::guard($guard)->check()) {
                return Auth::guard($guard)->user();
            }
        }
        return null;
    }

    /**
     * 获取当前登录用户的角色（复用AuthController逻辑）
     */
    protected function getUserRole($user): string
    {
        if ($user instanceof Manager) return 'manager';
        if ($user instanceof Volunteer) return 'volunteer';
        if ($user instanceof UPMUser) return 'upm_user';
        return '';
    }
}