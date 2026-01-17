<!DOCTYPE html>
<html>
<head>
    <title>Manager - Create Feeding Point</title>
    <style>body{padding:25px;font-size:16px;font-family:Arial;}</style>
</head>
<body>
    <!-- 返回功能中心按钮 -->
<a href="/dashboard" style="display: inline-block; margin: 10px 0; padding: 8px 16px; background: #009688; color: white; border-radius: 4px; text-decoration: none; font-weight: bold;">
  ← Back to Function Center
</a>

    <h2>✨ Manager - Create New Feeding Point</h2>
    <form method="POST" action="/manager/store-feeding-point">
        @csrf
        <div style="margin:12px 0;"><label>Feeding Point Name：</label><input type="text" name="name" required style="padding:6px;width:250px;" placeholder="e.g.Library"></div>
        <div style="margin:12px 0;"><label>Feeding Point Location：</label><input type="text" name="location" required style="padding:6px;width:250px;" placeholder="e.g. DKAP"></div>
        <button type="submit" style="padding:7px 22px;background:#009688;color:#fff;border:none;border-radius:4px;">Create Feeding Point</button>
    </form>
    <br>
    <a href="/manager/feeding-point-list">👉 View All Feeding Points</a>
</body>
</html>