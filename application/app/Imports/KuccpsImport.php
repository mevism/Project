<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Modules\Application\Entities\Education;
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

            $exit_date = preg_replace('/&/', '', substr($row[1], -4));

            $applicant = KuccpsApplicant::create([
                'index_number' => preg_replace('/&/', 'AND', $row[1]),
                'sname' => preg_replace('/&/', 'AND', $sname),
                'fname' => preg_replace('/&/', 'AND', $fname) ,
                'mname' => preg_replace('/&/', 'AND', $mname) ,
                'gender' => preg_replace('/&/', 'AND', $row[3]),
                'mobile' => preg_replace('/&/', 'AND', $row[4]),
                'alt_mobile' => preg_replace('/&/', 'AND', $row[5]),
                'alt_email' => preg_replace('/&/', 'AND', $row[7]),
                'BOX' => preg_replace('/&/', 'AND', $row[8]),
                'postal_code' => preg_replace('/&/', 'AND', $row[9]),
                'town' => preg_replace('/&/', 'AND', $row[10]),
                'school' => preg_replace('/&/', 'AND', $row[13]),
            ]);

            KuccpsApplication::create([
                'applicant_id' => $applicant->id,
                'intake_id' => $this->intake_id,
                'course_code' => preg_replace('/&/', 'AND', $row[11]) ,
                'course_name' => preg_replace('/&/', 'AND', $row[12])
            ]);

            Education::create([
                'applicant_id' => $applicant->id,
                'institution' => preg_replace('/&/', 'AND', $row[13]),
                'level' => 'SECONDARY',
                'qualification' => 'KUCCPS',
                'exit_date' => $exit_date,
                'start_date' => $exit_date - 3,
            ]);
        }
    }
}
