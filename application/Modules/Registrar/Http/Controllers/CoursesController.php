<?php

namespace Modules\Registrar\Http\Controllers;

use Carbon;
use Illuminate\Http\Request;
use App\Imports\KuccpsImport;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Application\Entities\Applicant;
use Modules\Registrar\Entities\Campus;
use Modules\Registrar\Entities\Intake;
use Modules\Registrar\Entities\School;
use Illuminate\Support\Facades\Storage;
use Modules\Registrar\Entities\Classes;
use Modules\Registrar\Entities\Courses;
use Modules\Registrar\Entities\Student;
use PhpOffice\PhpWord\TemplateProcessor;
use Modules\Registrar\emails\KuccpsMails;
use Modules\Registrar\Entities\Attendance;
use Modules\Registrar\Entities\Department;
use Modules\Application\Entities\Education;
use NcJoes\OfficeConverter\OfficeConverter;
use Modules\Registrar\Entities\RegistrarLog;
use Modules\Registrar\Entities\StudentLogin;
use Modules\Application\Entities\Application;
use Modules\Registrar\Entities\StudentCourse;
use Modules\Registrar\Entities\AvailableCourse;
use Modules\Registrar\Entities\KuccpsApplicant;
use Modules\Registrar\Entities\KuccpsApplication;
use Modules\Application\Entities\AdmissionApproval;
use Modules\Registrar\Entities\ClusterSubjects;
use Modules\Registrar\Entities\CourseRequirement;

class CoursesController extends Controller

{

    public function acceptApplication($id){

        $app = Application::find($id);
        $app->registrar_status = 1;
        $app->save();

        $logs = new RegistrarLog;
        $logs->application_id = $app->id;
        $logs->user = Auth::guard('user')->user()->name;
        $logs->user_role = Auth::guard('user')->user()->role_id;
        $logs->activity = 'Application accepted';
        $logs->save();

        return redirect()->route('courses.applications')->with('success', '1 applicant approved');
    }

    public function rejectApplication(Request $request, $id){
        $app = Application::find($id);
        $app->registrar_status = 2;
        $app->registrar_comments = $request->comment;
        $app->save();

        $logs = new RegistrarLog;
        $logs->application_id = $app->id;
        $logs->user = Auth::guard('user')->user()->name;
        $logs->user_role = Auth::guard('user')->user()->role_id;
        $logs->activity = 'Application rejected';
        $logs->comments = $request->comment;
        $logs->save();

        return redirect()->route('courses.applications')->with('success', 'Application declined');
    }

    public function preview($id){
        $app = Application::find($id);
        $school = Education::where('applicant_id', $app->applicant->id)->first();
        return view('registrar::offer.preview')->with(['app' => $app, 'school' => $school]);
    }
    public function viewApplication($id){
        $app = Application::find($id);
        $school = Education::where('applicant_id', $app->applicant->id)->first();
        return view('registrar::offer.viewApplication')->with(['app' => $app, 'school' => $school]);
    }

