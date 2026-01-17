<!DOCTYPE html>
<html>
<head>
    <title>Volunteer - Submit Task Report</title>
    <style>body{padding:25px;font-size:16px;font-family:Arial;}</style>
</head>
<body>
    <!-- 返回功能中心按钮 -->
<a href="/dashboard" style="display: inline-block; margin: 10px 0; padding: 8px 16px; background: #009688; color: white; border-radius: 4px; text-decoration: none; font-weight: bold;">
  ← Back to Function Center
</a>

    <h2>🙋 Volunteer - Submit Task Completion Report</h2>
    <form method="POST" action="/manager/store-report">
        @csrf
        <div style="margin:12px 0;">
            <label>Select Completed Task：</label>
            <select name="task_id" required style="padding:6px;width:350px;">
                <option value="">-- Please Select Completed Task --</option>
                @foreach($tasks as $task)
                <option value="{{ $task->id }}">Task ID:{{ $task->id }} → {{ $task->content }}</option>
                @endforeach
            </select>
        </div>
        <div style="margin:12px 0;"><label>Your Name：</label><input type="text" name="volunteer_name" required style="padding:6px;width:250px;"></div>
        <div style="margin:12px 0;"><label>Report Content：</label><textarea name="report_content" required style="padding:6px;width:350px;height:100px;" placeholder="e.g. Completed feeding work, the feeding point is clean, all stray animals are healthy"></textarea></div>
        <button type="submit" style="padding:7px 22px;background:#009688;color:#fff;border:none;border-radius:4px;">Submit Report</button>
    </form>
</body>
</html>