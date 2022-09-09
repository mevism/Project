<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
           ['name' => 'Registrar', 'username' => 'registrar'.'@gmail.com', 'password' => Hash::make('1234'), 'role_id' => 1,],
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
           ['name' => 'COD 16', 'username' => 'coddci', 'password' => Hash::make('1234'), 'role_id' => 2, 'department_id' => 16,],
           ['name' => 'Finance', 'username' => 'finance'.'@gmail.com', 'password' => Hash::make('1234'), 'role_id' => 3,],
           ['name' => 'Dean 1', 'username' => 'deansob'.'@gmail.com', 'password' => Hash::make('1234'), 'role_id' => 4, 'school_id' => 1,],
           ['name' => 'Dean 2', 'username' => 'deansoet'.'@gmail.com', 'password' => Hash::make('1234'), 'role_id' => 4, 'school_id' => 2,],
           ['name' => 'Dean 3', 'username' => 'deansoahs'.'@gmail.com', 'password' => Hash::make('1234'), 'role_id' => 4, 'school_id' => 3,],
           ['name' => 'Dean 4', 'username' => 'deansohss'.'@gmail.com', 'password' => Hash::make('1234'), 'role_id' => 4, 'school_id' => 4,],
           ['name' => 'Dean 5', 'username' => 'deanici'.'@gmail.com', 'password' => Hash::make('1234'), 'role_id' => 4, 'school_id' => 5,],
           ['name' => 'Accommodation', 'username' => 'accommodation'.'@gmail.com', 'password' => Hash::make('1234'), 'role_id' => 5,],
//            ['name' => 'Student', 'username' => 'student'.'@gmail.com', 'password' => Hash::make('1234'), 'role_id' => 6,],
////            ['name' => 'Exams', 'username' => 'examination'.'@gmail.com', 'password' => Hash::make('1234'), 'role_id' => 7,],
          ['name' => 'Medical', 'username' => 'medical'.'@gmail.com', 'password' => Hash::make('1234'), 'role_id' => 8,],
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
            ['initials'=>'SOB', 'name'=>'SCHOOL OF BUSINESS'],
            ['initials'=>'SoET', 'name'=>'SCHOOL OF ENGINEERING AND TECHNOLOGY'],
            ['initials'=>'SOAHS', 'name'=>'SCHOOL OF APPLIED AND HEALTH SCIENCES'],
            ['initials'=>'SOHSS', 'name'=>'SCHOOL OF HUMANITIES AND SOCIAL SCIENCES'],
            ['initials'=>'ICI', 'name'=>'SCHOOL OF COMPUTNG AND INFORMATICS'],
        ]); 

        DB::table('departments')->insert([
            ['school_id'=>'1', 'dept_code'=>'DAF', 'name'=>'DEPARTMENT OF ACCOUNTING AND FINANCE'],
            ['school_id'=>'1', 'dept_code'=>'DBA', 'name'=>'DEPARTMENT OF BUSINESS ADMINISTRATION'],
            ['school_id'=>'1', 'dept_code'=>'DHM', 'name'=>'DEPARTMENT OF MANAGEMENT SCIENCE'],
            ['school_id'=>'2', 'dept_code'=>'DABE', 'name'=>'DEPARTMENT OF ARCHITECTURE AND BUILT ENVIRONMENT'],
            ['school_id'=>'2', 'dept_code'=>'DBCE', 'name'=>'DEPARTMENT OF BUILDING AND CIVIL ENGINEERING'],
            ['school_id'=>'2', 'dept_code'=>'DEE', 'name'=>'DEPARTMENT OF ELECTRICAL AND ELECTRONIC ENGINEERING'],
            ['school_id'=>'2', 'dept_code'=>'DME', 'name'=>'DEPARTMENT OF MEDICAL ENGINEERING'],
            ['school_id'=>'2', 'dept_code'=>'DMAE', 'name'=>'DEPARTMENT OF MECHANICAL AND AUTOMOTIVE ENGINEERING'],
            ['school_id'=>'3', 'dept_code'=>'DEHS', 'name'=>'DEPARTMENT OF ENVIRONMENT AND HEALTH SCIENCES'],
            ['school_id'=>'3', 'dept_code'=>'DMP', 'name'=>'DEPARTMENT OF MATHEMATICS AND PHYSICS'],
            ['school_id'=>'3', 'dept_code'=>'DPAS', 'name'=>'DEPARTMENT OF PURE AND APPLIED SCIENCES'],
            ['school_id'=>'3', 'dept_code'=>'DOMS', 'name'=>'DEPARTMENT OF MEDICAL SCIENCES'],
            ['school_id'=>'4', 'dept_code'=>'DSS', 'name'=>'DEPARTMENT OF SOCIAL SCIENCES'],
            ['school_id'=>'4', 'dept_code'=>'DHTM', 'name'=>'DEPARTMENT OF HOSPITALITY AND TOURISM MANAGEMENT'],
            ['school_id'=>'4', 'dept_code'=>'DCS', 'name'=>'DEPARTMENT OF COMMUNICATION STUDIES'],
            ['school_id'=>'5', 'dept_code'=>'DCI', 'name'=>'DEPARTMENT OF COMPUTER SCIENCE AND INFORMATION TECHNOLOGY'],

        ]);   
    }
}
