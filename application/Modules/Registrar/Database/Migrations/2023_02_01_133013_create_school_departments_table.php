<?php

use Illuminate\Support\Facades\DB;
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
        Schema::create('school_departments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('school_id');
            $table->foreign('school_id')->references('school_id')->on('schools')->onUpdate('cascade')->onDelete('cascade');
            $table->string('department_id');
            $table->foreign('department_id')->references('department_id')->on('departments')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('school_departments');
    }
};
