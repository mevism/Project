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
            $table->string('invoice_id', 12)->primary();
            $table->string('student_id', 12);
            $table->foreign('student_id')->references('student_id')->on('student_contacts')->onDelete('cascade')->onUpdate('cascade');
            $table->string('reg_number', 16);
            $table->string('invoice_number', 16);
            $table->string('stage', 3);
            $table->string('amount', 8);
            $table->mediumText('description', 50);
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
