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
        Schema::create('admission_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('application_id', 32);
            $table->foreign('application_id')->references('application_id')->on('applications')->onUpdate('cascade')->onDelete('cascade');
            $table->string('certificates', 64)->nullable();
            $table->string('bank_receipt', 64)->nullable();
            $table->string('medical_form', 64)->nullable();
            $table->string('passport_photo', 64)->nullable();
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('admission_documents');
    }
};
