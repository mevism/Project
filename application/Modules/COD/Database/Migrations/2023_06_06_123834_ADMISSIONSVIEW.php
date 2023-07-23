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
            "CREATE VIEW admissionsview AS
            SELECT admission_approvals.applicant_id, applicant_infos.fname, applicant_infos.mname, applicant_infos.sname, applicant_infos.gender, applicant_infos.title, applicant_infos.marital_status, applicant_infos.DOB, applicant_infos.id_number, applicant_infos.disabled, applicant_contacts.email, applicant_contacts.alt_email, applicant_contacts.mobile, applicant_contacts.alt_mobile, applicant_addresses.town, applicant_addresses.nationality, applicant_addresses.county, applicant_addresses.sub_county, applicant_addresses.address, applicant_addresses.postal_code, applicant_infos.disability, admission_approvals.application_id, applications.student_type, applications.course_id, applications.intake_id, applications.ref_number, application_approvals.reg_number, applications.department_id, application_subjects.subject_1, application_subjects.subject_2, application_subjects.subject_3, application_subjects.subject_4, admission_approvals.cod_status, admission_approvals.cod_comments, admission_approvals.registrar_status, admission_approvals.registrar_comment, admission_approvals.medical_status, admission_approvals.medical_comments, admission_approvals.accommodation_status, admission_approvals.accommodation_comments, admission_approvals.id_status, admission_approvals.id_comments,admission_approvals.status, admission_documents.certificates, admission_documents.bank_receipt, admission_documents.medical_form, admission_documents.passport_photo, admission_approvals.created_at
                        FROM admission_approvals
                        JOIN admission_documents ON admission_documents.application_id = admission_approvals.application_id
                        JOIN application_approvals ON application_approvals.application_id  =  admission_approvals.application_id
                        JOIN applicant_addresses ON applicant_addresses.applicant_id  =  admission_approvals.applicant_id
                        JOIN applicant_contacts ON applicant_contacts.applicant_id  =  admission_approvals.applicant_id
                        JOIN applicant_infos ON applicant_infos.applicant_id = admission_approvals.applicant_id
                        JOIN applications ON applications.application_id = admission_approvals.application_id
                        JOIN application_subjects ON application_subjects.application_id = admission_approvals.application_id;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admissionsview');
    }
};
