<?php

use App\Service\CustomIds;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        $otherConnection = DB::connection('EREGISTRAR_MAIN');

        $dataFromOtherDatabase = $otherConnection->table('tumisapplicantapplications')
            ->select('colIndexNo', 'colFirstName', 'colMidleName', 'colSurName', 'colGender', 'colTitle', 'colDateOfBirth', 'colAppRef', 'colCourse_Name', 'colCourseAccesCode', 'colAddress', 'colTown', 'colEmail', 'colMobile', 'colPhone', 'colCourseType', 'colCourseLevel', 'colCourse_ID_FK', 'colCounty','colIDNo', 'campusName', 'startOn')
            ->where('startOn', 'January-2014')   
            ->distinct() 
            ->get();

            $chunkedData = array_chunk($dataFromOtherDatabase->toArray(), 50);

            $applicantId  =  new CustomIds();
            $applicationId  =  new CustomIds();

            foreach ($chunkedData as $chunk) {
            $mappedChunk = [];

            foreach ($chunk as $item) {
                $mappedChunk[] = [
                    'applicant_id' => $applicantId->generateId(),
                    'application_id' => $applicationId->generateId(),
                    'first_name' => $item->colFirstName,
                    'middle_name' => $item->colMidleName,
                    'surname' => $item->colSurName,
                    'index_number' => $item->colIndexNo,
                    'gender' => $item->colGender,
                    'mobile' => $item->colMobile,
                    'alt_mobile' => $item->colPhone,
                    'email' => $item->colEmail,
                    'intake_id' => $item->startOn,
                    'course_code' => $item->colCourse_ID_FK,
                    'course_name' => $item->colCourse_Name,
                    'level' => $item->colCourseLevel,
                    'town' => $item->colTown,
                    'address' => $item->colAddress,
                    'ref_number' => $item->colAppRef,
                    'class' => $item->colCourseAccesCode,
                    'id_number' => $item->colIDNo,
                    'campus' => $item->campusName,
                    'county' => $item->colCounty,
                    'title' => $item->colTitle,
                    'date_of_birth' => $item->colDateOfBirth                    
                ];
            }
            DB::table('applicant_details_view')->insert($mappedChunk);
        }
        
    }

};
