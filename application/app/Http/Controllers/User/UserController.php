<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Session;
use Modules\Application\Entities\AdmissionApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Application\Entities\ApplicationApproval;
use Modules\Application\Entities\VerifyUser;
use Modules\Application\Entities\Application;
use Modules\COD\Entities\AdmissionsView;
use Modules\COD\Entities\ApplicationsView;
use Modules\Registrar\Entities\AvailableCourse;
use Modules\Registrar\Entities\Courses;
use Modules\Registrar\Entities\SchoolDepartment;

class UserController extends Controller
{
    public function signOut(){
        Session::flush();
        $guards = array_keys(config('auth.guards'));
        foreach ($guards as $guard) {
            if(Auth::guard($guard)->check()) {
                Auth::guard($guard)->logout();
            }
        }
        return redirect()->route('root')->with('success', 'You are now logged out');
    }
    public function login(Request $request){
        $logins = $request->only('username', 'password');
        if (\auth()->guard('user')->attempt($logins)) {
            if (auth()->guard('user')->user()) {
                return redirect()->intended('/dashboard');
            }
        }elseif (\auth()->guard('web')->attempt($logins, true)) {
            return redirect()->route('application.applicant');
        }elseif (\auth()->guard('student')->attempt($logins, true)) {
            if (\auth()->guard('student')) {
                return redirect()->route('student')->with('success', 'You have logged in');
            }
        } else {
            return redirect('/')->with('error', 'Your details did not match to any record in the database');
        }
    }
    public function dashboard(){
        if (auth()->guard('user')->check()){
            // return auth()->guard('user')->user();
            if (\auth()->guard('user')->user()->roles->first()->id == 0){
                $courses = AvailableCourse::count();
                $applications = Application::count();

                return view('admin.index')->with(['courses'=>$courses,'applications'=>$applications]);

            } elseif (\auth()->guard('user')->user()->roles->first()->id == 1){

                $courses = AvailableCourse::where('status', 1)->count();
//                $applications = ApplicationsView::where('registrar_status',0)->count();
                $applications = 0;
                $admissions = AdmissionApproval::where('registrar_status',0)->count();

                return view('admin.index')->with(['courses'=>$courses,'applications'=>$applications,'admissions'=>$admissions]);

            } elseif (\auth()->guard('user')->user()->roles->first()->id == 2){
                $courseIDs = Courses::where('department_id', auth()->guard('user')->user()->employmentDepartment->first()->department_id)->pluck('course_id');
               $apps_cod = ApplicationsView::where('cod_status', null )->whereIn('course_id', $courseIDs)->where('student_type', 1)->count();
               $classes = DB::table('classesview')->where('department_id', auth()->guard('user')->user()->employmentDepartment->first()->department_id)->count();
                $admissions = AdmissionsView::whereIn('course_id', $courseIDs)->where('cod_status', 0)->get()->count();

                return view('cod::COD.index')->with(['apps'=>$apps_cod, 'admissions'=>$admissions, 'classes' => $classes]);

            }elseif (\auth()->guard('user')->user()->roles->first()->id == 3){
                $apps_finance = Application::all()->count();
                return view('applications::finance.index')->with('apps', $apps_finance);
            }elseif (auth()->guard('user')->user()->roles->first()->id == 4){
                $departments = SchoolDepartment::where('school_id', auth()->guard('user')->user()->employmentDepartment->first()->schools->first()->school_id)->pluck('department_id');
                $courses = Courses::whereIn('department_id', $departments)->pluck('course_id');
                $apps_dean = ApplicationsView::whereIn('course_id', $courses)->where('dean_status', 0)->get()->count();
                return view('dean::dean.index')->with('apps', $apps_dean);

            }elseif (auth()->guard('user')->user()->roles->first()->id == 5){

                return view('hostel::hostels.index');

            }elseif (auth()->guard('user')->user()->roles->first()->id == 11){

                //
            }elseif (auth()->guard('user')->user()->roles->first()->id == 6){
                return redirect()->route('examination')->with("success",'Welcome');


            }elseif (\auth()->guard('user')->user()->roles->first()->id == 7){
                $apps = AdmissionsView::where('registrar_status', null)->count();
                return view('medical::medical.index')->with('apps', $apps);
            }elseif (\auth()->guard('user')->user()->roles->first()->id == 8){

                return view('lecturer::index');


            }elseif (\auth()->guard('student')->check()){
//                return '\auth()->guard('student')->user()';

                return redirect()->route('student')->with('success', 'You are now logged in');

            }else{

                return redirect()->route('root')->with('error', 'You are not registered to use this system');
            }

        }else{

            return redirect()->route('root')->with('error', 'Your are not logged in. Please login first.');
        }
    }
}
