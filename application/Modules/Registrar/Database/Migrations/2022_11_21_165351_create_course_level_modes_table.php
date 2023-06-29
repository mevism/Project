<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Registrar\Entities\SemesterFee;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_level_modes', function (Blueprint $table) {
            $table->string('course_level_mode_id');
            $table->string('course_id');
            $table->string('level_id');
            $table->string('attendance_id');
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
        Schema::dropIfExists('course_level_modes');
    }
};
