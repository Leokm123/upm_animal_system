<!DOCTYPE html>
<html>
<head>
    <title>Manager - View All Task Reports</title>
    <style>body{padding:25px;font-size:16px;font-family:Arial;} .success{color:#009688;font-weight:bold;}</style>
</head>
<body>
    <!-- 返回功能中心按钮 -->
<a href="/dashboard" style="display: inline-block; margin: 10px 0; padding: 8px 16px; background: #009688; color: white; border-radius: 4px; text-decoration: none; font-weight: bold;">
  ← Back to Function Center
</a>

    <h2>✅ Manager Core Function - All Volunteer Task Reports</h2>
    @if(session('msg')) <p class="success">{{ session('msg') }}</p> @endif
    <table border="1" cellpadding="10" cellspacing="0" style="border-collapse:collapse;">
        <tr style="background:#f5f5f5;"><th>Report ID</th><th>Related Task ID</th><th>Volunteer Name</th><th>Report Details</th><th>Submission Time</th></tr>
        @foreach($reports as $report)
        <tr><td>{{ $report->id }}</td><td>{{ $report->task_id }}</td><td>{{ $report->volunteer_name }}</td><td>{{ $report->report_content }}</td><td>{{ $report->created_at }}</td></tr>
        @endforeach
    </table>
    <br>
    <a href="/manager/volunteer-report">👉 Volunteer Submit Report</a> | 
    <a href="/manager/task-list">👉 Back to Task List</a> |
    <a href="/manager/create-feeding-point">👉 Back to Create Feeding Point</a>
</body>
</html>