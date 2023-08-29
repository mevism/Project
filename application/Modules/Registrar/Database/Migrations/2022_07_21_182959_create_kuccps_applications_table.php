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
        Schema::create('kuccps_applications', function (Blueprint $table) {
            $table->string('applicant_id', 32)->primary();
            $table->foreign('applicant_id')->references('applicant_id')->on('kuccps_applicants')->onUpdate('cascade')->onDelete('cascade');
            $table->string('intake_id', 32);
            $table->foreign('intake_id')->references('intake_id')->on('intakes')->onUpdate('cascade')->onDelete('cascade');
            $table->string('course_code' , 8);
            $table->string('course_name', 50);
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
        Schema::dropIfExists('kuccps_applications');
    }
};
