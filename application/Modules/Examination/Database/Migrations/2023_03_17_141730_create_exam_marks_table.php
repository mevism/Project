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
        Schema::create('exam_marks', function (Blueprint $table) {
            $table->string('exam_id')->primary();
            $table->string('class_code');
            $table->string('unit_code');
            $table->string('student_number');
            $table->string('academic_year');
            $table->string('academic_semester');
            $table->integer('stage');
            $table->integer('semester');
            $table->string('cat')->nullable();
            $table->string('assignment')->nullable();
            $table->string('practical')->nullable();
            $table->string('exam')->nullable();
            $table->string('total_cat')->nullable();
            $table->string('total_exam')->nullable();
            $table->string('total_mark')->nullable();
            $table->string('attempt');
            $table->string('exam_approval_id');
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('exam_marks');
    }
};
