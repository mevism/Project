<?php

namespace Modules\User\Http\Controllers;

use App\Models\User;
use App\Models\UserEmployment;
use App\Service\CustomIds;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Modules\Administrator\Entities\Staff;
use Modules\Administrator\Http\API\StaffInfoAPI;
use Modules\Registrar\Entities\Campus;
use Modules\Registrar\Entities\Department;
use Modules\Registrar\Entities\Division;
use Modules\User\Entities\StaffInfo;
use Spatie\Permission\Models\Role;
use GuzzleHttp;

class UserController extends Controller
{
    protected $staffInfoAPI;

    public function __construct(StaffInfoAPI $staffInfoAPI){

        $this->staffInfoAPI = $staffInfoAPI;

    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $users = Staff::latest()->get();

        return view('user::index')->with(['users' => $users]);
    }

    public function fetchById(Request $request){

        $userId = $request->userId;
        $staffNumber = $request->staffNumber;
        $data = $this->staffInfoAPI->fetchStaff($staffNumber, $userId);
        $campuses = Campus::all();
        $divisions = Division::all();
        $roles = Role::all();

        if (count($data) == 0){
            return  redirect()->back()->with('error', 'Oops!! Details provided do not match any records');
        }

        return view('user::users.addNewUser')->with(['staff' => $data, 'campuses' => $campuses, 'divisions' => $divisions, 'roles' => $roles]);

    }


    public function divisionDepartment(Request $request){

        $data = Department::where('division_id', $request->division)->latest()->get();

        return response()->json($data);
    }

    public function getDepartment(Request $request){

      $data = Department::where('department_id', $request->deptID)->first();

        return response()->json($data);
    }

    public function importUsers(Request $request){

        $request->validate([
           'campus' => 'required',
           'division' => 'required',
           'department' => 'required',
           'station' => 'required',
           'role' => 'required',
           'contract' => 'required',
        ]);

        $userId = $request->input('userId');
        $staffNumber = $request->input('staffNumber');
        $data = $this->staffInfoAPI->fetchStaff($staffNumber, $userId);

        $userID = new CustomIds();
        $staffInfo = new StaffInfo;
        $staffInfo->user_id = $userID->generateId();
        $staffInfo->staff_number = $data['dataPayload']['data']['staff_number'];
        $staffInfo->title = 'NA';
        $staffInfo->first_name = $data['dataPayload']['data']['first_name'];
        $staffInfo->middle_name =$data['dataPayload']['data']['middle_name'];
        $staffInfo->last_name = $data['dataPayload']['data']['last_name'];
        $staffInfo->personal_email = $data['dataPayload']['data']['personal_email'];
        $staffInfo->office_email = $data['dataPayload']['data']['work_email'];
        $staffInfo->gender = $data['dataPayload']['data']['gender'];
        $staffInfo->phone_number = $data['dataPayload']['data']['mobile_number'];
        $staffInfo->save();

        $user = new User;
        $user->user_id = $staffInfo->user_id;
        $user->username = $data['dataPayload']['data']['staff_number'];
        $user->password = Hash::make($data['dataPayload']['data']['id_number']);
        $user->save();

        $userDept = new UserEmployment;
        $userDept->user_id = $staffInfo->user_id;
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

        $campuses = Campus::all();
        $divisions = Division::all();
        $roles = Role::all();

        $user = Staff::where('user_id', $id)->first();

        return view('user::users.addUserRoles')->with(['user' => $user, 'campuses' => $campuses, 'divisions' => $divisions, 'roles' => $roles]);
    }

    public function storeUserRole(Request $request, $id){

        $request->validate([
            'campus' => 'required',
            'division' => 'required',
            'department' => 'required',
            'station' => 'required',
            'role' => 'required',
            'contract' => 'required',
        ]);

        $newEmployment = new UserEmployment;
        $newEmployment->user_id = $id;
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
