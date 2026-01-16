<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>{{ $animal->name ?? '动物档案' }}</title>
    <style>
        .container { width: 600px; margin: 50px auto; padding: 20px; border: 1px solid #eee; border-radius: 8px; }
        .info-item { margin-bottom: 15px; }
        .label { font-weight: bold; display: inline-block; width: 120px; }
        .photo { margin: 10px 0; max-width: 200px; height: auto; }
        .btn { display: inline-block; padding: 8px 16px; margin-right: 10px; background: #2196F3; color: white; text-decoration: none; border-radius: 4px; }
        .btn-edit { background: #FFC107; }
        .success { color: green; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>动物档案详情</h2>
        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <div class="info-item">
            <span class="label">档案ID：</span>
            <span>{{ $animal->animalId }}</span>
        </div>
        <div class="info-item">
            <span class="label">物种：</span>
            <span>{{ $animal->species }}</span>
        </div>
        <div class="info-item">
            <span class="label">性别：</span>
            <span>{{ $animal->gender == 'male' ? '公' : ($animal->gender == 'female' ? '母' : '未知') }}</span>
        </div>
        <div class="info-item">
            <span class="label">预估年龄：</span>
            <span>{{ $animal->estimatedAgeYears }} 年</span>
        </div>
        <div class="info-item">
            <span class="label">颜色：</span>
            <span>{{ $animal->color }}</span>
        </div>
        <div class="info-item">
            <span class="label">体型：</span>
            <span>{{ $animal->size == 'small' ? '小型' : ($animal->size == 'medium' ? '中型' : '大型') }}</span>
        </div>
        <div class="info-item">
            <span class="label">特征标记：</span>
            <span>{{ $animal->markings }}</span>
        </div>
        <div class="info-item">
            <span class="label">照片：</span>
            <br>
            @foreach($animal->photoUrls as $photoUrl)
                <img src="{{ $photoUrl }}" class="photo" alt="动物照片">
            @endforeach
        </div>
        <div class="info-item">
            <span class="label">最后目击：</span>
            <span>{{ $animal->last_sighting_time->format('Y-m-d H:i') }}（{{ $animal->last_sighting_location }}）</span>
        </div>
        <div class="info-item">
            <span class="label">状态：</span>
            <span>{{ $animal->status ?? '无' }}</span>
        </div>

        <a href="{{ route('animal.edit', $animal->animalId) }}" class="btn btn-edit">编辑档案</a>
        <a href="{{ route('sighting.create') }}" class="btn">上报新目击</a>
    </div>
</body>
</html>