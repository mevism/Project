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
        Schema::create('applications', function (Blueprint $table) {
            $table->string('application_id')->primary();
            $table->string('applicant_id');
            $table->foreign('applicant_id')->references('applicant_id')->on('applicant_contacts')->onUpdate('cascade')->onDelete('cascade');
            $table->string('ref_number')->nullable();
            $table->string('intake_id');
            $table->string('student_type');
            $table->string('campus_id')->nullable();
            $table->string('school_id');
            $table->string('department_id');
            $table->string('course_id');
            $table->tinyInteger('declaration')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('applications');
    }
};
