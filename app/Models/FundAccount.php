<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FundAccount extends Model
{
    protected $table = 'FUND_ACCOUNT'; // 对应文档 FUND_ACCOUNT 表
    protected $primaryKey = 'Account'; // 主键字段
    public $timestamps = false;
    protected $fillable = [
        'Account',
        'Name',
        'Balance'
    ];
}