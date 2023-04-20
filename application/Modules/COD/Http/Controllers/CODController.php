<?php

namespace Modules\COD\Http\Controllers;

use App\Models\User;
use Auth;
use Modules\Lecturer\Entities\LecturerQualification;
use Modules\Lecturer\Entities\QualificationRemarks;
use Modules\Lecturer\Entities\TeachingArea;
use Modules\Lecturer\Entities\TeachingAreaRemarks;
use Response;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\COD\Entities\CODLog;
use Modules\COD\Entities\Pattern;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\Element\Table;
use Illuminate\Support\Facades\Crypt;
use Modules\COD\Entities\Nominalroll;
use Modules\COD\Entities\Progression;
use Modules\COD\Entities\ClassPattern;
use Modules\COD\Entities\SemesterUnit;
use Modules\Registrar\Entities\Campus;
use Modules\Registrar\Entities\Intake;
use Modules\Registrar\Entities\Classes;
use Modules\Registrar\Entities\Courses;
use Modules\Registrar\Entities\Student;
use Modules\Finance\Entities\FinanceLog;
use PhpOffice\PhpWord\TemplateProcessor;
use Modules\Student\Entities\ExamResults;
use Modules\Student\Entities\Readmission;
use Modules\COD\Entities\ReadmissionClass;
use Modules\Registrar\Entities\Attendance;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use Modules\Application\Entities\Education;
use Modules\Registrar\Entities\SemesterFee;
use Modules\Student\Entities\AcademicLeave;
use NcJoes\OfficeConverter\OfficeConverter;
use Illuminate\Contracts\Support\Renderable;
use Modules\Finance\Entities\StudentInvoice;
use Modules\Registrar\Entities\FeeStructure;
use Modules\Student\Entities\CourseTransfer;
use Modules\Application\Entities\Application;
use Modules\Registrar\Entities\StudentCourse;
use Modules\Registrar\Entities\UnitProgramms;
use Modules\Application\Entities\Notification;
use Modules\Registrar\Entities\AvailableCourse;
use Modules\Registrar\Entities\CourseLevelMode;
use Modules\Registrar\Entities\KuccpsApplication;
use Modules\Student\Entities\ReadmissionApproval;
use Modules\Application\Entities\AdmissionApproval;
use Modules\Application\Entities\AdmissionDocument;
use Modules\Student\Entities\AcademicLeaveApproval;
use Modules\Student\Entities\CourseTransferApproval;

class CODController extends Controller
{

//    public function index(){
//
//        $admissions = Application::where('cod_status', 1)
//            ->where('department_id',auth()->guard('user')->user()->department_id)
//            ->where('registrar_status',3)
//            ->where('status',0)
//            ->count();
//
//        $apps_cod = Application::where('cod_status', 0)
//            ->where('department_id',auth()->guard('user')->user()->employmentDepartment->first()->id)
//            ->orWhere('dean_status', 3)
//            ->count();
//
//        return view('cod::COD.index')->with(['apps'=>$apps_cod, 'admissions'=>$admissions]);
//    }

    public function applications(){

        $applications = Application::where('cod_status', '>=', 0)
            ->where('department_id',auth()->guard('user')->user()->employmentDepartment->first()->id)
            ->where('dean_status', null)
            ->orWhere('dean_status', 3)
            ->orderby('id', 'DESC')
            ->get();

//        return auth()->guard('user')->user()->roles;

        return view('cod::applications.index')->with('apps', $applications);
    }

    public function viewApplication($id){

        $hashedId = Crypt::decrypt($id);

        $app = Application::find($hashedId);
        $school = Education::where('applicant_id', $app->applicant->id)->get();

        return view('cod::applications.viewApplication')->with(['app' => $app, 'school' => $school]);
    }

    public function previewApplication($id){

        $hashedId = Crypt::decrypt($id);

        $app = Application::find($hashedId);
        $school = Education::where('applicant_id', $app->applicant->id)->get();
        return view('cod::applications.preview')->with(['app' => $app, 'school' => $school]);
    }

    public function acceptApplication($id){

        $hashedId = Crypt::decrypt($id);

        $app = Application::find($hashedId);
        $app->cod_status = 1;
        $app->cod_comments = NULL;
        $app->save();

        $logs = new CODLog;
        $logs->application_id = $app->id;
        $logs->user = Auth::guard('user')->user()->name;
        $logs->user_role = Auth::guard('user')->user()->role_id;
        $logs->activity = 'Application accepted';
        $logs->save();

        return redirect()->route('cod.applications')->with('success', '1 applicant approved');
    }

    public function rejectApplication(Request $request, $id){

        $request->validate([
                'comment' => 'required|string'
            ]);

        $hashedId = Crypt::decrypt($id);

        $app = Application::find($hashedId);
        $app->cod_status = 2;
        $app->cod_comments = $request->comment;
        $app->save();

        $logs = new CODLog;
        $logs->application_id = $app->id;
        $logs->user = Auth::guard('user')->user()->name;
        $logs->user_role = Auth::guard('user')->user()->role_id;
        $logs->comments = $request->comment;
        if ($app->dean_status == 3){
            $logs->activity = 'Application reviewed by COD';
        }
        $logs->activity = 'Application rejected';
        $logs->save();

        return redirect()->route('cod.applications')->with('success', 'Application declined');
    }

