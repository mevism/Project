<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('staff_number')->unique();
            $table->text('title');
            $table->text('first_name');
            $table->text('middle_name');
            $table->text('last_name');
            $table->string('phone_number')->unique();
            $table->string('office_email')->unique();
            $table->string('personal_email')->unique();
            $table->string('gender');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('remember_token');
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
        Schema::dropIfExists('users');
    }
};