    public function accepted(){

        $kuccps = KuccpsApplicant::where('status', 0)->get();

            foreach ($kuccps as $applicant){

                $course = Courses::where('course_code', $applicant->kuccpsApplication->course_code)->first();

                $regNumber = Application::where('course_id', $course->id)
                        ->where('intake_id', $applicant->kuccpsApplication->intake_id)
                        ->where('student_type', 2)
                        ->count();

                        $app = new Applicant;

                        $app->index_number = $applicant->index_number;
                        $app->password = Hash::make($applicant->index_number);
                        $app->username = $applicant->index_number;
                        $app->email = $applicant->email;
                        $app->alt_email = $applicant->alt_email;
                        $app->sname = $applicant->sname;
                        $app->fname = $applicant->fname;
                        $app->mname = $applicant->mname;
                        $app->gender = $applicant->gender;
                        $app->phone_verification = 1;
                        $app->email_verified_at = date('d-m-Y');
                        $app->mobile = $applicant->mobile;
                        $app->alt_mobile = $applicant->alt_mobile;
                        $app->town = $applicant->town;
                        $app->address = $applicant->BOX;
                        $app->postal_code = $applicant->postal;
                        $app->student_type = 2;
                        $app->save();

                                $app_course = new Application;
                                $app_course->applicant_id = $app->id;
                                $app_course->intake_id = $applicant->kuccpsApplication->intake_id;
                                $app_course->department_id = $course->department_id;
                                $app_course->school_id = $course->getCourseDept->school_id;
                                $app_course->course_id = $course->id;
                                $app_course->finance_status = 1;
                                $app_course->cod_status = 1;
                                $app_course->dean_status = 1;
                                $app_course->registrar_status = 3;
                                $app_course->status = 1;
                                $app_course->student_type = 2;
                                $app_course->ref_number = 'APP/'.date('Y')."/".str_pad(0000000 + $applicant->id, 6, "0", STR_PAD_LEFT);
                                $app_course->reg_number = $applicant->kuccpsApplication->course_code."/".str_pad($regNumber + 1, 3, "0", STR_PAD_LEFT)."J"."/".Carbon\carbon::parse($applicant->kuccpsApplication->kuccpsIntake->intake_from)->format('Y');
                                $app_course->adm_letter = 'APP'."_".date('Y')."_".str_pad(0000000 + $applicant->id, 6, "0", STR_PAD_LEFT).'.pdf';
                                    $app_course->save();

                    $domPdfPath = base_path('vendor/dompdf/dompdf');
                    \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
                    \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

                    $my_template = new TemplateProcessor(storage_path('adm_template.docx'));

                    $my_template->setValue('name', strtoupper($applicant->sname." ".$applicant->mname." ".$applicant->fname));
                    $my_template->setValue('box', strtoupper( $applicant->BOX));
                    $my_template->setValue('address', strtoupper($applicant->address));
                    $my_template->setValue('postal_code', strtoupper($applicant->postal_code));
                    $my_template->setValue('town', strtoupper($applicant->town));
                    $my_template->setValue('course', $applicant->kuccpsApplication->course_name);
                    $my_template->setValue('department', $course->getCourseDept->name);
                    $my_template->setValue('duration', $course->courseRequirements->course_duration);
                    $my_template->setValue('from', Carbon\carbon::parse($applicant->kuccpsApplication->kuccpsIntake->intake_from)->format('d-m-Y'));
                    $my_template->setValue('to', Carbon\carbon::parse($applicant->kuccpsApplication->kuccpsIntake->intake_to)->format('d-m-Y'));
                    $my_template->setValue('reg_number', $applicant->kuccpsApplication->course_code."/".str_pad(1 + $regNumber, 3, "0", STR_PAD_LEFT)."J"."/".Carbon\carbon::parse($applicant->kuccpsApplication->kuccpsIntake->intake_from)->format('Y'));
                    $my_template->setValue('ref_number', 'APP/'.date('Y')."/".str_pad(0000000 + $applicant->id, 6, "0", STR_PAD_LEFT));
                    $my_template->setValue('date',  date('d-M-Y'));


                    $docPath = storage_path('APP'."_".date('Y')."_".str_pad(0000000 + $applicant->id, 6, "0", STR_PAD_LEFT).".docx");

                    $my_template->saveAs($docPath);

                    $contents = \PhpOffice\PhpWord\IOFactory::load($docPath);

                    $pdfPath = storage_path('APP'."_".date('Y')."_".str_pad(0000000 + $applicant->id, 6, "0", STR_PAD_LEFT).".pdf");

                   if(file_exists($pdfPath)){
                       unlink($pdfPath);
                   }

               $converter = new OfficeConverter(storage_path('APP'."_".date('Y')."_".str_pad(0000000 + $applicant->id, 6, "0", STR_PAD_LEFT).".docx"), storage_path());
               $converter->convertTo('APP'."_".date('Y')."_".str_pad(0000000 + $applicant->id, 6, "0", STR_PAD_LEFT).'.pdf');

               if(file_exists($docPath)){
                   unlink($docPath);
               }

                Application::where('applicant_id', $applicant->id)->update(['status' => 0]);
                KuccpsApplicant::where('id', $applicant->id)->update(['status' => 1]);

                if ($applicant->alt_email != null){

                    Mail::to($applicant->alt_email)->send(new KuccpsMails($applicant));

                }

            }

        return redirect()->back()->with('success', 'Email sent');
    }

