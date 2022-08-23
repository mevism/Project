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
//            ['name' => 'Registrar', 'username' => 'registrar'.'@gmail.com', 'password' => Hash::make('1234'), 'role_id' => 1,],
//            ['name' => 'COD 1', 'username' => 'cod0'.'@gmail.com', 'password' => Hash::make('1234'), 'role_id' => 2, 'department_id' => 1,],
//            ['name' => 'COD 2', 'username' => 'cod1'.'@gmail.com', 'password' => Hash::make('1234'), 'role_id' => 2, 'department_id' => 2,],
//            ['name' => 'COD 3', 'username' => 'cod2'.'@gmail.com', 'password' => Hash::make('1234'), 'role_id' => 2, 'department_id' => 3,],
//            ['name' => 'COD 4', 'username' => 'cod3'.'@gmail.com', 'password' => Hash::make('1234'), 'role_id' => 2, 'department_id' => 4,],
//            ['name' => 'COD 5', 'username' => 'cod4'.'@gmail.com', 'password' => Hash::make('1234'), 'role_id' => 2, 'department_id' => 5,],
//            ['name' => 'COD 6', 'username' => 'cod5'.'@gmail.com', 'password' => Hash::make('1234'), 'role_id' => 2, 'department_id' => 6,],
//            ['name' => 'COD 7', 'username' => 'cod6'.'@gmail.com', 'password' => Hash::make('1234'), 'role_id' => 2, 'department_id' => 7,],
//            ['name' => 'COD 8', 'username' => 'cod7'.'@gmail.com', 'password' => Hash::make('1234'), 'role_id' => 2, 'department_id' => 8,],
//            ['name' => 'COD 9', 'username' => 'cod8'.'@gmail.com', 'password' => Hash::make('1234'), 'role_id' => 2, 'department_id' => 9,],
//            ['name' => 'COD 10', 'username' => 'cod9'.'@gmail.com', 'password' => Hash::make('1234'), 'role_id' => 2, 'department_id' => 10,],
            ['name' => 'Finance', 'username' => 'finance'.'@gmail.com', 'password' => Hash::make('1234'), 'role_id' => 3,],
//            ['name' => 'Dean 1', 'username' => 'dean1'.'@gmail.com', 'password' => Hash::make('1234'), 'role_id' => 4, 'school_id' => 1,],
//            ['name' => 'Dean 2', 'username' => 'dean2'.'@gmail.com', 'password' => Hash::make('1234'), 'role_id' => 4, 'school_id' => 2,],
//            ['name' => 'Dean 3', 'username' => 'dean3'.'@gmail.com', 'password' => Hash::make('1234'), 'role_id' => 4, 'school_id' => 3,],
//            ['name' => 'Dean 4', 'username' => 'dean4'.'@gmail.com', 'password' => Hash::make('1234'), 'role_id' => 4, 'school_id' => 4,],
//            ['name' => 'Dean 5', 'username' => 'dean5'.'@gmail.com', 'password' => Hash::make('1234'), 'role_id' => 4, 'school_id' => 5,],
//            ['name' => 'Accommodation', 'username' => 'accommodation'.'@gmail.com', 'password' => Hash::make('1234'), 'role_id' => 5,],
////            ['name' => 'Student', 'username' => 'student'.'@gmail.com', 'password' => Hash::make('1234'), 'role_id' => 6,],
////            ['name' => 'Exams', 'username' => 'examination'.'@gmail.com', 'password' => Hash::make('1234'), 'role_id' => 7,],
//            ['name' => 'Medical', 'username' => 'medical'.'@gmail.com', 'password' => Hash::make('1234'), 'role_id' => 8,],
////            ['name' => 'Admin', 'username' => 'admin'.'@gmail.com', 'password' => Hash::make('1234'), 'role_id' => 0,],
        ];

        foreach ($users as $user){
            DB::table('users')->insert([ $user ]);
        }
    }
}
