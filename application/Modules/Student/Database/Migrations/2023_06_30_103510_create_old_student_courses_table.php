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
        Schema::create('old_student_courses', function (Blueprint $table) {
            $table->string('student_id', 12)->primary();
            $table->foreign('student_id')->references('student_id')->on('student_courses')->onDelete('cascade')->onUpdate('cascade');   
            $table->string('current_class', 20);
            // $table->foreign('current_class')->references('name')->on('classes')->onDelete('cascade')->onUpdate('cascade');             
            $table->string('student_number', 16);
            $table->string('reference_number', 16);
            $table->string('student_type', 2);                        
            $table->string('entry_class', 20);
            $table->integer('status')->default(2);
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
        Schema::dropIfExists('old_student_courses');
    }
};
