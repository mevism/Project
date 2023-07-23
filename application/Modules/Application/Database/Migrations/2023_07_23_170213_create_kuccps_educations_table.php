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
        Schema::create('kuccps_educations', function (Blueprint $table) {
            $table->string('applicant_id');
            $table->foreign('applicant_id')->references('applicant_id')->on('kuccps_applicants')->onUpdate('cascade')->onDelete('cascade');
            $table->string('institution');
            $table->string('qualification');
            $table->string('level');
            $table->string('start_date');
            $table->string('exit_date');
            $table->string('certificate')->nullable();
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
        Schema::dropIfExists('kuccps_educations');
    }
};
