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
        $data = DB::table('applicantdetailsview')->get()->groupBy('applicant_id');
        $chunkSize = 50;     
        foreach ($data as $applicantId => $applicantData) {
            $applicantContactsData = [];
            $applicantInfosData = [];
            $applicantAddressesData = [];
            $applicantApplicationsData = [];

            foreach ($applicantData as $row) {
                
                $applicantContactsData[] = [
                    'applicant_id' => $applicantId,
                    'email' => $row->email,
                    'mobile' => $row->mobile,
                    'alt_mobile' => $row->alt_mobile,
                ];
                $applicantInfosData[] = [
                    'applicant_id' => $applicantId,
                    'first_name' => $row->first_name,
                    'middle_name' => $row->middle_name,
                    'surname' => $row->surname,
                    'gender' => $row->gender,
                ];
                $applicantAddressesData[] = [
                    'applicant_id' => $applicantId,
                    'town' => $row->town,
                    'address' => $row->box,
                    'postal_code' => $row->postal_code,
                ];
                $applicantApplicationsData[] = [
                    'applicant_id' => $row->application_id,
                    'applicant_id' => $applicantId,
                    'campus_id' => $row->campus,
                    'intake_id' => $row->intake_id,
                    'course_id' => $row->course_name,
                    'student_type' => $row->student_type,
                    'ref_number' => $row->postal_code,
                    'declaration'  => "1",
                ];
            }
    
            DB::table('applicant_contacts')->insert($applicantContactsData);
            DB::table('applicant_infos')->insert($applicantInfosData);
            DB::table('applicant_addresses')->insert($applicantAddressesData);
            DB::table('applications')->insert($applicantApplicationsData);
        }
    }
    
    public function down()
    {
        Schema::dropIfExists('insertingdata');
    }
};
