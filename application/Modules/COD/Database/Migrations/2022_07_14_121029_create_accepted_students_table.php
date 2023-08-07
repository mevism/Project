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
        Schema::create('accepted_students', function (Blueprint $table) {
            $table->string('accepted_student_id', 12);
            $table->string('applicant_id' , 12);
            $table->foreign('applicant_id')->references('applicant_id')->on('applicant_contacts')->onDelete('cascade')->onUpdate('cascade');
            $table->string('reference_number', 16);
            $table->string('student_number' , 16)->unique();
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
        Schema::dropIfExists('accepted_students');
    }
};
