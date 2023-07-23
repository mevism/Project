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
            "CREATE VIEW studentview AS 
            SELECT student_courses.id, student_infos.student_id, student_infos.sname, student_infos.fname, student_infos.mname, student_infos.gender, student_infos.title, student_courses.student_number, student_courses.student_type, courses.course_name, intakes.intake_from, student_courses.current_class, student_courses.entry_class, student_courses.status, departments.name, student_contacts.email, student_contacts.student_email, student_contacts.mobile, student_addresses.citizen, student_addresses.county, student_addresses.town, student_addresses.address, student_addresses.postal_code
            FROM student_courses 
            JOIN student_infos ON student_infos.student_id = student_courses.student_id
            JOIN courses ON courses.course_id = student_courses.course_id
            JOIN departments ON departments.department_id = student_courses.department_id
            JOIN student_contacts ON student_contacts.student_id = student_courses.student_id
            JOIN student_addresses ON student_addresses.student_id = student_courses.student_id
            JOIN intakes ON intakes.intake_id = student_courses.intake_id;"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('studentview');
    }
};
