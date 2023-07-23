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
        DB::statement("
           CREATE VIEW coursesonofferview AS
            SELECT available_courses.available_id, available_courses.intake_id, available_courses.course_id, available_courses.campus_id, courses.department_id, courses.course_code, courses.course_name, courses.level, intakes.intake_from, intakes.intake_to, departments.dept_code, school_departments.school_id, course_requirements.application_fee, course_requirements.subject1, course_requirements.subject2, course_requirements.subject3, course_requirements.subject4, course_requirements.course_duration, course_requirements.course_requirements, campuses.name, available_courses.created_at
            FROM available_courses
            JOIN courses ON courses.course_id = available_courses.course_id
            JOIN intakes ON intakes.intake_id = available_courses.intake_id
            JOIN departments ON departments.department_id = courses.department_id
            JOIN course_requirements ON course_requirements.course_id = courses.course_id
            JOIN campuses ON campuses.campus_id = available_courses.campus_id
            JOIN school_departments ON school_departments.department_id = departments.department_id;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courseonofferview');
    }
};