    public function index(){

        return view('registrar::index');
    }

    public function approveIndex(){

        return view('registrar::approval.approveIndex');
    }

    public function importExportViewkuccps(){
        $intakes = Intake::where('status',1)->get();

        $newstudents = KuccpsApplicant::where('status', 0)->get();

        return view('registrar::offer.kuccps')->with(['intakes' => $intakes, 'new' => $newstudents]);

     }

     public function importkuccps(Request $request) {
        $vz = $request->validate([
            'excel_file'   =>    'required|mimes:xlsx'
        ]);
        // return $request->intake;


        $excel_file  = $request->excel_file;
        $intake_id = $request->intake;

        Excel::import(new KuccpsImport( $intake_id), $excel_file);

        return back()->with('success' , 'Data Imported Successfully');
    }

    public function applications(){

        $accepted      =     Application::where('registrar_status', '>=', 0)
        ->where('registrar_status', '!=', 3 )
        ->where('registrar_status', '!=', 4 )
        ->get();

        return view('registrar::offer.applications')->with('accepted',$accepted);
    }

    public function showKuccps(){
        $kuccps = KuccpsApplicant::orderBy('id', 'desc')->get();

        return view('registrar::offer.showKuccps')->with(['kuccps' => $kuccps]);
    }

    public function offer(){

        $active = Intake::where('status', 1)->get();

        if (count($active) === 0){

            $courses = $active;

            return view('registrar::offer.coursesOffer', compact('courses'));

        }else{

            foreach ($active as $intake){

                $courses[] = AvailableCourse::where('intake_id', $intake->id)->get();

            }

            return view('registrar::offer.coursesOffer', compact('courses', 'active'));

        }
    }

    public function profile(){

        return view('registrar::profilepage');
    }

