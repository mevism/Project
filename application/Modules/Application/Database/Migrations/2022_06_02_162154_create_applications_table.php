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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->integer('intake_id');
            $table->integer('student_type');
            $table->integer('school_id');
            $table->integer('department_id');
            $table->integer('course_id');
            $table->string('subject_1')->nullable();
            $table->string('subject_2')->nullable();
            $table->string('subject_3')->nullable();
            $table->string('subject_4')->nullable();
            $table->string('campus')->nullable();
            $table->string('receipt')->nullable();
            $table->string('receipt_file')->nullable();
            $table->tinyInteger('declaration')->nullable();
            $table->integer('finance_status')->nullable();
            $table->string('finance_comments')->nullable();
            $table->integer('cod_status')->nullable();
            $table->string('cod_comments')->nullable();
            $table->integer('dean_status')->nullable();
            $table->string('dean_comments')->nullable();
            $table->integer('registrar_comments')->nullable();
            $table->integer('registrar_status')->nullable();
            $table->integer('status')->nullable();
            $table->string('ref_number')->nullable();
            $table->string('reg_number')->nullable();
            $table->string('adm_letter')->nullable();
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
        Schema::dropIfExists('applications');
    }
};
