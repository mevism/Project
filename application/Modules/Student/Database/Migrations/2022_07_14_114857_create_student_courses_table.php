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
            $table->string('intake_id', 12);
            $table->foreign('intake_id')->references('intake_id')->on('intakes')->onDelete('cascade')->onUpdate('cascade');
            $table->string('course_id', 12);
            $table->foreign('course_id')->references('course_id')->on('courses')->onDelete('cascade')->onUpdate('cascade');
            $table->string('applicant_id', 12);
            $table->foreign('applicant_id')->references('applicant_id')->on('applicant_contacts')->onDelete('cascade')->onUpdate('cascade');      
            $table->string('student_type', 2);
            $table->string('student_number', 20);
            $table->string('current_class', 20);
            $table->string('entry_class', 20);
            $table->tinyInteger('status');
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