    public function acceptedMail(Request $request){

        $request->validate([
            'submit' => 'required'
        ]);

                foreach($request->submit as $id){

                    $app = Application::find($id);

                    if($app->registrar_status === 1 && $app->cod_status === 1){

                        $regNo  = Application::where('course_id', $app->course_id)
                        ->where('intake_id', $app->intake_id)
                        ->where('student_type', 1)
                        ->where('registrar_status', 3)
                        ->count();

                        $domPdfPath = base_path('vendor/dompdf/dompdf');
                            \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
                            \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

                            $my_template = new TemplateProcessor(storage_path('adm_template.docx'));

                            $my_template->setValue('name', strtoupper($app->applicant->sname." ".$app->applicant->mname." ".$app->applicant->fname));
                            $my_template->setValue('box', strtoupper($app->applicant->address));
                            $my_template->setValue('postal_code', strtoupper($app->applicant->postal_code));
                            $my_template->setValue('town', strtoupper($app->applicant->town));
                            $my_template->setValue('course', $app->courses->course_name);
                            $my_template->setValue('department', $app->courses->getCourseDept->name);
                            $my_template->setValue('duration', $app->courses->courseRequirements->course_duration);
                            $my_template->setValue('from', Carbon\carbon::parse($app->app_intake->intake_from)->format('d - m - Y'));
                            $my_template->setValue('to', Carbon\carbon::parse($app->app_intake->intake_to)->format('d-m-Y'));
                            $my_template->setValue('reg_number', $app->courses->course_code."/".str_pad( 1 + $regNo, 4, "0", STR_PAD_LEFT)."/". Carbon\carbon::parse($app->app_intake->intake_from)->format('Y'));
                            $my_template->setValue('ref_number', 'APP/'.date('Y')."/".str_pad(0000000 + $app->id, 6, "0", STR_PAD_LEFT));
                            $my_template->setValue('date',  date('d-M-Y'));


                            $docPath = storage_path('APP'."_".date('Y')."_".str_pad(0000000 + $app->id, 6, "0", STR_PAD_LEFT).".docx");

                                        $my_template->saveAs($docPath);

                                        $contents = \PhpOffice\PhpWord\IOFactory::load($docPath);

                                        $pdfPath = storage_path('APP'."_".date('Y')."_".str_pad(0000000 + $app->id, 6, "0", STR_PAD_LEFT).".pdf");

                                        if(file_exists($pdfPath)){
                                            unlink($pdfPath);
                                        }

                                        $converter = new OfficeConverter(storage_path('APP'."_".date('Y')."_".str_pad(0000000 + $app->id, 6, "0", STR_PAD_LEFT).".docx"), storage_path());
                                        $converter->convertTo('APP'."_".date('Y')."_".str_pad(0000000 + $app->id, 6, "0", STR_PAD_LEFT).'.pdf');

                                if(file_exists($docPath)){
                                    unlink($docPath);
                                }


                                $update = Application::find($id);
                                    $update->registrar_status = 3;
                                    $update->status = 0;
                                    $update->ref_number = 'APP/'.date('Y')."/".str_pad(0000000 + $app->id, 6, "0", STR_PAD_LEFT);
                                    $update->reg_number = $app->courses->course_code."/".str_pad( 1 + $regNo, 4, "0", STR_PAD_LEFT)."/". Carbon\carbon::parse($app->app_intake->intake_from)->format('Y');
                                    $update->adm_letter = 'APP'."_".date('Y')."_".str_pad(0000000 + $app->id, 6, "0", STR_PAD_LEFT).".pdf";
                                    $update->save();

                                    Mail::to($app->applicant->email)->send(new \App\Mail\RegistrarEmails($app->applicant));

                    }
                    if($app->finance_status === 3 && $app->registrar_status === 1){

                        // Send Mail

                        $update = Application::find($id);
                        $update->finance_status = 0;
                        $update->registrar_status = NULL;
                        $update->save();
                    }
                    if($app->dean_status === 2 && $app->registrar_status === 1){

                        // Send Failure Mail

                    }
                    if($app->dean_status === 1 && $app->registrar_status === 2){

                        Application::where('id', $id)->update(['cod_status' => 3, 'dean_status' => 3, 'registrar_status' => 4]);

                    }
                    if($app->dean_status === 2 && $app->registrar_status === 1){

                        Application::where('id', $id)->update(['cod_status' => 3, 'dean_status' => 3, 'registrar_status' => 4]);


                    }
                    if($app->cod_status === 2 && $app->registrar_status === 1){

                    Mail::to($app->applicant->email)->send(new \App\Mail\RegistrarEmails1($app->applicant));

                        $update = Application::find($id);
                        $update->registrar_status = 3;
                        $update->save();

                    }

                }

        return redirect()->back()->with('success', 'Report Generated');

}



    /**
     * Show the form for a new Intake Information.
     *
     */
    public function addIntake()
    {
        $data          =      Intake::all();
        $courses       =      Courses::all();

        return view('registrar::intake.addIntake')->with(['data'=>$data,'courses'=>$courses]);
    }

    public function editstatusIntake($id)
    {
        $data        =      Intake::find($id);

        return view('registrar::intake.editstatusIntake')->with('data' , $data);
    }

    public function statusIntake(Request $request, $id){

        $xyz = $request->validate(['status' => 'required']);


        if($request->status == 1){
            Intake::where('status', 1)->update(['status' => 2]);

            AvailableCourse::where('status', 1)->update(['status' => 0]);

            $data             =       Intake::find($id);
            $data->status     =       $request->input('status');
            $data->save();

           AvailableCourse::where('intake_id', $id)->update(['status' => 1]);

        }else{

            $data             =       Intake::find($id);
            $data->status     =       $request->input('status');
            $data->save();

        AvailableCourse::where('intake_id', $id)->update(['status' => 0]);

        }

        return redirect()->route('courses.showIntake')->with('status','Data Updated Successfully');


    }

    public function viewCourse($id){

        $course    =    AvailableCourse::where('id', $id)->select('course_id')->get();


        foreach($course as $data){

            $courses[]    =      Courses::where('id',$data->course_id)->get();

        }

        return view('registrar::intake.viewCourse')->with('courses',$courses);
    }

