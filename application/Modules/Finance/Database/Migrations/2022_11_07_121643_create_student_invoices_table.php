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
        Schema::create('student_invoices', function (Blueprint $table) {
            $table->string('invoice_id')->primary();
            $table->string('student_id');
            $table->foreign('student_id')->references('student_id')->on('student_contacts')->onDelete('cascade')->onUpdate('cascade');
            $table->string('reg_number');
            $table->string('invoice_number');
            $table->string('stage');
            $table->string('amount');
            $table->mediumText('description');
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
        Schema::dropIfExists('student_invoices');
    }
};
