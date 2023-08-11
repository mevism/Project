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
        Schema::create('student_logins', function (Blueprint $table) {
            $table->string('student_id', 12);
            $table->foreign('student_id')->references('student_id')->on('student_courses')->onUpdate('cascade')->onDelete('cascade');
            $table->string('username', 100);
            $table->rememberToken(150);
            $table->string('password', 150);
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
        Schema::dropIfExists('student_logins');
    }
};
