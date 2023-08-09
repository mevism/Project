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
        Schema::create('intakes', function (Blueprint $table) {
            $table->string('intake_id', 12)->primary();
            $table->string('academic_year_id', 12);
            $table->foreign('academic_year_id')->references('year_id')->on('academic_years')->onUpdate('cascade')->onDelete('cascade');
            $table->string('intake_from', 40)->unique();
            $table->string('intake_to', 40)->unique();
            $table->integer('status');
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
        Schema::dropIfExists('intakes');
    }
};
