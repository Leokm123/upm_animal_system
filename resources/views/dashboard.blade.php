<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>System Dashboard</title>
    <style>
        body { padding: 20px; font-family: Arial; }
        .container { width: 800px; margin: 0 auto; }
        .role { color: #2196F3; font-weight: bold; }
        .logout { margin-top: 20px; display: inline-block; padding: 8px 16px; background: #f44336; color: white; text-decoration: none; border-radius: 4px; }
        .logout:hover { background: #d32f2f; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to UPM Stray Animal Management System!</h1>
        <p>Current login role: <span class="role">{{ session('user_role') }}</span></p>
        <p>This is your dedicated dashboard, where you can perform operations for your role.</p>
        <!-- Logout link: corresponds to route name logout -->
        <a href="{{ route('logout') }}" class="logout">Click to Logout</a>
    </div>
</body>
</html>