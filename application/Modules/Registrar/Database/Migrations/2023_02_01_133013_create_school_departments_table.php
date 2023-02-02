<?php

use Illuminate\Support\Facades\DB;
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
        Schema::create('school_departments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('school_id');
            $table->integer('department_id');
            $table->timestamps();
            $table->softDeletes();
        });

        $departments = [
            ['school_id' => 1, 'department_id' => 1],
            ['school_id' => 1, 'department_id' => 2],
            ['school_id' => 1, 'department_id' => 3],
            ['school_id' => 2, 'department_id' => 4],
            ['school_id' => 2, 'department_id' => 5],
            ['school_id' => 2, 'department_id' => 6],
            ['school_id' => 2, 'department_id' => 7],
            ['school_id' => 2, 'department_id' => 8],
            ['school_id' => 3, 'department_id' => 9],
            ['school_id' => 3, 'department_id' => 10],
            ['school_id' => 3, 'department_id' => 11],
            ['school_id' => 3, 'department_id' => 12],
            ['school_id' => 4, 'department_id' => 13],
            ['school_id' => 4, 'department_id' => 14],
            ['school_id' => 4, 'department_id' => 15],
            ['school_id' => 5, 'department_id' => 16],
        ];

        foreach ($departments as $department){
            DB::table('school_departments')->insert($department);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school_departments');
    }
};
