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
        Schema::create('workloads', function (Blueprint $table) {
            $table->string('workload_id')->primary();
            $table->string('academic_year');
            $table->foreign('academic_year')->references('year_id')->on('academic_years')->onUpdate('cascade')->onDelete('cascade');
            $table->string('department_id');
            $table->foreign('department_id')->references('department_id')->on('departments')->onUpdate('cascade')->onDelete('cascade');
            $table->string('user_id');
            $table->foreign('user_id')->references('user_id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('unit_id');
            // $table->foreign('unit_id')->references('unit_id')->on('units')->onUpdate('cascade')->onDelete('cascade');
            $table->string('academic_semester');  
            $table->string('class_code');
            $table->string('workload_approval_id')->nullable();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('workloads');
    }
};
