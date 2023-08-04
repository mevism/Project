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
            Schema::create('kuccps_applicants', function (Blueprint $table) {
                $table->string('applicant_id', 12)->primary();
                $table->string('index_number', 20);
                $table->string('surname', 16);
                $table->string('first_name',16);
                $table->string('middle_name', 16)->nullable();
                $table->string('gender', 8);
                $table->string('mobile', 13)->nullable();
                $table->string('alt_mobile', 13)->nullable();
                $table->string('email', 32)->nullable();
                $table->string('alt_email', 32)->nullable();
                $table->string('BOX', 8)->nullable();
                $table->string('postal_code', 8)->nullable();
                $table->string('town', 16)->nullable();
                $table->string('school', 32);
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
        Schema::dropIfExists('kuccps_applicants');
    }
};
