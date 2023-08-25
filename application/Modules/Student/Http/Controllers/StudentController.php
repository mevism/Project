<?php

namespace Modules\Student\Http\Controllers;
use App\Http\Apis\AppApis;
use App\Service\CustomIds;
use BaconQrCode\Encoder\QrCode;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\COD\Entities\AcademicLeavesView;
use Modules\COD\Entities\ClassPattern;
use Modules\COD\Entities\CourseSyllabus;
use Modules\COD\Entities\Nominalroll;
use Modules\COD\Entities\ReadmissionsView;
use Modules\COD\Entities\SemesterUnit;
use Modules\Examination\Entities\Exam;
use Modules\Examination\Entities\ExamMarks;
use Modules\Examination\Entities\ModeratedResults;
use Modules\Finance\Entities\StudentInvoice;
use Modules\Registrar\Entities\CalenderOfEvents;
use Modules\Registrar\Entities\Classes;
use Modules\Registrar\Entities\ClusterWeights;
use Modules\Registrar\Entities\CourseLevelMode;
use Modules\Registrar\Entities\Courses;
use Modules\Registrar\Entities\Department;
use Modules\Registrar\Entities\Division;
use Modules\Registrar\Entities\Intake;
use Modules\Registrar\Entities\SemesterFee;
use Modules\Registrar\Entities\UnitProgramms;
use Modules\Student\Entities\AcademicLeave;
use Modules\Student\Entities\AcademicLeaveApproval;
use Modules\Student\Entities\CourseTransfer;
use Modules\Student\Entities\CourseTransfersView;
use Modules\Student\Entities\DeferredClass;
use Modules\Student\Entities\ExamResults;
use Modules\Student\Entities\OldStudentCourse;
use Modules\Student\Entities\Readmission;
use Modules\Student\Entities\StudentCourse;
use Modules\Student\Entities\STUDENTCOURSEVIEW;
use Modules\Student\Entities\StudentView;
use NcJoes\OfficeConverter\OfficeConverter;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use PhpOffice\PhpWord\TemplateProcessor;
use Str;
use SimpleSoftwareIO\QrCode\Facade;

class StudentController extends Controller
{
    public $appApi;
    public function __construct(AppApis $appApi){
        $this->appApi  =  $appApi;
    }
    public function index() {
        $courses = STUDENTCOURSEVIEW::where('student_id', auth()->guard('student')->user()->student_id)->get();
        return view('student::student.index')->with(['courses' => $courses]);
    }

    public function myCourse(){
        $course = STUDENTCOURSEVIEW::where('student_id', auth()->guard('student')->user()->student_id)->first();
        $reg = Nominalroll::where('student_id', auth()->guard('student')->user()->student_id)
            ->where('class_code', $course->current_class)
            ->where('registration', 1)
            ->where('activation', 1)
            ->latest()->first();
        $others = OldStudentCourse::where('student_id', auth()->guard('student')->user()->student_id)->get();

        return view('student::courses.index')->with(['course' => $course, 'reg' => $reg, 'others' => $others]);
    }

    public function myProfile(){
        $user = \auth()->guard('student')->user();
        return view('student::student.profile')->with('user', $user);
    }

    public function courseTransfers(){
        $transfers = CourseTransfersView::where('student_id', \auth()->guard('student')->user()->student_id)->get();
        return view('student::courses.transfers')->with(['transfers' => $transfers]);
    }

    public function requestTransfer(){
        $division = Division::where('name', 'ACADEMIC DIVISION')->first()->division_id;
        $departments = Department::where('division_id', $division)->latest()->get();
        $stage = Nominalroll::where('student_id', auth()->guard('student')->user()->student_id)->latest()->first();
        $registration = \auth()->guard('student')->user()->StudentsNominalRoll;
//        $current = Carbon::now()->format('Y-m-d');
        $current = '2023-09-23';
        $event = [];
        $academicYear = 'null';
        $student = StudentView::where('student_id', \auth()->guard('student')->user()->student_id)->first();

       $sem_date = Intake::where('intake_from', '<=', $current)->where('intake_to', '>=', $current)->first();
        if ($sem_date != null){
            $academicYear =  Carbon::parse($sem_date->academicYear->year_start)->format('Y').'/'.Carbon::parse($sem_date->academicYear->year_end)->format('Y');
            $semester = Carbon::parse($sem_date->intake_from)->format('M').'/'.Carbon::parse($sem_date->intake_to)->format('M');
          $event = CalenderOfEvents::where('intake_id', $sem_date->intake_id)->where('event_id', 5)->first();
        }
        return view('student::courses.coursetransfer')->with(['departments' => $departments, 'stage' => $stage, 'event' => $event, 'academic_year' => $academicYear, 'intake' => $sem_date->intake_id, 'registration' => $registration, 'student' => $student]);
    }

