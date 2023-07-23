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
        Schema::create('readmission_classes', function (Blueprint $table) {
            $table->string('readmission_class_id')->primary();
            $table->string('readmission_id');
            $table->foreign('readmission_id')->references('readmission_id')->on('readmissions')->onDelete('cascade')->onUpdate('cascade');
            $table->string('readmission_class');
            $table->string('readmission_year');
            $table->string('readmission_semester');
            $table->string('stage');
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
        Schema::dropIfExists('readmission_classes');
    }
};
