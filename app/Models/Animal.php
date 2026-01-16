<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Animal extends Model {
    protected $table = 'animals'; // 对应animals表
    protected $primaryKey = 'animalId'; // 自定义主键（非默认id）
    public $incrementing = false; // 关闭自增（主键是自定义字符串）
    protected $fillable = [ // 允许批量赋值的字段
        'animalId', 'species', 'gender', 'estimatedAgeYears', 
        'color', 'size', 'markings', 'photoUrls', 
        'last_sighting_time', 'last_sighting_location', 'status'
    ];
    protected $casts = [ // 字段类型转换（json转数组）
        'photoUrls' => 'array',
        'last_sighting_time' => 'datetime'
    ];

    // 关联：一个动物有多个目击记录
    public function sightings() {
        return $this->hasMany(Sighting::class, 'animalId', 'animalId');
    }
}