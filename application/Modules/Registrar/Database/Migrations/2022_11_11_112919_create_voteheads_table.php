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
        Schema::create('voteheads', function (Blueprint $table) {
            $table->string('votehead_id', 12)->primary();
            $table->string('vote_id', 8)->unique();
            $table->string('vote_name', 32)->unique();
            $table->string('vote_category', 32)->unique();
            $table->string('vote_type', 32)->unique();
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
