<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>上报动物目击</title>
    <style>
        .container { width: 600px; margin: 50px auto; padding: 20px; border: 1px solid #eee; border-radius: 8px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; }
        input, textarea, select { width: 100%; padding: 10px; box-sizing: border-box; border: 1px solid #ddd; border-radius: 4px; }
        .btn { padding: 12px 20px; background: #2196F3; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .btn:hover { background: #1976D2; }
        .error { color: red; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>上报动物目击</h2>
        @if($errors->any())
            <div class="error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('sighting.report') }}">
            @csrf
            <!-- 已识别动物（可选） -->
            <div class="form-group">
                <label>关联已识别动物（可选）</label>
                <select name="animal_id" id="animal_id">
                    <option value="">-- 未识别（后续创建档案）--</option>
                    <!-- 实际项目可通过AJAX加载现有动物列表，这里简化 -->
                </select>
            </div>

            <!-- 目击照片URL（多个，用逗号分隔） -->
            <div class="form-group">
                <label>照片URL（多个用逗号分隔）</label>
                <input type="text" name="photo_urls" placeholder="https://xxx.jpg,https://yyy.jpg" required>
                <small>提示：实际项目可改为文件上传</small>
            </div>

            <!-- 目击位置 -->
            <div class="form-group">
                <label>目击位置</label>
                <input type="text" name="location" placeholder="如：UPM图书馆门口" required>
            </div>

            <!-- 目击时间 -->
            <div class="form-group">
                <label>目击时间</label>
                <input type="datetime-local" name="sighting_time" required>
            </div>

            <!-- 动物状态 -->
            <div class="form-group">
                <label>动物状态</label>
                <input type="text" name="status" placeholder="如：healthy/injured/starving" value="healthy">
            </div>

            <!-- 备注 -->
            <div class="form-group">
                <label>备注</label>
                <textarea name="notes" rows="3" placeholder="补充描述（如行为、特征等）"></textarea>
            </div>

            <button type="submit" class="btn">提交目击记录</button>
        </form>
    </div>
</body>
</html>