    public function viewIntake($id){

        $course     =  AvailableCourse::where('intake_id', $id)->select('course_id')->get();

            foreach($course as $item){

            $courses[]    =     Courses::where('id', $item->course_id)->get();

            }

        return view('registrar::intake.viewIntake')->with('courses', $courses);
    }

    public function storeIntake(Request $request)    {

        $vz = $request->validate([
            'intake_name_from'      =>     'required',
            'intake_name_to'        =>     'required'

        ]);

        $intake                  =         new Intake;
        $intake->intake_from     =         $request->input('intake_name_from');
        $intake->intake_to       =         $request->input('intake_name_to');
        $intake->status          =         0;
        $intake->save();

        return redirect()->route('courses.showIntake')->with('success','Intake Created successfuly');
    }

    public function showIntake()
    {
        $data       =      Intake::latest()->paginate(5);

        return view('registrar::intake.showIntake')->with('data',$data);
    }


    public function editIntake($id)
    {
        $courses        =         Courses::all();
        $data           =         Intake::find($id);
        $course[]       =         AvailableCourse::find($id);

        return view('registrar::intake.editIntake')->with(['data'=>$data,'courses'=>$courses,'course'=>$course]);
    }


    public function updateIntake(Request $request, $id)
    {
        $data                   =      Intake::find($id);
        $data->intake_from      =      $request->input('intake_name_from');
        $data->intake_to        =      $request->input('intake_name_to');
        $data->save();

        foreach($request->input('course') as $course_id){

            $intakes               =        AvailableCourse::find($course_id)->id;
            $intakes->course_id    =        $course_id;
            $intakes->intake_id    =        $data->id;
            $intakes->save();
        }

        $data->intake_to           =        $request->input('intake_name_to');
        $data->update();

        return redirect()->route('courses.showIntake')->with('status','Data Updated Successfully');

    }


    public function destroyIntake($id)
    {
        $data      =    Intake::find($id);
        $data->delete();

        return redirect()->route('courses.showIntake');
    }

    /**
     *
     * Information about School
    */
    public function addAttendance(){

        return view('registrar::attendance.addAttendance');
    }


    public function showAttendance(){

        $data      =      Attendance::latest()->paginate(5);

        return view('registrar::attendance.showAttendance')->with('data',$data);

    }

    public function editAttendance($id){

        $data       =      Attendance::find($id);

        return view('registrar::attendance.editAttendance')->with('data',$data);
    }

    public function updateAttendance(Request $request, $id){

        $data                     =     Attendance::find($id);
        $data->attendance_code    =     $request->input('attendance_code');
        $data->attendance_name    =     $request->input('attendance_name');
        $data->update();

        return redirect()->route('courses.showAttendance')->with('status','Data Updated Successfully');

    }

    public function storeAttendance(Request $request){

        $vz                        =      $request->validate([
            'attendance_name'      =>     'required',
            'attendance_code'      =>     'required'
        ]);

        $attendances                     =     new Attendance;
        $attendances->attendance_code    =     $request->input('attendance_code');
        $attendances->attendance_name    =     $request->input('attendance_name');
        $attendances->save();

        return redirect()->route('courses.showAttendance')->with('success','Attendance Created');
    }

    public function destroyAttendance($id){

        $data      =    Attendance::find($id);
        $data->delete();

        return redirect()->route('courses.showAttendance');

    }

    /**
     *
     * Information about School
    */
    public function  addschool(){

        return view('registrar::school.addSchool');
    }


    public function  showSchool(){

        $data      =     School::latest()->paginate(5);
        return view('registrar::school.showSchool')->with('data',$data);

    }


    public function editSchool($id){

        $data      =     School::find($id);

        return view('registrar::school.editSchool')->with('data',$data ) ;
    }

    public function updateSchool(Request $request, $id){

        $data               =       School::find($id);
        $data->initials     =       $request->input('initials');
        $data->name         =       $request->input('name');
        $data->update();

        return redirect()->route('courses.showSchool')->with('status','Data Updated Successfully');

    }

    public function storeSchool(Request $request){

        $vz                    =      $request->validate([
            'initials'         =>     'required|unique:schools',
            'name'             =>     'required|unique:schools'
        ]);

        $schools               =     new School;

        $schools->initials     =   $request->input('initials');
        $schools->name         =   $request->input('name');
        $schools->save();

        return redirect()->route('courses.showSchool')->with('success','School Created');
    }

