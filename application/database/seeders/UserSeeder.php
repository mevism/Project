<?php

namespace Database\Seeders;

// use Carbon;
use App\Service\CustomIds;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Modules\Registrar\Entities\Campus;
use Modules\Registrar\Entities\ClusterSubject;
use Modules\Registrar\Entities\ClusterSubjects;
use Modules\Registrar\Entities\Group;
use Modules\Registrar\Entities\VoteHead;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $groups = [
//            ['name' => 'GROUP I'],
//            ['name' => 'GROUP II'],
//            ['name' => 'GROUP III'],
//            ['name' => 'GROUP IV'],
//            ['name' => 'GROUP V']
//        ];
//
//        foreach ($groups as $group) {
//            $groupId = new CustomIds();
//            Group::create(['group_id' => $groupId->generateId(), 'name' => $group['name']]);
//        }
//
//
//        $campuses = [
//            ['name' => 'MAIN CAMPUS'],
//            ['name' => 'KWALE CAMPUS'],
//            ['name' => 'LAMU CAMPUS'],
//        ];
//
//        foreach ($campuses as $campus){
//            $campusId = new CustomIds();
//            Campus::create(['campus_id' => $campusId->generateId(), 'name' => $campus['name']]);
//        }
//
//        $subjects = [
//            ['group' => 'GROUP I', 'subject' => 'MAT'],
//            ['group' => 'GROUP I', 'subject' => 'ENG'],
//            ['group' => 'GROUP I', 'subject' => 'KIS'],
//            ['group' => 'GROUP II', 'subject' => 'CHEM'],
//            ['group' => 'GROUP II', 'subject' => 'BIO'],
//            ['group' => 'GROUP II', 'subject' => 'PHY'],
//            ['group' => 'GROUP III', 'subject' => 'HIS'],
//            ['group' => 'GROUP III', 'subject' => 'GEO'],
//            ['group' => 'GROUP III', 'subject' => 'CRE'],
//            ['group' => 'GROUP III', 'subject' => 'HRE'],
//            ['group' => 'GROUP III', 'subject' => 'IRE'],
//            ['group' => 'GROUP IV', 'subject' => 'HSCI'],
//            ['group' => 'GROUP IV', 'subject' => 'AGRI'],
//            ['group' => 'GROUP IV', 'subject' => 'WWORK'],
//            ['group' => 'GROUP IV', 'subject' => 'COMP'],
//            ['group' => 'GROUP IV', 'subject' => 'MWORK'],
//            ['group' => 'GROUP V', 'subject' => 'BUS'],
//            ['group' => 'GROUP V', 'subject' => 'FRE'],
//            ['group' => 'GROUP V', 'subject' => 'GER'],
//            ['group' => 'GROUP V', 'subject' => 'ARAB'],
//            ['group' => 'GROUP V', 'subject' => 'MUSIC'],
//            ['group' => 'GROUP V', 'subject' => 'SIGN LANG'],
//        ];
//
//        foreach ($subjects as $subject){
//           $group = Group::where('name', $subject['group'])->first();
//            ClusterSubject::create(['group_id' => $group->group_id, 'subject' => $subject['subject']]);
//        }
//
////        $voteheads  =  [
////            ['name' => 'CAUTION MONEY'],
////            ['name' =>  'STUDENT UNION'],
////            ['name'=>'MEDICAL LEVY'],
////            ['name' => 'TUITION FEE'],
////            ['name'=> 'INDUSTRIAL ATTACHMENT'],
////            ['name' => 'STUDENT ID'],
////            ['name' => 'EXAMINATION'],
////            ['name' => 'REGISTRATION FEE'],
////            ['name' => 'LIBRARY LEVY'],
////            ['name' => 'I.C.T LEVY'],
////            ['name' => 'ACTIVITY FEE'],
////            ['name' => 'STUDENT BENEVOLENT'],
////            ['name' => 'KUCCPS PLACEMENT FEE'],
////            ['name' => 'CUE LEVY']
////        ];
////
////        foreach ($voteheads as $votehead){
////            $voteheadId = new CustomIds();
////            VoteHead::create(['votehead_id' => $voteheadId->generateId(), 'name' => $votehead['name']]);
////        }
//
//          DB::table('levels')->insert([
//              ['name' => 'CERTIFICATE'],
//              ['name' => 'DIPLOMA'],
//              ['name' => 'UNDERGRADUATE'],
//              ['name' => 'POSTGRADUATE'],
//              ['name' => 'NON STANDARD']
//          ]);
//
//          DB::table('events')->insert([
//             ['name' => 'SEMESTER REGISTRATION'],
//             ['name' => 'RETAKE'],
//             ['name' => 'READMISSION'],
//             ['name' => 'ACADEMIC LEAVE/DIFFERMENT'],
//             ['name' => 'TRANSFER']
//         ]);
//        DB::table('attendances')->insert([
//            ['attendance_code'=>'S-FT','attendance_name' => 'SELF SPONSORED FULL TIME'],
//            ['attendance_code'=>'J-FT', 'attendance_name' => 'GOVERNMENT SPONSORED'],
//            ['attendance_code'=>'S-PT','attendance_name' => 'SELF SPONSORED PART TIME'],
//            [ 'attendance_code'=>'S-EV','attendance_name' => 'SELF SPONSORED EVENING'],
//
//        ]);
//        DB::table('divisions')->insert([
//            ['division_id'=>'368HZXbsoMi','name' => 'ACADEMIC DIVISION'],
//            ['division_id'=>'NjvCrvr9X0W','name' => 'ADMINISTRATIVE DIVISION'],
//
//        ]);
//        DB::table('campuses')->insert([
//            ['campus_id' => '668HZXbsoM2','name' => 'MAIN CAMPUS'],
//
//        ]);
//
//        DB::table('departments')->insert([
//            ['department_id' => '368HZXbsoM2','division_id' =>  'NjvCrvr9X0W', 'dept_code'=> 'RAA' , 'name'  => 'REGISTRARAA'],
//        ]);
//
//        DB::table('users')->insert([
//            ['user_id' => '368HZXbso22','username' => 'admin', 'password'  =>  Hash::make('pass')]
//        ]);

        DB::table('roles')->insert([
            ['name' => 'REGISTRAR','guard_name' => 'user'],
            ['name' => 'CHAIRPERSON OF DEPARTMENT','guard_name' => 'user'],
            ['name' => 'STUDENT FINANCE','guard_name' => 'user'],
            ['name' => 'DEAN/DIRECTOR','guard_name' => 'user'],
            ['name' => 'ACCOMMODATION','guard_name' => 'user'],
            ['name' => 'EXAM COORDINATOR','guard_name' => 'user'],
            ['name' => 'MEDICAL OFFICER','guard_name' => 'user'],
            ['name' => 'LECTURER','guard_name' => 'user'],
        ]);

        DB::table('user_employments')->insert([
            ['user_id' => '368HZXbso22','department_id' => '368HZXbsoM2','division_id' =>  'NjvCrvr9X0W', 'campus_id' => '668HZXbsoM2','role_id' => 1,'station_id' => '368HZXbsoM2','employment_terms' => 'FT'],
        ]);

         DB::table('staff_infos')->insert([
           ['user_id' => '368HZXbso22' , 'staff_number' => '00N00000', 'title' => 'admin', 'first_name' => 'Super', 'middle_name' => 'System', 'last_name' => 'Admin', 'phone_number' => '0700000000', 'office_email' => 'admin@gmail.com', 'personal_email'=>'admin@gmail.com', 'gender' => 'O']
         ]);

    }


}
