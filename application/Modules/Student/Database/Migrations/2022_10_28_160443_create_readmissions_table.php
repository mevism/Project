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
        Schema::create('readmissions', function (Blueprint $table) {
            $table->string('readmision_id ');
            $table->string('student_id');
            $table->string('leave_id');
            $table->string('academic_year');
            $table->string('academic_semester');
            $table->string('intake_id');
            $table->tinyInteger('status')->nullable();
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
        Schema::dropIfExists('readmissions');
    }
};
