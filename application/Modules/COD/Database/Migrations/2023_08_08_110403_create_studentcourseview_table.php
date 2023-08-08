<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

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
        "CREATE VIEW studentcourseview AS
        SELECT student_logins.applicant_id, accepted_students.reference_number, accepted_students.student_number, student_courses.student_id, courses.course_name, courses.level_id, student_courses.student_type, student_courses.entry_class, student_courses.current_class, student_courses.intake_id, student_courses.status, course_requirements.course_duration, course_requirements.course_requirements
        FROM student_courses
        JOIN courses ON courses.course_id = student_courses.course_id
        JOIN intakes ON intakes.intake_id = student_courses.intake_id
        JOIN student_logins ON student_logins.student_id = student_courses.student_id
        JOIN accepted_students ON accepted_students.applicant_id = student_logins.applicant_id
        JOIN course_requirements ON course_requirements.course_id = courses.course_id;"
       );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('studentcourseview');
    }
};
