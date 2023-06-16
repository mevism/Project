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
        Schema::create('application_approvals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('applicant_id');
            $table->string('application_id');
            $table->integer('finance_status')->nullable();
            $table->string('invoice_number')->nullable();
            $table->integer('cod_status')->nullable();
            $table->string('cod_comments')->nullable();
            $table->integer('dean_status')->nullable();
            $table->string('dean_comments')->nullable();
            $table->string('registrar_comments')->nullable();
            $table->integer('registrar_status')->nullable();
            $table->string('reg_number')->nullable();
            $table->string('admission_letter')->nullable();
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
        Schema::dropIfExists('application_approvals');
    }
};
