<?php

namespace App\Http\Controllers\User;

use Modules\Application\Entities\AdmissionApproval;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Application\Entities\VerifyUser;
use Modules\Application\Entities\Application;
use Modules\Registrar\Entities\AvailableCourse;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $logins = $request->only('username', 'password');


        if (Auth::guard('user')->attempt($logins)) {

            $name = Auth::guard('user')->user()->name;

            if (Auth::guard('user')->user()) {
                return redirect()->intended('/dashboard')->with('success', 'Welcome' . " " . $name . " " . 'to' . " " . config('app.name') . ".");
            }
        }
        if (Auth::guard('web')->attempt($logins, true)) {
            if (Auth::guard('web'))
                return redirect()->route('application.applicant')->with('success', 'Welcome' . " " . Auth::user()->email . " " . Auth::user()->role_id . "  " . 'to' . " " . config('app.name') . ".");

        }

        if (Auth::guard('student')->attempt($logins, true)) {

            if (Auth::guard('student')) {

                return redirect()->route('student')->with('success', 'You have logged in');

            }

        } else {
            return redirect('/')->with('error', 'Your details did not match to any record in the database');
        }

    }
    public function dashboard(){

        if (auth()->guard('user')->check()){

            if (\auth()->guard('user')->user()->role_id === 0){
                $courses = AvailableCourse::count();
                $applications = Application::count();

                return view('admin.index')->with(['courses'=>$courses,'applications'=>$applications]);

            } elseif (\auth()->guard('user')->user()->role_id === 1){

                $courses = AvailableCourse::where('status', 1)->count();
                $applications = Application::where('registrar_status',0)->count();
                $admissions = AdmissionApproval::where('registrar_status',0)->count();

                return view('admin.index')->with(['courses'=>$courses,'applications'=>$applications,'admissions'=>$admissions]);

            } elseif (\auth()->guard('user')->user()->role_id === 2){

                $admissions = Application::where('cod_status', 1)
                    ->where('department_id',auth()->guard('user')->user()->department_id)
                    ->where('registrar_status',3)
                    ->where('status',0)
                    ->count();

                $apps_cod = Application::where('cod_status', 0)
                    ->where('department_id', auth()->guard('user')->user()->department_id)
                    ->orWhere('dean_status', 3)
                    ->count();

                return view('cod::COD.index')->with(['apps'=>$apps_cod, 'admissions'=>$admissions]);

            }elseif (auth()->guard('user')->user()->role_id === 3){

                $apps_finance = Application::where('cod_status', null)
                    ->where('finance_status', '!=', 3)
                    ->count();

                return view('applications::finance.index')->with('apps', $apps_finance);

            }elseif (auth()->guard('user')->user()->role_id === 4){

                $apps_dean = Application::where('dean_status', 0)
                    ->where('school_id', auth()->guard('user')->user()->school_id)->count();
                return view('dean::dean.index')->with('apps', $apps_dean);

            }elseif (auth()->guard('user')->user()->role_id === 5){

                return view('hostel::hostels.index');

            }elseif (auth()->guard('user')->user()->role_id === 6){

                //
            }elseif (auth()->guard('user')->user()->role_id === 7){


            }elseif (\auth()->guard('user')->user()->role_id === 8){

                $apps = AdmissionApproval::where('registrar_status', null)
                    ->where('finance_status', 1)->count();

                return view('medical::medical.index')->with('apps', $apps);

            }elseif (\auth()->guard('student')->check()){

                return redirect()->route('student')->with('success', 'You are now logged in');

            }else{

                return redirect()->route('root')->with('error', 'You are not registered to use this system');
            }

        }else{

            return redirect()->route('root')->with('error', 'Your are not looged in. Please login first.');
        }
    }


    /**
     *
     * information about intake
     */
    public function addIntake(){

        return view('intakes.addintake');
    }

    public function admin(){
        if (!Auth::guard('user')->check()){
            abort(403);
        } else{
            return view('admin.index');
        }
    }

    public function logout(){
        Session::flush();
        Auth::logout();

        return redirect( route('root'))->with('info', 'You have logged out');
    }
    public function showIntake(){

        //return Intake::all();
         $data = Intake::all();
         return view('intakes.showIntake')->with('data',$data);
    }

    public function storeIntake(Request $request){

        $intakes                =    new Intake;
        $intakes->intake_name   =    $request->input('intake_name');
        $intakes->save();

        return redirect('/admin')->with('success','Intake Created');
    }


    /**
     *
     * Information about departments
     */
    public function adddept(){
        $schools = School::all();
        return view('department.adddept')->with('schools',$schools);
    }

    public function showDept()
    {
        $data = Department::all();
        return view('department.showDept')->with('data',$data);
    }

    public function insert(Request $request){
        $this->validate($request,[
            'name'     =>   'required',
            'school'   =>   'required'
        ]);

        $departments             =       new Department;
        $departments->name       =       $request->input('name');
        $departments->school_id  =       $request->input('school');
        $departments->save();

        return redirect('/admin')->with('success','Department Created');
    }

    /**
     *
     * Information about School
    */
    public function addschool(){
        return view('school.addschool');
    }

    public function showSchool(){

        $data    =   School::all();
        return view('school.showSchool')->with('data',$data);

    }

    public function insertSchool(Request $request){
        $this->validate($request,[
            'name' => 'required'
        ]);
        $schools         =     new School;
        $schools->name   =     $request->input('name');
        $schools->save();

        return redirect('/admin')->with('success','School Created');
    }


    /**
     *
     * Information about Course
    */
    public function addCourse(){
        $schools = School::all();
        $departments = Department::all();
        return view('courses.addcourse')->with(['schools' => $schools, 'departments'=>$departments]);
    }
    public function getDepartment(Request $request)
    {
        $school_id = $request->post('school_id');
        $departments= DB::table('departments')->where('school',$school_id)->orderBy('departments','asc')->get();
        //print_r('departments');
        $html='<option selected disabled> Select Department</option>';
        foreach($departments as $list){
            $html.='<option value="'.$list->id.'">' .$list->departments.'</option>';
            echo $html;
        }
    }

    public function storeCourse(Request $request){
        $this->validate($request,[
            'course_name'           =>    'required',
            'course_code'           =>    'required',
            'course_duration'       =>    'required',
            'course_requirements'   =>    'required',
            'school'                =>    'required',
            'department'            =>    'required'
        ]);

        $courses                      =    new Course;
        $courses->course_name         =    $request->input('course_name');
        $courses->course_code         =    $request->input('course_code');
        $courses->course_duration     =    $request->input('course_duration');
        $courses->course_requirements =    $request->input('course_requirements');
        $courses->school_id           =    $request->input('school');
        $courses->department_id       =    $request->input('department');
        $courses->save();

        return redirect(route('courses'))->with('success','Course Created');
    }

    public function showCourse()
    {
        $data = Course::all();
        return view('courses.showCourse')->with('data',$data);
    }

    /**
     *
     * information about class
     */

    public function addClass(){
        return view('class.addclass');
    }

    public function storeClass(Request $request){

        $class         =    new Classes;
        $class->name   =    $request->input('name');
        $class->save();

        return redirect('/admin')->with('success','Class Created');
    }

    public function showClasses()
    {
        $data = Classes::all();
        return view('class.showClasses')->with('data',$data);
    }

    public function getSchools(){

        $schools = DB::table('schools')->get();

        return $schools;
    }

    public function getDepartments(Request $request){
        $departments = DB::table('departments')->where('id', $request->school_id)->get();
        if (count($departments)>0){
            return response()->json($departments);
        }
    }

    public function getCourses(Request $request){
        $courses = DB::table('courses')->where('id', $request->department_id)->get();

        if (count($courses)>0){
            return response()->json($courses);
        }
    }

    public function getClasses(Request $request){
        $classes = DB::table('classes')->where('id', $request->department_id)->get();

        if (count($classes)>0){
            return response()->json($classes);
        }
    }

    public function show(Course $course){
        return view('application::applicant.application')->with('course', $course);
    }

}