    public function getDeptCourses(Request $request){
        $data = Courses::where('department_id', $request->id)->where('level_id', auth()->guard('student')->user()->enrolledCourse->StudentsCourse->level_id)->latest()->get();
        return response()->json($data);
    }

    public function getCourseClasses(Request $request){
        $group = Courses::where('course_id', $request->id)->first();
        if ($group->level_id == 2){
            $classes = Classes::where('course_id', $request->id)
                ->where('attendance_id', 'J-FT')
                ->select('class_id','name')
                ->latest()
                ->first();
           $cluster = [$classes->class_id, $classes->name, $group->courseRequirements->subject1, $group->courseRequirements->subject2, $group->courseRequirements->subject3, $group->courseRequirements->subject4, $group->courseRequirements->course_requirements, $group->level_id];
            return response()->json($cluster);
        }else{
            $points = ClusterWeights::where('applicant_id', \auth()->guard('student')->user()->enrolledCourse->StudentApplication->applicant_id)->first();
            $classes = DB::table('coursetransferclasses')->where('course_id', $request->id)
                ->where('attendance_id', 'J-FT')
                ->select('class_id','name', 'points')
                ->latest()
                ->first();
            $cluster = [$classes->class_id, $classes->name, $points[$group->CourseClusters->cluster], $classes->points];
        }

        return response()->json($cluster);
    }

    public function submitRequest(Request $request){
        $request->validate([
            'dept' => 'required',
            'course' => 'required',
            'class' => 'required',
        ]);

        if (auth()->guard('student')->user()->enrolledCourse->course_id == $request->course){
            return redirect()->back()->with('info', 'You are already admitted to this course');
        }else{
            if (CourseTransfer::where('class_id', $request->class)->where('student_id', auth()->guard('student')->user()->student_id)->first()){
                return redirect()->route('student.coursetransfers')->with('warning', 'You have already requested course transfer for this course');
            }else{
                $transferID = new CustomIds();
                $transfer = new CourseTransfer;
                $transfer->course_transfer_id = $transferID->generateId();
                $transfer->student_id = auth()->guard('student')->user()->student_id;
                $transfer->class_id = $request->class;
                if ($request->mingrade == null){
                    $transfer->class_points = $request->points;
                    $transfer->student_points = $request->mypoints;
                }else{
                    $transfer->class_points = $request->mingrade;
                    $transfer->student_points = $request->mygrade;
                }
                $transfer->save();

                $particular [] = [
                    'votehead_id' => 'IT689',
                    'votehead_name' => 'Change of Course',
                    'quantity'  => '1',
                    'unit_price' => 500
                ];

                $invoice = [
                    'batch_description' => 'New Student Inter/Intra Faculty Course Transfer Fee',
                    'Invoices' => [
                        ['student_number' => \auth()->guard('student')->user()->enrolledCourse->student_number,
                            'invoice_description' => "New Student Inter/Intra Faculty Course Transfer Fee",
                            'InvoiceItems' => $particular,
                        ]
                    ]
                ];

                $this->appApi->invoiceStudent($invoice);
                return redirect()->route('student.coursetransfers')->with('success', 'Course transfer request created successfully');
            }
        }

    }

    public function editRequest($id){

        $hashedId = Crypt::decrypt($id);

        $transfer = CourseTransfer::find($hashedId);

        $departments = Department::all();

        return view('student::courses.edittransfer')->with(['transfer' => $transfer, 'departments' => $departments]);

    }

