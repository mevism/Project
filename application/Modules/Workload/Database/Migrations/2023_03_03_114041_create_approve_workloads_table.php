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
        Schema::create('approve_workloads', function (Blueprint $table) {
            $table->string('workload_approval_id');
            $table->integer('dean_status')->nullable();
            $table->string('dean_remarks')->nullable();
            $table->integer('registrar_status')->nullable();
            $table->string('registrar_remarks')->nullable();
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
        Schema::dropIfExists('approve_workloads');
    }
};
