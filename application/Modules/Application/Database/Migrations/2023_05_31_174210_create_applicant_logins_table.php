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
        Schema::create('applicant_logins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('applicant_id', 32);
            $table->foreign('applicant_id')->references('applicant_id')->on('applicant_contacts')->onUpdate('cascade')->onDelete('cascade');
            $table->string('username', 100);
            $table->string('password', 150);
            $table->tinyInteger('user_status')->default(0);
            $table->tinyInteger('student_type')->nullable();
            $table->date('email_verified_at')->nullable();
            $table->tinyInteger('phone_verification')->nullable();
            $table->rememberToken(150);
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
        Schema::dropIfExists('applicant_logins');
    }
};