    public function updateRequest(Request $request, $id){

        $request->validate([
            'dept' => 'required',
            'course' => 'required',
            'class' => 'required',
            'points' => 'required|numeric'
        ]);

        if (\auth()->guard('student')->user()->loggedStudent->courseStudent->course_id == $request->course) {

            return redirect()->route('student.coursetransfers')->with('error', 'You are already admitted to this course');

        } else {

            $hashedId = Crypt::decrypt($id);

            $transfer = CourseTransfer::find($hashedId);
            $transfer->student_id = \auth()->guard('student')->user()->student_id;
            $transfer->department_id = $request->dept;
            $transfer->course_id = $request->course;
            $transfer->class_id = $request->class;
            $transfer->points = $request->points;
            $transfer->save();

            return redirect()->route('student.coursetransfers')->with('success', 'Course transfer request updated successfully');
        }
    }

    public function deleteRequest($id){

        $hashedId = Crypt::decrypt($id);

        CourseTransfer::find($hashedId)->delete();

        return redirect()->route('student.coursetransfers')->with('success', 'Course transfer request deleted successfully');
    }

    public function academicLeave(){
        $leaves = AcademicLeavesView::where('student_id', \auth()->guard('student')->user()->student_id)->get();
        return view('student::academic.academicleave')->with(['leaves' => $leaves]);
    }

    public function requestLeave(){
       $student = StudentView::where('student_id', \auth()->guard('student')->user()->student_id)->first();
       $stage = Nominalroll::where('student_id', $student->student_id)->latest()->first();
//       $current_date = Carbon::now()->format('Y-m-d');
       $current_date = '2024-01-05';
       $dates = Intake::where('intake_from', '<=', $current_date)->where('intake_to', '>=', $current_date)->first();
       $intake =  DB::table('academicperiods')->where('intake_id', $dates->intake_id)->first();
       $event = CalenderOfEvents::where('intake_id', $intake->intake_id)->where('event_id', 4)->first();
       $currentStage = $stage->year_study.'.'.$stage->semester_study;
       $pattern = ClassPattern::where('class_code', $stage->class_code)->get();
            foreach ($pattern as $classPattern){
                $list[] = $classPattern->semester;
            }

            $id_collection = collect($list);
            $this_key = $id_collection->search($currentStage);
            $next_id = $id_collection->get($this_key);

            if ( (float)$currentStage > (float)'1.2'){
                $currently = $stage->year_study.'.'.$stage->semester_study;
                $classPattern =  ClassPattern::where('semester', '<',  $currently)
                    ->get()
                    ->groupBy('class_code');
            }

            $student = StudentView::where('student_id', \auth()->guard('student')->user()->student_id)->first();

            if ($student->student_type == 2){
                $mode = 'J-FT';
            }elseif ($student->student_type == 1){
                $mode = 'S-FT';
            }elseif ($student->student_type == 3){
                $mode = 'S-PT';
            }else{
                $mode = 'S-EV';
            }

            foreach ($classPattern as $pattern){
                $classes = Classes::where('course_id', $student->course_id)
                    ->where('name', '!=', $student->current_class)
                    ->where('attendance_id', $mode)
                    ->latest()
                    ->get()
                    ->groupBy('name');
            }

        return view('student::academic.requestleave')->with(['student' => $student, 'stage' => $stage, 'event' => $event, 'dates' => $current_date, 'list' => $list, 'classes' => $classes, 'intake' => $dates]);

    }

    public function leaveClasses(Request $request){
        $data = ClassPattern::where('class_code', $request->class_code)
                            ->where('semester', $request->stage)
                            ->first();
        return response()->json($data);
    }

    public function defermentRequest(Request $request){
        $deferment = Nominalroll::where('student_id', $request->studNumber)->first();
        $period = DB::table('academicperiods')->where('intake_id', $deferment->intake_id)->first();
        $combinedData = [
            'deferment' => $deferment,
            'period' => $period
        ];
        return response()->json($combinedData);
    }

