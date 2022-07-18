<?php

namespace Modules\Registrar\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Modules\Application\Entities\AdmissionApproval;
use Modules\Registrar\Entities\Campus;
use Modules\Registrar\Entities\Intake;
use Modules\Registrar\Entities\School;
use Modules\Registrar\Entities\Classes;
use Modules\Registrar\Entities\Courses;
use Modules\Registrar\Entities\Attendance;
use Modules\Registrar\Entities\Department;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Support\Renderable;
use Modules\Application\Entities\Application;
use Modules\Registrar\Entities\AvailableCourse;
use Modules\Registrar\Entities\Student;
use Modules\Registrar\Entities\StudentCourse;
use Modules\Registrar\Entities\StudentLogin;
use PhpOffice\PhpWord\TemplateProcessor;
use Carbon;
use NcJoes\OfficeConverter\OfficeConverter;
use Illuminate\Support\Facades\Storage;

class CoursesController extends Controller

{

    public function index(){

        return view('registrar::index');
    }

    public function approveIndex(){

        return view('registrar::approval.approveIndex');
    }

    public function applications(){

        $accepted      =     Application::where('registrar_status', 0)->get();

        return view('registrar::offer.applications')->with('accepted',$accepted);
    }

    public function offer(){

        $course_id     =     AvailableCourse::select('course_id')->get();

        if (count($course_id) == 0){

            $availables  =  [];
        }
        foreach ($course_id as $course){

            $availables[]     =     Courses::where('id', $course->course_id)->get();

        }

        $intake_id      =       AvailableCourse::select('intake_id')->get();

        return view('registrar::offer.coursesOffer')->with(['availables' => $availables, 'intake' => $intake_id]);
    }

    public function profile(){

        return view('registrar::profilepage');
    }

    public function acceptedMail(Request $request){

        foreach($request->submit as $id){

            $app = Application::find($id);

            if($app->dean_status === 1){

                $domPdfPath = base_path('vendor/dompdf/dompdf');
                    \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
                    \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

                     $my_template = new TemplateProcessor(storage_path('adm_template.docx'));

                     $my_template->setValue('name', strtoupper($app->applicant->sname." ".$app->applicant->mname." ".$app->applicant->fname));
                     $my_template->setValue('address', strtoupper($app->applicant->address));
                     $my_template->setValue('town', strtoupper($app->applicant->town));
                     $my_template->setValue('course', $app->courses->course_name);
                     $my_template->setValue('department', $app->courses->department_id);
                     $my_template->setValue('duration', $app->courses->course_duration);
                     $my_template->setValue('from', Carbon\carbon::parse($app->app_intake->intake_from)->format('d - m - Y'));
                     $my_template->setValue('to', Carbon\carbon::parse($app->app_intake->intake_to)->format('d-m-Y'));
                     $my_template->setValue('reg_number', $app->courses->course_code."/".str_pad(0000 + $app->id, 4, "0", STR_PAD_LEFT)."/".date('Y'));
                     $my_template->setValue('ref_number', 'APP/'.date('Y')."/".str_pad(0000000 + $app->id, 6, "0", STR_PAD_LEFT));
                     $my_template->setValue('date',  date('d-M-Y'));


                       $docPath = storage_path('APP'."_".date('Y')."_".str_pad(0000000 + $app->id, 6, "0", STR_PAD_LEFT).".docx");

                                $my_template->saveAs($docPath);

//                                $contents = \PhpOffice\PhpWord\IOFactory::load($docPath);
//
//                                $pdfPath = storage_path('APP'."_".date('Y')."_".str_pad(0000000 + $app->id, 6, "0", STR_PAD_LEFT).".pdf");
//
//                                if(file_exists($pdfPath)){
//                                    unlink($pdfPath);
//                                }
//
//                                $converter = new OfficeConverter(storage_path('APP'."_".date('Y')."_".str_pad(0000000 + $app->id, 6, "0", STR_PAD_LEFT).".docx"), storage_path());
//                                $converter->convertTo('APP'."_".date('Y')."_".str_pad(0000000 + $app->id, 6, "0", STR_PAD_LEFT).'.pdf');
//
//                        if(file_exists($docPath)){
//                            unlink($docPath);
//                        }

            Mail::to($app->applicant->email)->send(new \App\Mail\RegistrarEmails($app->applicant));

            $app->find($id);
            $app->registrar_status = 1;
            $app->status = 0;
            $app->ref_number = 'APP/'.date('Y')."/".str_pad(0000000 + $app->id, 6, "0", STR_PAD_LEFT);
            $app->reg_number = $app->courses->course_code."/".str_pad(0000 + $app->id, 4, "0", STR_PAD_LEFT)."/".date('Y');
            $app->adm_letter = 'APP'."_".date('Y')."_".str_pad(0000000 + $app->id, 6, "0", STR_PAD_LEFT).".pdf";
            $app->save();

            }elseif($app->dean_status === 2){
                Mail::to($app->applicant->email)->send(new \App\Mail\RegistrarEmails1($app->applicant));

                $app->find($id);
                $app->registrar_status = 1;
                $app->save();

            }else{

                $app = Application::find($id);
                $app->finance_status = NULL;
                $app->registrar_status = NULL;
                $app->save();
            }

        }
        return redirect()->back()->with('success', 'Email sent');
    }



