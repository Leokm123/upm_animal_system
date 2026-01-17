<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to UPM Stray Animal Management System!</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 40px; max-width: 1200px; margin: 0 auto; }
        h1 { color: #2d3748; margin-bottom: 20px; }
        .role { color: #4a5568; margin-bottom: 30px; }
        .function-center { background: #f7fafc; padding: 30px; border-radius: 8px; margin-bottom: 30px; }
        .function-center h2 { color: #2d3748; margin-bottom: 20px; }
        .btn-group { display: flex; gap: 20px; flex-wrap: wrap; }
        .btn {
            padding: 15px 30px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            color: white;
            transition: background 0.3s;
        }
        .btn-donate { background: #3182ce; }
        .btn-donate:hover { background: #2b6cb0; }
        .btn-report { background: #2f855a; }
        .btn-report:hover { background: #276749; }
        .logout-btn {
            background: #e53e3e;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s;
        }
        .logout-btn:hover { background: #c53030; }
    </style>
</head>
<body>
    <h1>Welcome to UPM Stray Animal Management System!</h1>
    <p class="role">Current login role: <span style="color: #3182ce; font-weight: bold;">upm_user</span></p>

    <div class="function-center">
        <h2>UPM User Function Center</h2>
        <div class="btn-group">
            <a href="/upm-user/donate-page" class="btn btn-donate">我要捐款</a>
            <a href="/upm-user/financialreport_list" class="btn btn-report">查看财务报告</a>
        </div>
    </div>

    <form action="/logout" method="POST" style="display: inline;">
        @csrf
        <button type="submit" class="logout-btn">Logout</button>
    </form>
</body>
</html>