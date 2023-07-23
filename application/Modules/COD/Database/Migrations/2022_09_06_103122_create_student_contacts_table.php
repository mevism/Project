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
        Schema::create('student_contacts', function (Blueprint $table) {
            $table->string('student_id')->primary();
            $table->foreign('student_id')->references('student_id')->on('student_logins')->onDelete('cascade')->onUpdate('cascade');
            $table->string('email');
            $table->string('alt_email');
            $table->string('student_email');
            $table->string('mobile');
            $table->string('alt_mobile');
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
        Schema::dropIfExists('student_contacts');
    }
};
