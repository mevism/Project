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
            $table->string('readmission_class_id', 12)->primary();
            $table->string('readmission_id', 12);
            $table->foreign('readmission_id')->references('readmission_id')->on('readmissions')->onDelete('cascade')->onUpdate('cascade');
            $table->string('readmission_class', 20);
            $table->string('readmission_year', 10);
            $table->string('readmission_semester', 10);
            $table->string('stage', 4);
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
