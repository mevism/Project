<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Modules\Registrar\Entities\Unit;
use Maatwebsite\Excel\Concerns\ToCollection;

class UnitImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $collection)
    {
        foreach($collection as $row)
        Unit::create([
            'colSubjectId' => $row[0],
            'colSubjectName' => $row[1],

        ]);   
    }
}
