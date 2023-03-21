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
        Schema::create('course_transfer_approvals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('course_transfer_id');
            $table->integer('cod_status');
            $table->mediumText('cod_remarks')->nullable();
            $table->integer('dean_status')->nullable();
            $table->mediumText('dean_remarks')->nullable();
            $table->integer('registrar_status')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_transfer_approvals');
    }
};
