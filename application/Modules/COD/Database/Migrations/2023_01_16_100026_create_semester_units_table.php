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
        Schema::create('semester_units', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('class_code', 20);
            $table->string('unit_code', 16);
            $table->string('unit_name', 64);
            $table->tinyInteger('stage');
            $table->tinyInteger('semester');
            $table->string('type', 10)->nullable();
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
        Schema::dropIfExists('semester_units');
    }
};
