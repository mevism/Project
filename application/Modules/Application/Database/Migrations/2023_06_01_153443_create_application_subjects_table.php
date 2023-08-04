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
        Schema::create('application_subjects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('application_id', 2);
            $table->foreign('application_id')->references('application_id')->on('applications')->onUpdate('cascade')->onDelete('cascade');
            $table->string('subject_1', 16)->nullable();
            $table->string('subject_2', 16)->nullable();
            $table->string('subject_3', 16)->nullable();
            $table->string('subject_4', 16)->nullable();
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
        Schema::dropIfExists('application_subjects');
    }
};