    public function reverseApplication(Request $request, $id){

        $hashedId = Crypt::decrypt($id);

        $app = Application::find($hashedId);
        $app->cod_status = 4;
        $app->cod_comments = $request->comment;
        $app->save();

        $logs = new CODLog;
        $logs->application_id = $app->id;
        $logs->user = Auth::guard('user')->user()->name;
        $logs->user_role = Auth::guard('user')->user()->role_id;
        $logs->comments = $request->comment;
        $logs->activity = 'Application reversed for corrections';
        $logs->save();

        $comms = new Notification;
        $comms->application_id = $hashedId;
        $comms->role_id = Auth::guard('user')->user()->role_id;
        $comms->subject = 'Application Approval Process';
        $comms->comment = $request->comment;
        $comms->save();

        return  redirect()->route('cod.applications')->with('success', 'Application send to the student for Corrections');
    }

    public function batch(){
        $apps = Application::where('cod_status', '>', 0)
            ->where('department_id',auth()->guard('user')->user()->employmentDepartment->first()->id)
            ->where('dean_status', null)
            ->orWhere('dean_status', 3)
            ->where('cod_status', '!=', 3)
            ->get();

        return view('cod::applications.batch')->with('apps', $apps);
    }

    public function batchSubmit(Request $request){

        foreach ($request->submit as $item){

            $app = Application::find($item);

            if ($app->cod_status == 4){

                $app = Application::find($item);
                $app->cod_status = NULL;
                $app->finance_status = NULL;
                $app->declaration = 0;
                $app->save();

                $logs = new CODLog;
                $logs->application_id = $app->id;
                $logs->user = Auth::guard('user')->user()->name;
                $logs->user_role = Auth::guard('user')->user()->role_id;
                $logs->activity = "Application awaiting Dean's Verification";
                $logs->save();

                $notify = Notification::where('application_id', $item)->latest()->first();
                $notify->status = 1;
                $notify->save();

            }else{
                $app = Application::find($item);
                $app->dean_status = 0;
                $app->save();

                $logs = new CODLog;
                $logs->application_id = $app->id;
                $logs->user = Auth::guard('user')->user()->name;
                $logs->user_role = Auth::guard('user')->user()->role_id;
                $logs->activity = "Application awaiting Dean's Verification";
                $logs->save();
            }
        }

        return redirect()->route('cod.batch')->with('success', '1 Batch elevated for Dean approval');
    }


    public function admissions(){

        $applicant = Application::where('cod_status', 1)
            ->where('department_id',auth()->guard('user')->user()->employmentDepartment->first()->id)
            ->where('registrar_status', 3)
            ->where('status', 0)
            ->get();

        return view('cod::admissions.index')->with('applicant', $applicant);
    }

    public function reviewAdmission($id){

        $hashedId = Crypt::decrypt($id);

        $app = Application::find($hashedId);
        $documents = AdmissionDocument::where('application_id', $hashedId)->first();
        $school = Education::where('applicant_id', $app->applicant->id)->get();

        return view('cod::admissions.review')->with(['app' => $app, 'documents' => $documents, 'school' => $school]);

    }

    public function acceptAdmission($id){

        $hashedId = Crypt::decrypt($id);

        AdmissionApproval::where('application_id', $hashedId)->update(['cod_status' => 1]);

        return redirect()->route('cod.Admissions')->with('success', 'New student admitted successfully');
    }

    public function rejectAdmission(Request $request, $id){

        $hashedId = Crypt::decrypt($id);

        AdmissionApproval::where('application_id', $hashedId)->update(['cod_status' => 2, 'cod_comments' => $request->comment]);

        return redirect()->route('cod.Admissions')->with('warning', 'Admission request rejected');
    }


    public function withholdAdmission(Request $request, $id){

        $hashedId = Crypt::decrypt($id);

        AdmissionApproval::where('application_id', $hashedId)->update(['cod_status' => 3, 'cod_comments' => $request->comment]);

        return redirect()->route('cod.Admissions')->with('warning', 'Admission request rejected');
    }



    public function submitAdmission($id){

        $hashedId = Crypt::decrypt($id);

        AdmissionApproval::where('application_id', $hashedId)->update(['finance_status' => 0]);

        Application::where('id', $hashedId)->update(['status' => 1]);

        return redirect()->back()->with('success', 'Record submitted to finance');
    }


    public function submitAdmJab($id){

        $hashedId = Crypt::decrypt($id);

        AdmissionApproval::where('application_id', $hashedId)->update(['finance_status' => 0]);

        KuccpsApplication::where('applicant_id', $hashedId)->update(['registered' => Carbon::now()]);

        return redirect()->back()->with('success', 'Record submitted to finance');
    }

