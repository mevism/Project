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
        Schema::create('course_requirements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('course_id' , 12);
            $table->foreign('course_id')->references('course_id')->on('courses')->onUpdate('cascade')->onDelete('cascade');
            $table->string('application_fee', 8);
            $table->string('subject1', 16);
            $table->string('subject2', 16);
            $table->string('subject3', 16);
            $table->string('subject4', 16);
            $table->string('course_duration', 8);
            $table->longText('course_requirements', 32);
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
        Schema::dropIfExists('course_requirements');
    }
};
