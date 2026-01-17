<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManagerController extends Controller
{
    // ========== 1. 管理员创建喂养点 相关 ==========
    // 打开「创建喂养点」的表单页面
    public function createFeedingPoint()
    {
        return view('manager.create_feeding_point');
    }
    // 提交表单，保存喂养点数据到数据库
    public function storeFeedingPoint(Request $request)
    {
        DB::table('feeding_points')->insert([
            'name' => $request->name,
            'location' => $request->location,
        ]);
        return redirect('/manager/feeding-point-list')->with('msg', '✅ Feeding point created successfully!');
    }
    // 查看所有喂养点列表
    public function feedingPointList()
    {
        $points = DB::table('feeding_points')->get();
        return view('manager.feeding_point_list', ['points' => $points]);
    }

    // ========== 2. 管理员分配任务给志愿者 相关 ==========
    // 打开「分配任务」的表单页面
    public function assignTask()
    {
        $points = DB::table('feeding_points')->get();
        return view('manager.assign_task', ['points' => $points]);
    }
    // 提交表单，保存任务数据到数据库
    public function storeTask(Request $request)
    {
        DB::table('tasks')->insert([
            'feeding_point_id' => $request->feeding_point_id,
            'volunteer_name' => $request->volunteer_name,
            'content' => $request->content,
            'status' => 'append'
        ]);
        return redirect('/manager/task-list')->with('msg', '✅ Task assignment successful!');
    }
    // 查看所有任务列表
    public function taskList()
    {
        $tasks = DB::table('tasks')->get();
        return view('manager.task_list', ['tasks' => $tasks]);
    }

    // ========== 3. 志愿者提交报告 + 管理员查看报告 相关 ==========
    // 打开「志愿者提交报告」的页面（极简演示，无需登录）
    public function volunteerReport()
    {
        $tasks = DB::table('tasks')->get();
        return view('manager.volunteer_report', ['tasks' => $tasks]);
    }
    // 保存志愿者报告到数据库 + 更新任务状态为【已完成】
    public function storeReport(Request $request)
    {
        DB::table('task_reports')->insert([
            'task_id' => $request->task_id,
            'volunteer_name' => $request->volunteer_name,
            'report_content' => $request->report_content,
        ]);
        DB::table('tasks')->where('id', $request->task_id)->update(['status' => '✅已完成']);
        return redirect('/manager/view-reports')->with('msg', '✅ Report submitted successfully! ');
    }
    // 管理员核心功能：查看所有志愿者提交的报告
    public function viewReports()
    {
        $reports = DB::table('task_reports')->get();
        return view('manager.view_reports', ['reports' => $reports]);
    }
}