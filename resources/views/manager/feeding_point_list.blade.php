<!DOCTYPE html>
<html>
<head>
    <title>Feeding Point List</title>
    <style>body{padding:25px;font-size:16px;font-family:Arial;} .success{color:#009688;font-weight:bold;}</style>
</head>
<body>
    <!-- 返回功能中心按钮 -->
<a href="/dashboard" style="display: inline-block; margin: 10px 0; padding: 8px 16px; background: #009688; color: white; border-radius: 4px; text-decoration: none; font-weight: bold;">
  ← Back to Function Center
</a>

    <h2>✅ All Feeding Points List</h2>
    @if(session('msg')) <p class="success">{{ session('msg') }}</p> @endif
    <table border="1" cellpadding="10" cellspacing="0" style="border-collapse:collapse;">
        <tr style="background:#f5f5f5;"><th>ID</th><th>Feeding Point Name</th><th>Location</th><th>Creation Time</th></tr>
        @foreach($points as $point)
        <tr><td>{{ $point->id }}</td><td>{{ $point->name }}</td><td>{{ $point->location }}</td><td>{{ $point->created_at }}</td></tr>
        @endforeach
    </table>
    <br>
    <a href="/manager/create-feeding-point">👉 Create New Feeding Point</a> | 
    <a href="/manager/assign-task">👉 Assign Task to Volunteer</a>
</body>
</html>