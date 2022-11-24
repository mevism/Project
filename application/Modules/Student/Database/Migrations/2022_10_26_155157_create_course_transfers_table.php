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
        Schema::create('course_transfers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('student_id');
            $table->integer('course_id');
            $table->integer('class_id');
            $table->integer('department_id');
            $table->float('points');
            $table->integer('cod_status')->nullable();
            $table->longText('cod_remarks')->nullable();
            $table->integer('dean_status')->nullable();
            $table->longText('dean_remarks')->nullable();
            $table->integer('registrar_status')->nullable();
            $table->longText('registrar_remarks')->nullable();
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
        Schema::dropIfExists('course_transfers');
    }
};