    public function courses(){

//        return auth()->guard('user')->user()->employmentDepartment->first()->id;
            $courses = Courses::where('department_id',auth()->guard('user')->user()->employmentDepartment->first()->id)->get();

            return view('cod::courses.index')->with('courses', $courses);
    }

    public function intakes(){

            $intakes = Intake::latest()->get();

            return view('cod::intakes.index')->with('intakes', $intakes);
    }

    public function intakeCourses($id){


        $hashedId = Crypt::decrypt($id);

            $modes = Attendance::all();
            $campuses = Campus::all();
            $intake = Intake::find($hashedId);
            $courses = Courses::where('department_id',auth()->guard('user')->user()->employmentDepartment->first()->id)->get();

            return view('cod::intakes.addCourses')->with(['intake' => $intake, 'courses' => $courses, 'modes' => $modes, 'campuses' => $campuses]);

    }


    public function addAvailableCourses(Request $request){
            $var = $request->json()->all();
            $validation = Validator::make($var['value'][0], [
                'campus' => 'required'
            ]);

            if($validation->passes()) {

                foreach ($var['value'] as $data) {
                    foreach ($data['campus'] as $camp) {

                        $course = new AvailableCourse;
                        $course->intake_id = $data['intake'];
                        $course->course_id = $data['course'];
                        $course->campus_id = $camp;
                        $course->save();

                    }

                    foreach ($data['attendance_code'] as $code) {


                        $intakes = Intake::where('id', $data['intake'])->first();

                        $deptClass = Classes::where('name', $data['course_code'].'/'.strtoupper(Carbon::parse($intakes->intake_from)->format('MY')).'/'.$code)->exists();

                        if ($deptClass == null){

                            $class = new Classes;
                            $class->name = $data['course_code'].'/'.strtoupper(Carbon::parse($intakes->intake_from)->format('MY')).'/'. $code;
                            $class->attendance_id = $code;
                            $class->course_id = $data['course'];
                            $class->intake_from = $data['intake'];
                            $class->attendance_code = $code;
                            $class->save();

                        }

                    }
                }
                return json_encode([ 'success' => true ]);
            }else
                return json_encode([ 'error' => $validation->errors() ]);

    }

    public function deptClasses(){

            $classes = Classes::latest()->get()->groupBy('intake_from');
            $intakes = Intake::all();
            return view('cod::classes.index')->with(['intakes' => $intakes, 'classes' => $classes]);


    }

    public function viewIntakeClasses($intake){

        $intakeId = Crypt::decrypt($intake);

        $intake = Intake::find($intakeId);

        $courses = Courses::where('department_id', auth()->guard('user')->user()->employmentDepartment->first()->id)->get();

        $classes = [];

            foreach ($courses as $course){
                $classes[] = Classes::where('intake_from', $intakeId)
                    ->where('course_id', $course->id)
                    ->latest()
                    ->get();
            }

            return view('cod::classes.intakeClasses')->with(['intake' => $intake, 'classes' => $classes]);
    }

    public function viewSemesterUnits($id){

        $hashedId = Crypt::decrypt($id);

        $pattern = ClassPattern::find($hashedId);

//        return $pattern->pattern_id;

        $class = Classes::where('name', $pattern->class_code)->first();

       $semesterUnits = SemesterUnit::where('class_code', $class->name)
                        ->where('stage', $pattern->stage)
                        ->where('semester', $pattern->pattern_id)
                        ->latest()
                        ->get();

        $units = UnitProgramms::where('course_code', $class->classCourse->course_code)
                            ->orderByRaw("FIELD(stage, $pattern->stage) DESC")
                            ->orderByRaw("FIELD(semester, $pattern->pattern_id) DESC")
                            ->get();


        return view('cod::classes.semesterUnits')->with(['pattern' => $pattern, 'units' => $units, 'semesterUnits' => $semesterUnits]);
    }

    public function addSemesterUnit($id, $unit){
        $hashedId = Crypt::decrypt($id);

        $hashedUnit = Crypt::decrypt($unit);

        $pattern = ClassPattern::find($hashedId);

        $semesterUnit = UnitProgramms::find($hashedUnit);

        if (SemesterUnit::where('unit_code', $semesterUnit->course_unit_code)
                            ->where('class_code', $pattern->class_code)
                            ->where('semester', $pattern->pattern_id)
                            ->exists()){

            return redirect()->back()->with('info', 'Unit has already been mounted to the selected class pattern');

        }else{
            $addUnit = new SemesterUnit;
            $addUnit->class_code = $pattern->class_code;
            $addUnit->unit_code = $semesterUnit->course_unit_code;
            $addUnit->unit_name = $semesterUnit->unit_name;
            $addUnit->stage = $pattern->stage;
            $addUnit->semester = $pattern->pattern_id;
            $addUnit->type = $semesterUnit->type;
            $addUnit->save();
        }

            return redirect()->back()->with('success', 'Unit mounted to the selected class pattern');
    }

    public function dropSemesterUnit($id){

        $hashedId = Crypt::decrypt($id);

        SemesterUnit::find($hashedId)->delete();

        return redirect()->back()->with('success', 'Unit dropped successfully');

    }

