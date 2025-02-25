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
        Schema::create('available_courses', function (Blueprint $table) {
            $table->string('available_id', 12)->primary();
            $table->string('intake_id', 32);
            $table->foreign('intake_id')->references('intake_id')->on('intakes')->onUpdate('cascade')->onDelete('cascade');
            $table->string('course_id', 64);
            $table->foreign('course_id')->references('course_id')->on('courses')->onUpdate('cascade')->onDelete('cascade');
            $table->string('campus_id', 32);
            $table->foreign('campus_id')->references('campus_id')->on('campuses')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('available_courses');
    }
};
