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
        Schema::create('exam_workflows', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('academic_year');
            $table->string('academic_semester');
            $table->integer('cod_status')->nullable();
            $table->string('cod_remarks');
            $table->integer('dean_status')->nullable();
            $table->string('dean_remarks');
            $table->integer('registrar_status')->nullable();
            $table->string('registrar_remarks');
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('exam_workflows');
    }
};
