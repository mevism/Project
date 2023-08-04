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
            $table->string('class_pattern_id', 12)->primary();
            $table->unsignedBigInteger('pattern_id');
            $table->foreign('pattern_id')->references('id')->on('patterns')->onDelete('cascade')->onUpdate('cascade');
            $table->string('class_code', 20);
            $table->string('academic_year', 10);
            $table->tinyInteger('stage');            
            $table->string('period', 10);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('semester', 5);
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
