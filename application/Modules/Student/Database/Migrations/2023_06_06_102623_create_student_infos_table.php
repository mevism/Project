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
        Schema::create('student_infos', function (Blueprint $table) {
            $table->string('student_id')->primary();
            $table->foreign('student_id')->references('student_id')->on('student_logins')->onDelete('cascade')->onUpdate('cascade');            $table->string('sname');
            $table->string('fname');
            $table->string('mname');
            $table->string('gender');
            $table->string('marital_status');
            $table->string('title');
            $table->string('dob');
            $table->string('disabled');
            $table->string('id_number');
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
        Schema::dropIfExists('student_infos');
    }
};
