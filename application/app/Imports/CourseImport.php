<?php

namespace App\Imports;
use Illuminate\Support\Collection;
use Modules\Registrar\Entities\Courses;
use Maatwebsite\Excel\Concerns\ToCollection;
use Modules\Registrar\Entities\Department;

class CourseImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $collection)
    {
        
        foreach($collection as $row){
            // dd($row);
        $depts[] = $row[0];

        foreach($depts as $dept){
        //    dd($dept);
            if( $row[3] ==  'CERTIFICATE'){
                $level  =  1 ;

            }elseif($row[3]  ==  'DIPLOMA'){
                $level  =  2 ;

            }elseif($row[3]  == 'UNDERGRADUATE' ){
                $level  =  3 ;
            }
            elseif($row[3]  ==  'GRADUATE'){
                $level  =  4;

            }elseif($row[3]  ==  'POSTGRADUATE'){
                $level  =  5;

            }elseif($row[3] == 'NON-STANDARD'){
                $level  =  6 ;

            }else{
                $level = 7;
            }

            $deptID = Department::where('dept_code', $dept)->first();

            $id = $deptID->id;

   
            
        }       
        Courses::create([

            'department_id' => $id,
            'course_code' => $row[1],
            'course_name' => $row[2],
            'level' => $level,

        ]);
        
         
    }

    }
}
