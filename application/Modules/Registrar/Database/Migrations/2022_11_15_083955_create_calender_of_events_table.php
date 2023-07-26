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
        Schema::create('calender_of_events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('academic_year_id');
            $table->foreign('academic_year_id')->references('year_id')->on('academic_years')->onUpdate('no action')->onDelete('no action');
            $table->string('intake_id');
            $table->foreign('intake_id')->references('intake_id')->on('intakes')->onUpdate('no action')->onDelete('no action');
            $table->unsignedBigInteger('event_id');
            $table->foreign('event_id')->references('id')->on('events')->onUpdate('no action')->onDelete('no action');
            $table->string('start_date');
            $table->string('end_date');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calender_of_events');
    }
};