    public function submitLeaveRequest(Request $request){
        $request->validate([
            'type' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'reason' => 'required|string'
        ]);

       $currentStage = Nominalroll::where('student_id', auth()->guard('student')->user()->student_id)->latest()->first();
        if (AcademicLeave::where('student_id', $currentStage->student_id)->where('type', $request->type)->where('year_study', $currentStage->year_study)->where('semester_study', $currentStage->semester_study)->exists()){
            return redirect()->back()->with('info', 'You have already requested leave for this stage');
        }else {

            $leaveId = new CustomIds();
            $leave = new AcademicLeave;
            $leave->student_id = auth()->guard('student')->user()->student_id;
            $leave->leave_id = $leaveId->generateId();
            $leave->type = $request->type;
            $leave->current_class = $request->current_class;
            $leave->year_study = explode('.', $request->newStage)[0];
            $leave->semester_study = explode('.', $request->newStage)[1];
            $leave->academic_year = $request->newAcademic;
            $leave->academic_semester = $request->newSemester;
            $leave->from = $request->start_date;
            $leave->to = $request->end_date;
            $leave->reason = $request->reason;
            $leave->defer_class = $request->newClass;
            $leave->save();

            return redirect()->route('student.requestacademicleave')->with('success', 'Leave request created successfully');
        }
    }

    public function deleteLeaveRequest($id){
        AcademicLeave::where('leave_id', $id)->delete();
        DeferredClass::where('leave_id', $id)->delete();
        return redirect()->back()->with('success', 'Leave request deleted successfully');
    }

    public function requestReadmission(){
        $leaves = AcademicLeavesView::where('student_id', \auth()->guard('student')->user()->student_id)->pluck('leave_id');
        $readmit = ReadmissionsView::whereIn('leave_id', $leaves)->get();
        return view('student::academic.readmissions')->with(['readmits' => $readmit]);
    }

    public function readmissionRequests(){
      $student = StudentView::where('student_id', \auth()->guard('student')->user()->student_id)->first();
      $currentStage = Nominalroll::where('student_id', \auth()->guard('student')->user()->student_id)
                                    ->latest()
                                    ->first();
      $readmit = AcademicLeavesView::where('student_id', auth()->guard('student')->user()->student_id)
                        ->where('status', 1)
                        ->latest()
                        ->first();

//       $today = Carbon::now();
       $today = '2024-01-23';

      $intake = Intake::where('intake_from', '<=', $today)->where('intake_to', '>=', $today)->latest()->first();
      $semester = Carbon::parse($intake->intake_from)->format('M').'/'.Carbon::parse($intake->intake_to)->format('M');
      $academic_year = Carbon::parse($intake->academicYear->year_start)->format('Y').'/'. Carbon::parse($intake->academicYear->year_end)->format('Y');

      $dates = CalenderOfEvents::where('intake_id', $intake->intake_id)->where('event_id', 3)->first();

      return view('student::academic.readmissionrequests')->with(['admission' => $readmit, 'current' => $currentStage, 'dates' => $dates, 'student' => $student]);

    }

    public function storeReadmissionRequest($id){
//        $today = Carbon::now()->format('Y-m-d');
        $today = '2024-01-23';
        $intake = Intake::where('intake_from', '<=', $today)
                            ->where('intake_to', '>=', $today)
                            ->latest()
                            ->first();

       if (Readmission::where('leave_id', $id)->where('intake_id', $intake->intake_id)->exists()){
           return redirect()->back()->with('info', 'You have already requested for readmission');
       }else{

           $readmissionID = new CustomIds();
           $readmission = new Readmission;
           $readmission->readmission_id = $readmissionID->generateId();
           $readmission->leave_id = $id;
           $readmission->intake_id = $intake->intake_id;
           $readmission->save();
           return redirect()->route('student.requestreadmission')->with('success', 'Readmission request created successfully');
       }
    }

    public function unitRegistration(){
            $reg = Nominalroll::where('student_id', \auth()->guard('student')->user()->student_id)->latest()->get();
            return view('student::semester.index')->with(['reg' => $reg,]);
    }

