<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>UPM User Dashboard</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        .container { width: 1200px; margin: 50px auto; display: flex; gap: 30px; }
        .sidebar { width: 220px; border-right: 1px solid #e0e0e0; padding-right: 20px; }
        .sidebar h3 { margin-bottom: 20px; color: #333; }
        .sidebar a { display: block; margin: 12px 0; color: #0066cc; text-decoration: none; padding: 8px 0; }
        .sidebar a:hover { text-decoration: underline; }
        .content { flex: 1; }
        .content h2 { margin-bottom: 25px; color: #333; }
        .success { color: #28a745; margin: 15px 0; font-weight: bold; }
        .error { color: #dc3545; margin: 15px 0; }
        form p { margin: 18px 0; }
        label { display: inline-block; width: 120px; font-weight: 500; color: #555; }
        input { padding: 8px 10px; width: 300px; border: 1px solid #ccc; border-radius: 4px; }
        input:disabled { background: #f5f5f5; cursor: not-allowed; }
        button { padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
        .btn-confirm { background: #0066cc; color: white; margin-right: 10px; }
        .btn-cancel { background: #e0e0e0; color: #333; }
    </style>
</head>
<body>
    <div class="container">
        <!-- 左侧功能入口（匹配文档 2.3.2.3 UI） -->
        <div class="sidebar">
            <h3>Welcome, {{ $user->Name }}!</h3>
            <a href="{{ route('upmuser.dashboard') }}">Home</a>
            <a href="{{ route('upmuser.dashboard') }}">Make Donation</a>
            <a href="{{ route('upmuser.report_list') }}">View Financial Reports</a>
            <a href="{{ route('login') }}">Logout</a>
        </div>

        <!-- 右侧捐款表单 -->
        <div class="content">
            <h2>Make Donation</h2>
            
            <!-- 捐款成功提示 -->
            @if(session('success'))
                <div class="success">{{ session('success') }}</div>
            @endif

            <!-- 金额输入错误提示 -->
            @if($errors->has('amount'))
                <div class="error">{{ $errors->first('amount') }}</div>
            @endif

            <form method="POST" action="{{ route('upmuser.submit_donation') }}">
                @csrf <!-- Laravel 防 CSRF 攻击必加 -->
                
                <p>
                    <label>Donor Name:</label>
                    <input type="text" value="{{ $user->Name }}" disabled>
                </p>
                <p>
                    <label>Donation Amount (RM):</label>
                    <input type="number" name="amount" step="0.01" placeholder="Enter amount" required>
                </p>
                <p>
                    <label>Donation Date:</label>
                    <input type="text" value="{{ date('Y-m-d') }}" disabled>
                </p>
                <p>
                    <label>Fund Account:</label>
                    <input type="text" value="UPM Stray Animal Care Fund" disabled>
                </p>
                <button type="submit" class="btn-confirm">Confirm Donation</button>
                <button type="button" class="btn-cancel" onclick="history.back()">Cancel</button>
            </form>
        </div>
    </div>
</body>
</html>