    public function destroySchool($id){

        $data      =     School::find($id);
        $data->delete();

        return redirect()->route('courses.showSchool');

    }

    /**
     *
     * Information about departments
     */
    public function addDepartment(){

        $schools    =      School::all();

        return view('registrar::department.addDepartment')->with('schools',$schools);
    }

    public function showDepartment(){

        $data      =       Department::latest()->get();

        return view('registrar::department.showDepartment')->with('data',$data);
    }

    public function storeDepartment(Request $request){

        $vz                       =      $request->validate([
            // 'school_id'           =>     'required|unique:departments',
            'dept_code'           =>     'required|unique:departments',
            'name'                =>     'required|unique:departments'

        ]);

        $departments              =       new Department;
        $departments->school_id   =       $request->input('school');
        $departments->dept_code   =       $request->input('dept_code');
        $departments->name        =       $request->input('name');
        $departments->save();

        return redirect()->route('courses.showDepartment')->with('success','Department Created');
    }

    public function editDepartment($id){

        $data          =      Department::find($id);
        $schools       =      School::all();

        return view('registrar::department.editDepartment')->with(['data'=>$data, 'schools'=>$schools]);
    }

    public function updateDepartment(Request $request, $id){

        $data               =       Department::find($id);
        $data->school_id    =       $request->input('school');
        $data->dept_code   =       $request->input('dept_code');
        $data->name         =       $request->input('name');

         $data->update();

        return redirect()->route('courses.showDepartment')->with('status','Data Updated Successfully');
    }

     public function destroyDepartment($id){

        $data      =    Department::find($id);
        $data->delete();

        return redirect()->route('courses.showDepartment');

    }

     /**
     *
     * Information about Course
    */
    public function addCourse(){

        $schools           =      School::all();
        $departments       =      Department::all();
        $campuses          =      Campus::all();
        $group             =      \Modules\Registrar\Entities\Group::all();


         return view('registrar::course.addCourse')->with([ 'schools'=>$schools,'departments'=>$departments, 'campus' => $campuses, 'groups' => $group]);
    }

    public function storeCourse(Request $request){

          //        return $request->all();
        $vz = $request->validate([

            'department'             =>  'required',
            'course_name'               =>  'required|unique:courses',
            'course_code'               =>  'required|unique:courses',
            'level'                     =>  'required',
            'course_duration'           =>  'required',
            'course_requirements'       =>  'required',
            'subject1'                  =>  'required',
            'subject2'                  =>  'required',
            'subject3'                  =>  'required',
            'subject'                  =>  'required'
        ]);

        $subject = $request->subject;
        $subject1 = $request->subject1;
        $subject2 = $request->subject2;
        $subject3 = $request->subject3;

        $data = implode(",", $subject);
        $data1 = implode(",", $subject1);
        $data2 = implode(",", $subject2);
        $data3 = implode(",", $subject3);




        $courses                      =    new Courses();
        $courses->campus_id           =    $request->input('main');
        $courses->department_id       =    $request->input('department');
        $courses->course_name         =    $request->input('course_name');
        $courses->course_code         =    $request->input('course_code');
        $courses->level               =    $request->input('level');
        $courses->save();


        $requirement = new CourseRequirement;
        $requirement->course_id           =    $courses->id;
        $requirement->course_duration     =    $request->input('course_duration');
        if($request->level  == 1) {
            $requirement->fee  = '500';
        }elseif($request->level  == 2) {
            $requirement->fee  = '500';
        }elseif($request->level  == 3){
            $requirement->fee  = '1000';
        }else{
            $requirement->fee  = '1500';
        }
        $requirement->course_requirements =    $request->input('course_requirements');
        $requirement->subject1            =    str_replace(',','/',$data)." ".$request->grade1;
        $requirement->subject2            =    str_replace(',','/',$data1)." ".$request->grade2;
        $requirement->subject3            =    str_replace(',','/',$data2)." ".$request->grade2;
        $requirement->subject4            =    str_replace(',','/',$data3)." ".$request->grade3;
        $requirement->save();

        return redirect()->route('courses.showCourse')->with('success','Course Created');
    }

