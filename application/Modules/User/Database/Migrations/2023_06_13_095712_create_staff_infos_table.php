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
            $table->string('user_id',12);
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('staff_number', 11)->unique();
            $table->text('title', 8);
            $table->text('first_name', 16);
            $table->text('middle_name', 16)->nullable();
            $table->text('last_name', 16);
            $table->string('gender', 8);
            $table->string('phone_number', 13)->unique();
            $table->string('office_email', 32)->nullable();
            $table->string('personal_email', 32)->unique();
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
