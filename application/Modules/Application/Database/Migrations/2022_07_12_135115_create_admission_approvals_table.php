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
        Schema::create('admission_approvals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('application_id');
            $table->string('applicant_id');
            $table->integer('cod_status')->default(0);
            $table->string('cod_comments')->nullable();
            $table->integer('finance_status')->nullable();
            $table->string('finance_comments')->nullable();
            $table->integer('registrar_status')->nullable();
            $table->string('registrar_comment')->nullable();
            $table->integer('medical_status')->nullable();
            $table->string('medical_comments')->nullable();
            $table->integer('accommodation_status')->nullable();
            $table->string('accommodation_comments')->nullable();
            $table->integer('status')->nullable();
            $table->integer('id_status')->nullable();
            $table->string('id_comments')->nullable();
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
        Schema::dropIfExists('admission_approvals');
    }
};
