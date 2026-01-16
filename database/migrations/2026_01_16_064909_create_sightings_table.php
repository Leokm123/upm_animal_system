<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('sightings', function (Blueprint $table) {
            // 1. 指定存储引擎为InnoDB（必须，支持外键）
            $table->engine = 'InnoDB';
            
            // 2. 主键（自定义字符串）
            $table->string('sightingId')->primary()->unique();
            
            // 3. 关联动物ID
            $table->string('animalId')->default('UNIDENTIFIED');
            
            // 4. 核心：volunteerId字段（显式声明类型，匹配volunteers.id）
            // 若volunteers.id是bigIncrements() → 用unsignedBigInteger
            $table->unsignedBigInteger('volunteerId');
            
            // 5. 其他字段（保持不变）
            $table->dateTime('sightingTime');
            $table->string('location');
            $table->json('photoUrls');
            $table->string('status')->default('healthy');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // 6. 外键约束（显式写法，避免简写坑）
            $table->foreign('volunteerId')
                  ->references('id')
                  ->on('volunteers')
                  ->onDelete('cascade'); // 级联删除（可选，业务需要）
        });
    }

    public function down() {
        // 先删除外键约束，再删表（避免删表报错）
        Schema::table('sightings', function (Blueprint $table) {
            $table->dropForeign(['volunteerId']);
        });
        Schema::dropIfExists('sightings');
    }
};