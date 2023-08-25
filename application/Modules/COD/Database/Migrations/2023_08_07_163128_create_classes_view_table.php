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
        DB::statement(
            "CREATE  VIEW classesview AS
            SELECT
            classes.class_id, classes.name, classes.attendance_id, classes.course_id, classes.intake_id,classes.syllabus_name,classes.fee_version, departments.department_id, departments.dept_code, courses.course_code, courses.course_name, courses.level_id, intakes.intake_from, intakes.intake_to, classes.created_at
            FROM classes
            JOIN courses ON courses.course_id = classes.course_id
            JOIN departments ON departments.department_id = courses.department_id
            JOIN intakes ON intakes.intake_id = classes.intake_id"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS classesview');
    }
};
