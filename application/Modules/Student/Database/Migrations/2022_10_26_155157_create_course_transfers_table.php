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
        Schema::create('course_transfers', function (Blueprint $table) {
            $table->string('course_transfer_id', 12)->primary();
            $table->string('student_id', 12);
            // $table->foreign('student_id')->references('student_id')->on('student_courses')->onDelete('cascade')->onUpdate('cascade');            
            $table->string('intake_id', 12);
            $table->string('class_id', 12);
            $table->foreign('class_id')->references('class_id')->on('classes')->onUpdate('cascade')->onDelete('cascade');
            $table->string('class_points', 8);
            $table->string('student_points', 8);
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('course_transfers');
    }
};
