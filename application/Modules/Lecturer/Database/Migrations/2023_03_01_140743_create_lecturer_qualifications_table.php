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
        Schema::create('lecturer_qualifications', function (Blueprint $table) {
            $table->string('qualification_id')->primary();
            $table->string('user_id');
            $table->foreign('user_id')->references('user_id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('institution');
            $table->string('qualification');
            $table->integer('level');
            $table->integer('status');
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
        Schema::dropIfExists('lecturer_qualifications');
    }
};
