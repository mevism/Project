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
            $table->string('readmission_id', 12)->primary();
            $table->string('intake_id', 12);
            $table->foreign('intake_id')->references('intake_id')->on('intakes')->onDelete('cascade')->onUpdate('cascade');
            $table->string('leave_id', 12);
            $table->foreign('leave_id')->references('leave_id')->on('academic_leaves')->onDelete('cascade')->onUpdate('cascade');
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
