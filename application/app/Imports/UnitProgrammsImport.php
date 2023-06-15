<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Modules\Registrar\Entities\UnitProgramms;
use Modules\Registrar\Entities\UnitProgramVersion;
use Maatwebsite\Excel\Concerns\ToCollection;

class UnitProgrammsImport implements ToCollection
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        $courseCodes = $rows->pluck(0)->unique();

        foreach ($courseCodes as $courseCode) {
            $latestVersion = UnitProgramms::where('course_code', $courseCode)->max('version');
            $version = $latestVersion !== null ? $latestVersion + 1 : 1;

            $courseRecords = $rows->where(0, $courseCode);

            foreach ($courseRecords as $row) {
                UnitProgramms::create([
                    'course_code' => $courseCode,
                    'course_unit_code' => $row[1],
                    'unit_name' => $row[2],
                    'stage' => $row[3],
                    'semester' => $row[4],
                    'type' => $row[5],
                    'version' => $version,
                ]);
            }

            UnitProgramVersion::create([
                'course_code' => $courseCode,
                'version' => $version,
            ]);
        }
    }
}



// namespace App\Imports;

// use Illuminate\Support\Collection;
// use Modules\Registrar\Entities\UnitProgramms;
// use Maatwebsite\Excel\Concerns\ToCollection;

// class UnitProgrammsImport implements ToCollection
// {
//     /**
//      * @param array $row
//      *
//      * @return \Illuminate\Database\Eloquent\Model|null
//      */
//     public function collection(Collection $rows)
//     {
//         $courseCodes = $rows->pluck(0)->unique();

//         foreach ($courseCodes as $courseCode) {
//             $latestVersion = UnitProgramms::where('course_code', $courseCode)->max('version');
//             $version = $latestVersion !== null ? $latestVersion + 1 : 1;

//             $courseRecords = $rows->where(0, $courseCode);

//             foreach ($courseRecords as $row) {
//                 UnitProgramms::create([
//                     'course_code' => $courseCode,
//                     'course_unit_code' => $row[1],
//                     'unit_name' => $row[2],
//                     'stage' => $row[3],
//                     'semester' => $row[4],
//                     'type' => $row[5],
//                     'version' => $version,
//                 ]);
//             }
//         }
//     }
// }

