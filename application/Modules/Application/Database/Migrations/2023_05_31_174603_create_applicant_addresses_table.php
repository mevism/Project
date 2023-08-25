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
        Schema::create('applicant_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('applicant_id', 12);
            $table->foreign('applicant_id')->references('applicant_id')->on('applicant_contacts')->onUpdate('cascade')->onDelete('cascade');
            $table->string('nationality', 16)->nullable();
            $table->string('county', 16)->nullable();
            $table->string('sub_county', 16)->nullable();
            $table->string('town', 16)->nullable();
            $table->string('address', 16)->nullable();
            $table->string('postal_code', 16)->nullable();
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
        Schema::dropIfExists('applicant_addresses');
    }
};
