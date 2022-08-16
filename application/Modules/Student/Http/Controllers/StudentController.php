<?php

namespace Modules\Student\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('student::student.index');
    }

    public function checkName(){
        $name = "You are not a student";
        if(Auth::guard('student')->check()){
            $id = Auth::guard('student')->user()->student_id;
            $student = DB::table('students')
                ->where('id', '=', $id)
                ->get();

            $name = $student[0]->fname;
        }
        print_r(json_encode(['name' => $name]));
    }

    public function profile(){
        return view('student::student.index');
    }

    public function change_course(){
        return view('student::student.course');
    }

    public function getCourses(){
        $courses = DB::table('courses')
            ->get();

        $courseSelect = [];
        foreach ($courses as $oneCourse)
            $courseSelect[] = [ 'id' => $oneCourse->id . "," . $oneCourse->course_name, 'text' => $oneCourse->course_name ];

        print_r(json_encode(['course' => $courseSelect]));
    }
    public function getTransferLogs(){
        $id = Auth::guard('student')->user()->student_id;
        $transfers = DB::table('course_transfer_logs')
            ->where('user_id', '=',  $id)
            ->where('status', '<=',  8)
            ->get();
        print_r(json_encode(['transfers' => $transfers]));
    }
    public function checkChange(){
        $id = Auth::guard('student')->user()->student_id;
        $courses = DB::table('course_transfer')
            ->where('user_id', '=',  $id)
            ->where('status', '<=',  8)
            ->get();

        $response = false;
        if(count($courses) > 0)
            $response = true;

        print_r(json_encode(['response' => $response]));
    }
    public function selectCourses(Request $request){
        $data = $request->json()->all();
        $id = Auth::guard('student')->user()->student_id;

        $add_course = DB::table('course_transfer')->insert([
            [ 'user_id' => $id, 'course_id' =>  $data['selected'], 'status' => '0', 'cut_off' => $data['cut_off'] ]
        ]);

        $add_transfer = DB::table('course_transfer_logs')->insert([
            [ 'user_id' => $id, 'level' => 'COD', 'course_id' => $data['selected'], 'status' => '0', 'reason' => 'PENDING COD ACTION', 'date' => date('Y-m-d') ]
        ]);

        $feedback = [];
        if($add_course == 1)
            $feedback []= true;
        else
            $feedback []= false;

        if($add_transfer == 1)
            $feedback []= true;
        else
            $feedback []= false;

        print_r(json_encode(['feedback' => $feedback]));
    }
    public function platform_courses(Request $request){
        $data = $request->json()->all();
        $value = $data['course'];
        $id = Auth::guard('student')->user()->student_id;
        //If transfer is already submitted ?
        $course_transfers = DB::table('course_transfer')
            ->where('user_id', '=', $id)
            ->where('status', '=', '0')
            ->get();

        $cut = false;

        if(count($course_transfers) < 1) {
            //Make sure the course is not currently done or not already submitted for course change
            $profile = DB::table('students')
                ->where('id', '=', $id)
                ->get();
            $cut = DB::table('courses')
                ->where('cut_off', '<=', (int)$value)
                ->where('id', '!=', $profile[0]->courses_id)
                ->get();
        }
        print_r(json_encode(['group' => $cut]));
    }

    public function checkProfile(){
        $id = Auth::guard('student')->user()->student_id;
        $student = DB::table('students')
            ->where('id', $id)
            ->get();

        $checkField = ['citizen','county','sub_county','town','address','postal_code'];
        $moreProfile = [];
        foreach($student as $user)
            foreach($user as $key => $value)
                if(in_array($key,$checkField))
                    $moreProfile []= $value;

        $feedback = true;
        if(in_array(null,$moreProfile))
            $feedback = false;

        print_r(json_encode(['user' => $feedback, 'extra' => $moreProfile]));
    }
    public function updateProfile(Request $request){
        $id = Auth::guard('student')->user()->student_id;
        $data = $request->json()->all();
        if(empty($data['value']))
            $data['value'] = null;
        $student = DB::table('students')
            ->where('id', $id)
            ->update([$data['key'] => $data['value']]);

        $feedback = false;
        if($student == 1)
            $feedback = true;

        print_r(json_encode(['feedback' => $feedback]));
    }
    public function updateImg(Request $request){

        $image = $request->file('image');

        print_r(json_encode(['feedback' => $image]));
    }
    public function student_profile(){
        $profile = false;
        if(Auth::guard('student')->check()) {
            $id = Auth::guard('student')->user()->student_id;
            $profile = DB::table('students')
                ->where('id', '=', $id)
                ->get();
        }
        print_r(json_encode(['user' => $profile]));
    }
    public function bindNav(){
        $nav_student = "";
        if(request()->is('student/*'))
            $nav_student = " open";

        $sub_navigation = "";
        if(request()->is('student/change_course'))
            $sub_navigation = " active";

        $body = "
                <li class='nav-main-item'>
                    <a class='nav-main-link nav-main-link-submenu' data-toggle='submenu' aria-haspopup='true' aria-expanded='true' href='#'>
                        <i class='nav-main-link-icon si si-user'></i>
                        <span class='nav-main-link-name' id = 'in_course'>Courses</span>
                    </a>
                    <ul class='nav-main-submenu'>
                      <li class='nav-main-item'>
                          <a class='nav-main-link$sub_navigation' href='" . route('change_course') . "'>
                              <i class='nav-main-link-icon si si-user'></i>
                              <span class='nav-main-link-name'>
                                Change Courses
                              </span>
                          </a>
                      </li>
                    </ul>
              </li>
              <li class='nav-main-item'>
                  <a class='nav-main-link nav-main-link-submenu' data-toggle='submenu' aria-haspopup='true' aria-expanded='true' href='#'>
                      <i class='nav-main-link-icon si si-user'></i>
                      <span class='nav-main-link-name'>Academics</span>
                  </a>
                  <ul class='nav-main-submenu'>
                      <li class='nav-main-item'>
                          <a class='nav-main-link$sub_navigation' href='" . route('change_course') . "'>
                              <i class='nav-main-link-icon si si-user'></i>
                              <span class='nav-main-link-name'>
                                Exams Transcripts
                            </span>
                          </a>
                      </li>
                  </ul>
                  <ul class='nav-main-submenu'>
                      <li class='nav-main-item'>
                          <a class='nav-main-link$sub_navigation href='". route('change_course') . "'>
                              <i class='nav-main-link-icon si si-user'></i>
                              <span class='nav-main-link-name'>
                                Fee
                                </span>
                          </a>
                      </li>
                  </ul>
                  <ul class='nav-main-submenu'>
                      <li class='nav-main-item'>
                          <a class='nav-main-link$sub_navigation' href='" . route('change_course') . "'>
                              <i class='nav-main-link-icon si si-user'></i>
                              <span class='nav-main-link-name'>
                                Units
                                </span>
                          </a>
                      </li>
                  </ul>
              </li>
              <li class='nav-main-item'>
                  <a class='nav-main-link nav-main-link-submenu' data-toggle='submenu' aria-haspopup='true' aria-expanded='true' href='#'>
                      <i class='nav-main-link-icon si si-user'></i>
                      <span class='nav-main-link-name'>Accomodation</span>
                  </a>
                  <ul class='nav-main-submenu'>
                      <li class='nav-main-item'>
                          <a class='nav-main-link$sub_navigation' href='" . route('change_course') . "'>
                              <i class='nav-main-link-icon si si-user'></i>
                              <span class='nav-main-link-name'>
                                Book Hostel
                                 </span>
                          </a>
                      </li>
                  </ul>
                  <ul class='nav-main-submenu'>
                      <li class='nav-main-item'>
                          <a class='nav-main-link$sub_navigation' href='" . route('change_course') . "'>
                              <i class='nav-main-link-icon si si-user'></i>
                              <span class='nav-main-link-name'>
                                    Clearing
                                </span>
                          </a>
                      </li>
                  </ul>
              </li>
        ";
        print_r(json_encode(['body' => $body]));
    }
}
