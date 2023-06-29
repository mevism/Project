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
        Schema::create('course_transfers', function (Blueprint $table) {
            $table->string('course_transfer_id');
            $table->string('student_id');
            $table->string('intake_id');
            $table->string('course_id');
            $table->string('class_id');
            $table->string('department_id');
            $table->string('class_points');
            $table->string('student_points');
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('course_transfers');
    }
};
