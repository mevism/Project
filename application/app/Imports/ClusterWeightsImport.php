<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Modules\Application\Entities\ApplicantInfo;
use Modules\Registrar\Entities\ClusterWeights;

class ClusterWeightsImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $collection)
    {
        foreach($collection as $row){
            $student = ApplicantInfo::where('index_number', $row[0])->first();
            ClusterWeights::create([
                'applicant_id' => $student->applicant_id,
                'cw1' => $row[1],
                'cw2' => $row[2],
                'cw3' => $row[3],
                'cw4' => $row[4],
                'cw5' => $row[5],
                'cw6' => $row[6],
                'cw7' => $row[7],
                'cw8' => $row[8],
                'cw9' => $row[9],
                'cw10' => $row[10],
                'cw11' => $row[11],
                'cw12' => $row[12],
                'cw13' => $row[13],
                'cw14' => $row[14],
                'cw15' => $row[15],
                'cw16' => $row[16],
                'cw17' => $row[17],
                'cw18' => $row[18],
                'cw19' => $row[19],
                'cw20' => $row[20],
                'cw21' => $row[21],
                'cw22' => $row[22],
                'cw23' => $row[23]
            ]);
        }


    }
}
