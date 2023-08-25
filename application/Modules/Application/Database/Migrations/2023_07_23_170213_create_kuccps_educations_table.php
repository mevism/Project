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
            $table->string('applicant_id',12);
            $table->foreign('applicant_id')->references('applicant_id')->on('kuccps_applicants')->onUpdate('cascade')->onDelete('cascade');
            $table->string('institution', 64);
            $table->string('qualification', 16);
            $table->string('level', 16);
            $table->date('start_date', 10);
            $table->string('exit_date', 10);
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
