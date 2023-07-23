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
                $table->string('applicant_id')->primary();
                $table->string('index_number');
                $table->string('sname');
                $table->string('fname');
                $table->string('mname')->nullable();
                $table->string('gender');
                $table->string('mobile')->nullable();
                $table->string('alt_mobile')->nullable();
                $table->string('email')->nullable();
                $table->string('alt_email')->nullable();
                $table->string('BOX')->nullable();
                $table->string('postal_code')->nullable();
                $table->string('town')->nullable();
                $table->string('school');
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
