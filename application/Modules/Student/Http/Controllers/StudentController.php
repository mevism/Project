<?php

namespace Modules\Student\Http\Controllers;

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
use Modules\Student\Entities\DeferredClass;
use Modules\Student\Entities\ExamResults;
use Modules\Student\Entities\OldStudentCourse;
use Modules\Student\Entities\Readmission;
use Modules\Student\Entities\ReadmissionApproval;
use Modules\Student\Entities\StudentCourse;
use Modules\Student\Entities\STUDENTCOURSEVIEW;
use Modules\Student\Entities\StudentDeposit;
use Modules\Student\Entities\StudentInfo;
use Modules\Student\Entities\StudentLogin;
use Modules\Student\Entities\StudentView;
use NcJoes\OfficeConverter\OfficeConverter;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use PhpOffice\PhpWord\TemplateProcessor;
use Str;
use SimpleSoftwareIO\QrCode\Facade;

class StudentController extends Controller
{
     /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index() {
        $courses = STUDENTCOURSEVIEW::where('student_id', auth()->guard('student')->user()->student_id)->get();
        return view('student::student.index')->with(['courses' => $courses]);
    }

    public function myCourse(){
        $course = STUDENTCOURSEVIEW::where('student_id', auth()->guard('student')->user()->student_id)->first();
        $reg = Nominalroll::where('student_id', auth()->guard('student')->user()->loggedStudent->student_id)
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
       $student = auth()->guard('student')->user()->loggedStudent;
       $transfers = CourseTransfer::where('student_id', auth()->guard('student')->user()->student_id)->latest()->get();
        $current = Carbon::now()->format('Y-m-d');
        $sem_date = Intake::where('intake_from', '<=', $current )
        ->where('intake_to', '>=', $current)
        ->first();

        if ($sem_date != null){
            $academicYear =  Carbon::parse($sem_date->academicYear->year_start)->format('Y').'/'.Carbon::parse($sem_date->academicYear->year_end)->format('Y');
            $semester = Carbon::parse($sem_date->intake_from)->format('M').'/'.Carbon::parse($sem_date->intake_to)->format('M');

            $event = CalenderOfEvents::where('academic_year_id', $academicYear)
                ->where('intake_id', strtoupper($semester))
                ->where('event_id', 5)
                ->first();

            if ($event != null){

                if ($event->start_date <= $current && $current <= $event->end_date){

                    $invoices = StudentInvoice::where('student_id', $student->id)
                        ->where('reg_number', $student->reg_number)
                        ->latest()
                        ->get();
                    $deposits = StudentDeposit::where('reg_number', $student->reg_number)
                        ->latest()
                        ->get();

                    $invoice = 0;
                    $deposit = 0;

                    foreach ($invoices as $record){

                        $invoice += $record->amount;
                    }

                    foreach ($deposits as $record){

                        $deposit += $record->deposit;
                    }

                    if ($deposit >= $invoice){

                        foreach ($transfers as $transfer){

                            if (!$transfer->status){

                                $transfer->status = 1;
                                $transfer->save();
                            }
                        }
                    }

                }

            }
        }

        return view('student::courses.transfers')->with(['transfers' => $transfers]);
    }

