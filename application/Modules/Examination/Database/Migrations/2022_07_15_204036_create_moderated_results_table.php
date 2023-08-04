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
        Schema::create('moderated_results', function (Blueprint $table) {
            $table->string('moderated_exam_id', 12)->primary();
            $table->string('exam_approval_id', 12);
            $table->foreign('exam_approval_id')->references('exam_approval_id')->on('exam_workflows')->onDelete('cascade')->onUpdate('cascade');
            $table->string('intake_id',12);
            $table->foreign('intake_id')->references('intake_id')->on('intakes')->onDelete('cascade')->onUpdate('cascade');
            $table->string('class_code', 20);
            $table->foreign('class_code')->references('name')->on('classes')->onDelete('cascade')->onUpdate('cascade');
            $table->string('student_number', 16);
            $table->foreign('student_number')->references('student_number')->on('student_courses')->onDelete('cascade')->onUpdate('cascade');
            $table->string('unit_id', 12);
            $table->foreign('unit_id')->references('unit_id')->on('units')->onDelete('cascade')->onUpdate('cascade');
            $table->tinyInteger('stage');
            $table->float('semester');
            $table->float('total_cat')->nullable();
            $table->float('total_exam')->nullable();
            $table->string('attempt',16);
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('moderated_results');
    }
};
