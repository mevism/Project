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
        Schema::create('unit_programms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('course_code', 8);
            $table->string('course_unit_code', 8);
            $table->string('unit_name', 100);
            $table->tinyInteger('stage')->nullable();
            $table->string('semester', 11)->nullable();
            $table->string('type', 16)->nullable();
            $table->string('version', 8)->nullable();
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
        Schema::dropIfExists('unit_programms');
    }
};
