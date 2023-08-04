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
            $table->string('student_id', 12);
            $table->foreign('student_id')->references('student_id')->on('student_contacts')->onUpdate('cascade')->onDelete('cascade');
            $table->string('student_name', 64);
            $table->string('gender', 8);
            $table->string('citizenship', 16);
            $table->string('mean_grade', 8)->nullable();
            $table->string('agp', 4);
            $table->string('cw1', 8);
            $table->string('cw2', 8);
            $table->string('cw3', 8);
            $table->string('cw4', 8);
            $table->string('cw5', 8);
            $table->string('cw6', 8);
            $table->string('cw7', 8);
            $table->string('cw8', 8);
            $table->string('cw9', 8);
            $table->string('cw10', 8);
            $table->string('cw11', 8);
            $table->string('cw12', 8);
            $table->string('cw13', 8);
            $table->string('cw14', 8);
            $table->string('cw15', 8);
            $table->string('cw16', 8);
            $table->string('cw17', 8);
            $table->string('cw18', 8);
            $table->string('cw19', 8);
            $table->string('cw20', 8);
            $table->string('cw21',8);
            $table->string('cw22', 8);
            $table->string('cw23',8);
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
