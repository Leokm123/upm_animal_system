<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. 创建 喂养点表 feeding_points
        Schema::create('feeding_points', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // 喂养点名称
            $table->string('location'); // 喂养点位置
            $table->timestamps(); // 创建时间、更新时间
        });

        // 2. 创建 任务表 tasks
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('feeding_point_id'); // 关联喂养点ID
            $table->string('volunteer_name'); // 志愿者姓名
            $table->string('content'); // 任务内容
            $table->string('status')->default('待执行'); // 任务状态
            $table->timestamps();
        });

        // 3. 创建 任务报告表 task_reports
        Schema::create('task_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id'); // 关联任务ID
            $table->string('volunteer_name'); // 提交报告的志愿者姓名
            $table->text('report_content'); // 报告内容
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_reports');
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('feeding_points');
    }
};
