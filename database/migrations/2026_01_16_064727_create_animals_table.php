<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('animals', function (Blueprint $table) {
            $table->string('animalId')->primary()->unique(); // 主键（自定义ID：ANIMAL_xxx）
            $table->string('species'); // 物种（猫/狗等）
            $table->enum('gender', ['male', 'female', 'unknown']); // 性别
            $table->integer('estimatedAgeYears')->min(0); // 预估年龄（非负）
            $table->string('color'); // 颜色
            $table->enum('size', ['small', 'medium', 'large']); // 体型
            $table->string('markings'); // 特征标记（必填，用于匹配）
            $table->json('photoUrls'); // 照片URL数组（存多个照片）
            $table->dateTime('last_sighting_time'); // 最后目击时间
            $table->string('last_sighting_location'); // 最后目击位置
            $table->string('status')->nullable(); // 状态（如neutered/vaccinated）
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('animals');
    }
};