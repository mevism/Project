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
        Schema::create('intake_attendance', function (Blueprint $table) {
            $table->bigIncrements('intake_attendance_id');
            $table->integer('courses_id')->nullable();
            $table->integer('intake_id')->nullable();
            $table->integer('attendance_id')->nullable();
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
        Schema::dropIfExists('intake_attendance');
    }
};
