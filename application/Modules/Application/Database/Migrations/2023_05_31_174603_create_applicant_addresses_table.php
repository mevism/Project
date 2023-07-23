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
            $table->string('applicant_id');
            $table->foreign('applicant_id')->references('applicant_id')->on('applicant_contacts')->onUpdate('cascade')->onDelete('cascade');
            $table->string('nationality')->nullable();
            $table->string('county')->nullable();
            $table->string('sub_county')->nullable();
            $table->string('town')->nullable();
            $table->string('address')->nullable();
            $table->string('postal_code')->nullable();
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
