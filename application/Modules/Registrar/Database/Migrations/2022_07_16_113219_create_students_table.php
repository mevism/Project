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
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reg_number')->unique();
            $table->string('ref_number')->unique();
            $table->string('sname');
            $table->string('fname');
            $table->string('mname');
            $table->string('gender');
            $table->string('marital_status');
            $table->string('title');
            $table->string('dob');
            $table->string('email')->unique();
            $table->string('student_email')->unique();
            $table->string('mobile')->unique();
            $table->string('alt_mobile');
            $table->string('id_number')->unique();
            $table->string('citizen');
            $table->string('county');
            $table->string('sub_county');
            $table->string('town');
            $table->string('address');
            $table->string('postal_code');
            $table->string('disabled');
            $table->string('disability')->nullable();
            $table->string('status')->default(1);
            $table->string('ID_photo')->nullable();
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
        Schema::dropIfExists('students');
    }
};
