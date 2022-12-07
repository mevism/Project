<?php

namespace Database\Seeders;

// use Carbon;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $users = [
            ['name' => 'Registrar', 'username' => 'registrarAA', 'password' => Hash::make('1234'), 'role_id' => 1,],
            ['name' => 'COD 1', 'username' => 'coddaf', 'password' => Hash::make('1234'), 'role_id' => 2, 'department_id' => 1,],
            ['name' => 'COD 2', 'username' => 'coddba', 'password' => Hash::make('1234'), 'role_id' => 2, 'department_id' => 2,],
            ['name' => 'COD 3', 'username' => 'coddhm', 'password' => Hash::make('1234'), 'role_id' => 2, 'department_id' => 3,],
            ['name' => 'COD 4', 'username' => 'coddabe', 'password' => Hash::make('1234'), 'role_id' => 2, 'department_id' => 4,],
            ['name' => 'COD 5', 'username' => 'coddbce', 'password' => Hash::make('1234'), 'role_id' => 2, 'department_id' => 5,],
            ['name' => 'COD 6', 'username' => 'coddee', 'password' => Hash::make('1234'), 'role_id' => 2, 'department_id' => 6,],
            ['name' => 'COD 7', 'username' => 'coddme', 'password' => Hash::make('1234'), 'role_id' => 2, 'department_id' => 7,],
            ['name' => 'COD 8', 'username' => 'coddmae', 'password' => Hash::make('1234'), 'role_id' => 2, 'department_id' => 8,],
            ['name' => 'COD 9', 'username' => 'coddehs', 'password' => Hash::make('1234'), 'role_id' => 2, 'department_id' => 9,],
            ['name' => 'COD 10', 'username' => 'coddmp', 'password' => Hash::make('1234'), 'role_id' => 2, 'department_id' => 10,],
            ['name' => 'COD 11', 'username' => 'coddpas', 'password' => Hash::make('1234'), 'role_id' => 2, 'department_id' => 11,],
            ['name' => 'COD 12', 'username' => 'coddoms', 'password' => Hash::make('1234'), 'role_id' => 2, 'department_id' => 12,],
            ['name' => 'COD 13', 'username' => 'coddss', 'password' => Hash::make('1234'), 'role_id' => 2, 'department_id' => 13,],
            ['name' => 'COD 14', 'username' => 'coddhtm', 'password' => Hash::make('1234'), 'role_id' => 2, 'department_id' => 14,],
            ['name' => 'COD 15', 'username' => 'coddcs', 'password' => Hash::make('1234'), 'role_id' => 2, 'department_id' => 15,],
            ['name' => 'COD DCI', 'username' => 'coddci', 'password' => Hash::make('1234'), 'role_id' => 2, 'department_id' => 16,],
            ['name' => 'Student Finance', 'username' => 'studentfinance', 'password' => Hash::make('1234'), 'role_id' => 3,],
            ['name' => 'Dean SOB', 'username' => 'deansob', 'password' => Hash::make('1234'), 'role_id' => 4, 'school_id' => 1,],
            ['name' => 'Dean SOET', 'username' => 'deansoet', 'password' => Hash::make('1234'), 'role_id' => 4, 'school_id' => 2,],
            ['name' => 'Dean SOAHS', 'username' => 'deansoahs', 'password' => Hash::make('1234'), 'role_id' => 4, 'school_id' => 3,],
            ['name' => 'Dean SOHSS', 'username' => 'deansohss', 'password' => Hash::make('1234'), 'role_id' => 4, 'school_id' => 4,],
            ['name' => 'Dean ICI', 'username' => 'deanici', 'password' => Hash::make('1234'), 'role_id' => 4, 'school_id' => 5,],
            ['name' => 'Accommodation Officer', 'username' => 'accommodation', 'password' => Hash::make('1234'), 'role_id' => 5,],
 //         ['name' => 'Student', 'username' => 'student'.'@gmail.com', 'password' => Hash::make('1234'), 'role_id' => 6,],
            ['name' => 'Exams', 'username' => 'examination', 'password' => Hash::make('1234'), 'role_id' => 7,],
           ['name' => 'Medical Officer', 'username' => 'medicalofficer', 'password' => Hash::make('1234'), 'role_id' => 8,],
 ////            ['name' => 'Admin', 'username' => 'admin'.'@gmail.com', 'password' => Hash::make('1234'), 'role_id' => 0,],
         ];

         foreach ($users as $user){
             DB::table('users')->insert([ $user ]);
         }
         DB::table('groups')->insert([
             ['name' => 'GROUP I'],
             ['name' => 'GROUP II'],
             ['name' => 'GROUP III'],
             ['name' => 'GROUP IV'],
             ['name' => 'GROUP V'],
         ]);

            DB::table('campuses')->insert([
             ['name' => 'MAIN CAMPUS'],
             ['name' => 'KWALE CAMPUS'],
             ['name' => 'LAMU CAMPUS'],

         ]);
         DB::table('cluster_subjects')->insert([
             ['group_id' => '1', 'subject' => 'MAT'],
             ['group_id' => '1', 'subject' => 'ENG'],
             ['group_id' => '1', 'subject' => 'KIS'],
             ['group_id' => '2', 'subject' => 'CHEM'],
             ['group_id' => '2', 'subject' => 'BIO'],
             ['group_id' => '2', 'subject' => 'PHY'],
             ['group_id' => '3', 'subject' => 'HIS'],
             ['group_id' => '3', 'subject' => 'GEO'],
             ['group_id' => '3', 'subject' => 'CRE'],
             ['group_id' => '3', 'subject' => 'HRE'],
             ['group_id' => '3', 'subject' => 'IRE'],
             ['group_id' => '4', 'subject' => 'HSCI'],
             ['group_id' => '4', 'subject' => 'AGRI'],
             ['group_id' => '4', 'subject' => 'WWORK'],
             ['group_id' => '4', 'subject' => 'COMP'],
             ['group_id' => '4', 'subject' => 'MWORK'],
             ['group_id' => '5', 'subject' => 'BUS'],
             ['group_id' => '5', 'subject' => 'FRE'],
             ['group_id' => '5', 'subject' => 'GER'],
             ['group_id' => '5', 'subject' => 'ARAB'],
             ['group_id' => '5', 'subject' => 'MUSIC'],
             ['group_id' => '5', 'subject' => 'SIGN LANG'],
         ]);


         DB::table('schools')->insert([
             ['initials'=>'SOB', 'name'=>'SCHOOL OF BUSINESS', 'created_at' => Carbon::now()],
             ['initials'=>'SoET', 'name'=>'SCHOOL OF ENGINEERING AND TECHNOLOGY' ,'created_at' => Carbon::now()],
             ['initials'=>'SOAHS', 'name'=>'SCHOOL OF APPLIED AND HEALTH SCIENCES' ,'created_at' => Carbon::now()],
             ['initials'=>'SOHSS', 'name'=>'SCHOOL OF HUMANITIES AND SOCIAL SCIENCES' ,'created_at' => Carbon::now()],
             ['initials'=>'ICI', 'name'=>'SCHOOL OF COMPUTNG AND INFORMATICS','created_at' => Carbon::now()],
             
         ]);


         DB::table('departments')->insert([
             ['school_id'=>'1', 'dept_code'=>'DAF', 'name'=>'DEPARTMENT OF ACCOUNTING AND FINANCE','created_at' => Carbon::now()],
             ['school_id'=>'1', 'dept_code'=>'DBA', 'name'=>'DEPARTMENT OF BUSINESS ADMINISTRATION','created_at' => Carbon::now()],
             ['school_id'=>'1', 'dept_code'=>'DHM', 'name'=>'DEPARTMENT OF MANAGEMENT SCIENCE', 'created_at' => Carbon::now()],
             ['school_id'=>'2', 'dept_code'=>'DABE', 'name'=>'DEPARTMENT OF ARCHITECTURE AND BUILT ENVIRONMENT', 'created_at' => Carbon::now()],
             ['school_id'=>'2', 'dept_code'=>'DBCE', 'name'=>'DEPARTMENT OF BUILDING AND CIVIL ENGINEERING', 'created_at' => Carbon::now()],
             ['school_id'=>'2', 'dept_code'=>'DEE', 'name'=>'DEPARTMENT OF ELECTRICAL AND ELECTRONIC ENGINEERING', 'created_at' => Carbon::now()],
             ['school_id'=>'2', 'dept_code'=>'DME', 'name'=>'DEPARTMENT OF MEDICAL ENGINEERING', 'created_at' => Carbon::now()],
             ['school_id'=>'2', 'dept_code'=>'DMAE', 'name'=>'DEPARTMENT OF MECHANICAL AND AUTOMOTIVE ENGINEERING', 'created_at' => Carbon::now()],
             ['school_id'=>'3', 'dept_code'=>'DEHS', 'name'=>'DEPARTMENT OF ENVIRONMENT AND HEALTH SCIENCES', 'created_at' => Carbon::now()],
             ['school_id'=>'3', 'dept_code'=>'DMP', 'name'=>'DEPARTMENT OF MATHEMATICS AND PHYSICS', 'created_at' => Carbon::now()],
             ['school_id'=>'3', 'dept_code'=>'DPAS', 'name'=>'DEPARTMENT OF PURE AND APPLIED SCIENCES', 'created_at' => Carbon::now()],
             ['school_id'=>'3', 'dept_code'=>'DOMS', 'name'=>'DEPARTMENT OF MEDICAL SCIENCES', 'created_at' => Carbon::now()],
             ['school_id'=>'4', 'dept_code'=>'DSS', 'name'=>'DEPARTMENT OF SOCIAL SCIENCES', 'created_at' => Carbon::now()],
             ['school_id'=>'4', 'dept_code'=>'DHTM', 'name'=>'DEPARTMENT OF HOSPITALITY AND TOURISM MANAGEMENT', 'created_at' => Carbon::now()],
             ['school_id'=>'4', 'dept_code'=>'DCS', 'name'=>'DEPARTMENT OF COMMUNICATION STUDIES', 'created_at' => Carbon::now()],
             ['school_id'=>'5', 'dept_code'=>'DCI', 'name'=>'DEPARTMENT OF COMPUTER SCIENCE AND INFORMATION TECHNOLOGY', 'created_at' => Carbon::now()],

         ]);

         DB::table('vote_heads')->insert([
             ['name' => 'CAUTION MONEY'],
             ['name' =>  'STUDENT UNION'],
             ['name'=>'MEDICAL LEVY'],
             ['name' => 'TUITION FEE'],
             ['name'=> 'INDUSTRIAL ATTACHMENT'],
             ['name' => 'STUDENT ID'],
             ['name' => 'EXAMINATION'],
             ['name' => 'REGISTRATION FEE'],
             ['name' => 'LIBRARY LEVY'],
             ['name' => 'I.C.T LEVY'],
             ['name' => 'ACTIVITY FEE'],
             ['name' => 'STUDENT BENEVOLENT'],
             ['name' => 'KUCCPS PLACEMENT FEE'],
             ['name' => 'CUE LEVY']
         ]);

          DB::table('levels')->insert([
              ['name' => 'CERTIFICATE'],
              ['name' => 'DIPLOMA'],
              ['name' => 'UNDERGRADUATE'],
              ['name' => 'POSTGRADUATE'],
              ['name' => 'NON STANDARD']
          ]);

          DB::table('events')->insert([
             ['name' => 'SEMESTER REGISTRATION'],
             ['name' => 'RETAKE'],
             ['name' => 'READMISSION'],
             ['name' => 'ACADEMIC LEAVE/DIFFERMENT'],        
             ['name' => 'TRANSFER']
         ]);
        DB::table('attendances')->insert([
            ['attendance_code'=>'S-FT','attendance_name' => 'SELF SPONSORED FULL TIME'],
            ['attendance_code'=>'J-FT', 'attendance_name' => 'GOVERNMENT SPONSORED'],
            ['attendance_code'=>'S-PT','attendance_name' => 'SELF SPONSORED PART TIME'],
            [ 'attendance_code'=>'S-EV','attendance_name' => 'SELF SPONSORED EVENING'],

        ]);
    }


}
