<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;
use App\Models\Sighting;
use Illuminate\Support\Facades\Auth;

class AnimalProfileController extends Controller {
    // 构造函数：仅志愿者可访问（权限控制）
   public function __construct() {
        // 替换默认auth中间件，兼容多Guard登录检查
        $this->middleware(function ($request, $next) {
            // 1. 检查是否有任意Guard登录
            if (!$this->isAnyGuardLoggedIn()) {
                return redirect()->route('login')->withErrors('请先登录系统！');
            }
            // 2. 检查是否为志愿者
            $user = $this->getLoggedInUser();
            if ($user instanceof \App\Models\Volunteer) {
                return $next($request);
            }
            return redirect()->route('dashboard')->withErrors('仅志愿者可操作动物档案！');
        });
    }

    // 1. 动物档案查询匹配（根据目击数据匹配现有档案）
    public function matchProfiles(Request $request) {
        $sightingData = $request->validate([
            'photo_urls' => 'required|array|min:1',
            'location' => 'required|string',
            'color' => 'required|string',
            'markings' => 'nullable|string',
            'species' => 'nullable|string'
        ]);

        // 转换位置为坐标（简化实现：模拟经纬度，实际可集成地图API）
        $sightingCoords = $this->convertLocationToCoords($sightingData['location']);

        // 查询潜在匹配：同物种+相似颜色+1km内
        $potentialMatches = Animal::where(function ($query) use ($sightingData) {
            if (!empty($sightingData['species'])) {
                $query->where('species', $sightingData['species']);
            }
            $query->where('color', 'LIKE', "%{$sightingData['color']}%");
        })->get()->filter(function ($animal) use ($sightingCoords) {
            $animalCoords = $this->convertLocationToCoords($animal->last_sighting_location);
            $distance = $this->calculateDistance($sightingCoords, $animalCoords);
            return $distance < 1; // 1km内匹配
        });

        // 计算特征相似度，排序返回
        $matchedProfiles = $potentialMatches->map(function ($animal) use ($sightingData) {
            $similarity = 70; // 颜色+位置基础相似度
            if (!empty($sightingData['markings']) && !empty($animal->markings)) {
                $markingSimilarity = $this->calculateMarkingSimilarity($sightingData['markings'], $animal->markings);
                $similarity += $markingSimilarity;
            }
            return [
                'animal_id' => $animal->animalId,
                'name' => $animal->name ?? 'Unnamed',
                'photo_url' => $animal->photoUrls[0] ?? '',
                'similarity' => min($similarity, 100),
                'last_sighting' => $animal->last_sighting_time->format('Y-m-d H:i')
            ];
        })->sortByDesc('similarity');

        return response()->json(['matched_profiles' => $matchedProfiles]);
    }

    // 2. 创建新动物档案
    public function createProfile(Request $request) {
        $validated = $request->validate([
            'species' => 'required|string',
            'gender' => 'required|in:male,female,unknown',
            'estimated_age_years' => 'required|integer|min:0',
            'color' => 'required|string',
            'size' => 'required|in:small,medium,large',
            'markings' => 'required|string',
            'photo_urls' => 'required|array|min:1',
            'photo_urls.*' => 'url',
            'initial_sighting_id' => 'required|exists:sightings,sightingId'
        ]);

        // 获取初始目击记录
        $initialSighting = Sighting::findOrFail($validated['initial_sighting_id']);

        // 创建动物档案
        $animal = Animal::create([
            'animalId' => 'ANIMAL_' . uniqid(),
            'species' => $validated['species'],
            'gender' => $validated['gender'],
            'estimatedAgeYears' => $validated['estimated_age_years'],
            'color' => $validated['color'],
            'size' => $validated['size'],
            'markings' => $validated['markings'],
            'photoUrls' => $validated['photo_urls'],
            'last_sighting_time' => $initialSighting->sightingTime,
            'last_sighting_location' => $initialSighting->location
        ]);

        // 关联初始目击记录到新档案
        $initialSighting->update(['animalId' => $animal->animalId]);

        return redirect()->route('animal.show', $animal->animalId)
            ->with('success', '动物档案创建成功！');
    }

    // 3. 更新现有动物档案
    public function updateProfile(Request $request, $animalId) {
        $animal = Animal::findOrFail($animalId);

        $validated = $request->validate([
            'species' => 'nullable|string',
            'gender' => 'nullable|in:male,female,unknown',
            'estimated_age_years' => 'nullable|integer|min:0',
            'color' => 'nullable|string',
            'size' => 'nullable|in:small,medium,large',
            'markings' => 'nullable|string',
            'photo_urls' => 'nullable|array',
            'photo_urls.*' => 'url',
            'status' => 'nullable|string'
        ]);

        // 仅更新提供的字段（过滤空值）
        $animal->update(array_filter($validated));

        return redirect()->route('animal.show', $animal->animalId)
            ->with('success', '动物档案更新成功！');
    }

    // 4. 查看单个动物档案
    public function show($animalId) {
        $animal = Animal::findOrFail($animalId);
        return view('animal.show', compact('animal'));
    }

    // 辅助方法：位置转坐标（简化模拟）
    private function convertLocationToCoords($location) {
        // 实际项目可集成高德/谷歌地图API，这里模拟经纬度
        $locationHash = crc32($location);
        $lat = 2.5 + ($locationHash % 10) / 10; // 模拟纬度（2.5-3.5）
        $lng = 101.5 + ($locationHash % 10) / 10; // 模拟经度（101.5-102.5）
        return ['lat' => $lat, 'lng' => $lng];
    }

    // 辅助方法：计算两点距离（Haversine公式，单位：km）
    private function calculateDistance($coords1, $coords2) {
        $R = 6371; // 地球半径（km）
        $dLat = deg2rad($coords2['lat'] - $coords1['lat']);
        $dLng = deg2rad($coords2['lng'] - $coords1['lng']);
        $a = sin($dLat/2) * sin($dLat/2) +
             cos(deg2rad($coords1['lat'])) * cos(deg2rad($coords2['lat'])) *
             sin($dLng/2) * sin($dLng/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        return $R * $c; // 距离（km）
    }

    // 辅助方法：特征相似度计算（简化：字符串匹配度）
    private function calculateMarkingSimilarity($sightingMarkings, $animalMarkings) {
        similar_text(strtolower($sightingMarkings), strtolower($animalMarkings), $percent);
        return min($percent / 10, 30); // 相似度0-30分
    }
}