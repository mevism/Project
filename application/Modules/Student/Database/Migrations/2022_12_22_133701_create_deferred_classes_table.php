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
            $table->string('differed_class_id', 12)->primary();
            $table->string('leave_id', 12);
            $table->foreign('leave_id')->references('leave_id')->on('academic_leaves')->onDelete('cascade')->onUpdate('cascade');
            $table->string('differed_class', 20);
            $table->string('differed_year', 10);
            $table->string('differed_semester', 10);
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
