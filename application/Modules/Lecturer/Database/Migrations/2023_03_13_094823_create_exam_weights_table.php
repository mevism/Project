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
        Schema::create('exam_weights', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('unit_code', 8);
            $table->foreign('unit_code')->references('unit_code')->on('units')->onDelete('cascade')->onUpdate('cascade');
            $table->string('intake_id', 32);
            $table->foreign('intake_id')->references('intake_id')->on('intakes')->onDelete('cascade')->onUpdate('cascade');            
            $table->float('exam');
            $table->float('cat');
            $table->float('assignment');
            $table->float('practical');
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
        Schema::dropIfExists('exam_weights');
    }
};
