<!DOCTYPE html>
<html>
<head>
    <title>Manager - Assign Task</title>
    <style>body{padding:25px;font-size:16px;font-family:Arial;}</style>
</head>
<body>
    <!-- 返回功能中心按钮 -->
<a href="/dashboard" style="display: inline-block; margin: 10px 0; padding: 8px 16px; background: #009688; color: white; border-radius: 4px; text-decoration: none; font-weight: bold;">
  ← Back to Function Center
</a>

    <h2>✨ Manager - Assign Task to Volunteer</h2>
    <form method="POST" action="/manager/store-task">
        @csrf
        <div style="margin:12px 0;">
            <label>Select Feeding Point：</label>
            <select name="feeding_point_id" required style="padding:6px;width:250px;">
                <option value="">-- Please Select Feeding Point --</option>
                @foreach($points as $point)
                <option value="{{ $point->id }}">{{ $point->name }} ({{ $point->location }})</option>
                @endforeach
            </select>
        </div>
        <div style="margin:12px 0;"><label>Volunteer Name：</label><input type="text" name="volunteer_name" required style="padding:6px;width:250px;" placeholder="e.g. Amy"></div>
        <div style="margin:12px 0;"><label>Task Content：</label><input type="text" name="content" required style="padding:6px;width:350px;" placeholder="e.g. Feed stray animals at 10 AM and clean the feeding point"></div>
        <button type="submit" style="padding:7px 22px;background:#009688;color:#fff;border:none;border-radius:4px;">Assign Task</button>
    </form>
    <br>
    <a href="/manager/task-list">👉 View All Assigned Tasks</a> | 
    <a href="/manager/feeding-point-list">👉 Back to Feeding Point List</a>
</body>
</html>