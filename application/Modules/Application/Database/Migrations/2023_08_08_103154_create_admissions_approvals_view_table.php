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
            "CREATE VIEW admissionsview AS
            SELECT       
            applicant_infos.title, applicant_infos.first_name, applicant_infos.middle_name, applicant_infos.surname, applicant_infos.gender, applicant_infos.marital_status, applicant_infos.date_of_birth, applicant_infos.identification, applicant_infos.disabled, applicant_infos.disability, applicant_contacts.email, applicant_contacts.alt_email, applicant_contacts.mobile, applicant_contacts.alt_mobile, applicant_addresses.nationality, applicant_addresses.county, applicant_addresses.sub_county, applicant_addresses.town, applicant_addresses.address, applicant_addresses.postal_code, applications.student_type, applications.course_id, applications.intake_id, application_subjects.subject_1, application_subjects.subject_2, application_subjects.subject_3, application_subjects.subject_4, accepted_students.reference_number, accepted_students.student_number, admission_approvals.application_id, admission_approvals.cod_status, admission_approvals.cod_comments, admission_approvals.cod_user_id, admission_approvals.registrar_status, admission_approvals.registrar_comment, admission_approvals.registrar_user_id, admission_approvals.medical_status, admission_approvals.medical_comments, admission_approvals.medical_user_id, admission_approvals.status, admission_documents.certificates, admission_documents.bank_receipt, admission_documents.medical_form, admission_documents.passport_photo, admission_approvals.created_at
            
            FROM admission_approvals
            JOIN admission_documents ON admission_documents.application_id = admission_approvals.application_id
            JOIN applications ON applications.application_id = admission_approvals.application_id
            JOIN applicant_infos ON applicant_infos.applicant_id = applications.applicant_id
            JOIN application_subjects ON application_subjects.application_id = admission_approvals.application_id
            JOIN application_approvals ON application_approvals.application_id = admission_approvals.application_id
            JOIN applicant_contacts ON applicant_contacts.applicant_id = applications.applicant_id
            JOIN applicant_addresses ON applicant_addresses.applicant_id = applications.applicant_id
            JOIN accepted_students ON accepted_students.applicant_id = applications.applicant_id;"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS admissionsview');
    }
};
