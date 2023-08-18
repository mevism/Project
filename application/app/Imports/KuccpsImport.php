<?php

namespace App\Imports;

use App\Service\CustomIds;
use Illuminate\Support\Collection;
use Modules\Application\Entities\Education;
use Maatwebsite\Excel\Concerns\ToCollection;
use Modules\Application\Entities\KuccpsEducation;
use Modules\Registrar\Entities\KuccpsApplicant;
use Modules\Registrar\Entities\KuccpsApplication;

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

            $fname = ""; // Initialize first name
            $mname = ""; // Initialize middle name
            $sname = ""; // Initialize last name

            if (count($name) > 0) {
                $sname = array_pop($name); // Last chunk is always last name
            }
            if (count($name) > 0) {
                $fname = array_shift($name); // First remaining chunk is first name
            }
            if (count($name) > 0) {
                $mname = implode(' ', $name); // Any remaining chunks are middle name
            }

            $id = new CustomIds();
            $applcant_id = $id->generateId();

            $exit_date = preg_replace('/&/', '', substr($row[1], -4));

            KuccpsApplicant::create([
                'applicant_id' => $applcant_id,
                'index_number' => preg_replace('/&/', 'AND', $row[1]),
                'surname' => preg_replace('/&/', 'AND', $sname),
                'first_name' => preg_replace('/&/', 'AND', $fname) ,
                'middle_name' => preg_replace('/&/', 'AND', $mname) ,
                'gender' => preg_replace('/&/', 'AND', $row[3]),
                'mobile' => preg_replace('/&/', 'AND', $row[4]),
                'alt_mobile' => preg_replace('/&/', 'AND', $row[5]),
                'email' => preg_replace('/&/', 'AND', $row[6]),
                'alt_email' => preg_replace('/&/', 'AND', $row[7]),
                'box' => preg_replace('/&/', 'AND', $row[8]),
                'postal_code' => preg_replace('/&/', 'AND', $row[9]),
                'town' => preg_replace('/&/', 'AND', $row[10]),
                'intake_id' => $this->intake_id,
                'course_code' => preg_replace('/&/', 'AND', $row[11]) ,
                'course_name' => preg_replace('/&/', 'AND', $row[12]),
                'institution' => preg_replace('/&/', 'AND', $row[13]),
                'level' => 'SECONDARY',
                'qualification' => 'KUCCPS ENTRY',
                'exit_date' => $exit_date,
                'start_date' => $exit_date - 3,
            ]);
        }
    }
}
