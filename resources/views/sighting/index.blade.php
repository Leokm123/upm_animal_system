<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>我的目击记录</title>
    <style>
        .container { width: 800px; margin: 50px auto; padding: 20px; border: 1px solid #eee; border-radius: 8px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f5f5f5; }
        .btn { display: inline-block; padding: 8px 16px; background: #2196F3; color: white; text-decoration: none; border-radius: 4px; }
        .success { color: green; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>我的目击记录</h2>
        <a href="{{ route('sighting.create') }}" class="btn">新增目击上报</a>
        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <table>
            <thead>
                <tr>
                    <<th>目击ID</</th>
                    <<th>动物</</th>
                    <<th>位置</</th>
                    <<th>时间</</th>
                    <<th>状态</</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sightings as $sighting)
                <tr>
                    <td>{{ $sighting->sightingId }}</td>
                    <td>
                        @if($sighting->animalId != 'UNIDENTIFIED')
                            <a href="{{ route('animal.show', $sighting->animalId) }}">
                                {{ $sighting->animal->name ?? '动物档案' }}
                            </a>
                        @else
                            未识别（<a href="{{ route('animal.create', ['initial_sighting_id' => $sighting->sightingId]) }}">创建档案</a>）
                        @endif
                    </td>
                    <td>{{ $sighting->location }}</td>
                    <td>{{ $sighting->sightingTime->format('Y-m-d H:i') }}</td>
                    <td>{{ $sighting->status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>