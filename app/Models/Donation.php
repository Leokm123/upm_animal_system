<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $table = 'DONATION'; // 对应文档 DONATION 表
    protected $primaryKey = 'Donation_ID'; // 主键字段
    public $timestamps = false; // 表无自动时间戳字段
    // 允许批量赋值的字段（严格匹配 DONATION 表字段）
    protected $fillable = [
        'Donation_ID',
        'Amount',
        'Donated_Date',
        'Donor_User_ID',
        'Fund_Account_ID'
    ];
}