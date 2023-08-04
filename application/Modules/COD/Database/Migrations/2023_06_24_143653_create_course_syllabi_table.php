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
            $table->string('course_syllabus_id',12)->primary();
            $table->string('course_code', 8);
            $table->string('unit_code', 8);
            $table->string('stage', 2);
            $table->string('semester', 4);
            $table->string('type', 16);
            $table->string('option', 16);
            $table->string('version', 8);
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
