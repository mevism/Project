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
        Schema::create('qualification_remarks', function (Blueprint $table) {
            $table->string('qualification_id', 12)->primary();
            $table->foreign('qualification_id')->references('qualification_id')->on('lecturer_qualifications')->onDelete('cascade')->onUpdate('cascade');
            $table->longText('remarks', 64);
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
        Schema::dropIfExists('qualification_remarks');
    }
};
