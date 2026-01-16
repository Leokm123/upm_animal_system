<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Sighting extends Model {
    protected $table = 'sightings'; // 对应sightings表
    protected $primaryKey = 'sightingId'; // 自定义主键
    public $incrementing = false; // 关闭自增
    protected $fillable = [ // 允许批量赋值的字段
        'sightingId', 'animalId', 'volunteerId', 'sightingTime', 
        'location', 'photoUrls', 'status', 'notes'
    ];
    protected $casts = [ // 字段类型转换
        'photoUrls' => 'array',
        'sightingTime' => 'datetime'
    ];

    // 关联：一个目击记录属于一个动物
    public function animal() {
        return $this->belongsTo(Animal:: class, 'animalId', 'animalId');
    }

    // 关联：一个目击记录属于一个志愿者
    public function volunteer() {
        return $this->belongsTo(Volunteer::class, 'volunteerId', 'id');
    }

    // 新增：创建时自动填充志愿者ID（当前登录志愿者）
    protected static function booted() {
        static::creating(function ($sighting) {
            // 尝试从多个 guard 获取当前登录用户
            $user = Auth:: guard('volunteer')->user() 
                    ?? Auth::guard('web')->user() 
                    ??  Auth::user();
            
            if ($user) {
                $sighting->volunteerId = $user->id;
            }
        });
    }
}