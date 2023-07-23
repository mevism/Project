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
            "CREATE VIEW academicleaves AS
                SELECT
                academic_leaves.leave_id, academic_leaves.student_id, student_courses.student_number, student_infos.sname, student_infos.fname, student_infos.mname, student_contacts.student_email, student_courses.department_id, academic_leaves.type, academic_leaves.current_class, academic_leaves.year_study, academic_leaves.semester_study, academic_leaves.academic_year, academic_leaves.intake_id, academic_leaves.from, academic_leaves.to, academic_leaves.reason, deferred_classes.differed_class, deferred_classes.differed_year, deferred_classes.differed_semester, deferred_classes.stage, academic_leave_approvals.cod_status, academic_leave_approvals.cod_remarks, academic_leave_approvals.dean_status, academic_leave_approvals.dean_remarks, academic_leave_approvals.registrar_status, academic_leave_approvals.status, academic_leave_approvals.created_at
                FROM academic_leave_approvals
                JOIN academic_leaves ON academic_leaves.leave_id = academic_leave_approvals.leave_id
                JOIN deferred_classes ON deferred_classes.leave_id = academic_leave_approvals.leave_id
                JOIN student_infos ON student_infos.student_id = academic_leaves.student_id
                JOIN student_courses ON student_courses.student_id = academic_leaves.student_id
                JOIN student_contacts ON student_contacts.student_id = academic_leaves.student_id;

        "
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('academic_leaves_views');
    }
};
