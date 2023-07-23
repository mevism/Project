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
        Schema::create('staff_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('staff_number')->unique();
            $table->text('title');
            $table->text('first_name');
            $table->text('middle_name')->nullable();
            $table->text('last_name');
            $table->string('gender');
            $table->string('phone_number')->unique();
            $table->string('office_email')->nullable();
            $table->string('personal_email')->unique();
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
        Schema::dropIfExists('staff_infos');
    }
};
