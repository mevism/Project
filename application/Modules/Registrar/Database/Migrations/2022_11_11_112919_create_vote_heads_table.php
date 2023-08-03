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
        Schema::create('vote_heads', function (Blueprint $table) {
            $table->string('votehead_id')->primary();
            $table->string('vote_id')->primary();
            $table->string('vote_name')->primary();
            $table->string('vote_category')->primary();
            $table->string('vote_type')->primary();
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
        Schema::dropIfExists('vote_heads');
    }
};
