<?php

namespace Modules\User\Http\Controllers;

use App\Models\User;
use App\Models\UserEmployment;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Administrator\Entities\Staff;
use Modules\Registrar\Entities\Campus;
use Modules\Registrar\Entities\Department;
use Modules\Registrar\Entities\Division;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        $users = User::latest()->get();
        $staff = Staff::all();
        return view('user::index')->with(['users' => $users, 'staff' => $staff]);
    }

    public function addNewUser(Request $request){

        $request->validate([
            'search' => 'required'
        ]);
        $campuses = Campus::all();
        $divisions = Division::all();
        $staff = Staff::where('STAFFNO', $request->search)->first();
        $roles = Role::all();
        return view('user::users.addNewUser')->with(['staff' => $staff, 'campuses' => $campuses, 'divisions' => $divisions, 'roles' => $roles]);

    }

    public function divisionDepartment(Request $request){

        $data = Department::where('division_id', $request->division)->latest()->get();

        return response()->json($data);
    }

    public function getDepartment(Request $request){

        $data = Department::findorFail($request->deptID);

        return response()->json($data);
    }

    public function importUsers(Request $request, $id){

        $request->validate([
           'campus' => 'required',
           'division' => 'required',
           'department' => 'required',
           'station' => 'required',
           'role' => 'required',
           'contract' => 'required',
        ]);

        $staffNo = Crypt::decrypt($id);

        $staff = Staff::where('STAFFNO', $staffNo)->first();

        $user = new User;
        $user->staff_number = $staffNo;
        $user->title = $staff->SLTCODE;
        $user->first_name = $staff->NAMEFIRST;
        $user->middle_name = $staff->NAMEMID;
        $user->last_name = $staff->NAMELAST;
        $user->personal_email = $staff->EMAILP;
        $user->office_email = $staff->EMAIL0;
        $user->gender = $staff->GNDCODE;
        $user->phone_number = $staff->MOMBILE;
        $user->username = $staffNo;
        $user->password = Hash::make($staff->NATIONALID);
        $user->save();

        $userDept = new UserEmployment;
        $userDept->user_id = $user->id;
        $userDept->role_id = $request->role;
        $userDept->campus_id = $request->campus;
        $userDept->division_id = $request->division;
        $userDept->department_id = $request->department;
        $userDept->station_id = $request->station;
        $userDept->employment_terms = $request->contract;
        $userDept->save();

        return redirect()->route('admin.users')->with('success', 'User added successfully');

    }

    public function addUserRole($id){

        $hashedId = Crypt::decrypt($id);
        $campuses = Campus::all();
        $divisions = Division::all();
        $roles = Role::all();

        $user = User::findorFail($hashedId);

        return view('user::users.addUserRoles')->with(['user' => $user, 'campuses' => $campuses, 'divisions' => $divisions, 'roles' => $roles]);
    }

    public function storeUserRole(Request $request, $id){

        $hashedId = Crypt::decrypt($id);

        $request->validate([
            'campus' => 'required',
            'division' => 'required',
            'department' => 'required',
            'station' => 'required',
            'role' => 'required',
            'contract' => 'required',
        ]);

        $newEmployment = new UserEmployment;
        $newEmployment->user_id = $hashedId;
        $newEmployment->role_id = $request->role;
        $newEmployment->campus_id = $request->campus;
        $newEmployment->division_id = $request->division;
        $newEmployment->department_id = $request->department;
        $newEmployment->station_id = $request->station;
        $newEmployment->employment_terms = $request->contract;
        $newEmployment->save();

        return redirect()->route('admin.users')->with('success', 'User role added successfully');

    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('user::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('user::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('user::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
