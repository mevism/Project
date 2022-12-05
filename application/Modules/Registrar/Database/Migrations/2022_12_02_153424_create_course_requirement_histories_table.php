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
        Schema::create('course_requirement_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('course_requirement_id');
            $table->string('course_id');
            $table->string('fee');
            $table->string('subject1');
            $table->string('subject2');
            $table->string('subject3');
            $table->string('subject4');
            $table->string('course_duration');
            $table->longText('course_requirements');
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
        Schema::dropIfExists('course_requirement_histories');
    }
};
