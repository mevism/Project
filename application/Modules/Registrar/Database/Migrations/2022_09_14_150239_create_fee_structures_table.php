<?php
namespace Modules\Courses;

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
        Schema::create('fee_structures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('level');
            $table->string('student_type');
            $table->string('year');
            $table->string('semester');
            $table->string('caution_money');
            $table->string('student_union');
            $table->string('medical_levy');
            $table->string('tuition_fee');
            $table->string('industrial_attachment');
            $table->string('student_id');
            $table->string('examination');
            $table->string('registration_fee');
            $table->string('library_levy');
            $table->string('ict_levy');
            $table->string('activity_fee');
            $table->string('student_benevolent');
            $table->string('kuccps_placement_fee');
            $table->string('cue_levy');
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
        Schema::dropIfExists('fee_structures');
    }
};