    public function showCourse(){

        $data = Courses::orderBy('id', 'desc')->get();

        return view('registrar::course.showCourse')->with('data',$data);
    }

    public function editCourse($id){
        // $campuses           =          Campus::all();
        $schools            =          School::all();
        $departments        =          Department::all();
        $data               =          Courses::find($id);

        return view('registrar::course.editCourse')->with(['data'=>$data,'schools'=>$schools,'departments'=>$departments]);
    }

    public function updateCourse(Request $request, $id){

        $data                      =    Courses::find($id);

        $data->course_name         =    $request->input('course_name');
        // $data->campus_id           =    $request->input('campus');
        $data->department_id       =    $request->input('department');
        $data->level               =    $request->input('level');
        $data->course_code         =    $request->input('course_code');
        $data->course_duration     =    $request->input('course_duration');
        $data->course_requirements =    $request->input('course_requirements');
        $data->subject1            =    $request->input('subject1');
        $data->subject2            =    $request->input('subject2');
        $data->subject3            =    $request->input('subject3');
        $data->subject4            =    $request->input('subject4');
        $data->update();

        return redirect()->route('courses.showCourse')->with('status','Data Updated Successfully');

    }

    public function destroyCourse($id){

        $data     =      Courses::find($id);
        $data->delete();

        return redirect()->route('courses.showCourse');

    }
    public function archived(){

        $archived   =  Application::where('registrar_status',3)->get();

        return view('registrar::offer.archived')->with('archived',$archived);

    }

    /**
     *
     * information about class
     */

    public function addClasses(){

        $attendances        =         Attendance::all();
        // $clusters            =        ClusterSubjects::all();

        $courses            =         Courses::all();
        $intakes            =         Intake::where('status', 1)->get();

        return view('registrar::class.addClasses')->with(['attendances'  =>  $attendances, 'courses' =>  $courses, 'intakes' => $intakes]);
    }

    public function storeClasses(Request $request){

        $vz                    =           $request->validate([
            'attendance'       =>          'required',
            'intake_from'      =>          'required',
            'course'           =>          'required',

        ]);

        $intake                  =        AvailableCourse::where('course_id', $request->course_id)->select('intake_id')->get();

        $class                   =        new Classes;
        $class->attendance_id    =        $request->input('attendance');
        $class->course_id        =        $request->input('course');
        $class->intake_from      =        $request->intake_from;
        $class->attendance_code  =        $request->input('attendance');
        $class->name             =        $request->input('course')."/".$request->intake_from."/".$request->input('attendance');
        $class->save();

        return redirect()->route('courses.showClasses')->with('success','Class Created');
    }

    public function showClasses(){

        $data = Classes::all();

        return view('registrar::class.showClasses')->with('data',$data);
    }

    public function editClasses($id){

        $data             =       Classes::find($id);
        $attendances      =       Attendance::all();
        $courses          =       Courses::all();
        $data             =       Classes::find($id);
        $intakes          =       Intake::where('status',1)->get();


        return view('registrar::class.editClasses')->with(['data'=>  $data,'attendances'=>$attendances,'courses'=>$courses,'intakes'=>$intakes]);
    }

    public function updateClasses(Request $request, $id){

        $request->validate([
            'attendance_code'     =>      'required|string',
            'course_code'         =>      'required|string'
        ]);

        $data                 =   Classes::find($id);
        $data->attendance_id  =  $request->input('attendance');
        $data->course_id      =  $request->input('course');
        $data->name           =  $request->course_code."/".$request->intake_from."/".$request->attendance_code;
        $data->save();

        return redirect()->route('courses.showClasses')->with('status','Data Updated Successfully');
    }

     public function destroyClasses($id){

        $data           =       Classes::find($id);
        $data->delete();

        return redirect()->route('courses.showClasses');

    }
    public function destroyCoursesAvailable(Request $request, $id){

        $course = AvailableCourse::find($id)->delete();


        return redirect()->route('courses.offer');
    }

