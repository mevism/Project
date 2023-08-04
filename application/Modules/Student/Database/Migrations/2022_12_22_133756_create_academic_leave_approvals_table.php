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
            $table->string('leave_approval_id', 12)->primary();
            $table->string('leave_id', 12);
            $table->foreign('leave_id')->references('leave_id')->on('academic_leaves')->onDelete('cascade')->onUpdate('cascade');
            $table->tinyInteger('cod_status');
            $table->mediumText('cod_remarks', 64);
            $table->tinyInteger('dean_status')->nullable();
            $table->mediumText('dean_remarks', 64)->nullable();
            $table->tinyInteger('registrar_status')->nullable();
            $table->mediumText('registrar_remarks', 64)->nullable();
            $table->tinyInteger('status');
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
