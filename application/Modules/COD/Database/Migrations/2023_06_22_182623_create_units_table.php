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
        Schema::create('units', function (Blueprint $table) {
            $table->string('unit_id')->primary();
            $table->string('department_id');
            $table->foreign('department_id')->references('department_id')->on('departments')->onUpdate('cascade')->onDelete('cascade');
            $table->string('unit_code');
            $table->string('unit_name');
            $table->string('type');
            $table->integer('total_exam');
            $table->integer('total_cat');
            $table->integer('cat');
            $table->integer('assignment')->default(0);
            $table->integer('practical')->default(0);
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
        Schema::dropIfExists('units');
    }
};