    public function classList($id){

        $hashedId = Crypt::decrypt($id);

        $class = Classes::find($hashedId);

       $classList = StudentCourse::where('class_code', $class->name)->get();

        return view('cod::classes.classList')->with(['classList' => $classList, 'class' => $class]);
    }

    public function admitStudent($id){

        $hashedId = Crypt::decrypt($id);

        $student = Student::find($hashedId);

        $student_fee = $student->courseStudent;
        // return $student_fee;
        $fees = CourseLevelMode::where('attendance_id', $student_fee->student_type)
            ->where('course_id', $student_fee->course_id)
            ->where('level_id', $student_fee->studentCourse->level)
            ->first();

        if ($fees == null){

            return redirect()->back()->with('error', 'Oops! Course fee structure not found. Please contact the registrar');
        }else {


            $proformaInvoice = 0;

            //return $fees;

            foreach ($fees->invoiceProforma as $votehead) {

                $proformaInvoice += $votehead->semesterI;
            }

            $academic = Carbon::parse($student->courseStudent->courseEntry->year_start)->format('Y') . '/' . Carbon::parse($student->courseStudent->courseEntry->year_end)->format('Y');
            $period = Carbon::parse($student->courseStudent->coursesIntake->intake_from)->format('M') . '/' . Carbon::parse($student->courseStudent->coursesIntake->intake_to)->format('M');


            $signed = new Nominalroll;
            $signed->student_id = $student->id;
            $signed->reg_number = $student->reg_number;
            $signed->class_code = $student->courseStudent->class_code;
            $signed->year_study = 1;
            $signed->semester_study = 1;
            $signed->academic_year = $academic;
            $signed->academic_semester = strtoupper($period);
            $signed->pattern_id = 1;
            $signed->registration = 1;
            $signed->activation = 1;
            $signed->save();

            $invoice = new StudentInvoice;
            $invoice->student_id = $student->id;
            $invoice->reg_number = $student->reg_number;
            $invoice->invoice_number = 'INV' . time();
            $invoice->stage = '1.1';
            $invoice->amount = $proformaInvoice;
            $invoice->description = 'New Student Registration Invoice for 1.1 ' . 'Academic Year ' . $academic;
            $invoice->save();


            return redirect()->back()->with('success', 'Student admitted and invoiced successfully');
        }

    }


    public function downstream(){
        $callbackResponse = file_get_contents('./js/oneui.app.json');
        print_r(json_encode(['nut' => json_decode($callbackResponse), 'imgs' => [ asset('Images/success-tick.gif'), asset('Images/error-tick.jpg'), asset('Images/question.gif') ], 'route' => [ route('department.addAvailableCourses') ] ]));
    }

    public function classPattern($id){

        $hashedId = Crypt::decrypt($id);

        $class = Classes::find($hashedId);

        $seasons = Pattern::all();

        $patterns = ClassPattern::where('class_code', $class->name)->latest()->get();

        return view('cod::classes.classPattern')->with(['class' => $class, 'patterns' => $patterns, 'seasons' => $seasons]);

    }

    public function storeClassPattern(Request $request){

        $request->validate([
            'code' => 'required',
            'stage' => 'required',
            'period' => 'required',
            'semester' => 'required',
            'year' => 'required'
        ]);

        $semester = Pattern::find($request->semester);

        $pattern = new ClassPattern;
        $pattern->class_code = $request->code;
        $pattern->stage = $request->stage;
        $pattern->period = $request->period;
        $pattern->academic_year = $request->year;
        $pattern->pattern_id = $request->semester;
        $pattern->semester = $request->stage.'.'.$semester->season_code;
        $pattern->save();

        return redirect()->back()->with('success', 'Class pattern record created successfully');

    }

    public function updateClassPattern(Request $request, $id){

        $request->validate([
            'code' => 'required',
            'stage' => 'required',
            'period' => 'required',
            'semester' => 'required',
            'year' => 'required'
        ]);

        $semester = Pattern::find($request->semester);

        $hashedId = Crypt::decrypt($id);


        $pattern = ClassPattern::find($hashedId);
        $pattern->class_code = $request->code;
        $pattern->stage = $request->stage;
        $pattern->period = $request->period;
        $pattern->academic_year = $request->year;
        $pattern->start_date = $request->start_date;
        $pattern->end_date = $request->end_date;
        $pattern->pattern_id = $request->semester;
        $pattern->semester = $request->stage.'.'.$semester->season_code;
        $pattern->save();

        return redirect()->back()->with('success', 'Class pattern record updated successfully');

    }

    public function deleteClassPattern($id){

        $hashedId = Crypt::decrypt($id);

        ClassPattern::find($hashedId)->delete();

        return redirect()->back()->with('success', 'Class pattern record deleted successfully');

    }

    public function examResults(){

        $exams = ExamResults::latest()->get();

        return view('cod::exams.index')->with(['exams' => $exams]);
    }

    public function addResults(){

        $students = Student::latest()->get();

        return view('cod::exams.addExam')->with(['students' => $students]);
    }

