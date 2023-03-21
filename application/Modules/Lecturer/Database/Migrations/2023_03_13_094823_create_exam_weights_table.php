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
        Schema::create('exam_weights', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('unit_code');
            $table->string('academic_year');
            $table->string('academic_semester');
            $table->integer('exam');
            $table->integer('cat');
            $table->integer('assignment');
            $table->integer('practical');
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
        Schema::dropIfExists('exam_weights');
    }
};
