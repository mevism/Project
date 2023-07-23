<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classes', function (Blueprint $table) {
            $table->string('class_id')->primary();
            $table->string('name')->unique();
            $table->string('attendance_id');
            $table->string('course_id');
            $table->foreign('course_id')->references('course_id')->on('courses')->onUpdate('cascade')->onDelete('cascade');
            $table->string('intake_id');
            $table->foreign('intake_id')->references('intake_id')->on('intakes')->onUpdate('cascade')->onDelete('cascade');
            $table->string('syllabus_name');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classes');
    }
};