    /**
     * Show the form for a new Intake Information.
     *
     */
    public function addIntake()
    {
        $data          =      Intake::all();
        $courses       =      Course::all();

        return view('registrar::intake.addIntake')->with(['data'=>$data,'courses'=>$courses]);
    }

    public function editstatusIntake($id)
    {
        $data        =      Intake::find($id);

        return view('registrar::intake.editstatusIntake')->with('data' , $data);
    }

    public function statusIntake(Request $request, $id){

        $data             =       Intake::find($id);

        $data->status     =       $request->input('status');
        $data->update();

        return redirect()->route('registrar.showIntake')->with('status','Data Updated Successfully');
    }

    public function viewCourse($id){

        $course    =    AvailableCourse::where('id', $id)->select('course_id')->get();


        foreach($course as $data){

            $courses[]    =      Course::where('id',$data->course_id)->get();

        }

        return view('registrar::intake.viewCourse')->with('courses',$courses);
    }

    public function viewIntake($id){

        $course     =  AvailableCourse::where('intake_id', $id)->select('course_id')->get();

            foreach($course as $item){

            $courses[]    =     Course::where('id', $item->course_id)->get();

            }

        return view('registrar::intake.viewIntake')->with('courses', $courses);
    }

    public function storeIntake(Request $request)    {

        $vz = $request->validate([
            'course'                =>     'required',
            'intake_name_from'      =>     'required',
            'intake_name_to'        =>     'required'

        ]);

        $intake                  =         new Intake;
        $intake->intake_from     =         $request->input('intake_name_from');
        $intake->intake_to       =         $request->input('intake_name_to');
        $intake->status          =         0;
        $intake->save();

        foreach($request->input('course') as $course_id){
            $intakes              =          new AvailableCourse;
            $intakes->course_id   =          $course_id;
            $intakes->intake_id   =          $intake->id;
            $intakes->save();
        }

        return redirect()->route('registrar.showIntake')->with('success','Intake Created successfuly');
    }

    public function showIntake()
    {
        $data       =      Intake::latest()->paginate(5);

        return view('registrar::intake.showIntake')->with('data',$data);
    }


    public function editIntake($id)
    {
        $courses        =         Course::all();
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

        return redirect()->route('registrar.showIntake')->with('status','Data Updated Successfully');

    }


    public function destroyIntake($id)
    {
        $data      =    Intake::find($id);
        $data->delete();

        return redirect()->route('registrar.showIntake');
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

        return redirect()->route('registrar.showAttendance')->with('status','Data Updated Successfully');

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

        return redirect()->route('registrar.showAttendance')->with('success','Attendance Created');
    }

    public function destroyAttendance($id){

        $data      =    Attendance::find($id);
        $data->delete();

        return redirect()->route('registrar.showAttendance');

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

        return view('registrar::school.editSchool')->with('data',$data);
    }

