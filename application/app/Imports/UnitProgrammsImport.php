<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Modules\Registrar\Entities\UnitProgramms;
use Maatwebsite\Excel\Concerns\ToCollection;

class UnitProgrammsImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $collection)
    {
        foreach($collection as $row)
        UnitProgramms::create([
            'course_code' => $row[0],
            'course_unit_code' => $row[1],
            'unit_name' => $row[2],
            'stage' => $row[3],
            'semester' => $row[4],
            'type' => $row[5],

        ]);
    }
   
}
