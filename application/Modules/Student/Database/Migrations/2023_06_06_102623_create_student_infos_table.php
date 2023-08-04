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
            $table->string('student_id', 12)->primary();
            $table->foreign('student_id')->references('student_id')->on('student_logins')->onDelete('cascade')->onUpdate('cascade');            $table->string('sname');
            $table->string('first_name', 16);
            $table->string('middle_name', 16);
            $table->string('gender', 8);
            $table->string('marital_status', 16);
            $table->string('title', 8);
            $table->string('date_of_birth', 13);
            $table->string('disabled', 4);
            $table->string('id_number', 10);
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