    public function updateSchool(Request $request, $id){

        $data               =       School::find($id);
        $data->name         =       $request->input('name');
        $data->initials     =       $request->input('initials');
        $data->update();

        return redirect()->route('registrar.showSchool')->with('status','Data Updated Successfully');

    }

    public function storeSchool(Request $request){

        $vz                    =      $request->validate([
            'name'             =>     'required'
        ]);

        $schools               =     new School;
        $schools->name         =     $request->input('name');
        $schools->initials     =   $request->input('initials');
        $schools->save();

        return redirect()->route('registrar.showSchool')->with('success','School Created');
    }

    public function destroySchool($id){

        $data      =     School::find($id);
        $data->delete();

        return redirect()->route('registrar.showSchool');

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

        $data      =       Department::latest()->paginate(5);

        return view('registrar::department.showDepartment')->with('data',$data);
    }

    public function storeDepartment(Request $request){

        $vz                       =      $request->validate([
            'name'                =>     'required',
            'school'              =>     'required'
        ]);

        $departments              =       new Department;
        $departments->name        =       $request->input('name');
        $departments->dept_code        =       'Dept';
        $departments->school_id   =       $request->input('school');
        $departments->save();

        return redirect()->route('registrar.showDepartment')->with('success','Department Created');
    }

    public function editDepartment($id){

        $data          =      Department::find($id);
        $schools       =      School::all();

        return view('registrar::department.editDepartment')->with(['data'=>$data, 'schools'=>$schools]);
    }

    public function updateDepartment(Request $request, $id){

        $data               =       Department::find($id);
        $data->name         =       $request->input('name');
        $data->school_id    =       $request->input('school');
         $data->update();

        return redirect()->route('registrar.showDepartment')->with('status','Data Updated Successfully');
    }

     public function destroyDepartment($id){

        $data      =    Department::find($id);
        $data->delete();

        return redirect()->route('registrar.showDepartment');

    }

     /**
     *
     * Information about Course
    */
    public function addCourse(){

        $schools           =      School::all();
        $departments       =      Department::all();

         return view('registrar::course.addCourse')->with(['schools'=>$schools,'departments'=>$departments]);
    }

    public function storeCourse(Request $request){

      $vz = $request->validate([
          'school'                    =>  'required',
          'department'                =>  'required',
          'course_name'               =>  'required|unique:courses',
          'course_code'               =>  'required|unique:courses',
          'level'                     =>  'required',
          'course_duration'           =>  'required',
          'course_requirements'       =>  'required',
          'subject1'                  =>  'required',
          'subject2'                  =>  'required',
          'subject3'                  =>  'required',
          'subject4'                  =>  'required'
      ]);

        $courses                      =    new Course;
        $courses->school_id           =    $request->input('school');
        $courses->department_id       =    $request->input('department');
        $courses->course_name         =    $request->input('course_name');
        $courses->level               =    $request->input('level');
        $courses->course_duration     =    $request->input('course_duration');
        if($request->level == 1) {$courses->fee  = '500';}
        if($request->level == 2) {$courses->fee  = '500';}
        if($request->level == 3) {$courses->fee  = '1000';}
        if($request->level >= 4) {$courses->fee  = '1500';}
        $courses->course_code         =    $request->input('course_code');
        $courses->course_requirements =    $request->input('course_requirements');
        $courses->subject1            =    $request->input('subject1');
        $courses->subject2            =    $request->input('subject2');
        $courses->subject3            =    $request->input('subject3');
        $courses->subject4            =    $request->input('subject4');
        $courses->save();

        return redirect()->route('registrar.showCourse')->with('success','Course Created');
    }

    public function showCourse(){

        $data = Course::orderBy('id', 'desc')->get();

        return view('registrar::course.showCourse')->with('data',$data);
    }

    public function editCourse($id){

        $schools            =          School::all();
        $departments        =          Department::all();
        $data               =          Course::find($id);

        return view('registrar::course.editCourse')->with(['data'=>$data,'schools'=>$schools,'departments'=>$departments]);
    }

