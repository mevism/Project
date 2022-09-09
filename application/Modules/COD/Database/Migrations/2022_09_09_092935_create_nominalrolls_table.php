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
        Schema::create('nominalrolls', function (Blueprint $table) {
            $table->bigIncrements();
            $table->string('student_id');
            $table->string('year_study');
            $table->string('semester_study');
            $table->string('academic_year');
            $table->string('academic_semester');
            $table->string('course_id');
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
        Schema::dropIfExists('nominalrolls');
    }
};
