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
            $table->bigIncrements('id');
            $table->bigInteger('student_id');
            $table->integer('type');
            $table->integer('course_id');
            $table->integer('year_study');
            $table->string('semester_study');
            $table->string('academic_year');
            $table->date('from');
            $table->date('to');
            $table->longText('reason');
            $table->integer('cod_status')->nullable();
            $table->string('cod_remarks')->nullable();
            $table->integer('dean_status')->nullable();
            $table->string('dean_remarks')->nullable();
            $table->integer('registrar_status')->nullable();
            $table->string('registrar_remarks')->nullable();
            $table->tinyInteger('status')->nullable();
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
