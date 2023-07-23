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
        Schema::create('semester_fees', function (Blueprint $table) {
            $table->string('semester_fee_id')->primary();
            $table->string('course_level_mode_id');
            $table->string('votehead_id');
            $table->foreign('votehead_id')->references('votehead_id')->on('vote_heads')->onUpdate('cascade')->onDelete('cascade');
            $table->string('semesterI');
            $table->string('semesterII')->nullable();
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
        Schema::dropIfExists('semester_fees');
    }
};
