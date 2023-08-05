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
            $table->string('votehead_id', 12)->primary();
            $table->string('vote', 12)->unique();
            $table->string('vote_name', 50)->unique();
            $table->string('vote_category', 50);
            $table->tinyInteger('vote_type', 4);
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
