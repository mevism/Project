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
        DB::statement("
                    CREATE VIEW APPLICATIONSVIEW AS
        SELECT application_approvals.finance_status, application_approvals.invoice_number, application_approvals.cod_status, application_approvals.cod_comments, application_approvals.dean_status, application_approvals.dean_comments, application_approvals.registrar_status, application_approvals.registrar_comments, application_approvals.reg_number, application_approvals.admission_letter, applications.ref_number, applications.applicant_id, applications.application_id, applications.intake_id, applications.student_type, applications.campus_id, applications.school_id, applications.department_id, applications.course_id, applications.declaration, applications.status, application_subjects.subject_1, application_subjects.subject_2, application_subjects.subject_3, application_subjects.subject_4, applicant_infos.title, applicant_infos.fname, applicant_infos.mname, applicant_infos.sname, applicant_infos.gender, applicant_addresses.town, applicant_addresses.address, applicant_addresses.postal_code, applicant_contacts.mobile, applicant_contacts.email, applications.created_at
        FROM application_approvals
        JOIN applications ON applications.application_id = application_approvals.application_id
        JOIN applicant_infos ON applicant_infos.applicant_id = application_approvals.applicant_id
        JOIN application_subjects ON application_subjects.application_id = application_approvals.application_id
        JOIN applicant_addresses ON applicant_addresses.applicant_id = application_approvals.applicant_id
        JOIN applicant_contacts ON applicant_contacts.applicant_id = application_approvals.applicant_id;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('APPLICATIONSSVIEW');
    }
};
