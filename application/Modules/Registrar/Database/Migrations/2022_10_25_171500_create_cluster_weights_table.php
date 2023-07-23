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
        Schema::create('cluster_weights', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('student_id');
            $table->foreign('student_id')->references('student_id')->on('student_contacts')->onUpdate('cascade')->onDelete('cascade');
            $table->string('student_name');
            $table->string('gender');
            $table->string('citizenship');
            $table->string('mean_grade')->nullable();
            $table->string('agp');
            $table->string('cw1');
            $table->string('cw2');
            $table->string('cw3');
            $table->string('cw4');
            $table->string('cw5');
            $table->string('cw6');
            $table->string('cw7');
            $table->string('cw8');
            $table->string('cw9');
            $table->string('cw10');
            $table->string('cw11');
            $table->string('cw12');
            $table->string('cw13');
            $table->string('cw14');
            $table->string('cw15');
            $table->string('cw16');
            $table->string('cw17');
            $table->string('cw18');
            $table->string('cw19');
            $table->string('cw20');
            $table->string('cw21');
            $table->string('cw22');
            $table->string('cw23');
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
        Schema::dropIfExists('cluster_weights');
    }
};
