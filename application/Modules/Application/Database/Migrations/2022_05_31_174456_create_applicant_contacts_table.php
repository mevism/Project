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
        Schema::create('applicant_contacts', function (Blueprint $table) {
            $table->string('applicant_id', 12)->primary();
            $table->string('email', 32)->nullable();
            $table->string('alt_email', 32)->nullable();
            $table->string('mobile', 16)->nullable();
            $table->string('alt_mobile', 16)->nullable();
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
        Schema::dropIfExists('applicant_contacts');
    }
};
