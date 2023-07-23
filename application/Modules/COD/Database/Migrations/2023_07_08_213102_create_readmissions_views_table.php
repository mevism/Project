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
            "CREATE VIEW readmissionsview AS
            SELECT
            readmissions.readmission_id, readmissions.leave_id, readmissions.student_id, student_courses.student_number, student_infos.sname, student_infos.fname, student_infos.mname, student_contacts.student_email, student_courses.department_id, readmissions.academic_year, readmissions.academic_semester, readmissions.intake_id, readmission_approvals.cod_status, readmission_approvals.cod_remarks, readmission_approvals.dean_status, readmission_approvals.dean_remarks, readmission_approvals.registrar_status, readmissions.status, readmission_approvals.created_at
            FROM readmission_approvals
            JOIN readmissions ON readmissions.readmission_id = readmission_approvals.readmission_id
            JOIN student_infos ON student_infos.student_id = readmissions.student_id
            JOIN student_courses ON student_courses.student_id = readmissions.student_id
            JOIN student_contacts ON student_contacts.student_id = readmissions.student_id;"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('readmissionsview');
    }
};
