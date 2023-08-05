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
            "CREATE  VIEW studentcourseview AS
            SELECT student_courses.student_id, student_courses.student_number, courses.course_name, courses.level_id, student_courses.student_type, student_courses.entry_class, student_courses.current_class, intakes.intake_from, departments.name, student_courses.status, course_requirements.course_duration, course_requirements.course_requirements
            FROM student_courses
            JOIN courses ON courses.course_id = student_courses.course_id
            JOIN intakes ON intakes.intake_id = student_courses.intake_id
            JOIN course_requirements ON course_requirements.course_id = courses.course_id
            JOIN departments ON departments.department_id = courses.department_id;"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS studentcourseview');

    }
};
