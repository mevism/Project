<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_employments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id');
            $table->foreign('user_id')->references('user_id')->on('users')->onUpdate('no action')->onDelete('no action');
            $table->string('role_id');
            $table->string('campus_id');
            $table->foreign('campus_id')->references('campus_id')->on('campuses')->onUpdate('no action')->onDelete('no action');
            $table->string('division_id');
            $table->foreign('division_id')->references('division_id')->on('divisions')->onUpdate('no action')->onDelete('no action');
            $table->string('department_id');
            $table->foreign('department_id')->references('department_id')->on('departments')->onUpdate('no action')->onDelete('no action');
            $table->string('station_id');
            $table->string('employment_terms');
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
        Schema::dropIfExists('user_employements');
    }
};
