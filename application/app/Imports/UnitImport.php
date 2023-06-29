<?php

namespace App\Imports;

use App\Service\CustomIds;
use Illuminate\Support\Collection;
use Modules\COD\Entities\Unit;
use Modules\Registrar\Entities\Department;
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

        foreach($collection as $row) {
            $grading = [
                ['total_exam' => 70, 'total_cat' => 30, 'cat' => 15, 'assignment' => 10, 'practical' => 5],
                ['total_exam' => 70, 'total_cat' => 30, 'cat' => 20, 'assignment' => 10, 'practical' => 0],
                ['total_exam' => 70, 'total_cat' => 30, 'cat' => 30, 'assignment' => 0, 'practical' => 0],
                ['total_exam' => 70, 'total_cat' => 30, 'cat' => 10, 'assignment' => 10, 'practical' => 10],
                ['total_exam' => 70, 'total_cat' => 30, 'cat' => 15, 'assignment' => 5, 'practical' => 10],
                ['total_exam' => 70, 'total_cat' => 30, 'cat' => 5, 'assignment' => 10, 'practical' => 15],
                ['total_exam' => 60, 'total_cat' => 40, 'cat' => 20, 'assignment' => 10, 'practical' => 10],
                ['total_exam' => 60, 'total_cat' => 40, 'cat' => 10, 'assignment' => 15, 'practical' => 15],
                ['total_exam' => 60, 'total_cat' => 40, 'cat' => 15, 'assignment' => 15, 'practical' => 10],
                ['total_exam' => 60, 'total_cat' => 40, 'cat' => 40, 'assignment' => 0, 'practical' => 0],
                ['total_exam' => 60, 'total_cat' => 40, 'cat' => 30, 'assignment' => 10, 'practical' => 0],
            ];
            $GradeCollection = Collection::make($grading);
            $type = Collection::make([1, 2, 3]);
            $department = Department::where('division_id', '368HZXbsoMi')->pluck('department_id');
            $grade = $GradeCollection->random();
            $unitID = new CustomIds();
            Unit::create([
                'unit_id' => $unitID->generateId(),
                'unit_code' => strtoupper(str_replace(' ', '',$row[0])),
                'unit_name' =>  $row[1],
                'type' => $type->random(),
                'department_id' => $department->random(),
                'total_exam' => $grade['total_exam'],
                'total_cat' => $grade['total_cat'],
                'cat' => $grade['cat'],
                'assignment' => $grade['assignment'],
                'practical' => $grade['practical'],
            ]);
        }
    }
}
