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
            $table->string('course_transfer_id', 12)->primary();
            $table->tinyInteger('cod_status');
            $table->mediumText('cod_remarks', 64)->nullable();
            $table->tinyInteger('dean_status')->nullable();
            $table->mediumText('dean_remarks', 64)->nullable();
            $table->tinyInteger('registrar_status')->nullable();
            $table->mediumText('registrar_remarks', 64)->nullable();
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('course_transfer_approvals');
    }
};