    public function requestTransfer(){
        $division = Division::where('name', 'ACADEMIC DIVISION')->first()->division_id;
        $departments = Department::where('division_id', $division)->latest()->get();
        $stage = Nominalroll::where('reg_number', auth()->guard('student')->user()->enrolledCourse->student_number)
            ->latest()
            ->first();
        $registration = \auth()->guard('student')->user()->StudentsNominalRoll;
        $current = Carbon::now()->format('Y-m-d');
//        $current = '2023-09-23';
        $event = [];
        $academicYear = 'null';

       $sem_date = Intake::where('intake_from', '<=', $current, )
            ->where('intake_to', '>=', $current)
            ->first();
        if ($sem_date != null){
            $academicYear =  Carbon::parse($sem_date->academicYear->year_start)->format('Y').'/'.Carbon::parse($sem_date->academicYear->year_end)->format('Y');
            $semester = Carbon::parse($sem_date->intake_from)->format('M').'/'.Carbon::parse($sem_date->intake_to)->format('M');

          $event = CalenderOfEvents::where('academic_year_id', $academicYear)
                ->where('intake_id', strtoupper($semester))
                ->where('event_id', 5)
                ->first();
        }

        return view('student::courses.coursetransfer')->with(['departments' => $departments, 'stage' => $stage, 'event' => $event, 'academic_year' => $academicYear, 'intake' => $sem_date->intake_id, 'registration' => $registration]);
    }

    public function getDeptCourses(Request $request){
        $data = Courses::where('department_id', $request->id)
            ->where('level', auth()->guard('student')->user()->enrolledCourse->StudentsCourse->level)
            ->latest()
            ->get();
        return response()->json($data);
    }

