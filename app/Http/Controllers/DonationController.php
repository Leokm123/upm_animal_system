<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DonationController extends Controller
{
    // UPM用户功能选择主页
    public function home()
    {
        return view('upmuser.home');
    }

    // UPM用户捐款表单页面
    public function donatePage()
    {
        return view('upmuser.dashboard');
    }

    // UPM用户捐款主页面
    public function dashboard()
    {
        return view('upmuser.dashboard');
    }

    // 提交捐款数据处理逻辑
    public function submitDonation(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        $amount = $request->input('amount');
        DB::table('donations')->insert([
            'user_id' => auth()->user()->id,
            'amount' => $amount,
            'donated_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('upmuser.dashboard')->with('success', '捐款成功！感谢您的爱心捐款！');
    }

    // 财务报告列表数据查询
    public function financialreportList()
    {
        $reports = DB::table('donations')
            ->join('users', 'donations.user_id', '=', 'users.id')
            ->select('donations.*', 'users.username')
            ->orderBy('donations.donated_at', 'desc')
            ->get();
        return view('upmuser.financialreportList', compact('reports'));
    }

    // 单条财务报告详情数据查询
    public function financialreportDetails($reportId)
    {
        $report = DB::table('donations')
            ->join('users', 'donations.user_id', '=', 'users.id')
            ->select('donations.*', 'users.username')
            ->where('donations.id', $reportId)
            ->first();
        
        if (!$report) {
            return redirect()->route('upmuser.financialreport_list')->with('error', '报告不存在！');
        }
        return view('upmuser.financialreportDetails', compact('report'));
    }
}