<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialReport extends Model
{
    protected $table = 'FinancialReports'; // 对应文档 FinancialReports 表
    protected $primaryKey = 'report_ID'; // 主键字段
    public $timestamps = false; // 表无自动时间戳字段
    // 允许批量赋值的字段（无 status，匹配文档表结构）
    protected $fillable = [
        'report_ID',
        'start_date',
        'end_date',
        'opening_balance',
        'total_donation',
        'total_expense',
        'closing_balance',
        'generated_by' // 仅保留文档中存在的字段
    ];
}