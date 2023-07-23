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
        Schema::create('student_addresses', function (Blueprint $table) {
            $table->string('student_id')->primary();
            $table->foreign('student_id')->references('student_id')->on('student_logins')->onDelete('cascade')->onUpdate('cascade');            $table->string('citizen');
            $table->string('county');
            $table->string('sub_county');
            $table->string('town');
            $table->string('address');
            $table->string('postal_code');
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
        Schema::dropIfExists('student_addresses');
    }
};
