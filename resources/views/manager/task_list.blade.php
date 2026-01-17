<!DOCTYPE html>
<html>
<head>
    <title>Task List</title>
    <style>body{padding:25px;font-size:16px;font-family:Arial;} .success{color:#009688;font-weight:bold;}</style>
</head>
<body>
    <!-- 返回功能中心按钮 -->
<a href="/dashboard" style="display: inline-block; margin: 10px 0; padding: 8px 16px; background: #009688; color: white; border-radius: 4px; text-decoration: none; font-weight: bold;">
  ← Back to Function Center
</a>

    <h2>✅ All Assigned Tasks List</h2>
    @if(session('msg')) <p class="success">{{ session('msg') }}</p> @endif
    <table border="1" cellpadding="10" cellspacing="0" style="border-collapse:collapse;">
        <tr style="background:#f5f5f5;"><th>Task ID</th><th>Related Feeding Point ID</th><th>Volunteer</th><th>Task Content</th><th>Task Status</th><th>Assignment Time</th></tr>
        @foreach($tasks as $task)
        <tr><td>{{ $task->id }}</td><td>{{ $task->feeding_point_id }}</td><td>{{ $task->volunteer_name }}</td><td>{{ $task->content }}</td><td>{{ $task->status }}</td><td>{{ $task->created_at }}</td></tr>
        @endforeach
    </table>
    <br>
    <a href="/manager/assign-task">👉 Assign New Task</a> | 
    <a href="/manager/volunteer-report">👉 Volunteer Submit Task Report</a>
</body>
</html>