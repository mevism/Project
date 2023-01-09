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
        Schema::create('academic_leave_approvals', function (Blueprint $table) {
            $table->id();
            $table->string('academic_leave_id');
            $table->integer('cod_status');
            $table->mediumText('cod_remarks');
            $table->integer('dean_status')->nullable();
            $table->mediumText('dean_remarks')->nullable();
            $table->integer('registrar_status')->nullable();
            $table->integer('status');
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
        Schema::dropIfExists('academic_leave_approvals');
    }
};
