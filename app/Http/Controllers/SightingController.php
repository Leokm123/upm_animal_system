<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sighting;
use App\Models\Animal;
use Illuminate\Support\Facades\Auth;

class SightingController extends Controller {
    // 构造函数：仅志愿者可访问
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
            return redirect()->route('dashboard')->withErrors('仅志愿者可上报目击！');
        });
    }

    // 1. 显示上报目击表单
    public function create() {
        return view('sighting.report');
    }

    // 2. 提交目击记录（核心逻辑）
    public function reportSighting(Request $request) {
        $validated = $request->validate([
            'animal_id' => 'nullable|exists:animals,animalId', // 已识别动物ID（可选）
            'photo_urls' => 'required|array|min:1',
            'photo_urls.*' => 'url', // 照片URL（实际可改为文件上传）
            'location' => 'required|string',
            'sighting_time' => 'required|date',
            'status' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        // 创建目击记录
        $sighting = Sighting::create([
            'sightingId' => 'SIGHT_' . uniqid(),
            'animalId' => $validated['animal_id'] ?? 'UNIDENTIFIED',
            'sightingTime' => $validated['sighting_time'],
            'location' => $validated['location'],
            'photoUrls' => $validated['photo_urls'],
            'status' => $validated['status'] ?? 'healthy',
            'notes' => $validated['notes']
        ]);

        // 若关联动物，更新其最后目击信息
        if (!empty($validated['animal_id'])) {
            Animal::find($validated['animal_id'])->update([
                'last_sighting_time' => $validated['sighting_time'],
                'last_sighting_location' => $validated['location']
            ]);
            return redirect()->route('animal.show', $validated['animal_id'])
                ->with('success', '目击上报成功！动物档案已更新');
        }

        // 未识别动物：跳转到创建档案页面（关联当前目击ID）
        return redirect()->route('animal.create', ['initial_sighting_id' => $sighting->sightingId])
            ->with('success', '目击上报成功！请为未识别动物创建档案');
    }

    // 3. 查看志愿者的所有目击记录
    public function index() {
        $user = $this->getLoggedInUser();
    // 如果 Sighting 表有 volunteer_id 字段，可以按用户筛选
    // $sightings = Sighting::where('volunteer_id', $user->id)->get();
        $sightings = Sighting::all();  // 或显示所有记录
        return view('sighting.index', compact('sightings'));
}
}