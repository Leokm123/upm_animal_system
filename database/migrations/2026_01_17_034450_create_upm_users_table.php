<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('upm_users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // 用户名（唯一）
            $table->string('password'); // 密码（加密存储）
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('upm_users');
    }
};
