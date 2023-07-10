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
            $table->string('leave_id');
            $table->string('student_id');
            $table->integer('type');
            $table->string('current_class');
            $table->integer('year_study');
            $table->string('semester_study');
            $table->string('academic_year');
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
