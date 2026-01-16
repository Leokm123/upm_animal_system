<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>系统仪表盘</title>
    <style>
        body { padding: 20px; font-family: Arial; }
        .container { width: 800px; margin: 0 auto; }
        .role { color: #2196F3; font-weight: bold; }
        .nav-box { margin: 30px 0; padding: 20px; background: #f8f9fa; border-radius: 8px; }
        .nav-box h3 { margin-bottom: 20px; color: #333; }
        .nav-item { display: block; padding: 12px 20px; margin: 10px 0; background: #2196F3; color: white; text-decoration: none; border-radius: 4px; font-size: 16px; }
        .nav-item:hover { background: #1976D2; }
        .logout { margin-top: 20px; display: inline-block; padding: 8px 16px; background: #f44336; color: white; text-decoration: none; border-radius: 4px; }
        .logout:hover { background: #d32f2f; }
    </style>
</head>
<body>
    <div class="container">
        {{-- 基于Session判断登录状态（控制器已校验多Guard） --}}
        @if(session('user_role'))
            <h1>欢迎使用UPM流浪动物管理系统！</h1>
            <p>当前登录角色：<span class="role">{{ session('user_role') }}</span></p>

            {{-- 志愿者专属功能导航 --}}
            @if(session('user_role') == 'volunteer')
            <div class="nav-box">
                <h3>志愿者功能中心</h3>
                <a href="{{ route('sighting.create') }}" class="nav-item">📝 上报动物目击记录</a>
                <a href="{{ route('sighting.index') }}" class="nav-item">📜 查看我的目击记录</a>
                <a href="{{ route('animal.create') }}" class="nav-item">🐾 创建动物电子档案</a>
            </div>
            @endif

            <a href="{{ route('logout') }}" class="logout">🔒 点击登出</a>
        @else
            <p>请先<a href="{{ route('login') }}">登录</a>系统！</p>
        @endif
    </div>
</body>
</html>