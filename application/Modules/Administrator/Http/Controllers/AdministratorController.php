<?php

namespace Modules\Administrator\Http\Controllers;

use App\Service\CustomIds;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Registrar\Entities\Department;
use Modules\Registrar\Entities\Division;
use Modules\Registrar\Entities\School;
use Modules\Registrar\Entities\SchoolDepartment;

class AdministratorController extends Controller
{
    public function showAllDepartment(){
        $departments = Department::latest()->get();

        return view('administrator::department.showDepartment')->with('departments', $departments);
    }
    public function addDepartment(){
        $schools = School::all();
        $division = Division::all();
        return view('administrator::department.addDepartment')->with(['schools' => $schools, 'divisions' => $division]);
    }

    public function storeDepartment(Request $request){

        $request->validate([
            'dept_code' => 'required|unique:departments',
            'name' => 'required|unique:departments',
            'division' => 'required',
        ]);

        $id = new CustomIds();
        $division = Division::where('name', $request->division)->first();

        $departments = new Department;
        $departments->department_id = $id->generateId();
        $departments->division_id = $division->division_id;
        $departments->dept_code = $request->input('dept_code');
        $departments->name = $request->input('name');
        $departments->save();

        if ($division->name == "ACADEMIC DIVISION"){
            $school = new SchoolDepartment;
            $school->school_id = $request->school;
            $school->department_id = $departments->department_id;
            $school->save();
        }

        return redirect()->route('admin.showDepartment')->with('success', 'Department Created');
    }

}