    public function submitResults(Request $request){
        $request->validate([
            'student' => 'required',
            'stage' => 'required',
            'status' => 'required'
        ]);

        $student = Student::find($request->student);

        $exam = new ExamResults;
        $exam->student_id = $student->id;
        $exam->reg_number = $student->reg_number;
        $exam->stage = $request->stage;
        $exam->status = $request->status;
        $exam->save();

        return redirect()->route('department.examResults')->with('success', 'Exam result submitted successfully');

    }

    public function editResults($id){

        $hashedId = Crypt::decrypt($id);

        $result = ExamResults::find($hashedId);

        return view('cod::exams.editExam')->with(['result' => $result]);
    }

    public function updateResults(Request $request, $id){

        $request->validate([
            'student' => 'required',
            'stage' => 'required',
            'status' => 'required'
        ]);

        $hashedId = Crypt::decrypt($id);

        $students = Student::find($request->student);

        $exam = ExamResults::find($hashedId);
        $exam->student_id = $request->student;
        $exam->reg_number = $students->reg_number;
        $exam->stage = $request->stage;
        $exam->status = $request->status;
        $exam->save();

        return redirect()->route('department.examResults')->with('success', 'Exam result updated successfully');

    }

    public function transferRequests(){

        $transfers = CourseTransfer::where('department_id', auth()->guard('user')->user()->employmentDepartment->first()->id)
            ->latest()
            ->get()
            ->groupBy('academic_year');

        return view('cod::transfers.index')->with(['transfers' => $transfers]);

    }

    public function viewYearRequests($year){

        $hashedYear = Crypt::decrypt($year);

        $transfers = CourseTransfer::where('department_id', auth()->guard('user')->user()->employmentDepartment->first()->id)
            ->where('academic_year', $hashedYear)
            ->latest()
            ->get();

        return view('cod::transfers.annualTransfers')->with(['transfers' => $transfers, 'year' => $hashedYear]);


    }

    public function viewTransferRequest($id){

        $hashedId = Crypt::decrypt($id);

        $transfer = CourseTransfer::find($hashedId);

        return view('cod::transfers.viewRequest')->with(['transfer' => $transfer]);

    }

    public function viewUploadedDocument($id){

        $hashedId = Crypt::decrypt($id);

        $course = CourseTransfer::find($hashedId);

        $document = Application::where('reg_number', $course->studentTransfer->reg_number)->first();

        return response()->file('Admissions/Certificates/'.$document->admissionDoc->certificates);

    }

    public function acceptTransferRequest($id){

        $hashedId = Crypt::decrypt($id);
        $year = CourseTransfer::find($hashedId)->academic_year;
        $class = CourseTransfer::find($hashedId)->classTransfer->name;

        if (CourseTransferApproval::where('course_transfer_id', $hashedId)->exists()){

            $approval = CourseTransferApproval::where('course_transfer_id', $hashedId)->first();
            $approval->cod_status = 1;
            $approval->cod_remarks = 'Student to be admitted to '.$class.' class.';
            $approval->save();

        }else{

            $approval = new CourseTransferApproval;
            $approval->course_transfer_id = $hashedId;
            $approval->cod_status = 1;
            $approval->cod_remarks = 'Student to be admitted to '.$class.' class.';
            $approval->save();
        }

        return redirect()->route('department.viewYearRequests', ['year' => Crypt::encrypt($year)])->with('success', 'Course transfer request accepted');

    }

    public function declineTransferRequest(Request $request, $id){

        $hashedId = decrypt($id);

        $year = CourseTransfer::find($hashedId)->academic_year;

        if (CourseTransferApproval::where('course_transfer_id', $hashedId)->exists()){

            $approval = CourseTransferApproval::where('course_transfer_id', $hashedId)->first();
            $approval->cod_status = 2;
            $approval->cod_remarks = $request->remarks;
            $approval->save();

        }else{

            $approval = new CourseTransferApproval;
            $approval->course_transfer_id = $hashedId;
            $approval->cod_status = 2;
            $approval->cod_remarks = $request->remarks;
            $approval->save();

        }

        return redirect()->route('department.viewYearRequests', ['year' => Crypt::encrypt($year)])->with('success', 'Course transfer request accepted');
    }

