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
        Schema::create('intake_years', function (Blueprint $table) {
            $table->bigIncrements('intake_years_id');
            $table->integer('courses_id')->nullable();
            $table->integer('intake_id')->nullable();
            $table->integer('years')->nullable();
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
        Schema::dropIfExists('intake_years');
    }
};
