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
            $table->string('applicant_id', 12);
            $table->foreign('applicant_id')->references('applicant_id')->on('applicant_contacts')->onUpdate('cascade')->onDelete('cascade');
            $table->string('title', 8)->nullable();
            $table->string('first_name', 16)->nullable();
            $table->string('middle_name', 16)->nullable();
            $table->string('surname', 16)->nullable();
            $table->string('gender', 8)->nullable();
            $table->string('marital_status', 16)->nullable();
            $table->date('date_of_birth', 16)->nullable();
            $table->string('index_number', 16)->unique()->nullable();
            $table->string('type', 16)->unique()->nullable();
            $table->string('identification', 16)->unique()->nullable();
            $table->string('disabled', 8)->nullable();
            $table->string('disability', 32)->nullable();
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