    public function updateCourse(Request $request, $id){

        $data                      =    Course::find($id);
        $data->course_name         =    $request->input('course_name');
        $data->school_id           =    $request->input('school');
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

        return redirect()->route('registrar.showCourse')->with('status','Data Updated Successfully');

    }

    public function destroyCourse($id){

        $data     =      Course::find($id);
        $data->delete();

        return redirect()->route('courses.showCourse');

    }
    public function archived(){

        $archived   =  Application::where('registrar_status',1)->get();

        return view('registrar::offer.archived')->with('archived',$archived);

    }

    /**
     *
     * information about class
     */

    public function addClasses(){

        $attendances        =         Attendance::all();
        $courses            =         Course::all();
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

        $data = Classes::latest()->paginate(5);

        return view('registrar::class.showClasses')->with('data',$data);
    }

    public function editClasses($id){

        $data             =       Classes::find($id);
        $attendances      =       Attendance::all();
        $courses          =       Course::all();
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

        $course = AvailableCourse::find('id', $id)->delete();

        return redirect()->route('courses.offer');
    }

    public function admissions(){

            $admission = AdmissionApproval::where('medical_status', 1)
                ->where('status', NULL)
                ->get();

        return view('registrar::admissions.index')->with('admission', $admission);
    }

    public function admitStudent($id){

        $app = AdmissionApproval::find($id);

//        return $app;

            $student = new Student;

            $student->reg_number = $app->appApproval->reg_number;
            $student->ref_number = $app->appApproval->ref_number;
            $student->sname = $app->appApproval->applicant->sname;
            $student->fname = $app->appApproval->applicant->fname;
            $student->mname = $app->appApproval->applicant->mname;
            $student->email = $app->appApproval->applicant->email;
            $student->student_email = strtolower(str_replace('/', '', $app->appApproval->reg_number).'@students.tum.ac.ke');
            $student->mobile = $app->appApproval->applicant->mobile;
            $student->alt_mobile = $app->appApproval->applicant->alt_mobile;
            $student->title = $app->appApproval->applicant->title;
            $student->marital_status = $app->appApproval->applicant->marital_status;
            $student->gender = $app->appApproval->applicant->gender;
            $student->dob = $app->appApproval->applicant->DOB;
            $student->id_number = $app->appApproval->applicant->id_number;
            $student->citizen = $app->appApproval->applicant->nationality;
            $student->county = $app->appApproval->applicant->county;
            $student->sub_county = $app->appApproval->applicant->sub_county;
            $student->town = $app->appApproval->applicant->town;
            $student->address = $app->appApproval->applicant->address;
            $student->postal_code = $app->appApproval->applicant->postal_code;
            $student->disabled = $app->appApproval->applicant->disabled;
            $student->disability = $app->appApproval->applicant->disability;
            $student->save();

            $studCourse = new StudentCourse;
            $studCourse->student_id = $student->id;
            $studCourse->department_id = $app->appApproval->courses->department_id;
            $studCourse->course_id = $app->appApproval->course_id;
            $studCourse->intake_id = $app->appApproval->intake_id;
            $studCourse->class_code = strtoupper($app->appApproval->courses->course_code.'/'.Carbon\carbon::parse($app->appApproval->intake_from)->format('MY').'/J-FT');
            $studCourse->class = strtoupper($app->appApproval->courses->course_code.'/'.Carbon\carbon::parse($app->appApproval->intake_from)->format('MY').'/J-FT');
            $studCourse->course_duration = $app->appApproval->courses->course_duration;
            $studCourse->save();

            $studLogin = new StudentLogin;
            $studLogin->username = $app->appApproval->reg_number;
            $studLogin->password = Hash::make($app->appApproval->applicant->id_number);
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
        $fileName = strtoupper(str_replace('/', '', $studID->appApproval->reg_number)). '.png';

        $file = $folderPath. $fileName;

        Storage::put( $file, $image_base64);

        AdmissionApproval::where('id', $id)->update(['id_status' => 1]);

        Student::where('reg_number', $studID->appApproval->reg_number)->update(['ID_photo' => $fileName]);

        return redirect()->route('courses.admissions')->with('success', 'ID photo uploaded successfully');


    }
}


