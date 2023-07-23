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
            $table->string('leave_id')->primary();
            $table->string('student_id');
            $table->foreign('student_id')->references('student_id')->on('student_contacts')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('type');
            $table->string('current_class');
            $table->integer('year_study');
            $table->string('semester_study');
            $table->string('academic_year');
            $table->foreign('academic_year')->references('year_id')->on('academic_years')->onDelete('cascade')->onUpdate('cascade');
            $table->string('intake_id');
            $table->string('from');
            $table->string('to');
            $table->longText('reason');
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
