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
        Schema::create('finance_logs', function (Blueprint $table) {
            $table->id();
            $table->string('application_id');
            $table->foreign('application_id')->references('application_id')->on('applications')->onDelete('cascade')->onUpdate('cascade');
            $table->string('user');
            $table->string('user_role');
            $table->string('activity');
            $table->string('comments')->nullable();
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
        Schema::dropIfExists('finance_logs');
    }
};