    public function requestSemesterRegistration(){
        $student = StudentView::where('student_id', \auth()->guard('student')->user()->student_id)->first();
        $list = [];
        $reg = Nominalroll::where('student_id', \auth()->guard('student')->user()->student_id)
            ->where('registration', 1)
            ->where('activation', 1)
            ->latest()->first();
        $current = $reg->year_study.'.'.$reg->semester_study;
        $class_code = StudentCourse::where('student_id', auth()->guard('student')->user()->student_id)->first();
        $classes = ClassPattern::where('class_code', $class_code->current_class)->get();
        $course = $class_code->StudentsCourse;

        if ($reg == null){
            $options = [];
            $next = [];
            $list = [];
            $dates = [];
        }else{
            foreach ($classes as $class){
                $list[] = $class->semester;
            }
            sort($list);
            $id_collection = collect($list);
            $this_key = $id_collection->search($current);
            $next_id = $id_collection->get($this_key + 1);

            if ($next_id == null){
                $reg = Nominalroll::where('student_id', auth()->guard('student')->user()->student_id)
                    ->where('registration', 1)
                    ->where('activation', 1)
                    ->latest()->first();

                $options = [];

                $next = [];

                return view('student::semester.requestRegistration')
                    ->with([
                        'student' => $student,
                        'options' => $options,
                        'next' => $next,
                        'reg' => $reg,
                        'list' => $list,
                        'course' => $course
                    ]);

            }else{
                $new = explode('.', $next_id);
                 $class = Classes::where('name', $class_code->current_class)->first();

               $options = CourseSyllabus::where('course_code', $course->course_code)
                    ->where('version', $class->syllabus_name)
                    ->where('stage', $new[0])
                    ->where('semester', $new[1])
                    ->orderBy('unit_code', 'asc')
                    ->get()
                    ->groupBy('option');

               $next = ClassPattern::where('semester', $next_id)->where('class_code', $class_code->current_class)->first();
               $period = DB::table('academicperiods')->where('academic_year', $next->academic_year)->where('intake_month', $next->period)->first()->intake_id;
               $dates = CalenderOfEvents::where('intake_id', $period)
                    ->where('event_id', 1)
                    ->latest()
                    ->first();

                return view('student::semester.requestRegistration')
                    ->with([
                        'student' => $student,
                        'options' => $options,
                        'next' => $next,
                        'reg' => $reg,
                        'list' => $list,
                        'dates' => $dates,
                        'course' => $course
                    ]);
            }

        }
    }

    public function registerSemester(Request $request){
        $units = $request->unit_code;
        if ($request->optionId == null){
            return redirect()->back()->with('error', 'Ensure you have selected an option to proceed');
        }

        $intake = DB::table('academicperiods')->where('academic_year', $request->academicyear)->where('intake_month', $request->period)->first();

        if (Nominalroll::where('student_id', auth()->guard('student')->user()->student_id)
                    ->where('intake_id', $intake->intake_id)
                    ->where('year_study', $request->yearstudy)
                    ->where('semester_study', $request->semesterstudy)->exists()){
        return redirect()->back()->with('info', 'You have already registered for '.$request->semester.' stage.');
        }else {
            $student = StudentView::where('student_id', \auth()->guard('student')->user()->student_id)->first();
            $course = Courses::where('course_id', $student->course_id)->first();
            $class = Classes::where('name', $student->current_class)->first();
            $fees = SemesterFee::where('course_code', $course->course_code)
                ->where('version', $class->fee_version)
                ->where('attendance_id', $student->student_type)
                ->where('semester', $request->semester)
                ->get();

            $nominalID = new CustomIds();
            $signed = new Nominalroll;
            $signed->nominal_id = $nominalID->generateId();
            $signed->student_id = $student->student_id;
            $signed->class_code = $student->current_class;
            $signed->year_study = $request->yearstudy;
            $signed->semester_study = $request->semesterstudy;
            $signed->intake_id = $intake->intake_id;
            $signed->pattern_id = $request->pattern;
            $signed->registration = 1;
            $signed->save();

            foreach ($units as $unit){
                $wID = new CustomIds();
                $examinableUnit = new ExamMarks;
                $examinableUnit->exam_id = $wID->generateId();
                $examinableUnit->student_id = $student->student_id;
                $examinableUnit->class_code = $student->current_class;
                $examinableUnit->unit_code = $unit;
                $examinableUnit->intake_id = $intake->intake_id;
                $examinableUnit->stage = $request->yearstudy;
                $examinableUnit->semester = $request->semesterstudy;
                $examinableUnit->attempt = $request->yearstudy.'.'.$request->semesterstudy;
                $examinableUnit->save();
            }

        $naration = "Semester Invoice For Stage ".$request->yearstudy.".".$request->semesterstudy." Academic Year ".$intake->academic_year;

            foreach ($fees as $key => $fee){
                $particular [] = [
                    'votehead_id' => $fee->vote_id,
                    'votehead_name' => $fee->semVotehead->vote_name,
                    'quantity'  => '1',
                    'unit_price' => $fee->amount
                ];
            }

            $invoice = [
                'batch_description' => "SUBSEQUENT SEMESTER REGISTRATION",
                'Invoices' => [
                    ['student_number' => $student->student_number,
                        'invoice_description' => $naration,
                        'InvoiceItems' => $particular,
                    ]
                ]
            ];

            $this->appApi->invoiceStudent($invoice);
        }
        return redirect()->route('student.unitregistration')->with('success', 'You success registered for '.$request->semester);

    }

