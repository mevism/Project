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
            $table->string('user_id', 12);
            $table->foreign('user_id')->references('user_id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('role_id', 4);
            $table->string('campus_id', 12);
            $table->foreign('campus_id')->references('campus_id')->on('campuses')->onUpdate('cascade')->onDelete('cascade');
            $table->string('division_id', 12);
            $table->foreign('division_id')->references('division_id')->on('divisions')->onUpdate('cascade')->onDelete('cascade');
            $table->string('department_id', 12);
            $table->foreign('department_id')->references('department_id')->on('departments')->onUpdate('cascade')->onDelete('cascade');
            $table->string('station_id', 12);
            $table->string('employment_terms', 4);
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
