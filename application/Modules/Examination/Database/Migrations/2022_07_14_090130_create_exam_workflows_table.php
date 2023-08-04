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
        Schema::create('exam_workflows', function (Blueprint $table) {
            $table->string('exam_approval_id', 12)->primary();
            $table->string('intake_id', 12);
            $table->foreign('intake_id')->references('intake_id')->on('intakes')->onDelete('cascade')->onUpdate('cascade');
            $table->tinyInteger('cod_status')->nullable();
            $table->string('cod_remarks', 64);
            $table->tinyInteger('dean_status')->nullable();
            $table->string('dean_remarks', 64);
            $table->tinyInteger('registrar_status')->nullable();
            $table->string('registrar_remarks', 64);
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
        Schema::dropIfExists('exam_workflows');
    }
};