    public function requestedTransfers($year){

        $hashedYear = Crypt::decrypt($year);

        $user = Auth::guard('user')->user();

        $by = $user->name;
        $dept = $user->getDept->dept_code;
        $role = $user->userRoles->name;

        $transfers = CourseTransfer::where('department_id', auth()->guard('user')->user()->employmentDepartment->first()->id)
            // ->where('status', '<', 1)
            ->where('academic_year', $hashedYear)
            ->latest()
            ->get()
            ->groupBy('course_id');

        $school = Auth::guard('user')->user()->getDept->name;

        $courses = Courses::all();

        $domPdfPath = base_path('vendor/dompdf/dompdf');
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $center = ['bold' => true];

        $table = new Table(array('unit' => TblWidth::TWIP));
        foreach ($transfers as $course => $transfer) {
            foreach ($courses as $listed){
                if ($listed->id == $course){
                    $courseName =  $listed->course_name;
                    $courseCode = $listed->course_code;
                }
            }

            $headers = ['bold' => true, 'space' => ['before' => 2000, 'after' => 2000, 'rule' => 'exact']];

            $table->addRow(600);
            $table->addCell(5000, [ 'gridSpan' => 9, ])->addText($courseName.' '.'('.$courseCode.')', $headers, ['spaceAfter' => 300,'spaceBefore' => 300]);
            $table->addRow();
            $table->addCell(400, ['borderSize' => 1])->addText('#');
            $table->addCell(2700, ['borderSize' => 1])->addText('Student Name/ Reg. Number', $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 11, 'bold' => true]);
            $table->addCell(1900, ['borderSize' => 1])->addText('Programme/ Course Admitted', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
            $table->addCell(1900, ['borderSize' => 1])->addText('Programme/ Course Transferring', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
            $table->addCell(1750, ['borderSize' => 1])->addText('Programme/ Course Cut-off Points', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
            $table->addCell(1000, ['borderSize' => 1])->addText('Student Cut-off Points', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
            $table->addCell(2600, ['borderSize' => 1])->addText('COD Remarks', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
            $table->addCell(1500, ['borderSize' => 1])->addText('Dean Remarks',  $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
            $table->addCell(1750, ['borderSize' => 1])->addText('Deans Committee Remarks', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);

            foreach ($transfer as $key => $list) {
                $name = $list->studentTransfer->reg_number."<w:br/>\n".$list->studentTransfer->sname.' '.$list->studentTransfer->fname.' '.$list->studentTransfer->mname;
                if ($list->approveTransfer == null){
                    $remarks = 'Missed Deadline';
                }else{
                    $remarks = $list->approvedTransfer->cod_remarks;
                }
                $table->addRow();
                $table->addCell(400, ['borderSize' => 1])->addText(++$key);
                $table->addCell(2700, ['borderSize' => 1])->addText($name);
                $table->addCell(1900, ['borderSize' => 1])->addText($list->studentTransfer->courseStudent->studentCourse->course_code);
                $table->addCell(1900, ['borderSize' => 1])->addText($list->courseTransfer->course_code);
                $table->addCell(1750, ['borderSize' => 1])->addText($list->class_points);
                $table->addCell(1000, ['borderSize' => 1])->addText($list->student_points);
                $table->addCell(2600, ['borderSize' => 1])->addText($remarks);
                $table->addCell(1500, ['borderSize' => 1])->addText();
                $table->addCell(1750, ['borderSize' => 1])->addText();

            }
        }

        $summary = new Table(array('unit' => TblWidth::TWIP));
        $total = 0;
        foreach ($transfers as $group => $transfer){
            foreach ($courses as $listed){
                if ($listed->id == $group){
                    $courseName =  $listed->course_name;
                    $courseCode = $listed->course_code;
                }
            }

            $summary->addRow();
            $summary->addCell(5000, ['borderSize' => 1])->addText($courseName, ['bold' => true]);
            $summary->addCell(1250, ['borderSize' => 1])->addText($courseCode, ['bold' => true]);
            $summary->addCell(1250, ['borderSize' => 1])->addText($transfer->count());

            $total += $transfer->count();

        }

        $summary->addRow();
        $summary->addCell(6250, ['borderSize' => 1])->addText('Totals', ['bold' => true]);
        $summary->addCell(1250, ['borderSize' => 1])->addText($transfers->count(), ['bold' => true]);
        $summary->addCell(1250, ['borderSize' => 1])->addText($total, ['bold' => true]);

        $my_template = new TemplateProcessor(storage_path('course_transfers.docx'));

        $my_template->setValue('school', $school);
        $my_template->setValue('by', $by);
        $my_template->setValue('dept', $dept);
        $my_template->setValue('role', $role);
        $my_template->setComplexBlock('{table}', $table);
        $my_template->setComplexBlock('{summary}', $summary);
        $docPath = 'Fees/'.'Transfers'.time().".docx";
        $my_template->saveAs($docPath);

        $contents = \PhpOffice\PhpWord\IOFactory::load($docPath);

        $pdfPath = 'Fees/'.'Transfers'.time().".pdf";

        $converter =  new OfficeConverter($docPath, 'Fees/');
        $converter->convertTo('Transfers'.time().".pdf");

                    if(file_exists($docPath)){
                        unlink($docPath);
                    }
//
//        return response()->download($docPath)->deleteFileAfterSend(true);
        return response()->download($pdfPath)->deleteFileAfterSend(true);
    }


    public function academicLeave(){

        $requests = AcademicLeave::latest()
                                    ->get()
                                    ->groupBy('academic_year');

        return view('cod::leaves.index')->with(['leaves' => $requests]);
    }

    public function yearlyAcademicLeave($year){

        $hashedYear = Crypt::decrypt($year);

        $deptID = auth()->guard('user')->user()->employmentDepartment->first()->id;

      $requests = AcademicLeave::where('academic_year', $hashedYear)
            ->latest()
            ->get();

        $allLeaves = [];

        foreach ($requests as $leave){

            // return $leave->studentLeave->courseStudent->department_id;
            if ($leave->studentLeave->courseStudent->department_id == $deptID) {
                $allLeaves[] = $leave;

            }
        }

        return view('cod::leaves.annualLeaves')->with(['leaves' => $allLeaves, 'year' => $hashedYear]);

    }

    public function viewLeaveRequest($id){

        $hashedId = Crypt::decrypt($id);

        $leave = AcademicLeave::find($hashedId);

        $student = Student::find($leave->student_id);

        $currentStage = Nominalroll::where('student_id', $leave->student_id)
                ->latest()
                ->first();

        return view('cod::leaves.viewLeaveRequest')->with(['leave' => $leave, 'current' => $currentStage, 'student' => $student]);

    }

    public function acceptLeaveRequest($id){

       $hashedId = Crypt::decrypt($id);

      $leave = AcademicLeave::find($hashedId);

        if (AcademicLeaveApproval::where('academic_leave_id', $hashedId)->exists()){

            $updateApproval = AcademicLeaveApproval::where('academic_leave_id', $hashedId)->first();
            $updateApproval->cod_status = 1;
            $updateApproval->cod_remarks = 'Request Accepted';
            $updateApproval->save();

        }else{

            $newApproval = new AcademicLeaveApproval;
            $newApproval->academic_leave_id = $hashedId;
            $newApproval->cod_status = 1;
            $newApproval->cod_remarks = 'Request Accepted';
            $newApproval->save();

        }

        return redirect()->route('department.yearlyLeaves', ['year' => Crypt::encrypt($leave->academic_year)])->with('success', 'Deferment/Academic leave approved');

    }

    public function declineLeaveRequest(Request $request, $id){

        $hashedId = Crypt::decrypt($id);

        $leave = AcademicLeave::find($hashedId);

        if (AcademicLeaveApproval::where('academic_leave_id', $hashedId)->exists()){

            $updateApproval = AcademicLeaveApproval::where('academic_leave_id', $hashedId)->first();
            $updateApproval->cod_status = 2;
            $updateApproval->cod_remarks = $request->remarks;
            $updateApproval->save();

        }else{

            $newApproval = new AcademicLeaveApproval;
            $newApproval->academic_leave_id = $hashedId;
            $newApproval->cod_status = 2;
            $newApproval->cod_remarks = $request->remarks;
            $newApproval->save();

        }

        return redirect()->route('department.yearlyLeaves', ['year' => Crypt::encrypt($leave->academic_year)])->with('success', 'Deferment/Academic leave declined.');

    }

    public function readmissions(){

        $readmissions = Readmission::latest()->get()->groupBy('academic_year');

        return view('cod::readmissions.index')->with(['readmissions' => $readmissions]);
    }

    public function yearlyReadmissions($year){

       $hashedYear = Crypt::decrypt($year);

       $admissions = Readmission::where('academic_year', $hashedYear)->latest()->get()->groupBy('academic_semester');

       return view('cod::readmissions.yearlyReadmissions')->with(['admissions' => $admissions, 'year' => $hashedYear]);

    }

    public function intakeReadmissions($intake, $year){

        $hashedIntake = Crypt::decrypt($intake);
        $hashedYear = Crypt::decrypt($year);

        $readmissions = Readmission::where('academic_year', $hashedYear)
                        ->where('academic_semester', $hashedIntake)
                        ->get();

        $leaves = [];

            foreach ($readmissions as $readmission){

               if ($readmission->leaves->studentLeave->courseStudent->department_id == auth()->guard('user')->user()->employmentDepartment->first()->id){

                   $leaves[] = $readmission;

               }
            }

            return view('cod::readmissions.intakeReadmissions')->with(['admissions' => $leaves]);
    }

    public function selectedReadmission($id){

        $hashedId = Crypt::decrypt($id);
        // $classes = [];

        $leave = Readmission::find($hashedId);

        $stage = Nominalroll::where('student_id', $leave->leaves->studentLeave->id)
                                // ->where('activation', 0)
                                ->latest()
                                ->first();
       $studentStage = $stage->year_study.'.'.$stage->semester_study;

       $patterns = ClassPattern::where('academic_year', '>', $stage->academic_year)
                                ->where('period', $stage->academic_semester)
                                ->where('semester', $studentStage)
                                ->get()
                                ->groupBy('class_code');

        if(count($patterns) == 0){

            $classes = [];

        }else{

            foreach ($patterns as $class_code => $pattern) {

                $classes[] = Classes::where('name', $class_code)
                    ->where('course_id', $leave->leaves->studentLeave->courseStudent->course_id)
                    ->where('attendance_code', $leave->leaves->studentLeave->courseStudent->typeStudent->attendance_code)
                    ->where('name', '!=', $leave->leaves->studentLeave->courseStudent->class_code)
                    ->get()
                    ->groupBy('name');
            }
        }

        return view('cod::readmissions.viewSelectedReadmission')->with(['classes' => $classes, 'leave' => $leave, 'stage' => $stage]);

    }

    public function acceptReadmission(Request $request, $id){

        $request->validate([
            'class' => 'required'
        ]);

        $hashedId = Crypt::decrypt($id);

        $route = Readmission::find($hashedId);

        if (ReadmissionApproval::where('readmission_id', $hashedId)->exists()){

            $placement = new ReadmissionClass;
            $placement->readmission_id = $hashedId;
            $placement->class_code = $request->class;
            $placement->save();


            $readmission = ReadmissionApproval::where('readmission_id', $hashedId)->first();
            $readmission->cod_status = 1;
            $readmission->cod_remarks = 'Admit student to ' . $request->class . ' class.';
            $readmission->save();


        }else {

            $placement = new ReadmissionClass;
            $placement->readmission_id = $hashedId;
            $placement->class_code = $request->class;
            $placement->save();

            $readmission = new ReadmissionApproval;
            $readmission->readmission_id = $hashedId;
            $readmission->cod_status = 1;
            $readmission->cod_remarks = 'Admit student to ' . $request->class . ' class.';
            $readmission->save();
        }

        return redirect()->route('department.intakeReadmissions', ['intake' => Crypt::encrypt($route->academic_semester), 'year' => Crypt::encrypt($route->academic_year)])->with('success', 'Readmission request accepted');

    }

    public function declineReadmission(Request $request, $id){

        $request->validate([
            'remarks' => 'required'
        ]);

        $hashedId = Crypt::decrypt($id);

        $route = Readmission::find($hashedId);

        if (ReadmissionApproval::where('readmission_id', $hashedId)->exists()){

            ReadmissionClass::where('readmission_id', $hashedId)->delete();

            $readmission = ReadmissionApproval::where('readmission_id', $hashedId)->first();
            $readmission->cod_status = 2;
            $readmission->cod_remarks = $request->remarks;
            $readmission->save();


        }else {

            $readmission = new ReadmissionApproval;
            $readmission->readmission_id = $hashedId;
            $readmission->cod_status = 2;
            $readmission->cod_remarks = $request->remarks;
            $readmission->save();
        }

        return redirect()->route('department.intakeReadmissions', ['intake' => Crypt::encrypt($route->academic_semester), 'year' => Crypt::encrypt($route->academic_year)])->with('success', 'Readmission request declined');

    }

    public function departmentLectures(){

        $dept = auth()->guard('user')->user()->employmentDepartment->first()->id;

        $users = User::all();

        foreach ($users as $user){

            if ($user->employmentDepartment->first()->id == $dept){

                $lectures [] = $user;
            }
        }

        return view('cod::lecturers.index')->with(['lecturers' => $lectures]);
    }

    public function lecturesQualification (){

        $dept = auth()->guard('user')->user()->employmentDepartment->first()->id;

        $users = User::all();

        foreach ($users as $user){
// return $user->employmentDepartment->first();
            if ($user->employmentDepartment->first()->id == $dept){

                $lectures [] = $user;
            }
        }

        return view('cod::lecturers.departmentalLecturers')->with(['lecturers' => $lectures]);
    }

    public function viewLecturerQualification($id){

       $hashedId = Crypt::decrypt($id);

        $user = User::find($hashedId);

        return view('cod::lecturers.lecturerQualification')->with(['user' => $user]);

    }

    public function approveQualification ($id){

        $hashedId = Crypt::decrypt($id);

        $qualification = LecturerQualification::findorFail($hashedId);
        $qualification->status = 1;
        $qualification->save();

        return redirect()->back()->with('success', 'Lecturer qualification verified successfully');
    }

    public function rejectQualification(Request $request, $id)
    {
        $hashedId = Crypt::decrypt($id);

        $qualification = LecturerQualification::findorFail($hashedId);
        $qualification->status = 2;
        $qualification->save();

        $remark = new QualificationRemarks;
        $remark->qualification_id = $hashedId;
        $remark->remarks = $request->reason;
        $remark->save();

        return redirect()->back()->with('success', 'Lecturer qualification declined successfully');
    }

    public function viewLecturerTeachingArea($id){

        $hashedId = Crypt::decrypt($id);

        $user = User::find($hashedId);

        return view('cod::lecturers.teachingAreas')->with(['user' => $user]);

    }

    public function approveTeachingArea ($id){

        $hashedId = Crypt::decrypt($id);

        $qualification = TeachingArea::findorFail($hashedId);
        $qualification->status = 1;
        $qualification->save();

        return redirect()->back()->with('success', 'Lecturer qualification verified successfully');
    }

    public function declineTeachingArea (Request $request, $id)
    {
        $hashedId = Crypt::decrypt($id);

        $qualification = TeachingArea::findorFail($hashedId);
        $qualification->status = 2;
        $qualification->save();

        $remark = new TeachingAreaRemarks;
        $remark->teaching_id = $hashedId;
        $remark->remarks = $request->reason;
        $remark->save();

        return redirect()->back()->with('success', 'Lecturer qualification declined successfully');
    }

}
