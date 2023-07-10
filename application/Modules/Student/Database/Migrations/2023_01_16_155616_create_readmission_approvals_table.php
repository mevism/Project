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
            $table->string('approval_id ');
            $table->string('readmission_id');
            $table->integer('cod_status');
            $table->string('cod_remarks');
            $table->integer('dean_status')->nullable();
            $table->string('dean_remarks')->nullable();
            $table->integer('registrar_status')->nullable();
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
