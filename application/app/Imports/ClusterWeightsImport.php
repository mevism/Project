<?php

namespace App\Imports;
 
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
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
           $xyz = 
            ClusterWeights::create([
                'student_id' => $row[0],
                'student_name' => str_replace(["'", '"'], '', preg_replace('/b/', '',$row[1])),
                'gender' => $row[2],
                'citizenship' => $row[3],
                'mean_grade' => $row[4],
                'agp' => $row[5],
                'cw1' => $row[6],
                'cw2' => $row[7],
                'cw3' => $row[8],
                'cw4' => $row[9],
                'cw5' => $row[10],
                'cw6' => $row[11],
                'cw7' => $row[12],
                'cw8' => $row[13],
                'cw9' => $row[14],
                'cw10' => $row[15],
                'cw11' => $row[16],
                'cw12' => $row[17],
                'cw13' => $row[18],
                'cw14' => $row[19],
                'cw15' => $row[20],
                'cw16' => $row[21],
                'cw17' => $row[22],
                'cw18' => $row[23],
                'cw19' => $row[24],
                'cw20' => $row[25],
                'cw21' => $row[26],
                'cw22' => $row[27],
                'cw23' => $row[28]
            ]);
        }

        
    }
}
