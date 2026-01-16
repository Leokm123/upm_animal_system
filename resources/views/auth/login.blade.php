<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>UPM Stray Animal System - Login</title>
    <!-- Simple styling to ensure clear interface -->
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f5f5f5; font-family: Arial; }
        .login-box { width: 400px; margin: 100px auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px #eee; }
        .login-box h2 { text-align: center; margin-bottom: 20px; color: #333; }
        .error { color: red; text-align: center; margin-bottom: 15px; padding: 10px; background: #ffebee; border-radius: 4px; }
        .form-item { margin-bottom: 20px; }
        .form-item label { display: block; margin-bottom: 5px; color: #666; }
        .form-item input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 16px; }
        .login-btn { width: 100%; padding: 12px; background: #2196F3; color: white; border: none; border-radius: 4px; font-size: 16px; cursor: pointer; }
        .login-btn:hover { background: #1976D2; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>System Login</h2>
        
        <!-- Display login error message (e.g., incorrect username/password) -->
        @if($errors->has('login'))
            <div class="error">{{ $errors->first('login') }}</div>
        @endif

        <!-- Display logout success message -->
        @if(session('message'))
            <div style="color: green; text-align: center; margin-bottom: 15px;">{{ session('message') }}</div>
        @endif

        <!-- Login form: method must be POST, action corresponds to route name -->
        <form method="POST" action="{{ route('login.submit') }}">
            <!-- [Required] CSRF token: Laravel will block POST requests without this -->
            @csrf

            <!-- Username input: old('username') echoes previously entered content -->
            <div class="form-item">
                <label>Username</label>
                <input type="text" name="username" value="{{ old('username') }}" placeholder="Please enter username" required>
            </div>

            <!-- Password input -->
            <div class="form-item">
                <label>Password</label>
                <input type="password" name="password" placeholder="Please enter password" required>
            </div>

            <!-- Login button -->
            <button type="submit" class="login-btn">Login</button>
        </form>
    </div>
</body>
</html>