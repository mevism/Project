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
        Schema::create('teaching_area_remarks', function (Blueprint $table) {
            $table->string('teaching_area_id', 12)->primary();
            $table->foreign('teaching_area_id')->references('teaching_area_id')->on('teaching_areas')->onDelete('cascade')->onUpdate('cascade');
            $table->longText('remarks', 64);
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
        Schema::dropIfExists('teaching_area_remarks');
    }
};