    public function getCourseClasses(Request $request){
        $student = auth()->guard('student')->user()->loggedStudent;
        $group = Courses::where('course_id', $request->id)->first();
        if ($group->level == 2){
            $classes = Classes::where('course_id', $request->id)
                ->where('attendance_id', 'J-FT')
                ->select('class_id','name', 'points')
                ->latest()
                ->first();
           $cluster = [$classes->class_id, $classes->name, $group->courseRequirements->subject1, $group->courseRequirements->subject2, $group->courseRequirements->subject3, $group->courseRequirements->subject4, $group->courseRequirements->course_requirements, $group->level];

            return response()->json($cluster);
        }else{
            $points = ClusterWeights::where('student_name', $student->sname.' '.$student->fname.' '.$student->mname)
                ->select($group->CourseClusters->cluster)
                ->first();
            $classes = Classes::where('course_id', $request->id)
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

            return redirect()->back()->with('error', 'You are already admitted to this course');

        }else{
            if (CourseTransfer::where('course_id', $request->course)->where('student_id', auth()->guard('student')->user()->student_id)->first()){

                return redirect()->route('student.coursetransfers')->with('warning', 'You have already requested course transfer for this course');

            }else{
                $transferID = new CustomIds();
                $transfer = new CourseTransfer;
                $transfer->course_transfer_id = $transferID->generateId();
                $transfer->student_id = auth()->guard('student')->user()->student_id;
                $transfer->department_id = $request->dept;
                $transfer->course_id = $request->course;
                $transfer->class_id = $request->class;
                $transfer->intake_id = $request->intake;
                if ($request->mingrade == null){
                    $transfer->class_points = $request->points;
                    $transfer->student_points = $request->mypoints;
                }else{
                    $transfer->class_points = $request->mingrade;
                    $transfer->student_points = $request->mygrade;
                }
                $transfer->save();

                $invoiceID = new CustomIds();
                $invoice = new StudentInvoice;
                $invoice->invoice_id = $invoiceID->generateId();
                $invoice->student_id = auth()->guard('student')->user()->student_id;
                $invoice->reg_number = auth()->guard('student')->user()->enrolledCourse->student_number;
                $invoice->invoice_number = 'INV'.time();
                $invoice->description = 'New Student Inter/Intra Faculty Course Transfer Fee';
                $invoice->amount = 500;
                $invoice->stage = 1;
                $invoice->save();

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

    // public function storeRequest($id){

    //     $hashedId = Crypt::decrypt($id);

    //     CourseTransfer::find($hashedId)->update(['status' => 0]);

    //     $invoice = new TransferInvoice;
    //     $invoice->student_id = \auth()->guard('student')->user()->student_id;
    //     $invoice->reg_number = \auth()->guard('student')->user()->loggedStudent->reg_number;
    //     $invoice->invoice_number = 'INV'.time();
    //     $invoice->amount = 500;
    //     $invoice->description = 'Invoice for Course Transfer Fee';
    //     $invoice->save();

    //     return redirect()->back()->with('success', 'Your course transfer request submitted successfully');
    // }

    public function academicLeave(){
        $leaves = AcademicLeave::where('student_id', \auth()->guard('student')->user()->student_id)->get();
        return view('student::academic.academicleave')->with(['leaves' => $leaves]);
    }

    public function requestLeave(){
        $student = StudentView::where('student_id', \auth()->guard('student')->user()->student_id)
            ->first();
       $stage = Nominalroll::where('reg_number', $student->student_number)->latest()->first();
        $current_date = Carbon::now()->format('Y-m-d');
       $dates = Intake::where('intake_from', '<=', $current_date)->where('intake_to', '>=', $current_date)->first();
        $list = [];
        $data = [];
        $academicYear =  Carbon::parse($dates->academicYear->year_start)->format('Y').'/'.Carbon::parse($dates->academicYear->year_end)->format('Y');
       $semester = Carbon::parse($dates->intake_from)->format('M').'/'.Carbon::parse($dates->intake_to)->format('M');

       $event = CalenderOfEvents::where('academic_year_id', $academicYear)
            ->where('intake_id', strtoupper($semester))
            ->where('event_id', 4)
            ->first();
       if($stage == null){
            $currentStage = [];
       }else{
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

                if (\auth()->guard('student')->user()->enrolledCourse->student_type == 2){
                    $mode = 'J-FT';
                }elseif (\auth()->guard('student')->user()->enrolledCourse->student_type == 1){
                    $mode = 'S-FT';
                }elseif (\auth()->guard('student')->user()->enrolledCourse->student_type == 3){
                    $mode = 'S-PT';
                }else{
                    $mode = 'S-EV';
                }

                foreach ($classPattern as $class => $pattern){
                    $classes[] = Classes::where('course_id', \auth()->guard('student')->user()->enrolledCourse->course_id)
                        ->where('name', $class)
                        ->where('name', '!=', \auth()->guard('student')->user()->enrolledCourse->current_class)
                        ->where('attendance_id', $mode)
                        ->latest()
                        ->get()
                        ->groupBy('name');
                }
            }

        return view('student::academic.requestleave')->with(['student' => $student, 'data' => $data, 'stage' => $stage, 'event' => $event, 'dates' => $current_date, 'list' => $list, 'classes' => $classes, 'intake' => $dates]);

    }


    public function leaveClasses(Request $request){
        $data = ClassPattern::where('class_code', $request->class)
                            ->where('semester', $request->stage)
                            ->first();
        return response()->json($data);
    }

    public function defermentRequest(Request $request){
        $deferment = Nominalroll::where('reg_number', $request->studNumber)
            ->first();
        return response()->json($deferment);
    }

    public function submitLeaveRequest(Request $request){
        $request->validate([
            'type' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'reason' => 'required|string'
        ]);
        $currentStage = Nominalroll::where('student_id', auth()->guard('student')->user()->student_id)
                                    ->latest()
                                    ->first();
        if (AcademicLeave::where('student_id', $currentStage->student_id)->where('type', $request->type)->where('year_study', $currentStage->year_study)->where('semester_study', $currentStage->semester_study)->exists()){

            return redirect()->back()->with('info', 'You have already requested leave for this stage');
        }else {

            $leaveId = new CustomIds();
            $leave = new AcademicLeave;
            $leave->student_id = auth()->guard('student')->user()->student_id;
            $leave->leave_id = $leaveId->generateId();
            $leave->type = $request->type;
            $leave->current_class = $currentStage->class_code;
            $leave->year_study = $currentStage->year_study;
            $leave->semester_study = $currentStage->semester_study;
            $leave->academic_year = $currentStage->academic_year;
            $leave->intake_id = $request->intake;
            $leave->from = $request->start_date;
            $leave->to = $request->end_date;
            $leave->reason = $request->reason;
            $leave->save();

            $differedId = new CustomIds();
            $deferredClass = new DeferredClass;
            $deferredClass->differed_class_id = $differedId->generateId();
            $deferredClass->leave_id = $leave->leave_id;
            $deferredClass->differed_class = $request->newClass;
            $deferredClass->differed_year = $request->newAcademic;
            $deferredClass->differed_semester = $request->newSemester;
            $deferredClass->stage = $request->newStage;
            $deferredClass->save();

            $approvalId = new CustomIds();
            $approvals = new AcademicLeaveApproval;
            $approvals->leave_approval_id = $approvalId->generateId();
            $approvals->leave_id = $leave->leave_id;
            $approvals->save();

            return redirect()->route('student.requestacademicleave')->with('success', 'Leave request created successfully');
        }
    }

    public function deleteLeaveRequest($id){
        AcademicLeave::where('leave_id', $id)->delete();
        DeferredClass::where('leave_id', $id)->delete();
        return redirect()->back()->with('success', 'Leave request deleted successfully');
    }

    public function requestReadmission(){
        $readmit = Readmission::where('student_id', auth()->guard('student')->user()->student_id)->get();
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

       $today = Carbon::now();
//       $today = '2023-09-23';

      $intake = Intake::where('intake_from', '<=', $today)->where('intake_to', '>=', $today)->latest()->first();
      $semester = Carbon::parse($intake->intake_from)->format('M').'/'.Carbon::parse($intake->intake_to)->format('M');
      $academic_year = Carbon::parse($intake->academicYear->year_start)->format('Y').'/'. Carbon::parse($intake->academicYear->year_end)->format('Y');

      $dates = CalenderOfEvents::where('academic_year_id', $academic_year)->where('intake_id', strtoupper($semester))->where('event_id', 3)->first();

        return view('student::academic.readmissionrequests')->with(['admission' => $readmit, 'current' => $currentStage, 'dates' => $dates, 'student' => $student]);

    }

    public function storeReadmissionRequest($id){
        $today = Carbon::now()->format('Y-m-d');
//        $today = '2023-09-23';
        $intake = Intake::where('intake_from', '<=', $today)
                            ->where('intake_to', '>=', $today)
                            ->latest()
                            ->first();
        $season = Carbon::parse($intake->intake_from)->format('M').'/'.Carbon::parse($intake->intake_to)->format('M');

        $academicYear = Carbon::parse($intake->academicYear->year_start)->format('Y').'/'.Carbon::parse($intake->academicYear->year_end)->format('Y');

       if (Readmission::where('student_id', auth()->guard('student')->user()->student_id)
                        ->where('leave_id', $id)
                        ->where('status', 0)->exists()){
           return redirect()->back()->with('info', 'You have already requested for readmission');
       }else{

           $readmissionID = new CustomIds();
           $readmission = new Readmission;
           $readmission->student_id = auth()->guard('student')->user()->student_id;
           $readmission->readmision_id = $readmissionID->generateId();
           $readmission->leave_id = $id;
           $readmission->academic_year = $academicYear;
           $readmission->academic_semester = strtoupper($season);
           $readmission->intake_id = $intake->intake_id;
           $readmission->status = 0;
           $readmission->save();

           $approvalID = new CustomIds();
           $approval = new ReadmissionApproval;
           $approval->approval_id = $approvalID->generateId();
           $approval->readmission_id = $readmission->readmision_id;
           $approval->save();

           return redirect()->route('student.requestreadmission')->with('success', 'Readmission request created successfully');
       }
    }

    public function unitRegistration(){
        $studentCourses = StudentCourse::where('student_id',  auth()->guard('student')->user()->student_id)->first();
        $student_activation = StudentInvoice::where('student_id', auth()->guard('student')->user()->student_id)
            ->where('reg_number', $studentCourses->student_number)
            ->latest()->first();

        if ($student_activation == null){

            $reg = [];

            $balance = [];

            $fee = [];

            return view('student::semester.index')->with([
                'reg' => $reg,
                'balance' => $balance,
                'fee' => $fee
            ]);
        }else{

        $semester = Nominalroll::where('student_id', auth()->guard('student')->user()->student_id)
            ->where('reg_number', auth()->guard('student')->user()->enrolledCourse->student_number)
            ->latest()
            ->first();

        $previousStage = Nominalroll::where('student_id', auth()->guard('student')->user()->student_id)
            ->where('reg_number', auth()->guard('student')->user()->enrolledCourse->student_number)
            ->where('activation', 1)
            ->latest()
            ->first();

        $invoices = StudentInvoice::where('student_id', auth()->guard('student')->user()->student_id)
            ->where('reg_number', auth()->guard('student')->user()->enrolledCourse->student_number)
            ->where('stage', '<', $student_activation->stage)->get();

        $results = ModeratedResults::where('student_number', auth()->guard('student')->user()->enrolledCourse->student_number)
           ->where('stage', $previousStage->year_study)
           ->latest()
           ->first();

            $invoice = 0;

            foreach ($invoices as $payment){

                $invoice += $payment->amount;
            }

            $paid = StudentDeposit::where('reg_number', auth()->guard('student')->user()->enrolledCourse->student_number)
                ->get();

            $payed = 0;

            foreach ($paid as $invoiced){

                $payed += $invoiced->deposit;
            }

            $balance = $payed - $invoice;

            if ($semester->semester_study == 1 && $results != null){
                if ($balance >= $student_activation->amount*0.5 && $results->status == 1){

                    $sign = Nominalroll::where('student_id', auth()->guard('student')->user()->student_id)
                        ->where('reg_number', auth()->guard('student')->user()->enrolledCourse->student_number)
                        ->latest()
                        ->first();
                    if (!$sign->activation){

                        $sign->activation = 1;
                        $sign->save();
                    }
                }
            }

            if ($semester->semester_study == 2){
                if ($balance >= $student_activation->amount*0.5){

                    $sign = Nominalroll::where('student_id', auth()->guard('student')->user()->student_id)
                        ->where('reg_number', auth()->guard('student')->user()->enrolledCourse->student_number)
                        ->latest()
                        ->first();
                    if (!$sign->activation){

                        $sign->activation = 1;
                        $sign->save();
                    }
                }
            }

            if ($semester->pattern_id == 3){

                $sign = Nominalroll::where('student_id', auth()->guard('student')->user()->student_id)
                    ->where('reg_number', auth()->guard('student')->user()->enrolledCourse->student_number)
                    ->latest()
                    ->first();

                if (!$sign->activation){

                    $sign->activation = 1;
                    $sign->save();
                }
            }

            $inv = StudentInvoice::where('reg_number', auth()->guard('student')->user()->enrolledCourse->student_number)->get();
            $dep = StudentDeposit::where('reg_number', auth()->guard('student')->user()->enrolledCourse->student_number)->get();

            $invo = 0;
            $depo = 0;

            foreach ($inv as $i){

                $invo += $i->amount;
            }

            foreach ($dep as $d){

                $depo += $d->deposit;
            }

            $bal = $depo - $invo;

            if (in_array($semester->pattern_id, [4, 5], true) && $bal >= 0){
                $sign = Nominalroll::where('student_id', auth()->guard('student')->user()->student_id)
                    ->where('reg_number', auth()->guard('student')->user()->enrolledCourse->student_number)
                    ->latest()
                    ->first();

                if (!$sign->activation){

                    $sign->activation = 1;
                    $sign->save();
                }
            }


            $reg = Nominalroll::where('student_id', \auth()->guard('student')->user()->student_id)->latest()->get();

            return view('student::semester.index')->with([
                'reg' => $reg,
                'balance' => $balance,
                'fee' => $student_activation->amount
            ]);
        }
    }

    public function requestSemesterRegistration(){

        $student = DB::table('studentview')->where('student_id', \auth()->guard('student')->user()->student_id)
            ->first();
        $list = [];

        $reg = Nominalroll::where('student_id', \auth()->guard('student')->user()->loggedStudent->student_id)
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

                $dates = CalenderOfEvents::where('academic_year_id', $next->academic_year)
                    ->where('intake_id', $next->period)
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

//        return $request->all();

        if ($request->optionId == null){
            return redirect()->back()->with('error', 'Ensure you have selected an option to proceed');
        }
        $student = StudentCourse::where('student_id', auth()->guard('student')->user()->student_id)->first();
        $fees = SemesterFee::where('attendance_id', $student->student_type)
                            ->where('course_code', $student->StudentsCourse->course_code)
                            ->where('version', $student->version)
                            ->where('semester', $request->semester)
                            ->get();
//        return $fees;
        $proformaInvoice = 0;

        foreach ($fees as $item){
            $proformaInvoice += $item->amount;
        }

//        return $proformaInvoice;

        if (Nominalroll::where('student_id', auth()->guard('student')->user()->student_id)
                    ->where('academic_year', $request->academicyear)
                    ->where('year_study', $request->yearstudy)
                    ->where('semester_study', $request->semesterstudy)->exists()){

            return redirect()->back()->with('info', 'You have already registered for '.$request->semester.' stage.');

        }else {

            $invoiceNo = 'INV' . time();
            $description = 'Registration Invoice for Stage ' . $request->semester . ' Academic Year ' . $request->academicyear;
            $nominalID = new CustomIds();
            $nominal = new Nominalroll;
            $nominal->nominal_id = $nominalID->generateId();
            $nominal->student_id = auth()->guard('student')->user()->student_id;
            $nominal->reg_number = auth()->guard('student')->user()->enrolledCourse->student_number;
            $nominal->class_code = auth()->guard('student')->user()->enrolledCourse->current_class;
            $nominal->year_study = $request->yearstudy;
            $nominal->semester_study = $request->semesterstudy;
            $nominal->academic_semester = $request->period;
            $nominal->academic_year = $request->academicyear;
            $nominal->pattern_id = $request->pattern;
            $nominal->registration = 1;
            $nominal->save();

            if (!in_array($request->semester, ['1.3', '2.3', '3.3', '4.3', '5.3', '6.3'], true)) {

                $invoiceID = new CustomIds();
                $invoice = new StudentInvoice;
                $invoice->invoice_id = $invoiceID->generateId();
                $invoice->student_id = auth()->guard('student')->user()->student_id;
                $invoice->reg_number = auth()->guard('student')->user()->enrolledCourse->student_number;
                $invoice->invoice_number = $invoiceNo;
                $invoice->stage = $request->semester;
                $invoice->amount = $proformaInvoice;
                $invoice->description = $description;
                $invoice->save();

                foreach ($units as $unit){
                    $wID = new CustomIds();
                    $examinableUnit = new ExamMarks;
                    $examinableUnit->exam_id = $wID->generateId();
                    $examinableUnit->student_number = \auth()->guard('student')->user()->enrolledCourse->student_number;
                    $examinableUnit->class_code = \auth()->guard('student')->user()->enrolledCourse->current_class;
                    $examinableUnit->unit_code = $unit;
                    $examinableUnit->academic_year = $request->academicyear;
                    $examinableUnit->academic_semester = $request->period;
                    $examinableUnit->stage = $request->yearstudy;
                    $examinableUnit->semester = $request->semesterstudy;
                    $examinableUnit->attempt = $request->yearstudy.'.'.$request->semesterstudy;
                    $examinableUnit->save();
                }

            }

        }
        return redirect()->route('student.unitregistration')->with('success', 'You success registered for '.$request->semester);

    }

    public function viewSemesterUnits($id){

        $season = Nominalroll::where('nominal_id', $id)->first();
        $units = ExamMarks::where('student_number', \auth()->guard('student')->user()->enrolledCourse->student_number)
            ->where('stage', $season->year_study)
            ->where('semester', $season->semester_study)
            ->orderBy('unit_code', 'asc')
            ->get();

        return view('student::semester.semesterUnits')->with(['units' => $units]);
    }

    public function feesStatement(){

        $statements = StudentInvoice::where('reg_number', auth()->guard('student')->user()->enrolledCourse->student_number)
            ->orderBy('created_at', 'asc')
            ->get();

        $invoices = StudentDeposit::where('reg_number', \auth()->guard('student')->user()->loggedStudent->reg_number)
            ->orderBy('created_at', 'asc')
            ->get();

        $statement = ($statements)->concat($invoices)->sortBy('created_at')->values();


        return view('student::invoice.statement')->with(['statement' => $statement]);
    }

    public function printStatement(){

        $student = StudentInfo::where('student_id', \auth()->guard('student')->user()->student_id)->first();
        $statements = StudentInvoice::where('reg_number', \auth()->guard('student')->user()->enrolledCourse->student_number)
            ->orderBy('created_at', 'desc')
            ->get();
        $reg = Nominalroll::where('student_id', \auth()->guard('student')->user()->student_id)
            ->where('registration', 1)
            ->where('activation', 1)
            ->latest()->first();
        $invoices = StudentDeposit::where('reg_number', \auth()->guard('student')->user()->enrolledCourse->student_number)
            ->orderBy('created_at', 'desc')
            ->get();
        $statement = ($statements)->concat($invoices)->sortBy('created_at')->values();
        $total = 0;
        $settled = 0;

        foreach ($statement as $paid){

            $total += $paid->amount;
        }

        foreach ($invoices as $invoice){

            $settled += $invoice->deposit;
        }

        $balance = $settled - $total;

        $image = time().'.png';

        if ($reg == null){

            $stage = 'Not registered';

            \QrCode::size(200)
                ->format('png')
                ->generate( 'Name: '.$student->fname.' '.$student->mname.' '.$student->sname."\n".
                    'Registration: '.\auth()->guard('student')->user()->enrolledCourse->student_number. "\n".
                    'Class Code: '.\auth()->guard('student')->user()->enrolledCourse->current_class."\n".
                    'Current Stage: '.$stage."\n".
                    'Fee Balance:  '.$balance, 'QrCodes/'.$image);

        }else{

            \QrCode::size(200)
                ->format('png')
                ->generate( 'Name: '.$student->fname.' '.$student->mname.' '.$student->sname."\n".
                    'Registration: '.\auth()->guard('student')->user()->enrolledCourse->student_number. "\n".
                    'Class Code: '.\auth()->guard('student')->user()->enrolledCourse->current_class."\n".
                    'Current Stage: '.'Year '.$reg->year_study.' Semester '.$reg->patternRoll->season."\n".
                    'Fee Balance:  '.$balance, 'QrCodes/'.$image);
        }

        $domPdfPath = base_path('vendor/dompdf/dompdf');
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $table = new Table(array('unit' => TblWidth::TWIP));

        $table->addRow();
        $table->addCell(7600, ['borderSize' => 1, 'gridSpan' => 3])->addText('Student Name : '.strtoupper($student->sname." ".$student->mname." ".$student->fname), ['bold' => true, 'name' => 'Book Antiqua']);
        $table->addCell(4000, ['borderSize' => 1, 'gridSpan' => 2])->addText('Printed On : '.date('d-M-Y'), ['bold' => true, 'name' => 'Book Antiqua']);

        $table->addRow();
        $table->addCell(7600, ['borderSize' => 1, 'gridSpan' => 3])->addText('Registration Number : '. \auth()->guard('student')->user()->enrolledCourse->student_number, ['bold' => true, 'name' => 'Book Antiqua']);
        $table->addCell(4000, ['borderSize' => 1, 'gridSpan' => 2])->addText('Class Code : '.\auth()->guard('student')->user()->enrolledCourse->current_class, ['bold' => true, 'name' => 'Book Antiqua']);

        $table->addRow();
        $table->addCell(11600, ['borderSize' => 1, 'gridSpan' => 5])->addText('Course Name : '.\auth()->guard('student')->user()->enrolledCourse->StudentsCourse->course_name, ['bold' => true, 'name' => 'Book Antiqua']);


        $table->addRow();
        $table->addCell(1600, ['borderSize' => 1])->addText('Date', ['bold' => true, 'name' => 'Book Antiqua']);
        $table->addCell(5000, ['borderSize' => 1])->addText('Description', ['bold' => true, 'name' => 'Book Antiqua']);
        $table->addCell(2000, ['borderSize' => 1])->addText('Invoice Number', ['bold' => true, 'name' => 'Book Antiqua']);
        $table->addCell(1500, ['borderSize' => 1])->addText('Debit', ['bold' => true, 'name' => 'Book Antiqua']);
        $table->addCell(1500, ['borderSize' => 1])->addText('Credit', ['bold' => true, 'name' => 'Book Antiqua']);

        foreach ($statement as $detail) {
            $table->addRow();
            $table->addCell(1600, ['borderSize' => 1])->addText(Carbon::parse($detail->created_at)->format('d-M-Y'));
            $table->addCell(5000, ['borderSize' => 1])->addText($detail->description, ['name' => 'Book Antiqua']);
            $table->addCell(2000, ['borderSize' => 1])->addText($detail->invoice_number);
            $table->addCell(1500, ['borderSize' => 1])->addText(number_format($detail->amount, 2));
            $table->addCell(1500, ['borderSize' => 1])->addText(number_format($detail->deposit, 2));
        }

        $table->addRow();
        $table->addCell(7600, ['gridSpan' => 3])->addText();
        $table->addCell(1500)->addText( number_format($total, 2), ['underline' => 'single', 'bold' => true]);
        $table->addCell(1500)->addText( number_format($settled, 2), ['underline' => 'single', 'bold' => true]);

        $table->addRow();
        $table->addCell(7600, ['gridSpan' => 3])->addText();
        $table->addCell(3000, ['gridSpan' => 2])->addText('Balance : '.number_format($balance, 2), ['underline' => 'single', 'bold' => true]);


        $my_template = new TemplateProcessor(storage_path('fee_statement.docx'));

        $my_template->setComplexBlock('{table}', $table);
        $my_template->setImageValue('qr', array('path' => 'QrCodes/'.$image, 'width' => 80, 'height' => 80, 'ratio' => true));
        $docPath = 'Fees/'.preg_replace('~/~', '', \auth()->guard('student')->user()->enrolledCourse->student_number).".docx";
        $my_template->saveAs($docPath);

        $pdfPath = 'Fees/'.preg_replace('~/~', '', \auth()->guard('student')->user()->enrolledCourse->student_number).".pdf";

//        $convert = new OfficeConverter('Fees/'.preg_replace('~/~', '', $student->reg_number).".docx", 'Fee/');
//        $convert->convertTo(preg_replace('~/~', '', $student->reg_number).".pdf");

//        if(file_exists($docPath)){
//            unlink($docPath);
//        }

        unlink('QrCodes/'.$image);

         return response()->download($docPath)->deleteFileAfterSend(true);
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
        $class = StudentView::where('student_number', \auth()->guard('student')->user()->enrolledCourse->student_number)
                ->pluck('current_class');
        $patterns = ClassPattern::where('class_code', $class)->orderBy('semester', 'asc')->get();
        return view('student::courses.myCalendar')->with(['patterns' => $patterns]);
    }
}
