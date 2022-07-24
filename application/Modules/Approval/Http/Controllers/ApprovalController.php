<?php

namespace Modules\Approval\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Approval\Entities\Education;
use Modules\Approval\Entities\Work;
use Modules\Approval\Entities\Application;
use Modules\Approval\Entities\Applicants;
use Modules\Approval\Entities\Course;
use Modules\Approval\Entities\Attendances;
use Modules\Approval\Entities\Intake;
use Modules\Approval\Entities\StatusYear;
use Modules\Approval\Entities\IntakeYears;
use DB;
use Modules\Approval\Entities\IntakeCourse;

class ApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('approval::index');
    }
   /*
    * First login redirect
    */
    public function dashboard(){

        if (Auth::check()) {

            if (Auth::user()->email_verified_at === null){
                Auth::logout();

                return redirect(route('root'))->with('warning', 'Please verify your email first');
            }
            if (Auth::user()->user_status === 0) {
                return redirect()->route('application.details')->with(['info' => 'Please update your profile']);

            } else {

                if(Auth::guard('user')->user()->role_id == 2)
                    return view('approval::cod.index');
                else
                    return view('approval::dean.index');

            }
            redirect()->route('application.login')->with('error', 'Please try again');
        }

    }
    /**
     *@views
     */
    public function pending(){
        $roles = Auth::guard('user')->user()->role_id;

       if ($roles == 2){
           if (!Auth::guard('user')->check()){
               abort(403);
           } else{
               return view('approval::cod.pending');
           }
       }
       if ($roles == 4){
           if (!Auth::guard('user')->check()){
               abort(403);
           } else{
               return view('approval::dean.pending');
           }
       }
    }
    public function approved(){
       $roles = Auth::guard('user')->user()->role_id;
       if ($roles == 2){
           if (!Auth::guard('user')->check()){
               abort(403);
           } else{
               return view('approval::cod.approved');
           }
       }
       if ($roles == 4){
           if (!Auth::guard('user')->check()){
               abort(403);
           } else{
               return view('approval::dean.approved');
           }
       }
    }
    public function rejected(){
       $roles = Auth::guard('user')->user()->role_id;
       if ($roles == 2){
           if (!Auth::guard('user')->check()){
               abort(403);
           } else{
               return view('approval::cod.rejected');
           }
       }
       if ($roles == 4){
           if (!Auth::guard('user')->check()){
               abort(403);
           } else{
               return view('approval::dean.rejected');
           }
       }
    }
    public function search(){
       $roles = Auth::guard('user')->user()->role_id;
       if ($roles == 2){
           if (!Auth::guard('user')->check()){
               abort(403);
           } else{
               return view('approval::cod.search');
           }
       }
       if ($roles == 4){
           if (!Auth::guard('user')->check()){
               abort(403);
           } else{
               return view('approval::dean.search');
           }
       }
    }
    public function viewPending(){
       $roles = Auth::guard('user')->user()->role_id;
       if ($roles == 2){
           if (!Auth::guard('user')->check()){
               abort(403);
           } else{
               return view('approval::cod.view');
           }
       }
       if ($roles == 4){
           if (!Auth::guard('user')->check()){
               abort(403);
           } else{
               return view('approval::dean.view');
           }
       }
    }
    public function searchValue(Request $request){
        $data = $request->json()->all();
        $value = $data['value'];
        $apps = DB::table('applicants')
            ->where('id_number', 'LIKE', "%$value%")
            ->orWhere('index_number', 'LIKE', "%$value%")
            ->orWhere('fname', 'LIKE', "%$value%")
            ->orWhere('mname', 'LIKE', "%$value%")
            ->orWhere('sname', 'LIKE', "%$value%")
            ->orWhere('county', 'LIKE', "%$value%")
            ->orWhere('sub_county', 'LIKE', "%$value%")
            ->orWhere('town', 'LIKE', "%$value%")
            ->orWhere('address', 'LIKE', "%$value%")
            ->orWhere('gender', 'LIKE', "%$value%")
            ->orWhere('marital_status', 'LIKE', "%$value%")
            ->get();
        $education = DB::table('education')
                    ->where('user_id',$apps[0]->id)
                    ->orWhere('institution', 'LIKE', "%$value%")
                    ->orWhere('qualification', 'LIKE', "%$value%")
                    ->get();
        $work = DB::table('work_experiences')
                    ->where('user_id',$apps[0]->id)
                    ->orWhere('organization', 'LIKE', "%$value%")
                    ->orWhere('post', 'LIKE', "%$value%")
                    ->get();
        $application = [];
        foreach($apps as $app)
            $application[] = Application::select('*')->where('user_id', $app->id)->get();

        print_r(json_encode(['user' => $apps, 'work' => $work, 'application' => $application, 'education' => $education, 'role' => Auth::guard('user')->user()->role_id ]));
    }
    public function getApplication(Request $request){
        $data = $request->json()->all();
        $intakes = Intake::select('*')->where('id', $data['app'])->get();
        $intakesDep = IntakeCourse::select('*')->where('intake_id', $data['app'])->get();
        $courses = [];
        $attendances = [];
        $years = [];
        foreach($intakesDep as $eachIntake){
            $courses_data = Course::select('*')->where('id', '=', $eachIntake['course_id'])->get();
            if (count($courses_data) > 0)
                $courses[] = $courses_data;
        }
        $attendance_query = DB::table('intake_attendance')
            ->where('intake_id', '=', $data['app'])
            ->get();
        foreach ($attendance_query as $attendance) {
            $attendance_data = Attendances::select('*')->where('id', '=', $attendance->attendance_id)->get();
            if (count($attendance_data) > 0)
                $attendances[] = $attendance_data;
        }
        $year_query = DB::table('intake_years')
            ->where('intake_id', '=', $data['app'])
            ->get();
        if (count($year_query) > 0)
            $years[] = $year_query;
        print_r(json_encode(['app' => $intakes, 'courses' => $courses, 'attendances' => $attendances, 'years' => $years]));
    }
    public function candidate(Request $request){
        $data = $request->json()->all();
        $apps = [];
        $user = [];
        $education = [];
        $work = [];
        $logs = [];

        $apps_push = [];
        foreach (explode(',',$data['status']) as $key => $status) {
            if($data['filter'] == 1) {
                $app = Application::select('*')
                    ->where('course', $data['course'])
                    ->where('status', $status)
                    ->offset($data['offset'])
                    ->limit($data['limit'])
                    ->get();
            }else{
                $app = Application::select('*')
                    ->where('status', $status)
                    ->offset($data['offset'])
                    ->limit($data['limit'])
                    ->get();
            }
            $apps_push[] = $app;
        }
        $apps_count = count($apps_push);

        if ($apps_count > 0) {
            foreach($apps_push as $appArr) {
                foreach($appArr as $app) {
                    $user_push = Applicants::select('*')
                        ->where('id', '=', $app['user_id'])
                        ->get();
                    $education_push = Education::select('*')
                        ->where('user_id', '=', $app['user_id'])
                        ->get();
                    $work_push = Work::select('*')
                        ->where('user_id', '=', $app['user_id'])
                        ->get();
                    $logs_push = DB::table('application_logs')
                        ->where('application_id', '=', $app['id'])
                        ->get();
                    $apps[] = $app;
                    $user[] = $user_push;
                    $education[] = $education_push;
                    $work[] = $work_push;
                    $logs[] = $logs_push;
                }
            }
        }

        $full_page = ceil($apps_count/100);
        if($full_page < 1)
            $full_page = 1;

        print_r(json_encode(['user' => $user, 'application' => $apps, 'logs' => $logs, 'work' => $work, 'education' => $education, 'page' => $full_page, 'role' => Auth::guard('user')->user()->role_id]));

    }
    public function printApplications(Request $request){
        $data = $request->json()->all();
        $apps_push = [];
        $department = Auth::guard('user')->user()->department_role;
        $intakes = Intake::select('*')->where('status', 1)->get();
        foreach (explode(',',$data['status']) as $key => $status) {
            $app = DB::table('applications')
                ->leftJoin('applicants', 'applicants.id', '=', 'applications.user_id')
                ->where('status', '=', (int)$status)
                ->where('department', '=', $department)
                ->where('intake_id', '=', $intakes[0]['id'])
                ->get();
            $apps_push[] = $app;
        }

        print_r(json_encode(['application' => $apps_push, 'department' => $department]));

    }
    public function reject(Request $request){
        $data = $request->json()->all();
        $app = Application::select('*')->where('id', $data['application'])->get();
        $department = Auth::guard('user')->user()->department_role;

        $status = 2;
        $level = "COD";
        if(Auth::guard('user')->user()->role_id == 4){
            $status = 4;
            $level = "DEAN";
            //Check whether COD had rejected before
            if($app[0]['status'] === 9)
                $status = 8;
        }

        $add_log = DB::table('application_logs')->insert([
            ['status' => $status, 'application_id' =>  $data['application'], 'department' => $department, "reason" => $data['reason'], "date" => date("Y-m-d"), "level" => $level]
        ]);
        $feedback = [];
        if($add_log == 1)
            $feedback[] = true;
        else
            $feedback[] = false;

        $apps = DB::table('applications')
            ->where('id', $data['application'])
            ->update(['status' => $status]);

        if ($apps == 1)
            $feedback[] = true;
        else
            $feedback[] = false;

        print_r(json_encode(['user' => $feedback]));
    }
    public function approve(Request $request){
        $data = $request->json()->all();

        $app = Application::select('*')->where('id', $data['application'])->get();
        $department = Auth::guard('user')->user()->department_role;

        $status = 1;
        $level = "COD";
        if(Auth::guard('user')->user()->role_id == 4){
            $status = 3;
            $level = "DEAN";
            //Check whether COD had rejected before
            if($app[0]['status'] === 9)
                $status = 5;
        }

        $add_log = DB::table('application_logs')->insert([
            ['status' => $status, 'application_id' =>  $data['application'], 'department' => $department, "reason" => $data['reason'], "date" => date("Y-m-d"), "level" => $level]
        ]);
        $feedback = [];
        if($add_log == 1)
            $feedback[] = true;
        else
            $feedback[] = false;

        $apps = DB::table('applications')
            ->where('id', $data['application'])
            ->update(['status' => $status]);

        if ($apps == 1)
            $feedback[] = true;
        else
            $feedback[] = false;
        print_r(json_encode(['user' => $feedback]));
    }
    public function approves(Request $request){
        $data = $request->json()->all();
        $feedback = [];
        $department = Auth::guard('user')->user()->department_role;
        foreach($data['application'] as $monitor => $appValue) {

            $app = Application::select('*')->where('id',$appValue)->get();

            $status = 1;
            $level = "COD";
            if (Auth::guard('user')->user()->role_id == 4) {
                $status = 3;
                $level = "DEAN";
                //Check whether COD had rejected before
                if ($app[0]['status'] === 9)
                    $status = 5;
            }

            $add_log = DB::table('application_logs')->insert([
                ['status' => $status, 'application_id' =>  $appValue, 'department' => $department, "reason" => 'OK', "date" => date("Y-m-d"), "level" => $level]
            ]);

            if ($add_log == 1)
                $feedback[] = ['status' => true, 'character' => $monitor];
            else
                $feedback[] = ['status' => false, 'character' => $monitor];

            $apps = DB::table('applications')
                ->where('id', $appValue)
                ->update(['status' => $status]);

            if ($apps == 1)
                $feedback[] = ['status' => true, 'character' => $monitor];
            else
                $feedback[] = ['status' => false, 'character' => $monitor];
        }
        print_r(json_encode(['user' => $feedback]));
    }
    public function push(Request $request){
        $data = $request->json()->all();
        $status = 0;
        //User is COD
        if(Auth::guard('user')->user()->role_id == 2){
            if($data['status'] == 1) //If COD Approved
                $status = 6;
            if($data['status'] == 2) //If COD Rejected
                $status = 9;
        }
        //User is Dean
        if(Auth::guard('user')->user()->role_id == 4){
            if($data['status'] == 3 || $data['status'] == 5) //If DEAN Approved
                $status = 7;
            if($data['status'] == 4 || $data['status'] == 8) //If DEAN Rejected
                $status = 10;
        }
        $apps = DB::table('applications')
                      ->where('intake_id', (int)$data['intake'])
                      ->where('status', (int)$data['status'])
                      ->update(['status' => $status]);

        $feedback = false;
        if($apps === 1)
            $feedback = true;
        print_r(json_encode(['now' => $feedback, 'we' => $apps,]));
    }
    public function getIntakes(){
        $intakes = Intake::select('*')->get();
        $intake_organise = [];
        foreach($intakes as $intake){
            $start_time = strtotime($intake['intake_from']);
            $end_time = strtotime($intake['intake_to']);
            $intake_name = date("M-Y",$start_time)."/".date("M-Y",$end_time);
            $intake_organise[] = ['id' => $intake['id'] .','. $intake_name, 'text' => $intake_name];
        }
        print_r(json_encode(['data' => $intake_organise]));
    }
    public function removeCourses(Request $request){
        $data = $request->json()->all();
        $feedback = [];
        $status = [];
        foreach ($data["courses"] as $occur => $oneCourse) {
            if($oneCourse > 0) {
                $delete_course = DB::delete('delete from intake_courses where intake_id = ? and course_id = ?',[$data['intake'],$oneCourse]);

                if ($delete_course == 1) {
                    $feedback[] = 1;
                    $status[] = $occur;
                }else {
                    $feedback[] = 0;
                    $status[] = $occur;
                }
            }
        }

        print_r(json_encode(['feedback' => $feedback, 'status' => $status]));
    }
    public function addCourses(Request $request){
        $data = $request->json()->all();
        $department = Auth::guard('user')->user()->department_role;
        $feedback = [];
        $status = [];
        foreach ($data["courses"] as $occur => $oneCourse) {
            if($oneCourse > 0) {
                $add_course = DB::table('intake_courses')->insert([
                    ['intake_id' => $data['intake'], 'department_id' => $department, 'course_id' => $oneCourse]
                ]);
                if ($add_course == 1) {
                    $feedback[] = 1;
                    $status[] = $occur;
                }else {
                    $feedback[] = 0;
                    $status[] = $occur;
                }
            }
        }

        print_r(json_encode(['feedback' => $feedback, 'status' => $status]));
    }
    public function allYears(Request $request){
        $data = $request->json()->all();
        $department = Auth::guard('user')->user()->department_role;
        $courses = IntakeCourse::select('*')
            ->where('intake_id',$data['intake'])
            ->where('department_id',$department)
            ->get();
        $feedback = false;
        $course_arr = [];
        if(count($courses) > 0){
            if($courses[0]['years'])
                $course_arr = json_decode($courses[0]['years']);
            foreach ($data["years"] as $oneCourse) {
                if (!in_array($oneCourse, $course_arr)) //Add not in array
                    $course_arr[] = $oneCourse;
            }
            $update_course = IntakeCourse::where('intake_id', $data['intake'])
                ->where('department_id', $department)
                ->update(['years' => $course_arr]);

            if($update_course == 1)
                $feedback = true;
        }else {
            $add_course = DB::table('intake_courses')->insert([
                ['intake_id' => $data['intake'], 'department_id' => $department, 'years' => $course_arr]
            ]);
            if($add_course == 1)
                $feedback = true;
        }

        print_r(json_encode(['feedback' => $feedback]));
    }
    public function addAttendances(Request $request){
        $data = $request->json()->all();
        $department = Auth::guard('user')->user()->department_role;
        $courses = IntakeCourse::select('*')
            ->where('intake_id',$data['intake'])
            ->where('department_id',$department)
            ->get();
        $feedback = false;
        $course_arr = [];
        if(count($courses) > 0){
            if($courses[0]['attendance_id'])
                $course_arr = json_decode($courses[0]['attendance_id']);
            foreach ($data["attendance"] as $oneCourse) {
                if (!in_array($oneCourse, $course_arr)) //Add not in array
                    $course_arr[] = $oneCourse;
            }
            $update_course = IntakeCourse::where('intake_id', $data['intake'])
                ->where('department_id', $department)
                ->update(['attendance_id' => $course_arr]);

            if($update_course == 1)
                $feedback = true;
        }else {
            $add_course = DB::table('intake_courses')->insert([
                ['intake_id' => $data['intake'], 'department_id' => $department, 'attendance_id' => $course_arr]
            ]);
            if($add_course == 1)
                $feedback = true;
        }

        print_r(json_encode(['feedback' => $feedback]));
    }
    public function addCourse(Request $request){
        $data = $request->json()->all();
        $department = Auth::guard('user')->user()->department_role;
        $courses = IntakeCourse::select('*')
                    ->where('intake_id',$data['intake'])
                    ->where('department_id',$department)
                    ->get();
        $feedback = false;
        if(count($courses) > 0){
            $course_arr = [];
            foreach ($courses as $course)
                $course_arr[] = $course['course_id'];
            if(in_array($data['course'],$course_arr)){ //Remove
                $delete_course = DB::delete('delete from intake_courses where intake_id = ? and course_id = ?',[$data['intake'],$data['course']]);
                if($delete_course == 1)
                    $feedback = true;
            }else { //Add
                $add_course = DB::table('intake_courses')->insert([
                    ['intake_id' => $data['intake'], 'department_id' => $department, 'course_id' => $data['course']]
                ]);
                if($add_course == 1)
                    $feedback = true;
            }

        }else {
            $add_course = DB::table('intake_courses')->insert([
                ['intake_id' => $data['intake'], 'department_id' => $department, 'course_id' => $data['course']]
            ]);
            if($add_course == 1)
                $feedback = true;
        }

        print_r(json_encode(['feedback' => $feedback]));
    }
    public function classSession(Request $request){
        $data = $request->json()->all();
        $class_arr = [];
        $intake_data = DB::table('class_status')
            ->where('courses_id', '=', $data['course'])
            ->where('intake_id', '=', $data['intake'])
            ->where('classes_id', '=', $data['year'])
            ->where('soft_delete', '=', 1)
            ->get();
        $feedback = [];
        if(count($intake_data) > 0) //Update query
            foreach ($intake_data as $att)
                $class_arr[] = $att->status;

        foreach($data['session'] as $session) {
            if(!in_array($session,$class_arr)) {
                $add_course = DB::table('class_status')->insert([
                    ['courses_id' => (int)$data['course'], 'classes_id' => (int)$data['year'], 'intake_id' => (int)$data['intake'], 'status' => $session, 'soft_delete' => 1]
                ]);
                if ($add_course == 1)
                    $feedback[] = true;
                else
                    $feedback[] = false;
            }
        }

        print_r(json_encode(['feedback' => $feedback]));
    }
    public function removeSession(Request $request){
        $data = $request->json()->all();
        $update_sesssion = DB::table('class_status')
            ->where('classes_id', $data['year'])
            ->where('courses_id', $data['course'])
            ->where('intake_id', $data['intake'])
            ->where('status', $data['status'])
            ->update(['soft_delete' => 0]);

        $feedback[] = false;
        if ($update_sesssion == 1)
            $feedback[] = true;

        print_r(json_encode(['feedback' => $feedback]));
    }
    public function addYears(Request $request){
        $data = $request->json()->all();
        $years_arr = [];
        $intake_data = DB::table('intake_years')
            ->where('courses_id', '=', $data['course'])
            ->where('intake_id', '=', $data['intake'])
            ->where('years', '=', $data['year'])
            ->get();
        if(count($intake_data) > 0)
            foreach ($intake_data as $att)
                $years_arr[] = $att->years;
        $feedback = false;
        if(in_array($data['year'],$years_arr)){ //Remove
            $delete_year = DB::delete('delete from intake_years where years = ? and courses_id = ? and intake_id = ?',[$data['year'],$data['course'],$data['intake']]);
            if($delete_year == 1)
                $feedback = true;
        }else { //Add
            $add_course = DB::table('intake_years')->insert([
                ['courses_id' => $data['course'], 'years' => $data['year'], 'intake_id' => $data['intake']]
            ]);
            if($add_course == 1)
                $feedback = true;
        }
        print_r(json_encode(['feedback' => $feedback]));
    }
    public function addAttendance(Request $request){
        $data = $request->json()->all();
        $attendance_arr = [];
        $intake_data = DB::table('intake_attendance')
            ->where('courses_id', '=', $data['course'])
            ->where('intake_id', '=', $data['intake'])
            ->get();
        if(count($intake_data) > 0)
            foreach ($intake_data as $att)
                $attendance_arr[] = $att->attendance_id;
        $feedback = false;
        if(in_array($data['attendance'],$attendance_arr)){ //Remove
            $delete_attendance = DB::delete('delete from intake_attendance where attendance_id = ? and courses_id = ? and intake_id = ?',[$data['attendance'],$data['course'],$data['intake']]);
            if($delete_attendance == 1)
                $feedback = true;
        }else { //Add
            $add_course = DB::table('intake_attendance')->insert([
                ['courses_id' => $data['course'], 'attendance_id' => $data['attendance'], 'intake_id' => $data['intake']]
            ]);
            if($add_course == 1)
                $feedback = true;
        }

        print_r(json_encode(['feedback' => $feedback]));
    }
    public function getYears(Request $request){
        $data = $request->json()->all();
        $department = Auth::guard('user')->user()->department_role;

        $in_years = IntakeCourse::select('*')
            ->where('department_id', '=', $department)
            ->where('intake_id', '=', $data['intake'])
            ->get();
        $yearArr = [];
        if(count($in_years) > 0)
            if($in_years[0]['years'])
                $yearArr = json_decode($in_years[0]['years']);

        $fine_years = [];
        for($year = 1;$year < 7;$year++){
            if(in_array($year,$yearArr))
                $fine_years[] = ['name' => $year, 'status' => true, 'id' => $year ];
            else
                $fine_years[] = ['name' => $year, 'status' => false, 'id' => $year ];
        }
        print_r(json_encode(['years' => $fine_years]));
    }
    public function getCourses(Request $request){
        $data = $request->json()->all();
        $department = Auth::guard('user')->user()->department_role;
        $courses = DB::table('courses')
            ->where('department_id', '=', $department)
            ->get();
        $in_courses = IntakeCourse::select('*')
            ->where('department_id', '=', $department)
            ->where('intake_id', '=', $data['intake'])
            ->get();
        $attendances = Attendances::select('*')->get();
        $courseArr = [];

        foreach($in_courses as $course)
            $courseArr[] = $course['course_id'];

        $fine_data = [];
        foreach($courses as $occurence => $course){
            if(in_array($course->id,$courseArr)) {
                $fine_data[$occurence]['courses'][] = ['name' => $course->course_name, 'code' => $course->course_code, 'status' => true, 'id' => $course->id];

                $fine_data[$occurence]['attendances'] = [];

                $attendanceArr = [];
                $attendanceIntake = DB::table('intake_attendance')
                    ->where('courses_id', '=', $course->id)
                    ->where('intake_id', '=', $data['intake'])
                    ->get();
                foreach($attendanceIntake as $id)
                    $attendanceArr[] = $id->attendance_id;

                foreach($attendances as $attendance){
                    if(in_array($attendance['id'],$attendanceArr))
                        $fine_data[$occurence]['attendances'][] = ['name' => $attendance['attendance_name'], 'code' => $attendance['attendance_code'], 'status' => true, 'id' => $attendance['id'], 'course' => $course->id];
                    else
                        $fine_data[$occurence]['attendances'][] = ['name' => $attendance['attendance_name'], 'code' => $attendance['attendance_code'], 'status' => false, 'id' => $attendance['id'], 'course' => $course->id ];
                }

                $yearsArr = [];
                $yearsIntake = DB::table('intake_years')
                    ->where('courses_id', '=', $course->id)
                    ->where('intake_id', '=', $data['intake'])
                    ->get();

                foreach($yearsIntake as $id)
                    $yearsArr[] = $id->years;

                $fine_data[$occurence]['years'] = [];
                for($year = 1;$year < 7;$year++){
                    if(in_array($year,$yearsArr))
                        $fine_data[$occurence]['years'][] = ['name' => $year, 'status' => true, 'id' => $year, 'course' => $course->id];
                    else
                        $fine_data[$occurence]['years'][] = ['name' => $year, 'status' => false, 'id' => $year, 'course' => $course->id ];
                }
            }else{
                $fine_data[$occurence]['courses'][] = ['name' => $course->course_name, 'code' => $course->course_code, 'status' => false, 'id' => $course->id ];
                $fine_data[$occurence]['attendances'] = [];
                foreach($attendances as $attendance)
                    $fine_data[$occurence]['attendances'][] = ['name' => $attendance['attendance_name'], 'code' => $attendance['attendance_code'], 'status' => null, 'id' => $attendance['id'], 'course' => $course->id ];
                $fine_data[$occurence]['years'] = [];
                for($year = 1;$year < 7;$year++)
                    $fine_data[$occurence]['years'][] = ['name' => $year, 'status' => null, 'id' => $year, 'course' => $course->id ];

            }
        }
        print_r(json_encode(['course' => $fine_data, 'department' => $department]));
    }
    public function searchCourses(Request $request){
        $data = $request->json()->all();
        $department = Auth::guard('user')->user()->department_role;
        $value = $data['search'];
        $courses = DB::table('courses')
            ->where('department_id', '=', $department)
            ->where('course_name', 'LIKE', "%$value%")
            ->get();
        $in_courses = IntakeCourse::select('*')
            ->where('department_id', '=', $department)
            ->where('intake_id', '=', $data['intake'])
            ->get();
        $attendances = Attendances::select('*')->get();
        $courseArr = [];

        foreach($in_courses as $course)
            $courseArr[] = $course['course_id'];

        $fine_data = [];
        foreach($courses as $occurence => $course){
            if(in_array($course->id,$courseArr)) {
                $fine_data[$occurence]['courses'][] = ['name' => $course->course_name, 'code' => $course->course_code, 'status' => true, 'id' => $course->id];

                $fine_data[$occurence]['attendances'] = [];

                $attendanceArr = [];
                $attendanceIntake = DB::table('intake_attendance')
                    ->where('courses_id', '=', $course->id)
                    ->where('intake_id', '=', $data['intake'])
                    ->get();
                foreach($attendanceIntake as $id)
                    $attendanceArr[] = $id->attendance_id;

                foreach($attendances as $attendance){
                    if(in_array($attendance['id'],$attendanceArr))
                        $fine_data[$occurence]['attendances'][] = ['name' => $attendance['attendance_name'], 'code' => $attendance['attendance_code'], 'status' => true, 'id' => $attendance['id'], 'course' => $course->id];
                    else
                        $fine_data[$occurence]['attendances'][] = ['name' => $attendance['attendance_name'], 'code' => $attendance['attendance_code'], 'status' => false, 'id' => $attendance['id'], 'course' => $course->id ];
                }

                $yearsArr = [];
                $yearsIntake = DB::table('intake_years')
                    ->where('courses_id', '=', $course->id)
                    ->where('intake_id', '=', $data['intake'])
                    ->get();

                foreach($yearsIntake as $id)
                    $yearsArr[] = $id->years;

                $fine_data[$occurence]['years'] = [];
                for($year = 1;$year < 7;$year++){
                    if(in_array($year,$yearsArr))
                        $fine_data[$occurence]['years'][] = ['name' => $year, 'status' => true, 'id' => $year, 'course' => $course->id];
                    else
                        $fine_data[$occurence]['years'][] = ['name' => $year, 'status' => false, 'id' => $year, 'course' => $course->id ];
                }
            }else{
                $fine_data[$occurence]['courses'][] = ['name' => $course->course_name, 'code' => $course->course_code, 'status' => false, 'id' => $course->id ];
                $fine_data[$occurence]['attendances'] = [];
                foreach($attendances as $attendance)
                    $fine_data[$occurence]['attendances'][] = ['name' => $attendance['attendance_name'], 'code' => $attendance['attendance_code'], 'status' => null, 'id' => $attendance['id'], 'course' => $course->id ];
                $fine_data[$occurence]['years'] = [];
                for($year = 1;$year < 7;$year++)
                    $fine_data[$occurence]['years'][] = ['name' => $year, 'status' => null, 'id' => $year, 'course' => $course->id ];

            }
        }
        print_r(json_encode(['course' => $fine_data, 'department' => $department]));
    }
    public function getAttendance(Request $request){
        $data = $request->json()->all();
        $department = Auth::guard('user')->user()->department_role;
        $attendances = Attendances::select('*')->get();
        $in_attendance = IntakeCourse::select('*')
            ->where('department_id', '=', $department)
            ->where('intake_id', '=', $data['intake'])
            ->get();
        $attendanceArr = [];
        if(count($in_attendance) > 0)
            if($in_attendance[0]['attendance_id'])
                $attendanceArr = json_decode($in_attendance[0]['attendance_id']);

        $fine_attendance = [];
        foreach($attendances as $attendance){
            if(in_array($attendance['id'],$attendanceArr))
                $fine_attendance[] = ['name' => $attendance['attendance_name'], 'code' => $attendance['attendance_code'], 'status' => true, 'id' => $attendance['id'] ];
            else
                $fine_attendance[] = ['name' => $attendance['attendance_name'], 'code' => $attendance['attendance_code'], 'status' => false, 'id' => $attendance['id'] ];
        }
        print_r(json_encode(['attendance' => $fine_attendance]));
    }
    public function courses(){
        return view('approval::cod.courses');
    }
    public function report(){
        return view('approval::cod.report');
    }
    public function fetchData(Request $request){

        $data = $request->json()->all();

        $collection = explode(',',$data['id']);
        $applications = [];

        $department = Auth::guard('user')->user()->department_role;
        $courses = DB::table('courses')
            ->where('department_id', '=', $department)
            ->get();
        $intake_arr = [];
        $intakes = Intake::select('*')->where('status', 1)->get();
        foreach($collection as $item){
            foreach($courses as $course){
                $application_data = DB::table('applications')
                    ->leftJoin('courses', 'courses.course_name', '=', 'applications.course')
                    ->where('status', '=', (int)$item)
                    ->where('course', '=', $course->course_name)
                    ->where('intake_id', '=', $intakes[0]['id'])
                    ->get();
                //Adjusted to only include one intake session, the active one
                if(count($application_data) > 0 && count($intakes) > 0) {
                    $applications[] = ['application' => $application_data];
                    $intake_arr[] = $intakes;
                }
            }
        }
        $fetched = [];

        if(count($applications) > 0){
            foreach($applications as  $occurrence => $application){

                if(count($application) > 0){
                    foreach($application['application'] as $foundItem){

                        $start_time = strtotime($intake_arr[0][0]['intake_from']);
                        $end_time = strtotime($intake_arr[0][0]['intake_to']);
                        $intake = date("M-Y",$start_time)."/".date("M-Y",$end_time);

                        $intakeId = (int)$intake_arr[0][0]->id;
                        $status = (int)$foundItem->status;
                        $programs = $foundItem->level;
                        $start_date = $intake_arr[0][0]['intake_from'];
                        $end_date = $intake_arr[0][0]['intake_to'];

                        $start_time = strtotime($start_date);
                        $end_time = strtotime($end_date);
                        $sweet_date_start = date("D-d-M-Y",$start_time);
                        $sweet_date_end = date("D-d-M-Y",$end_time);
                        $id = $foundItem->id;

                        $expire = false;
                        if((date("Y-m-d") >= date("Y-m-d",$start_time)) && (date("Y-m-d") <= date("Y-m-d",$end_time)))
                            $expire = true;

                        if(in_array($intakeId,array_column($fetched,"intake"))){
                            $work_key = array_keys(array_column($fetched,"intake"),$intakeId)[0];
                            if(in_array($programs,array_column($fetched[$work_key]["academic"],"program"))){
                                $program_key = array_keys(array_column($fetched[$work_key]["academic"],"program"),$programs)[0];
                                $fetched[$work_key]["academic"][$program_key]["number"] = (int)$fetched[$work_key]["academic"][$program_key]["number"] + 1;
                            }else{
                                $fetched[$work_key]["academic"][] = [ "program" => $programs, "number" => 1];
                            }
                            $keys = array_column($fetched[$work_key]["academic"], 'program');
                            array_multisort($keys, SORT_ASC, $fetched[$work_key]["academic"]);
                        }else{
                            $fetched[] = array(
                                "intake" => $intakeId,
                                "name" => $intake,
                                "status" => $status,
                                "academic" => [
                                    [
                                        "program" => $programs,
                                        "number" => 1
                                    ]
                                ],
                                "start" => $sweet_date_start,
                                "end" => $sweet_date_end,
                                "id" => $id,
                                "expire" => $expire
                            );
                        }

                    }
                }
            }
        }

        $keys = array_column($fetched, 'start');
        array_multisort($keys, SORT_DESC, $fetched);
        print_r(json_encode(['list' => $fetched, 'extra' => $applications, 'course' => $courses]));

    }
    public function getReport(Request $request){
        $data = $request->json()->all();
        //Get the active intake
        $getIntake = Intake::select('*')->where('status', "1")->get();
        $intake_report = [false];
        if(count($getIntake) > 0){
            //Check the last year of the class for that course using its duration
            $courses = Course::select('*')->where('id',$data['course'])->get();
            if(count($courses) > 0) {
                $active_intake = date_create_from_format('Y-m-d',date('Y-m-d',strtotime($getIntake[0]['intake_from'])));
                date_sub($active_intake,date_interval_create_from_date_string("".$courses[0]['course_duration'].""));
                $last_active_year =  date_format($active_intake,'Y-m-d');
                $class_query = DB::table('classes')
                    ->where('intake_from', '>=', $last_active_year)
                    ->where('course_id', '=', $courses[0]['id'])
                    ->get();

                foreach ($class_query as $occurence => $class) {
                    $intake_report[$occurence]['class'] = $class->name;
                    $intake_report[$occurence]['class_id'] = $class->id;
                    //Group intakes for the class in ascending order to get years of the intake
                    $reportIntake = DB::table('intakes')
                        ->where('intake_from', '>=', $class->intake_from)
                        ->orderBy('intake_from', 'asc')
                        ->get();
                    foreach($reportIntake as $intake_iteration => $eachIntake){
                        $intake_report[$occurence]['intakes_from'][] = date("D-M-y", strtotime($eachIntake->intake_from));
                        $intake_report[$occurence]['intakes_to'][] = date("D-M-y", strtotime($eachIntake->intake_to));
                        $intake_report[$occurence]['intake'][] = date("M-Y", strtotime($eachIntake->intake_from)) . '/' . date("M-Y", strtotime($eachIntake->intake_to));
                        $intake_report[$occurence]['intake_id'][] = $eachIntake->id;
                        $status_query = DB::table('class_status')
                            ->where('classes_id', '=', $class->id)
                            ->where('courses_id', '=', $data['course'])
                            ->where('intake_id', '=', $eachIntake->id)
                            ->get();

                        if (count($status_query) > 0) {
                            foreach ($status_query as $eachStatus)
                                $intake_report[$occurence]['status'][$intake_iteration][] = $eachStatus->status;
                            if(in_array("IN SESSION",$intake_report[$occurence]['status']) || in_array("ONLINE SESSION",$intake_report[$occurence]['status']) || in_array("WORKSHOP",$intake_report[$occurence]['status'])){
                                //If class did not progress the year get the previous values
                                if($intake_iteration > 0){
                                    $previous_year = $intake_report[$occurence]['year'][count($intake_report[$occurence]['year']) - 1];
                                    $previous_sem = $intake_report[$occurence]['semester'][count($intake_report[$occurence]['semester']) - 1];

                                    $intake_report[$occurence]['year'][] =  $previous_year + 1;
                                    $intake_report[$occurence]['semester'][] = ($previous_sem < $courses[0]['semester']) ? $previous_sem + 1 : 1 ;
                                }else { //first encounter
                                    $intake_report[$occurence]['year'][] = 1;
                                    $intake_report[$occurence]['semester'][] = 1;
                                }
                            }else{
                                //If class did not progress the year get the previous values
                                if($intake_iteration > 0){
                                    $intake_report[$occurence]['year'][] = $intake_report[$occurence]['year'][count($intake_report[$occurence]['year']) - 1];
                                    $intake_report[$occurence]['semester'][] = $intake_report[$occurence]['semester'][count($intake_report[$occurence]['semester']) - 1];
                                }else { //If class did not progress the year and semester remains of the value of the previous value
                                    $intake_report[$occurence]['year'][] = 1;
                                    $intake_report[$occurence]['semester'][] = 1;
                                }
                            }

                        } else {
                            $intake_report[$occurence]['status'][] = ["NOT IN SESSION"];
                            //If class did not progress the year get the previous values
                            if($intake_iteration > 0){
                                $intake_report[$occurence]['year'][] = $intake_report[$occurence]['year'][count($intake_report[$occurence]['year']) - 1];
                                $intake_report[$occurence]['semester'][] = $intake_report[$occurence]['semester'][count($intake_report[$occurence]['semester']) - 1];
                            }else { //If class did not progress the year and semester remains of the value of the previous value
                                $intake_report[$occurence]['year'][] = 1;
                                $intake_report[$occurence]['semester'][] = 1;
                            }
                        }
                    }
                }
            }
        }
        print_r(json_encode(['report' => $intake_report, 'department' => Auth::guard('user')->user()->department_role]));
    }
    public function allCourses(){
        $department = Auth::guard('user')->user()->department_role;
        $courses = DB::table('courses')
            ->where('department_id', '=', $department)
            ->get();
        $courseSelect = [];
        foreach ($courses as $oneCourse)
            $courseSelect[] = [ 'id' => $oneCourse->id . "," . $oneCourse->course_name, 'text' => $oneCourse->course_name ];
        print_r(json_encode(['course' => $courseSelect]));
    }
    public function graph(){

        $department = Auth::guard('user')->user()->department_role;
        $courses = DB::table('courses')
            ->where('department_id', '=', $department)
            ->get();
        $applications = [];
        $intakesArr = [];
        $intakes = Intake::select('*')->where('status', 1)->get();
        foreach($courses as $course){
            //Adjusted to only include one intake session, the active one
            $applications_data = DB::table('applications')
                ->where('course', '=', $course->course_name)
                ->where('intake_id', '=', $intakes[0]['id'])
                ->get();


            if(count($applications_data) > 0 && count($intakes) > 0) {
                $applications[] = ['application' => $applications_data];
                $intakesArr[] = $intakes;
            }
        }
        $graphData = [];
        if(count($applications) > 0){
            foreach($applications as $occurence => $application){
                if(count($application) > 0){
                    foreach($application['application'] as $foundItem){
                        $intake_id = $intakesArr[0][0]['id'];
                        $app_logs = DB::table('application_logs')
                            ->where('application_id', '=', $foundItem->id)
                            ->get();
                        $side = $foundItem->status;
                        $TIMESTAMP = $foundItem->created_at;
                        if(count($app_logs) > 0)
                            $TIMESTAMP = $app_logs[count($app_logs) - 1]->date;
                        $time = strtotime($TIMESTAMP);
                        $c_time = date("Y-m-d",$time);
                        $c_year = date("Y",$time);
                        $start_time = strtotime($intakesArr[0][0]['intake_from']);
                        $end_time = strtotime($intakesArr[0][0]['intake_to']);
                        $intake = date("M-Y",$start_time)."-".date("M-Y",$end_time);
                        $approved = 0;
                        $rejected = 0;
                        $pending = 0;
                        if(Auth::guard('user')->user()->role_id == 2){
                            if($side == 2 || $side == 9)
                                $rejected = 1;
                            if($side == 0)
                                $pending = 1;
                            if($side == 1 || $side == 6)
                                $approved = 1;
                        }
                        if(Auth::guard('user')->user()->role_id == 4){
                            if($side == 4 || $side == 8 || $side == 10)
                                $rejected = 1;
                            if($side == 9 || $side == 6) //COD PUSHED APPROVED OR REJECTED
                                $pending = 1;
                            if($side == 3 || $side == 5 || $side == 7)
                                $approved = 1;
                        }
                        if(in_array($intake_id,array_column($graphData,"id"))){
                            $work_key = array_keys(array_column($graphData,"id"),$intake_id)[0];
                            $graphData[$work_key]["count"] = (int)$graphData[array_keys(array_column($graphData,"id"),$intake_id)[0]]["count"] + 1;
                            $graphData[$work_key]["approved"] = (int)$graphData[array_keys(array_column($graphData,"id"),$intake_id)[0]]["approved"] + (int)$approved;
                            $graphData[$work_key]["rejected"] = (int)$graphData[array_keys(array_column($graphData,"id"),$intake_id)[0]]["rejected"] + (int)$rejected;
                            $graphData[$work_key]["pending"] = (int)$graphData[array_keys(array_column($graphData,"id"),$intake_id)[0]]["pending"] + (int)$pending;
                            $graphData[$work_key]["year"] = $c_year;
                            $graphData[$work_key]["date"][] = $c_time;
                        }else{
                            $graphData[] = array(
                                "date" => [$c_time],
                                "year" => $c_year,
                                "count" => 1,
                                "intake" => $intake,
                                "id" => $intake_id,
                                "approved" => $approved,
                                "rejected" => $rejected,
                                "pending" => $pending
                            );
                        }
                    }
                }
            }
        }

        $keys = array_column($graphData, 'id');
        array_multisort($keys, SORT_DESC, $graphData);
        print_r(json_encode(['graph' => $graphData]));
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('approval::create');
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
        return view('approval::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('approval::edit');
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
