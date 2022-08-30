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

            // dd($row);

            // return $row;
         
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

            // dd($mname);


            $applicant = KuccpsApplicant::create([
                'index_number' =>trim( $row[1]),
                'sname' => trim($sname),  
                'fname' => trim($fname) ,
                'mname' => trim($mname),
                'gender' => trim($row[3]),
                'mobile' => trim($row[4]),
                'alt_mobile' => trim($row[5]),
                'email' => trim($row[6]),
                'alt_email' => trim($row[7]),
                'BOX' => trim($row[8]),
                'postal_code' => trim($row[9]),
                'town' => trim($row[10]),
                'school' => trim($row[13]),
            ]); 

            KuccpsApplication::create([
                'user_id' => trim($applicant->id),
                'intake_id' => trim($this->intake_id),
                'course_code' => trim($row[11]),
                'course_name' => trim($row[12])
            
            ]);
        }
    }
}
