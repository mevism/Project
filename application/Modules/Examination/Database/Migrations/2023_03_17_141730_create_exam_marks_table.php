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
        Schema::create('exam_marks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('workflow_id')->nullable();
            $table->string('class_code');
            $table->string('unit_code');
            $table->string('reg_number');
            $table->string('academic_year');
            $table->string('academic_semester');
            $table->integer('stage');
            $table->integer('semester');
            $table->integer('cat');
            $table->integer('assignment')->default(0);
            $table->integer('practical')->default(0);
            $table->integer('exam');
            $table->integer('total_cat')->default(0);
            $table->integer('total_exam');
            $table->integer('total_mark');
            $table->string('attempt');
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
        Schema::dropIfExists('exam_marks');
    }
};
