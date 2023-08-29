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
        Schema::create('student_deposits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('student_id', 12);  
            $table->foreign('student_id')->references('student_id')->on('student_courses')->onDelete('cascade')->onUpdate('cascade');            
            $table->float('deposit');
            $table->mediumText('description', 64);
            $table->string('invoice_number', 16)->unique();
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
        Schema::dropIfExists('student_deposits');
    }
};
