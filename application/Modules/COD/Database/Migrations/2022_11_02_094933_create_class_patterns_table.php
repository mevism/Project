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
        Schema::create('class_patterns', function (Blueprint $table) {
            $table->string('class_pattern_id')->primary();
            $table->string('class_code');
            $table->string('academic_year');
            $table->integer('stage');
            $table->unsignedBigInteger('pattern_id');
            $table->foreign('pattern_id')->references('id')->on('patterns')->onDelete('cascade')->onUpdate('cascade');
            $table->string('period');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('semester');
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('class_patterns');
    }
};
