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
        Schema::create('applicants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('index_number')->unique()->nullable();
            $table->string('id_number')->unique()->nullable();
            $table->string('password');
            $table->string('username');
            $table->string('email')->unique()->nullable();
            $table->string('alt_email')->nullable();
            $table->string('sname')->nullable();
            $table->string('mname')->nullable();
            $table->string('fname')->nullable();
            $table->string('gender')->nullable();
            $table->tinyInteger('phone_verification')->nullable();
            $table->string('marital_status')->nullable();
            $table->date('email_verified_at')->nullable();
            $table->string('mobile')->nullable();
            $table->string('alt_mobile')->nullable();
            $table->date('DOB')->nullable();
            $table->string('disabled')->nullable();
            $table->string('disability')->nullable();
            $table->string('title')->nullable();
            $table->string('nationality')->nullable();
            $table->string('county')->nullable();
            $table->string('sub_county')->nullable();
            $table->string('town')->nullable();
            $table->string('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('remember_token')->nullable();
            $table->integer('student_type')->nullable();
            $table->tinyInteger('user_status')->default(0);
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
        Schema::dropIfExists('applicants');
    }
};
