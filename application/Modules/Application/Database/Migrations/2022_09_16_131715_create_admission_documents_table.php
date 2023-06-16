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
            $table->id();
            $table->string('applicant_id');
            $table->string('application_id');
            $table->string('certificates')->nullable();
            $table->string('bank_receipt')->nullable();
            $table->string('medical_form')->nullable();
            $table->string('passport_photo')->nullable();
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
