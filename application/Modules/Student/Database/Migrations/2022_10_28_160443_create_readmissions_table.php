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
        Schema::create('readmissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('student_id');
            $table->bigInteger('course_id');
            $table->longText('reason');
            $table->tinyInteger('cod_status')->nullable();
            $table->longText('cod_remarks')->nullable();
            $table->tinyInteger('dean_status')->nullable();
            $table->longText('dean_remarks')->nullable();
            $table->tinyInteger('registrar_status')->nullable();
            $table->longText('registrar_remarks')->nullable();
            $table->tinyInteger('status')->nullable();
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
        Schema::dropIfExists('readmissions');
    }
};
