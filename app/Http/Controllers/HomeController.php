<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * 系统仪表盘（兼容多Guard登录）
     */
    public function dashboard()
    {
        // 1. 检查多Guard登录状态
        if (!$this->isAnyGuardLoggedIn()) {
            return redirect()->route('login')->withErrors('请先登录！');
        }
        // 2. 获取当前登录用户并赋值角色到Session
        $user = $this->getLoggedInUser();
        session(['user_role' => $this->getUserRole($user)]);
        
        return view('dashboard');
    }
}