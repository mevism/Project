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
        Schema::create('c_o_d_logs', function (Blueprint $table) {
            $table->id();
            $table->string('application_id');
            $table->foreign('application_id')->references('application_id')->on('applications')->onUpdate('cascade')->onDelete('cascade');
            $table->string('user');
            $table->string('user_role');
            $table->string('activity');
            $table->string('comments')->nullable();
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
        Schema::dropIfExists('c_o_d_logs');
    }
};
