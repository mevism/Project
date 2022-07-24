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
        Schema::create('course_transfer_logs', function (Blueprint $table) {
            $table->bigIncrements('course_transfer_logs_id');
            $table->integer('course_transfer_id')->nullable();
            $table->string('level')->nullable();
            $table->integer('status')->nullable();
            $table->string('reason')->nullable();
            $table->date('date');
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
        Schema::dropIfExists('course_transfer_logs');
    }
};
