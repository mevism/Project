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
        Schema::create('course_syllabi', function (Blueprint $table) {
            $table->string('course_syllabus_id')->primary();
            $table->string('course_code');
            $table->string('unit_code');
            $table->string('stage');
            $table->string('semester');
            $table->string('type');
            $table->string('option');
            $table->string('version');
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
        Schema::dropIfExists('course_syllabi');
    }
};
