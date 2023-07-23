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
        Schema::create('applicant_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('applicant_id');
            $table->foreign('applicant_id')->references('applicant_id')->on('applicant_contacts')->onUpdate('cascade')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('fname')->nullable();
            $table->string('mname')->nullable();
            $table->string('sname')->nullable();
            $table->string('gender')->nullable();
            $table->string('marital_status')->nullable();
            $table->date('DOB')->nullable();
            $table->string('index_number')->unique()->nullable();
            $table->string('id_number')->unique()->nullable();
            $table->string('disabled')->nullable();
            $table->string('disability')->nullable();
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
        Schema::dropIfExists('applicant_infos');
    }
};
