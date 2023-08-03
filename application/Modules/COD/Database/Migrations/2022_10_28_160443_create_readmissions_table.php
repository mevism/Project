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
            $table->string('readmission_id')->primary();
            $table->string('intake_id');
            $table->foreign('intake_id')->references('intake_id')->on('intakes')->onDelete('no action')->onUpdate('no action');
            $table->string('student_id');
            $table->foreign('student_id')->references('student_id')->on('student_contacts')->onUpdate('no action')->onDelete('no action');
            $table->string('leave_id');
            $table->foreign('leave_id')->references('leave_id')->on('academic_leaves')->onDelete('no action')->onUpdate('no action');
            $table->string('academic_year');
            $table->string('academic_semester');
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
