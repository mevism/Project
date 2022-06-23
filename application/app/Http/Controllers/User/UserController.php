<?php

namespace App\Http\Controllers\User;

use Session;
use App\Models\User;
use App\Models\Course;
use App\Models\Intake;
use App\Models\School;
use http\Env\Response;
use App\Models\Classes;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Application\Entities\VerifyUser;
use Modules\Application\Entities\Application;
use Modules\Courses\Entities\AvailableCourse;

class UserController extends Controller
{
    public function login(Request $request){

//        return $request->all();
        $logins = $request->only('username', 'password');

        if (Auth::guard('user')->attempt($logins)){

            $name = Auth::guard('user')->user()->name;
            if (Auth::guard('user')->user()->role_id === 6){
                return redirect()->intended('/dashboard')->with('success', 'Welcome'." ".$name." ".'to'." ".config('app.name').".");
            }

            if (Auth::guard('user')->user()->role_id === 1){

                return redirect()->intended('/dashboard')->with('success', 'Welcome'." ".$name." ".'to'." ".config('app.name').".");
            }

            if (Auth::guard('user')->user()->role_id === 2){
                return redirect()->intended('/dashboard')->with('success', 'Welcome'." ".$name." ".'to'." ".config('app.name').".");
            }

            if (Auth::guard('user')->user()->role_id === 4){
                return redirect()->intended('/dashboard')->with('success', 'Welcome'." ".$name." ".'to'." ".config('app.name').".");
            }

            if (Auth::guard('user')->user()->role_id === 7){
                return redirect()->intended('/dashboard')->with('success', 'Welcome'." ".$name." ".'to'." ".config('app.name').".");
            }

            if (Auth::guard('user')->user()->role_id === 3){
                return redirect()->intended('/dashboard')->with('success', 'Welcome'." ".$name." ".'to'." ".config('app.name').".");
            }
        }
        if(Auth::guard('web')->attempt($logins, true)){
            if (Auth::guard('user'))
                return redirect()->route('application.applicant')->with('success', 'Welcome'." ".Auth::user()->email." ".Auth::user()->role_id."  ".'to'." ".config('app.name').".");

        }else{
            return redirect('/')->with('error', 'Your details did not match to any record in the database');
        }

    }
    public function dashboard(){

       if (Auth::guard('user')->user()->role_id === 1){
        $courses = AvailableCourse::count();
        $applications = Application::count();
           if (!Auth::guard('user')->check()){
               abort(403);
           } else{
               return view('admin.index')->with(['courses'=>$courses,'applications'=>$applications]);
           }
       }elseif (Auth::guard('user')->user()->role_id === 6){
           if (!Auth::guard('user')->check()){
               abort(403);
           } else{
               return view('student.index');
           }
       }elseif (Auth::guard('user')->user()->role_id === 2){
           if (!Auth::guard('user')->check()){
               abort(403);
           } else{
               return view('cod::cod.index');
           }
       }elseif (Auth::guard('user')->user()->role_id === 4){
           if (!Auth::guard('user')->check()){
               abort(403);
           } else{
               return view('approval::dean.index');
           }
       }elseif (Auth::guard('user')->user()->role_id === 3){
           if (!Auth::guard('user')->check()){
               abort(403);
           } else{
               return view('applications::finance.index');
           }
       }else{
           return redirect('application/applicant');
       }
    }


    //    public function logout(){
    //        Session::flush();
    //        Auth::logout();
    //
    //        return redirect( route('root'))->with('info', 'You have logged out');
    //    }

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
