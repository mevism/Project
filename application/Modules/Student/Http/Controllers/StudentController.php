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

    public function selectCourses(Request $request){
        $data = $request->json()->all();
        $id = Auth::guard('student')->user()->student_id;

        $add_course = DB::table('course_transfer')->insert([
            [ 'user_id' => $id, 'course_id' =>  $data['selected'], 'status' => '0' ]
        ]);
        $feedback = false;
        if($add_course == 1)
            $feedback = true;

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
}
