<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['name' => 'enter-student-marks', 'guard_name' => 'user'],
            ['name' => 'view-workload', 'guard_name' => 'user'],
            ['name' => 'print-class-list', 'guard_name' => 'user'],
            ['name' => 'book-hostel', 'guard_name' => 'user'],
            ['name' => 'allocate-hostel', 'guard_name' => 'user'],
            ['name' => 'publish-results', 'guard_name' => 'user'],
            ['name' => 'generate-admission-letters', 'guard_name' => 'user'],
            ['name' => 'view-exams', 'guard_name' => 'user'],
            ['name' => 'approve-application', 'guard_name' => 'user'],
            ['name' => 'approve-admission', 'guard_name' => 'user'],
        ];

        foreach ($permissions as $permission){
            Permission::firstOrCreate($permission);
        }

        $registrarRole = Role::firstOrCreate(['name' => 'Registrar', 'guard_name' => 'user']);
        $codRole = Role::firstOrCreate(['name' => 'Chairperson of Department', 'guard_name' => 'user']);
        $financeRole = Role::firstOrCreate(['name' => 'Student Finance', 'guard_name' => 'user']);
        $deanRole = Role::firstOrCreate(['name' => 'Director/Dean', 'guard_name' => 'user']);
        $accommodationRole = Role::firstOrCreate(['name' => 'Accommodation Manager', 'guard_name' => 'user']);
        $examsRole = Role::firstOrCreate(['name' => 'Exam Coordinator', 'guard_name' => 'user']);
        $medicalRole = Role::firstOrCreate(['name' => 'Medical Officer', 'guard_name' => 'user']);
        $adminRole = Role::firstOrCreate(['name' => 'System Administrator', 'guard_name' => 'user']);
        $timetablerRole = Role::firstOrCreate(['name' => 'Timetabler', 'guard_name' => 'user']);
        $lecturerRole = Role::firstOrCreate(['name' => 'Lecturer', 'guard_name' => 'user']);
        $adminAssistantRole = Role::firstOrCreate(['name' => 'Admin Assistant', 'guard_name' => 'user']);

       $registrarRole->givePermissionTo([
           'generate-admission-letters',
           'approve-admission',
           'approve-application'
       ]);

       $deanRole->givePermissionTo([
            'approve-workload',
            'publish-workload'
       ]);
       $codRole->givePermissionTo([
           'approve-admission',
           'approve-application',
           'view-workload',
           'print-class-list',
           'view-exams'
       ]);

       $lecturerRole->givePermissionTo([
           'enter-student-marks',
           'view-workload',
           'print-class-list',

       ]);

       $accommodationRole->givePermissionTo([
           'book-hostel',
           'allocate-hostel',
       ]);

       $examsRole->givePermissionTo([
           'publish-results',
           'view-exams'
       ]);

        $users = User::where('role_id', 2)->get();
        foreach ($users as $user){

            $user->assignRole('Chairperson of Department');
        }

        User::$guard_name = 'user';

        $role = Role::findByName('Chairperson of Department');

        $role->givePermissionTo([
            'approve-admission',
            'approve-application',
            'view-workload',
            'print-class-list',
            'view-exams'
        ]);


        $users = User::where('role_id', 2)->get();
        foreach ($users as $user){
            $user->givePermissionTo([
                'approve-admission',
                'approve-application',
                'view-workload',
                'print-class-list',
                'view-exams'
            ]);
        }



    }
}
