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
        Schema::create('deferred_classes', function (Blueprint $table) {
            $table->string('differed_class_id')->primary();
            $table->string('leave_id');
            $table->foreign('leave_id')->references('leave_id')->on('academic_leaves')->onDelete('cascade')->onUpdate('cascade');
            $table->string('differed_class');
            $table->string('differed_year');
            $table->string('differed_semester');
            $table->string('stage');
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
        Schema::dropIfExists('deferred_classes');
    }
};
