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
        Schema::create('course_transfers', function (Blueprint $table) {
            $table->string('course_transfer_id')->primary();
            $table->string('student_id');
            $table->foreign('student_id')->references('student_id')->on('student_logins')->onDelete('no action')->onUpdate('no action');            $table->string('intake_id');
            $table->foreign('intake_id')->references('intake_id')->on('intakes')->onUpdate('no action')->onDelete('no action');
            $table->string('course_id');
            $table->foreign('course_id')->references('course_id')->on('courses')->onUpdate('no action')->onDelete('no action');
            $table->string('class_id');
            $table->foreign('class_id')->references('class_id')->on('classes')->onUpdate('no action')->onDelete('no action');
            $table->string('department_id');
            $table->foreign('department_id')->references('department_id')->on('departments')->onUpdate('no action')->onDelete('no action');
            $table->string('class_points');
            $table->string('student_points');
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
        Schema::dropIfExists('course_transfers');
    }
};
