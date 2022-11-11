<?php

namespace Modules\COD\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Crypt;
use Modules\Application\Entities\AdmissionApproval;
use Modules\Application\Entities\AdmissionDocument;
use Modules\Application\Entities\Application;
use Modules\Application\Entities\Education;
use Modules\Application\Entities\Notification;
use Modules\COD\Entities\ClassPattern;
use Modules\COD\Entities\Nominalroll;
use Modules\COD\Entities\Pattern;
use Modules\COD\Entities\Progression;
use Modules\Finance\Entities\FinanceLog;
use Modules\COD\Entities\CODLog;
use Auth;
use Modules\Finance\Entities\StudentInvoice;
use Modules\Registrar\Entities\FeeStructure;
use Modules\Registrar\Entities\Student;
use Modules\Registrar\Entities\StudentCourse;
use Validator;
use Modules\Registrar\Entities\AvailableCourse;
use Modules\Registrar\Entities\Classes;
use Modules\Registrar\Entities\Intake;
use Modules\Registrar\Entities\Courses;
use Modules\Registrar\Entities\Attendance;
use Modules\Registrar\Entities\Campus;
use Response;

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
//            ->where('department_id', auth()->guard('user')->user()->department_id)
//            ->orWhere('dean_status', 3)
//            ->count();
//
//        return view('cod::COD.index')->with(['apps'=>$apps_cod, 'admissions'=>$admissions]);
//    }

    public function applications(){

        $applications = Application::where('cod_status', '>=', 0)
            ->where('department_id', auth()->guard('user')->user()->department_id)
            ->where('dean_status', null)
            ->orWhere('dean_status', 3)
            ->orderby('id', 'DESC')
            ->get();

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
            ->where('department_id', auth()->guard('user')->user()->department_id)
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
            ->where('department_id', auth()->guard('user')->user()->department_id)
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
            $courses = Courses::where('department_id', auth()->guard('user')->user()->department_id)->get();

            return view('cod::courses.index')->with('courses', $courses);
    }

    public function intakes(){
            $intakes = Intake::all();

            return view('cod::intakes.index')->with('intakes', $intakes);
    }

    public function intakeCourses($id){


        $hashedId = Crypt::decrypt($id);

            $modes = Attendance::all();
            $campuses = Campus::all();
            $intake = Intake::find($hashedId);
            $courses = Courses::where('department_id', auth()->guard('user')->user()->department_id)->get();

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

                            $progress = new Progression;
                            $progress->class_code = $class->name;
                            $progress->intake_id = $data['intake'];
                            $progress->course_id = $data['course'];
                            $progress->academic_year = $intakes->academic_year_id;
                            $progress->calendar_year = Carbon::now()->format('Y');
                            $progress->year_study = 1;
                            $progress->semester_study = 'I';
                            $progress->pattern = 'ON SESSION';
                            $progress->save();

                        }

                    }
                }
                return json_encode([ 'success' => true ]);
            }else
                return json_encode([ 'error' => $validation->errors() ]);

    }

    public function deptClasses(){

        $courses = Courses::where('department_id', auth()->guard('user')->user()->department_id)->get();

        if (count($courses) == 0){

            $classes = $courses;

            return view('cod::classes.index')->with('classes', $classes);
        }else {

            foreach ($courses as $course) {

                $classes[] = Classes::where('course_id', $course->id)->get();

            }

            return view('cod::classes.index')->with('classes', $classes);
        }

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

        $fees = FeeStructure::where('student_type', $student_fee->student_type)
            ->where('course_id', $student_fee->course_id)
            ->where('semester', 'I')
            ->first();

        $fee = $fees->caution_money + $fees->student_union + $fees->medical_levy + $fees->tuition_fee + $fees->industrial_attachment + $fees->student_id + $fees->examination + $fees->registration_fee + $fees->library_levy + $fees->ict_levy + $fees->activity_fee +$fees->student_benevolent + $fees->kuccps_placement_fee + $fees->cue_levy;

        $academic = Carbon::parse($student->courseStudent->courseEntry->year_start)->format('Y').'/'.Carbon::parse($student->courseStudent->courseEntry->year_end)->format('Y');
       $period = Carbon::parse($student->courseStudent->coursesIntake->intake_from)->format('M').'/'.Carbon::parse($student->courseStudent->coursesIntake->intake_to)->format('M');


        $signed = new Nominalroll;
        $signed->student_id = $student->id;
        $signed->reg_number = $student->reg_number;
        $signed->class_code = $student->courseStudent->class_code;
        $signed->year_study = 1;
        $signed->semester_study = 1;
        $signed->academic_year = $academic;
        $signed->academic_semester = strtoupper($period );
        $signed->pattern_id = 1;
        $signed->registration = 1;
        $signed->activation = 1;
        $signed->save();

        $invoice = new StudentInvoice;
        $invoice->student_id = $student->id;
        $invoice->reg_number = $student->reg_number;
        $invoice->invoice_number = 'INV'.time();
        $invoice->stage = '1.1';
        $invoice->amount = $fee;
        $invoice->description = 'New Student Registration Invoice for 1.1 '.'Academic Year '.$academic;
        $invoice->save();


        return redirect()->back()->with('success', 'Student admitted and invoiced successfully');

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

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('cod::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('cod::create');
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
        return view('cod::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('cod::edit');
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
