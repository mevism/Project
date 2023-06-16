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
        DB::statement(
            "CREATE VIEW ACADEMICDEPARTMENTS AS
                SELECT
                departments.*, school_departments.school_id
                FROM school_departments
                JOIN departments ON departments.department_id = school_departments.department_id;"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ACADEMICDEPARTMENTS');
    }
};
