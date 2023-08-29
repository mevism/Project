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
        Schema::create('applicant_details_view', function (Blueprint $table) {
            $table->string('applicant_id')->nullable();
            $table->string('application_id')->nullable();
            $table->string('index_number');
            $table->string('surname');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('gender');
            $table->string('mobile')->nullable();
            $table->string('alt_mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('alt_email')->nullable();
            $table->string('box')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('intake_id')->nullable();
            $table->string('course_code')->nullable();
            $table->string('course_name')->nullable();
            $table->string('level')->nullable();
            $table->string('town')->nullable();
            $table->string('address')->nullable();
            $table->string('ref_number')->nullable();
            $table->string('class')->nullable();
            $table->string('id_number')->nullable();
            $table->string('campus')->nullable();
            $table->string('title')->nullable();
            $table->string('date_of_birth')->nullable();
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
        Schema::dropIfExists('applicant_details_view');
    }
};
