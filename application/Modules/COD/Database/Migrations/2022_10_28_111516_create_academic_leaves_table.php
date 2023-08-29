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
        Schema::create('academic_leaves', function (Blueprint $table) {
            $table->string('leave_id', 12)->primary();
            $table->string('academic_year', 12);
            // $table->foreign('academic_year')->references('year_id')->on('academic_years')->onDelete('cascade')->onUpdate('cascade');
            $table->string('student_id', 12);
            $table->foreign('student_id')->references('student_id')->on('student_courses')->onDelete('cascade')->onUpdate('cascade');
            $table->tinyInteger('type');
            $table->string('current_class', 16);
            $table->tinyInteger('year_study');
            $table->string('semester_study', 4);          
            $table->string('from', 16);
            $table->string('to', 16);
            $table->longText('reason', 100);
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
        Schema::dropIfExists('academic_leaves');
    }
};
