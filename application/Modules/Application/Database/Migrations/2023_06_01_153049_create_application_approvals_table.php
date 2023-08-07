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
            $table->string('application_id', 12);
            $table->foreign('application_id')->references('application_id')->on('applications')->onUpdate('cascade')->onDelete('cascade');
            $table->tinyInteger('finance_status')->nullable();
            $table->string('transaction_number', 32)->nullable();
            $table->tinyInteger('cod_status')->nullable();
            $table->string('cod_comments', 64)->nullable();
            $table->tinyInteger('dean_status')->nullable();
            $table->string('dean_comments', 64)->nullable();
            $table->tinyInteger('registrar_status')->nullable();
            $table->string('registrar_comments', 64)->nullable();
            $table->string('admission_letter', 64)->nullable();
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
