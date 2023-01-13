<?php

namespace Modules\Student\Http\Controllers;

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
use Modules\COD\Entities\ClassPattern;
use Modules\COD\Entities\Nominalroll;
use Modules\Finance\Entities\StudentInvoice;
use Modules\Registrar\Entities\CalenderOfEvents;
use Modules\Registrar\Entities\Classes;
use Modules\Registrar\Entities\ClusterWeights;
use Modules\Registrar\Entities\CourseLevelMode;
use Modules\Registrar\Entities\Courses;
use Modules\Registrar\Entities\Department;
use Modules\Registrar\Entities\FeeStructure;
use Modules\Registrar\Entities\Intake;
use Modules\Registrar\Entities\Student;
use Modules\Registrar\Entities\StudentCourse;
use Modules\Registrar\Entities\UnitProgramms;
use Modules\Student\Entities\AcademicLeave;
use Modules\Student\Entities\AcademicLeaveApproval;
use Modules\Student\Entities\CourseTransfer;
use Modules\Student\Entities\DeferredClass;
use Modules\Student\Entities\ExamResults;
use Modules\Student\Entities\Readmission;
use Modules\Student\Entities\StudentDeposit;
use Modules\Student\Entities\TransferInvoice;
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
    public function index()
    {
        $courses = StudentCourse::where('student_id', Auth::guard('student')->user()->student_id)->get();

        return view('student::student.index')->with(['courses' => $courses]);
    }

    public function myCourse(){

        $course = StudentCourse::where('student_id', Auth::guard('student')->user()->student_id)->get();

        $reg = Nominalroll::where('student_id', Auth::guard('student')->user()->loggedStudent->id)
            ->where('registration', 1)
            ->where('activation', 1)
            ->latest()->first();

        return view('student::courses.index')->with(['course' => $course, 'reg' => $reg]);
    }

    public function myProfile(){

        $user = Auth::guard('student')->user();

        return view('student::student.profile')->with('user', $user);
    }

    public function courseTransfers(){

        $student = Auth::guard('student')->user()->loggedStudent;

        $transfers = CourseTransfer::where('student_id', Auth::guard('student')->user()->student_id)->latest()->get();

        $current = Carbon::now()->format('Y-m-d');

        $sem_date = Intake::where('intake_from', '<=', $current )
        ->where('intake_to', '>=', $current)
        ->first();

        $academicYear =  Carbon::parse($sem_date->academicYear->year_start)->format('Y').'/'.Carbon::parse($sem_date->academicYear->year_end)->format('Y');
        $semester = Carbon::parse($sem_date->intake_from)->format('M').'/'.Carbon::parse($sem_date->intake_to)->format('M');

        $event = CalenderOfEvents::where('academic_year_id', $academicYear)
            ->where('intake_id', strtoupper($semester))
            ->where('event_id', 5)
            ->first();

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

        return view('student::courses.transfers')->with(['transfers' => $transfers]);
    }

    public function requestTransfer(){

        $departments = Department::latest()->get();
        $stage = Nominalroll::where('reg_number', Auth::guard('student')->user()->loggedStudent->reg_number)->latest()->first();
        $current = Carbon::now()->format('Y-m-d');

        $sem_date = Intake::where('intake_from', '<=', $current, )
            ->where('intake_to', '>=', $current)
            ->first();

        $academicYear =  Carbon::parse($sem_date->academicYear->year_start)->format('Y').'/'.Carbon::parse($sem_date->academicYear->year_end)->format('Y');
        $semester = Carbon::parse($sem_date->intake_from)->format('M').'/'.Carbon::parse($sem_date->intake_to)->format('M');

        $event = CalenderOfEvents::where('academic_year_id', $academicYear)
            ->where('intake_id', strtoupper($semester))
            ->where('event_id', 5)
            ->first();

        return view('student::courses.coursetransfer')->with(['departments' => $departments, 'stage' => $stage, 'event' => $event, 'academic_year' => $academicYear]);

    }

    public function getDeptCourses(Request $request){

        $data = Courses::where('department_id', $request->id)
            ->where('level', Auth::guard('student')->user()->loggedStudent->courseStudent->studentCourse->level)
            ->latest()->get();

        return response()->json($data);
    }

    public function getCourseClasses(Request $request){

        $student = Auth::guard('student')->user()->loggedStudent;

        $group = Courses::where('id', $request->id)->first();

        if ($group->level == 2){

            $classes = Classes::where('course_id', $request->id)
                ->where('attendance_id', 'J-FT')
                ->select('id','name', 'points')
                ->latest()
                ->first();

            $cluster = [$classes->id, $classes->name, $group->courseRequirements->subject1, $group->courseRequirements->subject2, $group->courseRequirements->subject3, $group->courseRequirements->subject4, $group->courseRequirements->course_requirements, $group->level];

            return response()->json($cluster);
        }
        $points = ClusterWeights::where('student_name', $student->sname.' '.$student->fname.' '.$student->mname)
            ->select($group->cluster_group)
            ->first();

        $classes = Classes::where('course_id', $request->id)
            ->where('attendance_id', 'J-FT')
            ->select('id','name', 'points')
            ->latest()
            ->first();
            // return $classes;

        $cluster = [$classes->id, $classes->name, $points[$group->cluster_group], $classes->points];


        return response()->json($cluster);
    }

    public function submitRequest(Request $request){


        $request->validate([
            'dept' => 'required',
            'course' => 'required',
            'class' => 'required',
        ]);

        if (Auth::guard('student')->user()->loggedStudent->courseStudent->course_id == $request->course){

            return redirect()->back()->with('error', 'You are already admitted to this course');

        }else{
            if (CourseTransfer::where('course_id', $request->course)->where('student_id', Auth::guard('student')->user()->student_id)->first()){

                return redirect()->route('student.coursetransfers')->with('warning', 'You have already created course transfer request for this course');

            }else{

                $transfer = new CourseTransfer;
                $transfer->student_id = Auth::guard('student')->user()->student_id;
                $transfer->department_id = $request->dept;
                $transfer->course_id = $request->course;
                $transfer->class_id = $request->class;
                $transfer->academic_year = $request->academic_year;
                if ($request->mingrade == null){
                    $transfer->class_points = $request->points;
                    $transfer->student_points = $request->mypoints;
                }else{
                    $transfer->class_points = $request->mingrade;
                    $transfer->student_points = $request->mygrade;
                }
                $transfer->save();

                $invoice = new StudentInvoice;
                $invoice->student_id = Auth::guard('student')->user()->student_id;
                $invoice->reg_number = Auth::guard('student')->user()->loggedStudent->reg_number;
                $invoice->invoice_number = 'INV'.time();
                $invoice->description = 'New Student Course Transfers';
                $invoice->amount = 500;
                $invoice->stage = 1;
                $invoice->save();

                return redirect()->route('student.coursetransfers')->with('success', 'Course transfer request created successfully');
            }
        }

    }

    public function academicLeave(){

        $leaves = AcademicLeave::where('student_id', Auth::guard('student')->user()->student_id)->get();
        return view('student::academic.academicleave')->with(['leaves' => $leaves]);

    }

    public function requestLeave(){

      $stage = Nominalroll::where('reg_number', Auth::guard('student')->user()->loggedStudent->reg_number)
//                            ->where('activation', 1)
                            ->latest()
                            ->first();

       $current_date = Carbon::now()->format('Y-m-d');

       $dates = Intake::where('intake_from', '<=', $current_date)->where('intake_to', '>=', $current_date)->first();

       $academicYear =  Carbon::parse($dates->academicYear->year_start)->format('Y').'/'.Carbon::parse($dates->academicYear->year_end)->format('Y');
       $semester = Carbon::parse($dates->intake_from)->format('M').'/'.Carbon::parse($dates->intake_to)->format('M');

       $event = CalenderOfEvents::where('academic_year_id', $academicYear)
            ->where('intake_id', strtoupper($semester))
            ->where('event_id', 4)
            ->first();


       $currentStage = $stage->year_study.'.'.$stage->semester_study;

       $classes = ClassPattern::where('class_code', $stage->class_code)->get();

        foreach ($classes as $class){

            $list[] = $class->semester;
        }

        $id_collection = collect($list);
        $this_key = $id_collection->search($currentStage);
        $next_id = $id_collection->get($this_key + 1);

        $data = [];

        if ( (float)$currentStage > (float)'1.3'){

           $currently = $stage->year_study.'.'.$stage->semester_study;
            $classPattern =  ClassPattern::where('academic_year', $stage->academic_year)
                        ->where('period', $stage->academic_semester)
                        ->where('semester', '<',  $currently)
                        ->get()
                        ->groupBy('class_code');

            foreach ($classPattern as $class_code => $pattern) {

                $data[] = Classes::where('name', $class_code)
                    ->where('course_id', Auth::guard('student')->user()->loggedStudent->courseStudent->course_id)
                    ->where('attendance_code', Auth::guard('student')->user()->loggedStudent->courseStudent->typeStudent->attendance_code)
                    ->where('name', '!=', Auth::guard('student')->user()->loggedStudent->courseStudent->class_code)
                    ->get()
                    ->groupBy('name');
            }

        }else{

            $data = [];
        }

        return view('student::academic.requestleave')->with(['stage' => $stage, 'classes' => $data, 'nextStage' => $next_id, 'event' => $event, 'dates' => $current_date]);
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

        $currentStage = Nominalroll::where('student_id', Auth::guard('student')->user()->student_id)
                                    ->latest()
                                    ->first();
        if (AcademicLeave::where('student_id', $currentStage->student_id)->where('type', $request->type)->where('year_study', $currentStage->year_study)->where('semester_study', $currentStage->semester_study)->exists()){

            return redirect()->back()->with('info', 'You have already requested leave for this stage');
        }else {

            $leave = new AcademicLeave;
            $leave->student_id = Auth::guard('student')->user()->student_id;
            $leave->type = $request->type;
            $leave->current_class = $currentStage->class_code;
            $leave->year_study = $currentStage->year_study;
            $leave->semester_study = $currentStage->semester_study;
            $leave->academic_year = $currentStage->academic_year;
            $leave->from = $request->start_date;
            $leave->to = $request->end_date;
            $leave->reason = $request->reason;
            $leave->save();

            $deferredClass = new DeferredClass;
            $deferredClass->academic_leave_id = $leave->id;
            $deferredClass->deferred_class = $request->newClass;
            $deferredClass->academic_year = $request->newAcademic;
            $deferredClass->semester_study = $request->newSemester;
            $deferredClass->stage = $request->newStage;
            $deferredClass->save();

            return redirect()->route('student.requestacademicleave')->with('success', 'Leave request created successfully');
        }
    }

    public function deleteLeaveRequest($id){

        $hashedId = Crypt::decrypt($id);

        AcademicLeave::find($hashedId)->delete();
        DeferredClass::where('academic_leave_id', $hashedId)->delete();

        return redirect()->back()->with('success', 'Leave request deleted successfully');
    }

    public function requestReadmission(){

        $readmit = Readmission::where('student_id', Auth::guard('student')->user()->student_id)->get();

        return view('student::academic.readmissions')->with(['readmits' => $readmit]);

    }

    public function readmissionRequests(){

        $departments = Department::all();

        return view('student::academic.readmissionrequests')->with(['departments' => $departments]);

    }

    public function storeReadmissionRequest(Request $request){

        $request->validate([
            'dept' => 'required',
            'course' => 'required',
            'reason' => 'required|string'
        ]);

        if (Auth::guard('student')->user()->loggedStudent->courseStudent->course_id == $request->course){

            $readmit = new Readmission;
            $readmit->student_id = Auth::guard('student')->user()->student_id;
            $readmit->department_id = $request->dept;
            $readmit->course_id = $request->course;
            $readmit->reason = $request->reason;
            $readmit->save();

            return redirect()->route('student.requestreadmission')->with('success', 'Readmission request was created successfully');

        }else{

            return redirect()->back()->with('error', 'You are not enrolled to this course');

        }



    }

    public function unitRegistration(){

        $student_activation = StudentInvoice::where('student_id', Auth::guard('student')->user()->loggedStudent->id)
            ->where('reg_number', Auth::guard('student')->user()->loggedStudent->reg_number)
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

        $semester = Nominalroll::where('student_id', Auth::guard('student')->user()->loggedStudent->id)
            ->where('reg_number', Auth::guard('student')->user()->loggedStudent->reg_number)
            ->latest()
            ->first();

        $previousStage = Nominalroll::where('student_id', Auth::guard('student')->user()->loggedStudent->id)
            ->where('reg_number', Auth::guard('student')->user()->loggedStudent->reg_number)
            ->where('activation', 1)
            ->latest()
            ->first();

       $invoices = StudentInvoice::where('student_id', Auth::guard('student')->user()->loggedStudent->id)
            ->where('reg_number', Auth::guard('student')->user()->loggedStudent->reg_number)
            ->where('stage', '<', $student_activation->stage)->get();

       $results = ExamResults::where('reg_number', Auth::guard('student')->user()->loggedStudent->reg_number)
           ->where('stage', $previousStage->year_study)
           ->latest()
           ->first();

            $invoice = 0;

            foreach ($invoices as $payment){

                $invoice += $payment->amount;
            }

            $paid = StudentDeposit::where('reg_number', Auth::guard('student')->user()->loggedStudent->reg_number)
                ->get();

            $payed = 0;

            foreach ($paid as $invoiced){

                $payed += $invoiced->deposit;
            }

            $balance = $payed - $invoice;

            if ($semester->semester_study == 1 && $results != null){
                if ($balance >= $student_activation->amount*0.5 && $results->status == 1){

                    $sign = Nominalroll::where('student_id', Auth::guard('student')->user()->student_id)
                        ->where('reg_number', Auth::guard('student')->user()->loggedStudent->reg_number)
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

                    $sign = Nominalroll::where('student_id', Auth::guard('student')->user()->student_id)
                        ->where('reg_number', Auth::guard('student')->user()->loggedStudent->reg_number)
                        ->latest()
                        ->first();
                    if (!$sign->activation){

                        $sign->activation = 1;
                        $sign->save();
                    }
                }
            }

            if ($semester->pattern_id == 3){

                $sign = Nominalroll::where('student_id', Auth::guard('student')->user()->student_id)
                    ->where('reg_number', Auth::guard('student')->user()->loggedStudent->reg_number)
                    ->latest()
                    ->first();

                if (!$sign->activation){

                    $sign->activation = 1;
                    $sign->save();
                }
            }

            $inv = StudentInvoice::where('reg_number', Auth::guard('student')->user()->loggedStudent->reg_number)->get();
            $dep = StudentDeposit::where('reg_number', Auth::guard('student')->user()->loggedStudent->reg_number)->get();

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
                $sign = Nominalroll::where('student_id', Auth::guard('student')->user()->student_id)
                    ->where('reg_number', Auth::guard('student')->user()->loggedStudent->reg_number)
                    ->latest()
                    ->first();

                if (!$sign->activation){

                    $sign->activation = 1;
                    $sign->save();
                }
            }


            $reg = Nominalroll::where('student_id', Auth::guard('student')->user()->loggedStudent->id)->latest()->get();

            return view('student::semester.index')->with([
                'reg' => $reg,
                'balance' => $balance,
                'fee' => $student_activation->amount
            ]);
        }
    }

    public function requestSemesterRegistration(){

        $reg = Nominalroll::where('student_id', Auth::guard('student')->user()->loggedStudent->id)
            ->where('registration', 1)
            ->where('activation', 1)
            ->latest()->first();

        if ($reg == null){

            $units = [];

            $next = [];

            $list = [];

            $dates = [];

        }else{

            $current = $reg->year_study.'.'.$reg->semester_study;

            $course_code = Auth::guard('student')->user()->loggedStudent->courseStudent->studentCourse->course_code;

            $class_code = Auth::guard('student')->user()->loggedStudent->courseStudent->class_code;

            $classes = ClassPattern::where('class_code', $class_code)->get();

            foreach ($classes as $class){

                $list[] = $class->semester;
            }

            $id_collection = collect($list);
            $this_key = $id_collection->search($current);
            $next_id = $id_collection->get($this_key + 1);

            if ($next_id == null){

                $reg = Nominalroll::where('student_id', Auth::guard('student')->user()->loggedStudent->id)
                    ->where('registration', 1)
                    ->where('activation', 1)
                    ->latest()->first();

                $units = [];

                $next = [];

                return view('student::semester.requestRegistration')
                    ->with([
                        'units' => $units,
                        'next' => $next,
                        'reg' => $reg,
                        'list' => $list,
                    ]);

            }else{

                $new = explode('.', $next_id);

                $units = UnitProgramms::where('course_code', $course_code)
                    ->where('stage', $new[0])
                    ->where('semester', $new[1])
                    ->get();

                $next = ClassPattern::where('semester', $next_id)->where('class_code', $class_code)->first();
            }

            $dates = CalenderOfEvents::where('academic_year_id', $next->academic_year)
                ->where('intake_id', $next->period)
                ->where('event_id', 1)
                ->latest()
                ->first();

        }

        return view('student::semester.requestRegistration')
            ->with([
                'units' => $units,
                'next' => $next,
                'reg' => $reg,
                'list' => $list,
                'dates' => $dates
            ]);
    }

    public function registerSemester(Request $request){

        $student = StudentCourse::where('student_id', Auth::guard('student')->user()->student_id)->first();

        $fees = CourseLevelMode::where('attendance_id', $student->student_type)
                            ->where('course_id', $student->course_id)
                            ->where('level_id', $student->studentCourse->level)
                            ->first();
        $proformaInvoice = 0;

        foreach ($fees->invoiceProforma as $item){

            $proformaInvoice += $item->semesterII;
        }

        if (Nominalroll::where('student_id', Auth::guard('student')->user()->loggedStudent->id)
                    ->where('academic_year', $request->academicyear)
                    ->where('year_study', $request->yearstudy)
                    ->where('semester_study', $request->semesterstudy)->exists()){

            return redirect()->back()->with('info', 'You have already registered for '.$request->semester.' stage.');

        }else {
            $invoiceNo = 'INV' . time();

            $description = 'Registration Invoice for Stage ' . $request->semester . ' Academic Year ' . $request->academicyear;

            $nominal = new Nominalroll;
            $nominal->student_id = Auth::guard('student')->user()->loggedStudent->id;
            $nominal->reg_number = Auth::guard('student')->user()->loggedStudent->reg_number;
            $nominal->class_code = Auth::guard('student')->user()->loggedStudent->courseStudent->class_code;
            $nominal->year_study = $request->yearstudy;
            $nominal->semester_study = $request->semesterstudy;
            $nominal->academic_semester = $request->period;
            $nominal->academic_year = $request->academicyear;
            $nominal->pattern_id = $request->pattern;
            $nominal->registration = 1;
            $nominal->save();

            if (!in_array($request->semester, ['1.3', '2.3', '3.3', '4.3', '5.3', '6.3'], true)) {

                $invoice = new StudentInvoice;
                $invoice->student_id = Auth::guard('student')->user()->loggedStudent->id;
                $invoice->reg_number = Auth::guard('student')->user()->loggedStudent->reg_number;
                $invoice->invoice_number = $invoiceNo;
                $invoice->stage = $request->semester;
                $invoice->amount = $proformaInvoice;
                $invoice->description = $description;
                $invoice->save();
            }
        }


        return redirect()->route('student.unitregistration')->with('success', 'You success registered for '.$request->semester);

    }

    public function viewSemesterUnits($id){

        $hashedId = Crypt::decrypt($id);

        $season = Nominalroll::find($hashedId);

        $course_code = Auth::guard('student')->user()->loggedStudent->courseStudent->studentCourse->course_code;


        $units = UnitProgramms::where('course_code', $course_code)
            ->where('stage', $season->year_study)
            ->where('semester', $season->semester_study)
            ->get();

        return view('student::semester.semesterUnits')->with(['units' => $units]);
    }

    public function feesStatement(){

        $statements = StudentInvoice::where('reg_number', Auth::guard('student')->user()->loggedStudent->reg_number)
            ->orderBy('created_at', 'asc')
            ->get();

        $invoices = StudentDeposit::where('reg_number', Auth::guard('student')->user()->loggedStudent->reg_number)
            ->orderBy('created_at', 'asc')
            ->get();

        $statement = ($statements)->concat($invoices)->sortBy('created_at')->values();


        return view('student::invoice.statement')->with(['statement' => $statement]);
    }

    public function printStatement(){

        $student = Student::where('id', Auth::guard('student')->user()->id)->first();

        $statements = StudentInvoice::where('reg_number', Auth::guard('student')->user()->loggedStudent->reg_number)
            ->orderBy('created_at', 'desc')
            ->get();

        $reg = Nominalroll::where('student_id', Auth::guard('student')->user()->loggedStudent->id)
            ->where('registration', 1)
            ->where('activation', 1)
            ->latest()->first();

        $invoices = StudentDeposit::where('reg_number', Auth::guard('student')->user()->loggedStudent->reg_number)
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
                    'Registration: '.$student->reg_number. "\n".
                    'Class Code: '.$student->courseStudent->class_code."\n".
                    'Current Stage: '.$stage."\n".
                    'Fee Balance:  '.$balance, 'QrCodes/'.$image);

        }else{

            \QrCode::size(200)
                ->format('png')
                ->generate( 'Name: '.$student->fname.' '.$student->mname.' '.$student->sname."\n".
                    'Registration: '.$student->reg_number. "\n".
                    'Class Code: '.$student->courseStudent->class_code."\n".
                    'Current Stage: '.'Year '.$reg->year_study.' Semester '.$reg->patternRoll->season."\n".
                    'Fee Balance:  '.$balance, 'QrCodes/'.$image);
        }

        $domPdfPath = base_path('vendor/dompdf/dompdf');
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $table = new Table(array('unit' => TblWidth::TWIP));
        foreach ($statement as $detail) {
            $table->addRow();
            $table->addCell(1750, ['borderSize' => 2])->addText(Carbon::parse($detail->created_at)->format('d-M-Y'));
            $table->addCell(8800, ['borderSize' => 2])->addText($detail->description, 'Book Antiqua', 'none');
            $table->addCell(1450, ['borderSize' => 2])->addText($detail->invoice_number);
            $table->addCell(980, ['borderSize' => 2])->addText(number_format($detail->amount, 2));
            $table->addCell(980, ['borderSize' => 2])->addText(number_format($detail->deposit, 2));
        }

        $my_template = new TemplateProcessor(storage_path('fee_statement.docx'));

        $my_template->setValue('name', strtoupper($student->sname." ".$student->mname." ".$student->fname));
        $my_template->setValue('date', date('d M Y'));
        $my_template->setValue('reg_number', $student->reg_number);
        $my_template->setValue('class_code', $student->courseStudent->class_code);
        $my_template->setValue('course', $student->courseStudent->studentCourse->course_name);
        $my_template->setComplexBlock('{table}', $table);
        $my_template->setValue('total', number_format($total, 2));
        $my_template->setValue('settled', number_format($settled, 2));
        $my_template->setValue('balance', number_format($balance, 2));
        $my_template->setImageValue('qr', array('path' => 'QrCodes/'.$image, 'width' => 80, 'height' => 80, 'ratio' => true));
        $docPath = 'Fees/'.preg_replace('~/~', '', $student->reg_number).".docx";
        $my_template->saveAs($docPath);

        $pdfPath = 'Fees/'.preg_replace('~/~', '', $student->reg_number).".pdf";

        $convert = new OfficeConverter('Fees/'.preg_replace('~/~', '', $student->reg_number).".docx", 'Fee/');
        $convert->convertTo(preg_replace('~/~', '', $student->reg_number).".pdf");

        if(file_exists($docPath)){
            unlink($docPath);
        }

        unlink('QrCodes/'.$image);

         return response()->download($docPath)->deleteFileAfterSend(true);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('student::create');
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
        return view('student::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('student::edit');
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
