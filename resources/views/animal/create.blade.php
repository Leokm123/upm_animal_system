<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>创建动物档案</title>
    <style>
        .container { width: 600px; margin: 50px auto; padding: 20px; border: 1px solid #eee; border-radius: 8px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 10px; box-sizing: border-box; border: 1px solid #ddd; border-radius: 4px; }
        .btn { padding: 12px 20px; background: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .btn:hover { background: #388E3C; }
        .success { color: green; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>创建动物电子档案</h2>
        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div style="color: red; margin-bottom: 15px;">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('animal.store') }}">
            @csrf
            <!-- 隐藏字段：关联初始目击ID -->
            <input type="hidden" name="initial_sighting_id" value="{{ request('initial_sighting_id') }}" required>

            <!-- 物种 -->
            <div class="form-group">
                <label>物种</label>
                <input type="text" name="species" placeholder="如：猫/狗/流浪猫（橘色）" required>
            </div>

            <!-- 性别 -->
            <div class="form-group">
                <label>性别</label>
                <select name="gender" required>
                    <option value="male">公</option>
                    <option value="female">母</option>
                    <option value="unknown">未知</option>
                </select>
            </div>

            <!-- 预估年龄 -->
            <div class="form-group">
                <label>预估年龄（年）</label>
                <input type="number" name="estimated_age_years" min="0" placeholder="如：2" required>
            </div>

            <!-- 颜色 -->
            <div class="form-group">
                <label>颜色</label>
                <input type="text" name="color" placeholder="如：橘色/黑白/棕色" required>
            </div>

            <!-- 体型 -->
            <div class="form-group">
                <label>体型</label>
                <select name="size" required>
                    <option value="small">小型</option>
                    <option value="medium">中型</option>
                    <option value="large">大型</option>
                </select>
            </div>

            <!-- 特征标记 -->
            <div class="form-group">
                <label>特征标记（必填）</label>
                <textarea name="markings" rows="2" placeholder="如：左前爪白色/额头有黑斑" required></textarea>
            </div>

            <!-- 照片URL -->
            <div class="form-group">
                <label>照片URL（多个用逗号分隔）</label>
                <input type="text" name="photo_urls" placeholder="https://xxx.jpg,https://yyy.jpg" required>
            </div>

            <button type="submit" class="btn">创建档案</button>
        </form>
    </div>
</body>
</html>