    public function admissions(){

        $admission = AdmissionApproval::where('medical_status', 1)
//            ->where('student_type', 1)
            ->where('status', NULL)
            ->get();

        return view('registrar::admissions.index')->with('admission', $admission);
    }

    public function admissionsJab(){

        $admission = AdmissionApproval::where('medical_status', 1)
            ->where('student_type', 2)
            ->where('status', NULL)
            ->get();

        return view('registrar::admissions.kuccps')->with('admission', $admission);
    }

    public function admitStudent($id){

        $app = AdmissionApproval::find($id);

        //        return $app;

            $student = new Student;

            $student->reg_number = $app->admissions->reg_number;
            $student->ref_number = $app->admissions->ref_number;
            $student->sname = $app->admissions->applicant->sname;
            $student->fname = $app->admissions->applicant->fname;
            $student->mname = $app->admissions->applicant->mname;
            $student->email = $app->admissions->applicant->email;
            $student->student_email = strtolower(str_replace('/', '', $app->admissions->reg_number).'@students.tum.ac.ke');
            $student->mobile = $app->admissions->applicant->mobile;
            $student->alt_mobile = $app->admissions->applicant->alt_mobile;
            $student->title = $app->admissions->applicant->title;
            $student->marital_status = $app->admissions->applicant->marital_status;
            $student->gender = $app->admissions->applicant->gender;
            $student->dob = $app->admissions->applicant->DOB;
            $student->id_number = $app->admissions->applicant->id_number;
            $student->citizen = $app->admissions->applicant->nationality;
            $student->county = $app->admissions->applicant->county;
            $student->sub_county = $app->admissions->applicant->sub_county;
            $student->town = $app->admissions->applicant->town;
            $student->address = $app->admissions->applicant->address;
            $student->postal_code = $app->admissions->applicant->postal_code;
            $student->disabled = $app->admissions->applicant->disabled;
            $student->disability = $app->admissions->applicant->disability;
            $student->save();

            $studCourse = new StudentCourse;
            $studCourse->student_id = $student->id;
            $studCourse->department_id = $app->admissions->courses->department_id;
            $studCourse->course_id = $app->admissions->course_id;
            $studCourse->intake_id = $app->admissions->intake_id;
            $studCourse->class_code = strtoupper($app->admissions->courses->course_code.'/'.Carbon\carbon::parse($app->admissions->intake_from)->format('MY').'/J-FT');
            $studCourse->class = strtoupper($app->admissions->courses->course_code.'/'.Carbon\carbon::parse($app->admissions->intake_from)->format('MY').'/J-FT');
            $studCourse->course_duration = $app->admissions->courses->courseRequirements->course_duration;
            $studCourse->save();

            $studLogin = new StudentLogin;
            $studLogin->username = $app->admissions->reg_number;
            $studLogin->password = Hash::make($app->admissions->applicant->id_number);
            $studLogin->student_id = $student->id;
            $studLogin->save();

            $admin = AdmissionApproval::find($id);
            $admin->registrar_status = 1;
            $admin->accommodation_status = 0;
            $admin->save();

            return redirect()->back()->with('success', 'New student admission completed successfully');

    }

    public function studentID($id){
        $studentID = AdmissionApproval::find($id);
        return view('registrar::admissions.studentID')->with('app', $studentID);
    }

    public function storeStudentID(Request $request, $id){

        //        return $request->all();

        $request->validate([
           'image' => 'required'
        ]);

        $studID = AdmissionApproval::find($id);

        $img = $request->image;
        $folderPath = "studentID/";

        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);
        $fileName = strtoupper(str_replace('/', '', $studID->admissions->reg_number)). '.png';

        $file = $folderPath. $fileName;

        Storage::put( $file, $image_base64);

        AdmissionApproval::where('id', $id)->update(['id_status' => 1]);

        Student::where('reg_number', $studID->admissions->reg_number)->update(['ID_photo' => $fileName]);

        return redirect()->route('courses.admissions')->with('success', 'ID photo uploaded successfully');


    }

    public function fetchSubjects(Request $request){

        $data = ClusterSubjects::where('group_id', $request->id)->get();
        return response()->json($data);

    }

}



