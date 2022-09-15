<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Modules\Registrar\Entities\KuccpsApplicant;
use Modules\Registrar\Entities\KuccpsApplication;
use Illuminate\Support\Collection;
use Modules\Courses\Entities\Intake;

class KuccpsImport implements ToCollection
{

    public $intake_id;

    public function __construct($intake_id)
    {
      $this->intake_id  = $intake_id;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $collection)
    {

        foreach($collection as $row){

            $names = preg_replace('/\s+/', ' ',$row[2]);
            $name = explode(' ', $names);

            $sname = "";
            $fname = "";
            $mname = " ";

            if(count($name) > 0){
                $sname = $name[0];
            }
            if(count($name) > 1){
                $fname = $name[1];
            }
            if(count($name) > 2){
                $mname = $name[2];
            }

            $applicant = KuccpsApplicant::create([
                'index_number' => $row[1],
                'sname' => $sname,
                'fname' => $fname ,
                'mname' => $mname,
                'gender' => $row[3],
                'mobile' => $row[4],
                'alt_mobile' => $row[5],
                'alt_email' => $row[7],
                'BOX' => $row[8],
                'postal_code' => $row[9],
                'town' => $row[10],
                'school' => $row[13],
            ]);

            KuccpsApplication::create([
                'applicant_id' => $applicant->id,
                'intake_id' => $this->intake_id,
                'course_code' => $row[11],
                'course_name' => $row[12]

            ]);
        }
    }
}
