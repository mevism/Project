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
            $table->string('nominal_id')->primary();
            $table->string('student_id');
            $table->foreign('student_id')->references('student_id')->on('student_contacts')->onUpdate('cascade')->onDelete('cascade');
            $table->string('reg_number');
            $table->string('year_study');
            $table->string('semester_study');
            $table->string('academic_year');
            $table->string('academic_semester');
            $table->integer('pattern_id');
            $table->string('class_code');
            $table->integer('registration')->nullable();
            $table->integer('activation')->nullable();
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
