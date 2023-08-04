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
        Schema::create('departments', function (Blueprint $table) {
            $table->string('department_id', 12)->primary();
            $table->string('division_id', 12);
            $table->foreign('division_id')->references('division_id')->on('divisions')->onUpdate('cascade')->onDelete('cascade');
            $table->string('dept_code', 8)->unique();
            $table->string('name', 64)->unique();
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
        Schema::dropIfExists('departments');
    }
};
