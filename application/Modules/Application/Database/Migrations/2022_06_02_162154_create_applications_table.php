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
            $table->string('school');
            $table->string('department');
            $table->string('course');
            $table->string('subject_1');
            $table->string('subject_2');
            $table->string('subject_3');
            $table->string('subject_4');
            $table->string('receipt')->nullable();
            $table->string('receipt_file')->nullable();
            $table->integer('finance_status')->nullable();
            $table->string('finance_comments')->nullable();
            $table->integer('cod_status')->nullable();
            $table->string('cod_comments')->nullable();
            $table->integer('dean_status')->nullable();
            $table->string('dean_comments')->nullable();
            $table->integer('registrar_status')->nullable();
            $table->tinyInteger('declaration')->default(1);
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
