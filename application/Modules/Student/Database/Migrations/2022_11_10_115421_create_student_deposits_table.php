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
            $table->string('reg_number');     
            $table->integer('deposit');
            $table->mediumText('description');
            $table->string('invoice_number')->unique();
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
