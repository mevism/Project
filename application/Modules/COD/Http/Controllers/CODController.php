<?php

namespace Modules\COD\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Application\Entities\AdmissionApproval;
use Modules\Application\Entities\Application;
use Modules\Application\Entities\Education;
use Modules\COD\Entities\Nominalroll;
use Modules\COD\Entities\Progression;
use Modules\Finance\Entities\FinanceLog;
use Modules\COD\Entities\CODLog;
use Auth;
use Modules\Registrar\Entities\Student;
use Modules\Registrar\Entities\StudentCourse;
use Validator;
use Modules\Registrar\Entities\AvailableCourse;
use Modules\Registrar\Entities\Classes;
use Modules\Registrar\Entities\Intake;
use Modules\Registrar\Entities\Courses;
use Modules\Registrar\Entities\Attendance;
use Modules\Registrar\Entities\Campus;

class CODController extends Controller
{

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

        $app = Application::find($id);
        $school = Education::where('applicant_id', $app->applicant->id)->first();

        return view('cod::applications.viewApplication')->with(['app' => $app, 'school' => $school]);
    }

    public function previewApplication($id){

        $app = Application::find($id);
        $school = Education::where('applicant_id', $app->applicant->id)->first();
        return view('cod::applications.preview')->with(['app' => $app, 'school' => $school]);
    }

    public function acceptApplication($id){

        $app = Application::find($id);
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
        $app = Application::find($id);
        $app->cod_status = 2;
        $app->cod_comments = $request->comment;
        $app->save();

        $logs = new CODLog;
        $logs->application_id = $app->id;
        $logs->user = Auth::guard('user')->user()->name;
        $logs->user_role = Auth::guard('user')->user()->role_id;
        $logs->comments = $request->comment;
        if ($app->dean_status === 3){
            $logs->activity = 'Application reviewed by COD';
        }
        $logs->activity = 'Application rejected';
        $logs->save();

        return redirect()->route('cod.applications')->with('success', 'Application declined');
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
            $app->dean_status = 0;
            $app->save();

            $logs = new CODLog;
            $logs->application_id = $app->id;
            $logs->user = Auth::guard('user')->user()->name;
            $logs->user_role = Auth::guard('user')->user()->role_id;
            $logs->activity = "Application awaiting Dean's Verification";
            $logs->save();

        }

        return redirect()->route('cod.batch')->with('success', '1 Batch elevated for Dean approval');
    }


    public function admissionsSelf(){

        $applicant = Application::where('cod_status', 1)
            ->where('department_id', auth()->guard('user')->user()->department_id)
            ->where('registrar_status', 3)
            ->where('status', 0)
            ->get();

        return view('cod::admissions.index')->with('applicant', $applicant);
    }

    public function reviewAdmission($id){
        $app = Application::find($id);
        $school = Education::find($id);

        return view('cod::admissions.review')->with(['app' => $app, 'school' => $school]);
    }

    public function acceptAdmission($id){

        $app = AdmissionApproval::where('application_id', $id)->first();

        if ($app === NULL){
            $adm = new AdmissionApproval;
            $adm->application_id = $id;
            $adm->cod_status = 1;
            $adm->save();
        }else{
            AdmissionApproval::where('application_id', $id)->update(['cod_status' => 1]);
        }

        return redirect()->route('cod.selfAdmissions')->with('success', 'New student admitted successfully');
    }

    public function rejectAdmission(Request $request, $id){

            $app = AdmissionApproval::where('application_id', $id)->first();

            if ($app === NULL){

                $adm = new AdmissionApproval;
                $adm->application_id = $id;
                $adm->cod_status = 2;
                $adm->cod_comments = $request->comment;
                $adm->save();

            }else{

                AdmissionApproval::where('application_id', $id)->update(['cod_status' => 2, 'cod_comments' => $request->comment]);

            }

        return redirect()->route('cod.selfAdmissions')->with('warning', 'Admission request rejected');
    }
    public function rejectAdmJab(Request $request, $id){

        if (AdmissionApproval::where('application_id', $id)->exists()) {
            AdmissionApproval::where('application_id', $id)->update(['cod_status' => 2, 'cod_comments' => $request->comment]);
        }else{
            $adm = new AdmissionApproval;
            $adm->application_id = $id;
            $adm->cod_status = 2;
            $adm->cod_comments = $request->comment;
            $adm->save();
        }

        return redirect()->back()->with('warning', 'Admission request rejected');
    }

    public function submitAdmission($id){

        AdmissionApproval::where('application_id', $id)->update(['finance_status' => 0]);

        Application::where('id', $id)->update(['status' => 1]);

        return redirect()->back()->with('success', 'Record submitted to finance');
    }


    public function submitAdmJab($id){

        AdmissionApproval::where('application_id', $id)->update(['finance_status' => 0]);

        KuccpsApplication::where('applicant_id', $id)->update(['registered' => Carbon::now()]);

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

            $modes = Attendance::all();
            $campuses = Campus::all();
            $intake = Intake::find($id);
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
                            $progress->semester_study = 1;
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

        if (count($courses) === 0){

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

        $class = Classes::find($id);

        $classList = StudentCourse::where('class_code', $class->name)->get();

        return view('cod::classes.classList')->with(['classList' => $classList, 'class' => $class]);
    }

    public function admitStudent($id){

        $student = StudentCourse::where('student_id', $id)->first();

        $signed = new Nominalroll;
        $signed->student_id = $student->id;
        $signed->year_study = 1;
        $signed->semester_study = 'I';
        $signed->academic_year = $student->academic_year_id;
        $signed->academic_semester =$student->intake_id;
        $signed->course_id = $student->course_id;
        $signed->save();

        return redirect()->back()->with('success', 'Student admitted successfully');

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
