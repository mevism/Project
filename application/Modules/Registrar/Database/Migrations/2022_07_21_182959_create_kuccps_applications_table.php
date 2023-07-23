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
            $table->bigIncrements('id');
            $table->string('applicant_id');
            $table->foreign('applicant_id')->references('applicant_id')->on('applicant_contacts')->onUpdate('cascade')->onDelete('cascade');
            $table->string('intake_id');
            $table->foreign('intake_id')->references('intake_id')->on('intakes')->onUpdate('cascade')->onDelete('cascade');
            $table->string('course_code');
            $table->string('course_name');
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
