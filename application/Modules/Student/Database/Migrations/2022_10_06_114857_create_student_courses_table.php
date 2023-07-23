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
        Schema::create('student_courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('department_id');
            $table->foreign('department_id')->references('department_id')->on('departments')->onDelete('cascade')->onUpdate('cascade');
            $table->string('intake_id');
            $table->foreign('intake_id')->references('intake_id')->on('intakes')->onDelete('cascade')->onUpdate('cascade');
            $table->string('course_id');
            $table->foreign('course_id')->references('course_id')->on('courses')->onDelete('cascade')->onUpdate('cascade');
            $table->string('student_id');
            $table->foreign('student_id')->references('student_id')->on('student_logins')->onDelete('cascade')->onUpdate('cascade');            $table->string('student_number');
            $table->string('reference_number');
            $table->string('student_type');           
            $table->string('current_class');
            $table->string('entry_class');
            $table->integer('status');
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
        Schema::dropIfExists('student_courses');
    }
};
