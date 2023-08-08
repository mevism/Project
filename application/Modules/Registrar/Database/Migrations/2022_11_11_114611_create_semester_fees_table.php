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
        Schema::create('semester_fees', function (Blueprint $table) {
            $table->string('semester_fee_id', 12)->primary();
            $table->string('course_code', 8);
            $table->foreign('course_code')->references('course_code')->on('courses')->onUpdate('cascade')->onDelete('cascade');
            $table->string('vote_id', 12);
            $table->foreign('vote_id')->references('votehead_id')->on('voteheads')->onUpdate('cascade')->onDelete('cascade');
            $table->float('semester');
            $table->unsignedBigInteger('attendance_id');
//            $table->foreign('attendance_id')->references('id')->on('attendances')->onUpdate('cascade')->onDelete('cascade');
            $table->float('amount');
            $table->string('version', 8);
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
        Schema::dropIfExists('semester_fees');
    }
};
