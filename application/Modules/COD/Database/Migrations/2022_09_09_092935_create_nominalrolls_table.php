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
            $table->string('nominal_id', 12)->primary();
            $table->string('student_id', 12);
            $table->foreign('student_id')->references('student_id')->on('student_courses')->onUpdate('cascade')->onDelete('cascade');
            $table->string('intake_id');
            $table->foreign('intake_id')->references('intake_id')->on('intakes')->onUpdate('cascade')->onDelete('cascade');
            $table->tinyInteger('pattern_id');
            $table->tinyInteger('year_study');
            $table->float('semester_study');            
            $table->string('class_code', 20);
            $table->tinyInteger('registration')->nullable();
            $table->tinyInteger('activation')->nullable();
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
