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

            if (\auth()->guard('user')->user()->role_id == 0){
                $courses = AvailableCourse::count();
                $applications = Application::count();

                return view('admin.index')->with(['courses'=>$courses,'applications'=>$applications]);

            } elseif (\auth()->guard('user')->user()->role_id == 1){

                $courses = AvailableCourse::where('status', 1)->count();
                $applications = Application::where('registrar_status',0)->count();
                $admissions = AdmissionApproval::where('registrar_status',0)->count();

                return view('admin.index')->with(['courses'=>$courses,'applications'=>$applications,'admissions'=>$admissions]);

            } elseif (\auth()->guard('user')->user()->role_id == 2){

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

            }elseif (auth()->guard('user')->user()->role_id == 3){

                $apps_finance = Application::where('cod_status', null)
                    ->where('finance_status', '!=', 3)
                    ->count();

                return view('applications::finance.index')->with('apps', $apps_finance);

            }elseif (auth()->guard('user')->user()->role_id == 4){

                $apps_dean = Application::where('dean_status', 0)
                    ->where('school_id', auth()->guard('user')->user()->school_id)->count();
                return view('dean::dean.index')->with('apps', $apps_dean);

            }elseif (auth()->guard('user')->user()->role_id == 5){

                return view('hostel::hostels.index');

            }elseif (auth()->guard('user')->user()->role_id == 6){

                //
            }elseif (auth()->guard('user')->user()->role_id == 7){
                return redirect()->route('examination')->with("success",'Welcome');


            }elseif (\auth()->guard('user')->user()->role_id == 8){

                $apps = AdmissionApproval::where('registrar_status', null)
                    ->where('finance_status', 1)->count();

                return view('medical::medical.index')->with('apps', $apps);

//            }elseif (\auth()->guard('student')->check()){
//
//                return redirect()->route('student')->with('success', 'You are now logged in');

            }else{

                return redirect()->route('root')->with('error', 'You are not registered to use this system');
            }

        }else{

            return redirect()->route('root')->with('error', 'Your are not logged in. Please login first.');
        }
    }
}
