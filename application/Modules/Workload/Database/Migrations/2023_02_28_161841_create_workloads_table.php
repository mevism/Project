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
            $table->string('workload_id');
            $table->string('department_id');
            $table->string('academic_year');
            $table->string('academic_semester');
            $table->string('user_id');
            $table->string('unit_id');
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
