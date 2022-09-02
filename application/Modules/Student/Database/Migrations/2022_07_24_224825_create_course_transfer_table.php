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
        Schema::create('course_transfer', function (Blueprint $table) {
            $table->bigIncrements('course_transfer_id');
            $table->integer('applicant_id')->nullable();
            $table->integer('course_id')->nullable();
            $table->integer('COD')->nullable();
            $table->integer('DEAN')->nullable();
            $table->integer('REGISTRAR')->nullable();
            $table->integer('status')->nullable();
            $table->integer('cut_off')->nullable();
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
        Schema::dropIfExists('course_transfer');
    }
};
