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
        Schema::create('readmission_approvals', function (Blueprint $table) {
            $table->string('approval_id', 12)->primary();
            $table->string('readmission_id', 12);
            $table->foreign('readmission_id')->references('readmission_id')->on('readmissions')->onDelete('cascade')->onUpdate('cascade');
            $table->tinyInteger('cod_status');
            $table->string('cod_remarks', 64);
            $table->tinyInteger('dean_status')->nullable();
            $table->string('dean_remarks', 64)->nullable();
            $table->tinyInteger('registrar_status')->nullable();
            $table->string('registrar_remarks', 64)->nullable();
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
        Schema::dropIfExists('readmission_approvals');
    }
};