    public function viewSemesterUnits($id){
        $season = Nominalroll::where('nominal_id', $id)->first();
        $units = ExamMarks::where('student_id', \auth()->guard('student')->user()->student_id)
            ->where('stage', $season->year_study)
            ->where('semester', $season->semester_study)
            ->orderBy('unit_code', 'asc')
            ->get();

        return view('student::semester.semesterUnits')->with(['units' => $units]);
    }

    public function feesStatement(){
        $studentNumber = str_replace('/', '', \auth()->guard('student')->user()->enrolledCourse->student_number);
        $statement =  $this->appApi->StudentStatement($studentNumber);
        $data = collect($statement, true);
        $statements = $statement['dataPayload']['data']['Transactions'];

        return view('student::invoice.statement')->with(['statements' => $statements]);
    }

    public function printStatement(){
        $reg = Nominalroll::where('student_id', \auth()->guard('student')->user()->student_id)->where('registration', 1)->where('activation', 1)->latest()->first();
        $studentNumber = str_replace('/', '', \auth()->guard('student')->user()->enrolledCourse->student_number);
        $statement =  $this->appApi->StudentStatement($studentNumber);
        $data = collect($statement, true);
        $statements = $statement['dataPayload']['data']['Transactions'];
        $student = $statement['dataPayload']['data']['StudentDetails'];
        $summary = $statement['dataPayload']['data']['StatementSummary'];
        $course  = Courses::where('course_code', $student['course_code'])->first();

        $image = time().'.png';

        if ($reg == null){
            $stage = 'Not registered';

            \QrCode::size(200)
                ->format('png')
                ->generate( 'Name: '.$student['full_name']."\n".
                    'Registration: '.$student['student_number']. "\n".
                    'Class Code: '.$student['class_code']."\n".
                    'Current Stage: '.$stage."\n".
                    'Fee Balance:  '.$summary['fee_balances'], 'QrCodes/'.$image);

        }else{

            \QrCode::size(200)
                ->format('png')
                ->generate( 'Name: '.$student['full_name']."\n".
                    'Registration: '.$student['student_number']. "\n".
                    'Class Code: '.$student['class_code']."\n".
                    'Current Stage: '.'Year '.$reg->year_study.' Semester '.$reg->patternRoll->season."\n".
                    'Fee Balance:  '.$summary['fee_balances'], "QrCodes/".$image);
        }

        $domPdfPath = base_path('vendor/dompdf/dompdf');
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $table = new Table(array('unit' => TblWidth::TWIP));

        $table->addRow();
        $table->addCell(7600, ['borderSize' => 1, 'gridSpan' => 2])->addText('Student Name : '.strtoupper($student['full_name']), ['bold' => true, 'name' => 'Book Antiqua', 'size' => 9]);
        $table->addCell(4000, ['borderSize' => 1, 'gridSpan' => 3])->addText('Printed On : '.date('d-M-Y'), ['bold' => true, 'name' => 'Book Antiqua', 'size' => 9]);

        $table->addRow();
        $table->addCell(7600, ['borderSize' => 1, 'gridSpan' => 2])->addText('Registration Number : '. $student['student_number'], ['bold' => true, 'name' => 'Book Antiqua', 'size' => 9]);
        $table->addCell(4000, ['borderSize' => 1, 'gridSpan' => 3])->addText('Class Code : '. $student['class_code'], ['bold' => true, 'name' => 'Book Antiqua', 'size' => 9]);

        $table->addRow();
        $table->addCell(11600, ['borderSize' => 1, 'gridSpan' => 5])->addText('Course Name : '. $course->course_name, ['bold' => true, 'name' => 'Book Antiqua', 'size' => 9]);


        $table->addRow();
        $table->addCell(1600, ['borderSize' => 1])->addText('Date', ['bold' => true, 'name' => 'Book Antiqua', 'size' => 9]);
        $table->addCell(5000, ['borderSize' => 1])->addText('Description', ['bold' => true, 'name' => 'Book Antiqua', 'size' => 9]);
        $table->addCell(2000, ['borderSize' => 1])->addText('Invoice Number', ['bold' => true, 'name' => 'Book Antiqua', 'size' => 9]);
        $table->addCell(1500, ['borderSize' => 1])->addText('Debit', ['bold' => true, 'name' => 'Book Antiqua', 'size' => 9]);
        $table->addCell(1500, ['borderSize' => 1])->addText('Credit', ['bold' => true, 'name' => 'Book Antiqua', 'size' => 9]);

        foreach ($statements as $detail) {
            $table->addRow();
            $table->addCell(1600, ['borderSize' => 1])->addText($detail['date'], ['name' => 'Book Antiqua', 'size' => 9]);
            $table->addCell(5000, ['borderSize' => 1])->addText($detail['description'], ['name' => 'Book Antiqua', 'size' => 9]);
            $table->addCell(2000, ['borderSize' => 1])->addText($detail['reference'], ['name' => 'Book Antiqua', 'size' => 9]);
            $table->addCell(1500, ['borderSize' => 1])->addText($detail['debit'], ['name' => 'Book Antiqua', 'size' => 9]);
            $table->addCell(1500, ['borderSize' => 1])->addText($detail['credit'], ['name' => 'Book Antiqua', 'size' => 9]);
        }

        $table->addRow();
        $table->addCell(7600, ['gridSpan' => 3])->addText();
        $table->addCell(1500)->addText($summary['total_invoices'], ['underline' => 'single', 'bold' => true, 'size' => 9]);
        $table->addCell(1500)->addText($summary['total_payments'], ['underline' => 'single', 'bold' => true, 'size' => 9]);

        $table->addRow();
        $table->addCell(7600, ['gridSpan' => 3])->addText();
        $table->addCell(3000, ['gridSpan' => 2])->addText('Balance : '. $summary['fee_balances'], ['underline' => 'single', 'bold' => true, 'size' => 9]);

        $my_template = new TemplateProcessor(storage_path('fee_statement.docx'));

        $my_template->setComplexBlock('{table}', $table);
        $my_template->setImageValue('qr', array('path' => 'QrCodes/'.$image, 'width' => 80, 'height' => 80, 'ratio' => true));
        $docPath = 'Fees/'.preg_replace('~/~', '', $student['student_number']).".docx";
        $my_template->saveAs($docPath);

        $pdfPath = 'Fees/'.preg_replace('~/~', '', $student['student_number']).".pdf";

            $convert = new OfficeConverter('Fees/'.preg_replace('~/~', '', $student['student_number']).".docx", 'Fee/');
            $convert->convertTo(preg_replace('~/~', '', $student['student_number']).".pdf");

            if(file_exists($docPath)){
                unlink($docPath);
            }

        unlink('QrCodes/'.$image);

//         return response()->download($docPath)->deleteFileAfterSend(true);
         return response()->download($pdfPath)->deleteFileAfterSend(true);
    }

