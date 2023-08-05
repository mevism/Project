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
            "CREATE  VIEW coursetransferview AS
            SELECT
            course_transfers.student_id, student_courses.student_number, student_infos.sname, student_infos.first_name, student_infos.middle_name, student_infos.gender, course_transfers.intake_id, course_transfers.class_id, course_transfers.class_points, course_transfers.student_points, course_transfer_approvals.course_transfer_id, course_transfer_approvals.cod_status, course_transfer_approvals.cod_remarks, course_transfer_approvals.dean_status, course_transfer_approvals.dean_remarks, course_transfer_approvals.registrar_status, course_transfers.status
            FROM course_transfer_approvals
            JOIN course_transfers ON course_transfers.course_transfer_id = course_transfer_approvals.course_transfer_id
            JOIN student_infos ON student_infos.student_id = course_transfers.student_id
            JOIN student_courses ON student_courses.student_id = course_transfers.student_id;"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS coursetransferview');
    }
};
