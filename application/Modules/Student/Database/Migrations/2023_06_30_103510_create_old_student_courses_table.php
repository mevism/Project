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
        Schema::create('old_student_courses', function (Blueprint $table) {
            $table->string('student_id')->primary();
            $table->string('department_id');
            $table->string('intake_id');
            $table->string('course_id');
            $table->string('student_number');
            $table->string('reference_number');
            $table->string('student_type');            
            $table->string('current_class');
            $table->string('entry_class');
            $table->integer('status')->default(2);
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
        Schema::dropIfExists('old_student_courses');
    }
};