    public function viewExamResults(){
        $examResults = ModeratedResults::where('student_number', \auth()->guard('student')->user()->enrolledCourse->student_number)
            ->where('status', 1)
            ->get()
            ->groupBy('attempt');
        return view('student::examination.examresults',['results' => $examResults]);
    }

    public function viewExamMarks($id){
        $stage = base64_decode($id);
        $examResults = ModeratedResults::where('student_number', \auth()->guard('student')->user()->enrolledCourse->student_number)
            ->where('attempt', $stage)
            ->where('status', 1)
            ->orderBy('unit_code', 'asc')
            ->get();
        return view('student::examination.viewexammarks',['results' => $examResults, 'stage' => $stage = base64_decode($id)]);
    }

    public function myCalender(){
        $class = StudentView::where('student_id', \auth()->guard('student')->user()->student_id)
                ->first();
        $reg = Nominalroll::where('student_id', \auth()->guard('student')->user()->student_id)->where('registration', 1)->where('activation', 1)->latest()->first();
        $patterns = ClassPattern::where('class_code', $class->current_class)->where('semester', '>', $reg->year_study.'.'.$reg->semester_study)->orderBy('semester', 'asc')->get();
        return view('student::courses.myCalendar')->with(['patterns' => $patterns]);
    }
}
