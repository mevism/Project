<?php

namespace Modules\COD\Http\Controllers;

use App\Models\User;
use App\Service\CustomIds;
use Auth;
use Illuminate\Support\Facades\Cache;
use Modules\Administrator\Entities\Staff;
use Modules\Application\Entities\ApplicationApproval;
use Modules\COD\Entities\AcademicLeavesView;
use Modules\COD\Entities\AdmissionsView;
use Modules\COD\Entities\ApplicationsView;
use Modules\COD\Entities\CourseOnOfferView;
use Modules\COD\Entities\CourseOptions;
use Modules\COD\Entities\CourseSyllabus;
use Modules\COD\Entities\ReadmissionsView;
use Modules\COD\Entities\SupplementarySpecial;
use Modules\COD\Entities\SyllabusVersion;
use Modules\COD\Entities\Unit;
use Modules\Examination\Entities\ModeratedResults;
use Modules\Lecturer\Entities\LecturerQualification;
use Modules\Lecturer\Entities\QualificationRemarks;
use Modules\Lecturer\Entities\TeachingArea;
use Modules\Lecturer\Entities\TeachingAreaRemarks;
use Modules\Registrar\Entities\AcademicYear;
use Modules\Student\Entities\StudentCourse;
use Modules\Student\Entities\STUDENTCOURSEVIEW;
use Modules\Student\Entities\StudentView;
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
use Modules\Registrar\Entities\Department;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use Modules\Application\Entities\Education;
use Modules\Examination\Entities\ExamMarks;
use Modules\Registrar\Entities\SemesterFee;
use Modules\Student\Entities\AcademicLeave;
use NcJoes\OfficeConverter\OfficeConverter;
use Illuminate\Contracts\Support\Renderable;
use Modules\Finance\Entities\StudentInvoice;
use Modules\Registrar\Entities\FeeStructure;
use Modules\Student\Entities\CourseTransfer;
use Modules\Application\Entities\Application;
use Modules\Registrar\Entities\UnitProgramms;
use Modules\Application\Entities\Notification;
use Modules\Examination\Entities\ExamWorkflow;
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


    public function applications() {
        $applications = ApplicationsView::where('department_id', auth()->guard('user')->user()->employmentDepartment->first()->department_id)
           ->where('dean_status', null)
           ->where('declaration', '!=', null)
           ->latest()
           ->get();

        return view('cod::applications.index')->with('apps', $applications);
    }

    public function viewApplication($id)
    {

        $app = ApplicationsView::where('application_id', $id)->first();
        $school = Education::where('applicant_id', $app->applicant_id)->get();

        return view('cod::applications.viewApplication')->with(['app' => $app, 'school' => $school]);
    }

    public function previewApplication($id){
        $app = ApplicationsView::where('application_id', $id)->first();
        $school = Education::where('applicant_id', $app->applicant_id)->get();
        return view('cod::applications.preview')->with(['app' => $app, 'school' => $school]);
    }

    public function acceptApplication($id)
    {

        $app = ApplicationApproval::where('application_id', $id)->first();
        $app->cod_status = 1;
        $app->cod_comments = 'Application accepted by department';
        $app->save();

//        $logs = new CODLog;
//        $logs->application_id = $app->id;
//        $logs->user = Auth::guard('user')->user()->name;
//        $logs->user_role = Auth::guard('user')->user()->role_id;
//        $logs->activity = 'Application accepted';
//        $logs->save();

        return redirect()->route('cod.applications')->with('success', '1 applicant approved');
    }

    public function rejectApplication(Request $request, $id)
    {

        $request->validate([
            'comment' => 'required|string'
        ]);

        $app = ApplicationApproval::where('application_id', $id)->first();
        $app->cod_status = 2;
        $app->cod_comments = $request->comment;
        $app->save();

//        $logs = new CODLog;
//        $logs->application_id = $app->id;
//        $logs->user = Auth::guard('user')->user()->name;
//        $logs->user_role = Auth::guard('user')->user()->role_id;
//        $logs->comments = $request->comment;
//        if ($app->dean_status == 3){
//            $logs->activity = 'Application reviewed by COD';
//        }
//        $logs->activity = 'Application rejected';
//        $logs->save();

        return redirect()->route('cod.applications')->with('success', 'Application declined');
    }

    public function reverseApplication(Request $request, $id)
    {

        $app = ApplicationApproval::where('application_id', $id)->first();
        $app->cod_status = 4;
        $app->cod_comments = $request->comment;
        $app->save();

//        $logs = new CODLog;
//        $logs->application_id = $app->id;
//        $logs->user = Auth::guard('user')->user()->name;
//        $logs->user_role = Auth::guard('user')->user()->role_id;
//        $logs->comments = $request->comment;
//        $logs->activity = 'Application reversed for corrections';
//        $logs->save();
//
        $comms = new Notification;
        $comms->application_id = $id;
        $comms->role_id = \auth()->guard('user')->user()->roles->first()->id;
        $comms->subject = 'Application Approval Process';
        $comms->comment = $request->comment;
        $comms->save();

        return  redirect()->route('cod.applications')->with('success', 'Application send to the student for Corrections');
    }

    public function batch(){
        $apps = ApplicationsView::where('cod_status', '>', 0)
            ->where('department_id',auth()->guard('user')->user()->employmentDepartment->first()->department_id)
            ->where('dean_status', null)
            ->orWhere('dean_status', 3)
            ->where('cod_status', '!=', 3)
            ->latest()
            ->get();

        return view('cod::applications.batch')->with('apps', $apps);
    }

    public function batchSubmit(Request $request)
    {

        foreach ($request->submit as $item) {

            $app = ApplicationApproval::where('application_id', $item)->first();

            if ($app->cod_status == 4) {

                $app = ApplicationApproval::where('application_id', $item)->first();
                $app->cod_status = NULL;
                $app->dean_status = NULL;
                $app->save();

                $revert = Application::where('application_id', $item)->first();
                $revert->declaration = NULL;
                $revert->save();

//                $logs = new CODLog;
//                $logs->application_id = $app->id;
//                $logs->user = Auth::guard('user')->user()->name;
//                $logs->user_role = Auth::guard('user')->user()->role_id;
//                $logs->activity = "Application awaiting Dean's Verification";
//                $logs->save();

                $notify = Notification::where('application_id', $item)->latest()->first();
                $notify->status = '1';
                $notify->save();

            }else{
                $app = ApplicationApproval::where('application_id', $item)->first();
                $app->dean_status = 0;
                $app->save();

//                $logs = new CODLog;
//                $logs->application_id = $app->id;
//                $logs->user = Auth::guard('user')->user()->name;
//                $logs->user_role = Auth::guard('user')->user()->role_id;
//                $logs->activity = "Application awaiting Dean's Verification";
//                $logs->save();
            }
        }

        return redirect()->route('cod.batch')->with('success', '1 Batch elevated for Dean approval');
    }

    public function admissions(){

        $applicant = AdmissionsView::where('department_id',auth()->guard('user')->user()->employmentDepartment->first()->department_id)
            ->where('medical_status', null)
            ->latest()
            ->get();

        return view('cod::admissions.index')->with('applicant', $applicant);
    }

    public function reviewAdmission($id)
    {

        $app = AdmissionsView::where('application_id', $id)->first();
        $documents = AdmissionDocument::where('application_id', $app->application_id)->first();
        $school = Education::where('applicant_id', $app->applicant_id)->get();

        return view('cod::admissions.review')->with(['app' => $app, 'documents' => $documents, 'school' => $school]);
    }

    public function acceptAdmission($id)
    {

        AdmissionApproval::where('application_id', $id)->update(['cod_status' => 1, 'cod_comments' => 'Admission accepted at department level']);

        return redirect()->route('cod.Admissions')->with('success', 'New student admitted successfully');
    }

    public function rejectAdmission(Request $request, $id)
    {

        AdmissionApproval::where('application_id', $id)->update(['cod_status' => 2, 'cod_comments' => $request->comment]);

        return redirect()->route('cod.Admissions')->with('danger', 'Admission request rejected');
    }


    public function withholdAdmission(Request $request, $id)
    {

        AdmissionApproval::where('application_id', $id)->update(['cod_status' => 3, 'cod_comments' => $request->comment]);

        return redirect()->route('cod.Admissions')->with('info', 'Admission has been withheld');
    }

    public function submitAdmission($id)
    {

        AdmissionApproval::where('application_id', $id)->update(['medical_status' => 0]);

        Application::where('application_id', $id)->update(['status' => 1]);

        return redirect()->back()->with('success', 'Admission sent to medical desk for verification');
    }

    public function courses(){
         $courses = Courses::where('department_id', auth()->guard('user')->user()->employmentDepartment->first()->department_id)
             ->get();
        return view('cod::courses.index')->with('courses', $courses);
    }

    public function addCourseOption($id){
        $course = Courses::where('course_id', $id)->first();
        return view('cod::courses.addCourseOption')->with('course', $course);
    }

    public function storeCourseOption(Request $request){
        $request->validate([
            'name' => 'required|string'
        ]);

        $optionId = new CustomIds;
        $courseOption = new CourseOptions;
        $courseOption->option_id = $optionId->generateId();
        $courseOption->course_id = $request->course_id;
        $courseOption->option_name = trim(strtoupper($request->name));
        $courseOption->option_code = trim(strtoupper($request->option_code));
        $courseOption->save();

        return redirect()->route('department.courseOptions', $request->course_id)->with('success', 'Course option created successfully');
    }

    public  function editCourseOption($id){
        $option = CourseOptions::where('option_id', $id)->first();
        $course = Courses::where('course_id', $option->course_id)->first();

        return view('cod::courses.editCourseOption')->with(['course' => $course, 'option' => $option]);
    }

    public function updateCourseOption(Request $request, $id){
        $request->validate([
            'name' => 'required'
        ]);
        $courseOption = CourseOptions::where('option_id', $id)->first();
        CourseOptions::where('option_id', $id)->update([
            'option_name' => trim(strtoupper($request->name)),
            'option_code' => trim(strtoupper($request->option_code)),
        ]);
        return redirect()->route('department.courseOptions', $courseOption->course_id)->with('success', 'Course option updated successfully');
    }

    public function courseOptions($id){

        $course = Courses::where('course_id', $id)->first();

        $courses = CourseOptions::where('course_id', $id)->latest()->get();

        return view('cod::courses.courseOptions')->with(['courses' => $courses, 'course' => $course]);
    }

    public function allUnits(){
//        $cacheKey = 'all_units_' . auth()->guard('user')->user()->user_id;
//        $units = Cache::remember($cacheKey, 3600, function () {
        $units = Unit::where('department_id', auth()->guard('user')->user()->employmentDepartment->first()->department_id)
                ->orWhere('type', 1)
                ->orWhere('type', 2)
                ->latest()
                ->get();
//        });

        // Manually store the units in cache with a different cache key and time
//        $anotherCacheKey = 'all_units_other_key';
//        Cache::put($anotherCacheKey, $units, 1800); // Cache for 1800 seconds (30 minutes)

        return view('cod::syllabus.index')->with(['units' => $units]);
    }



    public function addUnit(){

        return view('cod::syllabus.addUnit');
    }

    public function storeUnit(Request $request){
        $request->validate([
           'unit_code' => 'required|string',
           'unit_name' => 'required|string',
           'unit_type' => 'required|numeric',
           'total_exam' => 'required|numeric',
           'total_cat' => 'required|numeric',
           'cat' => 'required|numeric',
        ]);

        $totatMark = $request->total_exam + $request->total_cat;
        $totalCat = $request->cat + $request->assignment + $request->practical;
        if ($totatMark != 100){
            return redirect()->back()->with('error', 'Exam mark and CAT mark must equal to 100%');
        }

        if ($totalCat != $request->total_cat){
            return redirect()->back()->with('error', 'CAT, Assignment and Practical marks must equal Total CAT');
        }
        $practical = 0;
        $assignment = 0;
        if ($request->assignment != null){
            $assignment = $request->assignment;
        }

        if ($request->practical != null){
            $practical = $request->practical;
        }

        $unitID = new CustomIds();

        $unit = new Unit;
        $unit->unit_id = $unitID->generateId();
        $unit->unit_code = strtoupper(str_replace(' ', '', $request->unit_code));
        $unit->unit_name = strtoupper($request->unit_name);
        $unit->type = $request->unit_type;
        $unit->department_id = auth()->guard('user')->user()->employmentDepartment->first()->department_id;
        $unit->total_exam = $request->total_exam;
        $unit->total_cat = $request->total_cat;
        $unit->cat = $request->cat;
        $unit->assignment = $assignment;
        $unit->practical = $practical;
        $unit->save();

        return redirect()->route('department.allUnits')->with('success', 'Unit has been successfully created');

    }

    public function editUnit($id){
        $unit = Unit::where('unit_id', $id)->first();
        return view('cod::syllabus.editUnit')->with('unit', $unit);
    }

    public function updateUnit(Request $request, $id){
        $request->validate([
            'unit_code' => 'required|string',
            'unit_name' => 'required|string',
            'unit_type' => 'required|numeric',
            'total_exam' => 'required|numeric',
            'total_cat' => 'required|numeric',
            'cat' => 'required|numeric',
        ]);

        $totatMark = $request->total_exam + $request->total_cat;
        $totalCat = $request->cat + $request->assignment + $request->practical;
        if ($totatMark != 100){
            return redirect()->back()->with('error', 'Exam mark and CAT mark must equal to 100%');
        }

        if ($totalCat != $request->total_cat){
            return redirect()->back()->with('error', 'CAT, Assignment and Practical marks must equal Total CAT');
        }
        $practical = 0;
        $assignment = 0;
        if ($request->assignment != null){
            $assignment = $request->assignment;
        }

        if ($request->practical != null){
            $practical = $request->practical;
        }

        Unit::where('unit_id', $id)->update([
            'unit_code' => strtoupper(str_replace(' ', '', $request->unit_code)),
            'unit_name' => strtoupper($request->unit_name),
            'type' => $request->unit_type,
            'department_id' => auth()->guard('user')->user()->employmentDepartment->first()->department_id,
            'total_exam' => $request->total_exam,
            'total_cat' => $request->total_cat,
            'cat' => $request->cat,
            'assignment' => $assignment,
            'practical' => $practical
        ]);

        return redirect()->route('department.allUnits')->with('success', 'Unit has been successfully updated');
    }

    public function intakes(){
            $intakes = Intake::latest()->get();
            return view('cod::intakes.index')->with('intakes', $intakes);
    }

    public function intakeCourses($id){
        // return $id;
            $modes = Attendance::all();
            $campuses = Campus::all();
            $intake = Intake::where('intake_id', $id)->first();
            $courses = Courses::where('department_id', auth()->guard('user')->user()->employmentDepartment->first()->department_id)->latest()->get();

            return view('cod::intakes.addCourses')->with(['intake' => $intake, 'courses' => $courses, 'modes' => $modes, 'campuses' => $campuses]);
    }


    public function addAvailableCourses(Request $request){
        $payload = json_decode($request->input('payload'), true);

        // Check if JSON decoding was successful
        if (is_null($payload)) {
            return response()->json(['error' => 'Invalid payload format'], 400);
        }

        // Laravel validation rules
        $rules = [
            'payload' => 'required',
            'payload.*.course' => 'required',
            'payload.*.modes' => 'required_if:payload.*.course,' . true . '|array',
            'payload.*.campus' => 'required_if:payload.*.course,' . true . '|array',
        ];

        // Validate the request
        $validatedData = $request->validate($rules);

        // Filter the payload to include only selected courses
        $selectedCourses = array_filter($payload, function ($item) {
            return !empty($item['modes']) && !empty($item['campus']);
        });


        foreach ($selectedCourses as $selectedCourse) {
            if (AvailableCourse::where('course_id', $selectedCourse['course'])->where('intake_id', $request->intake)->exists()){
                return redirect()->back()->with('info', 'Some of the course may already have been uploaded');
            }else{
                foreach ($selectedCourse['campus'] as $campus) {
                    $availableId = new CustomIds();
                    $generatedID  =  $availableId->generateId();
                    $availableCourse = new AvailableCourse;
                    $availableCourse->available_id = $generatedID;
                    $availableCourse->intake_id = $request->intake;
                    $availableCourse->course_id = $selectedCourse['course'];
                    $availableCourse->campus_id = $campus;
                    $availableCourse->save();
                }

                foreach ($selectedCourse['modes'] as $mode){

                    $intakes = Intake::where('intake_id', $request->intake)->first();
                    $course = Courses::where('course_id', $selectedCourse['course'])->first();
                    $code = Attendance::find($mode);
                    $classEx = $course->course_code.'/'.strtoupper(Carbon::parse($intakes->intake_from)->format('MY')).'/'.$code->attendance_code;
                    $syllabus = SyllabusVersion::where('course_id', $course->course_id)->latest()->first()->syllabus_name;
//                    $feeStructure = SemesterFee::where('course_code', $course->course_code)->pluck('version')->toArray();
                    $feeStructure = 'v.2023';

                    $classId = new CustomIds();
                    // $generatedClassID  =  $classId->generateId();

                    $deptClass = Classes::where('name', $classEx)->exists();
                    if ($deptClass == null){
                        $class = new Classes;
                        $class->class_id = $classId->generateId();
                        $class->name = $classEx;
                        $class->attendance_id = $code->attendance_code;
                        $class->course_id = $selectedCourse['course'];
                        $class->intake_id = $request->intake;
                        $class->syllabus_name = $syllabus;
//                        $class->fee_version = max($feeStructure);
                        $class->fee_version = $feeStructure;
//                        $class->points = 0;
                        $class->save();
                    }
                }
            }
        }

        return redirect()->back()->with('success', 'New courses are ready for applications');
    }

    public function viewDeptIntakeCourses($intake){

       $courses = CourseOnOfferView::where('intake_id', $intake)
           ->where('department_id', auth()->guard('user')->user()->employmentDepartment->first()->department_id)
           ->latest()
           ->get();

        return view('cod::intakes.intakeCourses')->with(['courses' => $courses]);
    }

    public function deptClasses(){
        $intakes = Intake::all();
        $classes = DB::table('classesview')
                ->where('department_id',  auth()->guard('user')->user()->employmentDepartment->first()->department_id)
                ->latest()->get()->groupBy('intake_id');
            return view('cod::classes.index')->with(['intakes' => $intakes, 'classes' => $classes]);

    }

    public function viewIntakeClasses($intake)
    {

        $intakes = Intake::where('intake_id', $intake)->first();
          $classes = DB::table('classesview')
            ->where('department_id',  auth()->guard('user')->user()->employmentDepartment->first()->department_id)
            ->where('intake_id', $intake)
            ->latest()->get();

            return view('cod::classes.intakeClasses')->with(['intake' => $intakes, 'classes' => $classes]);
    }

    public function syllabi(){
        $courses = Courses::where('department_id', auth()->guard('user')->user()->employmentDepartment->first()->department_id)
            ->get();
        return view('cod::syllabus.syllabi')->with('courses', $courses);
    }

    public function courseSyllabus($id){
        $course = Courses::where('course_id', $id)->first();
        $versions = SyllabusVersion::where('course_id', $id)->latest()->get();
        return view('cod::syllabus.courseSyllabus')->with(['course' => $course, 'versions' => $versions]);
    }

    public function addCourseSyllabusVersion($id){
        $versionID = new CustomIds();
        $syllabusName = 'v.'.Carbon::now()->format('Y');
        if (SyllabusVersion::where('course_id', $id)->where('syllabus_name', $syllabusName)->exists()){
            return redirect()->back()->with('warning', 'Syllabus version already exists');
        }

        $version = new SyllabusVersion;
        $version->syllabus_id = $versionID->generateId();
        $version->course_id = $id;
        $version->syllabus_name = $syllabusName;
        $version->save();

        return redirect()->back()->with('success', 'Syllabus version created successfully');
    }

    public function viewSyllabusUnits($id){
        $syllabus = SyllabusVersion::where('syllabus_id', $id)->first();
        return view('cod::syllabus.syllabusUnits')->with(['syllabus' => $syllabus]);
    }

    public function completeSyllabus($course, $version){
       $course = Courses::where('course_id', $course)->first();
       $versions = SyllabusVersion::where('syllabus_id', $version)->first();
       $stages = CourseSyllabus::where('course_code', $course->course_code)
          ->where('version', $versions->syllabus_name)
          ->orderBy('stage', 'asc')
          ->orderBy('semester', 'asc')
          ->get()
          ->groupBy(function ($item) {
              return $item->stage . '.' . $item->semester;
          });

        return view('cod::syllabus.completeCourseSyllabus')->with(['stages' => $stages, 'course' => $course]);
    }

    public function searchUnit(Request $request) {
        $query = $request->search;

        $units = Unit::where(function ($queryBuilder) use ($query) {
            $queryBuilder->where('unit_code', 'like', $query.'%')
                        ->orWhere('unit_name', 'like', $query.'%');
        })->get();

        return response()->json($units);
    }

    public function submitSyllabusUnits(Request $request){
        $request->validate([
           'stage' => 'required|string',
           'semester' => 'required|string',
           'option' => 'required|string',
           'units' => 'required|string',
        ]);

        foreach (json_decode($request->units) as $unit){
            $syllabusUnit = CourseSyllabus::where('course_code', $request->course_code)
                                            ->where('unit_code', $unit->unit_code)
                                            ->where('version', $request->version)
                                            ->exists();
            $syllabiID = new CustomIds();
            if (!$syllabusUnit){
                $syllabus = new CourseSyllabus;
                $syllabus->course_syllabus_id = $syllabiID->generateId();
                $syllabus->course_code = $request->course_code;
                $syllabus->unit_code = $unit->unit_code;
                $syllabus->stage = $request->stage;
                $syllabus->semester = $request->semester;
                $syllabus->type = $unit->unit_type;
                $syllabus->option = $request->option;
                $syllabus->version = $request->version;
                $syllabus->save();
            }

        }

        return redirect()->back()->with('success', 'Units mounted to a semester');
    }


    public function viewSemesterUnits($id){
      $pattern = ClassPattern::where('class_pattern_id', $id)->first();
      $class = DB::table('classesview')->where('name', $pattern->class_code)->first();
      $semesterUnits = CourseSyllabus::where('course_code', $class->course_code)
          ->where('version', $class->syllabus_name)
          ->where('stage', $pattern->stage)
          ->where('semester', $pattern->pattern_id)
          ->orderBy('unit_code', 'asc')
          ->get();

        return view('cod::classes.semesterUnits')->with(['class' => $class, 'pattern' => $pattern, 'semesterUnits' => $semesterUnits]);
    }

    public function classList($id){

        $class = Classes::where('class_id', $id)->first();

        $classList = StudentView::where('current_class', $class->name)
            ->orderBy('student_number', 'asc')
            ->get();

        return view('cod::classes.classList')->with(['classList' => $classList, 'class' => $class]);
    }

    public function admitStudent($id){
        $student = StudentCourse::where('student_id', $id)->first();
        $pattern = ClassPattern::where('class_code', $student->current_class)->pluck('semester')->toArray();
        $studentClass = Classes::where('name', $student->current_class)->first();
        $units = CourseSyllabus::where('course_code', $student->StudentsCourse->course_code)
                ->where('version', $studentClass->syllabus_name)
                ->where('stage', 1)
                ->where('semester', 1)
                ->get();

        $fees = SemesterFee::where('attendance_id', $student->student_type)
                ->where('course_code', $student->StudentsCourse->course_code)
//                ->where('version', $student->version)
                ->where('semester', min($pattern))
                ->get();
//        return $fees;
        if ($fees == null) {
            return redirect()->back()->with('error', 'Oops! Course fee structure not found. Please contact the registrar');
        } else {

            $proformaInvoice = 0;

            foreach ($fees as $votehead) {
                $proformaInvoice += $votehead->amount;
            }

            $academic = Carbon::parse($student->StudentIntake->academicYear->year_start)->format('Y') . '/' . Carbon::parse($student->StudentIntake->academicYear->year_end)->format('Y');
            $period = Carbon::parse($student->StudentIntake->intake_from)->format('M') . '/' . Carbon::parse($student->StudentIntake->intake_to)->format('M');

            $nominalID = new CustomIds();
            $signed = new Nominalroll;
            $signed->nominal_id = $nominalID->generateId();
            $signed->student_id = $student->student_id;
            $signed->reg_number = $student->student_number;
            $signed->class_code = $student->current_class;
            $signed->year_study = explode('.', min($pattern))[0];
            $signed->semester_study = explode('.', min($pattern))[1];
            $signed->academic_year = $academic;
            $signed->academic_semester = strtoupper($period);
            $signed->pattern_id = 1;
            $signed->registration = 1;
            $signed->activation = 1;
            $signed->save();

            $studInvoice = new CustomIds();
            $invoice = new StudentInvoice;
            $invoice->invoice_id = $studInvoice->generateId();
            $invoice->student_id = $student->student_id;
            $invoice->reg_number = $student->student_number;
            $invoice->invoice_number = 'INV' . time();
            $invoice->stage = min($pattern);
            $invoice->amount = $proformaInvoice;
            $invoice->description = 'New Student Registration Invoice for '. min($pattern) . ' Academic Year ' . $academic;
            $invoice->save();

            foreach ($units as $unit){
                $wID = new CustomIds();
                $examinableUnit = new ExamMarks;
                $examinableUnit->exam_id = $wID->generateId();
                $examinableUnit->student_number = $student->student_number;
                $examinableUnit->class_code = $student->current_class;
                $examinableUnit->unit_code = $unit->unit_code;
                $examinableUnit->academic_year = $academic;
                $examinableUnit->academic_semester = $period;
                $examinableUnit->stage = explode('.', min($pattern))[0];
                $examinableUnit->semester = explode('.', min($pattern))[1];
                $examinableUnit->attempt = min($pattern);
                $examinableUnit->save();
            }
            return redirect()->back()->with('success', 'Student admitted and invoiced successfully');
        }
    }

    public function classPattern($id){

        $class = Classes::where('class_id', $id)->first();

        $seasons = Pattern::all();

        $patterns = ClassPattern::where('class_code', $class->name)->latest()->get();

        return view('cod::classes.classPattern')->with(['class' => $class, 'patterns' => $patterns, 'seasons' => $seasons]);
    }

    public function storeClassPattern(Request $request)
    {

        $request->validate([
            'code' => 'required',
            'stage' => 'required',
            'period' => 'required',
            'semester' => 'required',
            'year' => 'required'
        ]);

        $semester = Pattern::find($request->semester);

        $customPattern = new CustomIds();
        $generatedPatternID   =  $customPattern->generateId();
        $pattern = new ClassPattern;
        $pattern->class_pattern_id = $generatedPatternID;
        $pattern->class_code = $request->code;
        $pattern->stage = $request->stage;
        $pattern->period = $request->period;
        $pattern->academic_year = $request->year;
        $pattern->pattern_id = $request->semester;
        $pattern->semester = $request->stage . '.' . $semester->season_code;
        $pattern->save();

        return redirect()->back()->with('success', 'Class pattern record created successfully');
    }

    public function updateClassPattern(Request $request, $id)
    {

        $request->validate([
            'code' => 'required',
            'stage' => 'required',
            'period' => 'required',
            'semester' => 'required',
            'year' => 'required'
        ]);

        $semester = Pattern::find($request->semester);

        ClassPattern::where('class_pattern_id', $id)->update([
            'class_code' => $request->code,
            'stage' => $request->stage,
            'period' => $request->period,
            'academic_year' => $request->year,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'pattern_id' => $request->semester,
            'semester' => $request->stage . '.' . $semester->season_code
        ]);

        return redirect()->back()->with('success', 'Class pattern record updated successfully');
    }

    public function deleteClassPattern($id)
    {

        $hashedId = Crypt::decrypt($id);

        ClassPattern::find($hashedId)->delete();

        return redirect()->back()->with('success', 'Class pattern record deleted successfully');
    }

    public function examResults(){

        $exams = ExamResults::latest()->get();

        return view('cod::exams.index')->with(['exams' => $exams]);
    }

    public function addResults()
    {

        $students = Student::latest()->get();

        return view('cod::exams.addExam')->with(['students' => $students]);
    }

    public function submitResults(Request $request)
    {
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

    public function editResults($id)
    {

        $hashedId = Crypt::decrypt($id);

        $result = ExamResults::find($hashedId);

        return view('cod::exams.editExam')->with(['result' => $result]);
    }

    public function updateResults(Request $request, $id)
    {

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
        $transfers = CourseTransfer::where('department_id', auth()->guard('user')->user()->employmentDepartment->first()->department_id)
            ->latest()
            ->get()
            ->groupBy('intake_id');

        return view('cod::transfers.index')->with(['transfers' => $transfers]);
    }

    public function viewYearRequests($id){

     $transfers = CourseTransfer::where('department_id', auth()->guard('user')->user()->employmentDepartment->first()->department_id)
            ->where('intake_id', $id)
            ->latest()
            ->get();

        return view('cod::transfers.annualTransfers')->with(['transfers' => $transfers, 'intake' => $id]);
    }

    public function viewTransferRequest($id){
        $transfer = CourseTransfer::where('course_transfer_id', $id)->first();
        return view('cod::transfers.viewRequest')->with(['transfer' => $transfer]);
    }

    public function viewUploadedDocument($id){
        $course = CourseTransfer::where('course_transfer_id', $id)->first();
        $document = ApplicationApproval::where('reg_number', $course->studentTransfer->enrolledCourse->student_number)->first()->ApplicationsDocments;

        return response()->file('Admissions/Certificates/' . $document->certificates);
    }

    public function acceptTransferRequest($id){
        $intake = CourseTransfer::where('course_transfer_id', $id)->first()->intake_id;
        $class = CourseTransfer::where('course_transfer_id', $id)->first()->classTransfer->name;

        if (CourseTransferApproval::where('course_transfer_id', $id)->exists()) {
            CourseTransferApproval::where('course_transfer_id', $id)->update([
                'cod_status' => 1,
                'cod_remarks' => 'Student to be admitted to ' . $class . ' class.'
            ]);
        } else {
            $approval = new CourseTransferApproval;
            $approval->course_transfer_id = $id;
            $approval->cod_status = 1;
            $approval->cod_remarks = 'Student to be admitted to ' . $class . ' class.';
            $approval->save();
        }

        return redirect()->route('department.viewYearRequests', $intake)->with('success', 'Course transfer request accepted');
    }

    public function declineTransferRequest(Request $request, $id){
        $intake = CourseTransfer::where('course_transfer_id', $id)->first()->intake_id;

        if (CourseTransferApproval::where('course_transfer_id', $id)->exists()) {
           CourseTransferApproval::where('course_transfer_id', $id)->update([
               'cod_status' => 2,
               'cod_remarks' => $request->remarks
           ]);

        } else {
            $approval = new CourseTransferApproval;
            $approval->course_transfer_id = $id;
            $approval->cod_status = 2;
            $approval->cod_remarks = $request->remarks;
            $approval->save();
        }

        return redirect()->route('department.viewYearRequests', $intake)->with('success', 'Course transfer request declined');
    }

    public function requestedTransfers($id){

        $user = auth()->guard('user')->user();
        $by = $user->staffInfos->title." ".$user->staffInfos->last_name." ".$user->staffInfos->first_name." ".$user->staffInfos->miidle_name;
        $dept = DB::table('staffview')->where('user_id', $user->user_id)->first()->name;
        $role = $user->roles->first()->name;

        $transfers = CourseTransfer::where('department_id', $user->employmentDepartment->first()->department_id)
//            ->where('status', '>=', 1)
            ->where('intake_id', $id)
            ->latest()

            ->get()
            ->groupBy('course_id');

        $school = $user->employmentDepartment->first()->schools->first()->name;

        $courses = Courses::all();

        $domPdfPath = base_path('vendor/dompdf/dompdf');
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $center = ['bold' => true];

        $table = new Table(array('unit' => TblWidth::TWIP));
        foreach ($transfers as $course => $transfer) {
            foreach ($courses as $listed) {
                if ($listed->course_id == $course) {
                    $courseName =  $listed->course_name;
                    $courseCode = $listed->course_code;
                }
            }

            $headers = ['bold' => true, 'space' => ['before' => 2000, 'after' => 2000, 'rule' => 'exact']];

            $table->addRow(600);
            $table->addCell(5000, ['gridSpan' => 9,])->addText($courseName . ' ' . '(' . $courseCode . ')', $headers, ['spaceAfter' => 300, 'spaceBefore' => 300]);
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
                $name = $list->studentTransfer->enrolledCourse->student_number . "<w:br/>\n" . $list->studentTransfer->loggedStudent->sname . ' ' . $list->studentTransfer->loggedStudent->fname . ' ' . $list->studentTransfer->loggedStudent->mname;
                if ($list->approvedTransfer == null) {
                    $remarks = 'Missed Deadline';
                } else {
                    $remarks = $list->approvedTransfer->cod_remarks;
                }
                $table->addRow();
                $table->addCell(400, ['borderSize' => 1])->addText(++$key);
                $table->addCell(2700, ['borderSize' => 1])->addText($name);
                $table->addCell(1900, ['borderSize' => 1])->addText($list->studentTransfer->enrolledCourse->StudentsCourse->course_code);
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
        foreach ($transfers as $group => $transfer) {
            foreach ($courses as $listed) {
                if ($listed->course_id == $group) {
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
        $docPath = 'Fees/' . 'Transfers' . time() . ".docx";
        $my_template->saveAs($docPath);

        $contents = \PhpOffice\PhpWord\IOFactory::load($docPath);

        $pdfPath = 'Fees/' . 'Transfers' . time() . ".pdf";

//        $converter =  new OfficeConverter($docPath, 'Fees/');
//        $converter->convertTo('Transfers' . time() . ".pdf");

//        if (file_exists($docPath)) {
//            unlink($docPath);
//        }
        //
                return response()->download($docPath)->deleteFileAfterSend(true);
//        return response()->download($pdfPath)->deleteFileAfterSend(true);
    }


    public function academicLeave(){
        $requests = AcademicLeave::latest()
            ->get()
            ->groupBy('intake_id');
        return view('cod::leaves.index')->with(['leaves' => $requests]);
    }

    public function yearlyAcademicLeave($id){
        $deptID = auth()->guard('user')->user()->employmentDepartment->first()->department_id;
        $leaves = AcademicLeavesView::where('intake_id', $id)
            ->where('department_id', $deptID)
            ->latest()
            ->get();

        return view('cod::leaves.annualLeaves')->with(['leaves' => $leaves, 'intake' => $id]);
    }

    public function viewLeaveRequest($id){
        $leave = AcademicLeavesView::where('leave_id', $id)->first();
        $student = StudentView::where('student_id', $leave->student_id)->first();
        return view('cod::leaves.viewLeaveRequest')->with(['leave' => $leave, 'student' => $student]);
    }

    public function acceptLeaveRequest($id){
        $updateApproval = AcademicLeavesView::where('leave_id', $id)->first();
        AcademicLeaveApproval::where('leave_id', $id)->update([
            'cod_status' => 1,
            'cod_remarks' => 'Request accepted'
            ]);
        return redirect()->route('department.yearlyLeaves', $updateApproval->intake_id)->with('success', 'Deferment/Academic leave approved');
    }

    public function declineLeaveRequest(Request $request, $id){
            $updateApproval = AcademicLeavesView::where('leave_id', $id)->first();
            AcademicLeaveApproval::where('leave_id', $id)->update([
                'cod_status' => 2,
                'cod_remarks' => $request->remarks
            ]);
        return redirect()->route('department.yearlyLeaves', $updateApproval->intake_id)->with('success', 'Deferment/Academic leave approved');
    }

    public function readmissions(){
        $readmissions = Readmission::latest()->get()->groupBy('intake_id');
        return view('cod::readmissions.index')->with(['readmissions' => $readmissions]);
    }

    public function yearlyReadmissions($id){
        $admissions = ReadmissionsView::where('intake_id', $id)
            ->where('department_id', auth()->guard('user')->user()->employmentDepartment->first()->department_id)
            ->latest()->get();
        return view('cod::readmissions.intakeReadmissions')->with(['admissions' => $admissions]);
    }

    public function selectedReadmission($id){
      $readmision = ReadmissionsView::where('readmision_id', $id)->first();
      $patterns = ClassPattern::where('semester', $readmision->StudentsReadmission->stage)
            ->get()
            ->groupBy('class_code');
      $studentCourse = StudentCourse::where('student_id', $readmision->student_id)->first();

      if ($studentCourse->student_type == 1){
          $mode = 'S-FT';
      }elseif ($studentCourse->student_type == 2){
          $mode = 'J-FT';
      }elseif ($studentCourse->student_type == 3){
          $mode = 'S-PT';
      }elseif ($studentCourse->student_type == 4){
          $mode = 'S-EV';
      }

        if (count($patterns) == 0) {
            $classes = [];
        } else {
            foreach ($patterns as $class_code => $pattern) {

                $classes[] = Classes::where('name', $class_code)
                    ->where('course_id', $studentCourse->course_id)
                    ->where('attendance_id', $mode)
                    ->where('name', '!=',$studentCourse->current_class)
                    ->get()
                    ->groupBy('name');
            }
        }

        return view('cod::readmissions.viewSelectedReadmission')->with(['readmision' => $readmision, 'classes' => $classes]);
    }

    public function acceptReadmission(Request $request, $id){
        $request->validate([
            'class' => 'required'
        ]);
       $pattern = ClassPattern::where('class_code', $request->class)->where('semester', $request->stage)->first();
        $intake = Readmission::where('readmision_id', $id)->first()->intake_id;
        ReadmissionApproval::where('readmission_id', $id)->update([
            'cod_status' => 1,
            'cod_remarks' => 'Admit student to ' . $request->class . ' class.',
        ]);

        if (ReadmissionClass::where('readmission_id', $id)->exists()){
            ReadmissionClass::where('readmission_id', $id)->update([
                'readimission_class' => $request->class
            ]);
        }else{
            $readID = new CustomIds();
            $placement = new ReadmissionClass;
            $placement->readmission_class_id = $readID->generateId();
            $placement->readmission_id = $id;
            $placement->readmission_class = $request->class;
            $placement->readmission_year = $pattern->academic_year;
            $placement->readmission_semester = $pattern->period;
            $placement->stage = $request->stage;
            $placement->save();
        }

        return redirect()->route('department.yearlyReadmissions', $intake)->with('success', 'Readmission request accepted');
    }

    public function declineReadmission(Request $request, $id){
        $request->validate([
            'remarks' => 'required'
        ]);
        $intake = Readmission::where('readmision_id', $id)->first()->intake_id;
        ReadmissionApproval::where('readmission_id', $id)->update([
            'cod_status' => 2,
            'cod_remarks' => $request->remarks,
        ]);
        ReadmissionClass::where('readmission_id', $id)->delete();
        return redirect()->route('department.yearlyReadmissions', $intake)->with('success', 'Readmission request accepted');
    }

    public function departmentLectures(){
        $lectures = Staff::where('department_id', auth()->guard('user')->user()->employmentDepartment->first()->department_id)
                        ->get();
        return view('cod::lecturers.index')->with(['lecturers' => $lectures]);
    }

    public function lecturesQualification()
    {
        $lectures = Staff::where('department_id', auth()->guard('user')->user()->employmentDepartment->first()->department_id)
            ->whereIn('role_id', [10, 2, 4])
            ->get();
        return view('cod::lecturers.departmentalLecturers')->with(['lecturers' => $lectures]);
    }

    public function viewLecturerQualification($id){
        $user = Staff::where('user_id', $id)->first();
        return view('cod::lecturers.lecturerQualification')->with(['user' => $user]);
    }

    public function approveQualification($id){
        LecturerQualification::where('qualification_id', $id)->update(['status' => 1]);
        return redirect()->back()->with('success', 'Lecturer qualification verified successfully');
    }

    public function rejectQualification(Request $request, $id){
        $request->validate([
            'reason' => 'required'
        ]);
        LecturerQualification::where('qualification_id', $id)->update(['status' => 2]);
        $remark = new QualificationRemarks;
        $remark->qualification_id = $id;
        $remark->remarks = $request->reason;
        $remark->save();
        return redirect()->back()->with('success', 'Lecturer qualification declined successfully');
    }

    public function viewLecturerTeachingArea($id){
        $user = User::where('user_id', $id)->first();
        return view('cod::lecturers.teachingAreas')->with(['user' => $user]);
    }

    public function approveTeachingArea($id){
        TeachingArea::where('teaching_area_id', $id)->update(['status' => 1]);
        return redirect()->back()->with('success', 'Lecturer qualification verified successfully');
    }

    public function declineTeachingArea(Request $request, $id){
        TeachingArea::where('teaching_area_id', $id)->update(['status' => 2]);
        $remark = new TeachingAreaRemarks;
        $remark->teaching_area_id = $id;
        $remark->remarks = $request->reason;
        $remark->save();
        return redirect()->back()->with('success', 'Lecturer qualification declined successfully');
    }

    /*
    * Examination part
    */
    public function yearlyResults() {
        $deptID = auth()->guard('user')->user()->employmentDepartment->first()->department_id;
        $academicYears = ExamWorkflow::where('department_id', $deptID)->get()->groupBy('academic_year');
        return view('cod::exams.index')->with(['academicYears' => $academicYears]);
    }
    public function semesterResults($id){
        $deptID = auth()->guard('user')->user()->employmentDepartment->first()->department_id;
        $semesters = ExamWorkflow::where('department_id', $deptID)->where('academic_year', base64_decode($id))->latest()->get()->groupBy('academic_semester');
        return view('cod::exams.semesterResults')->with(['semesters' => $semesters, 'year' => base64_decode($id)]);
    }

    public function viewStudentResults($id){
       $results =  ModeratedResults::where('exam_approval_id', $id)
            ->orderBy('class_code', 'asc')
            ->get()
            ->groupBy(['class_code', 'unit_code', 'student_number']);
        return view('cod::exams.viewExamResults')->with(['results' => $results]);
    }
    public function declineResults(Request $request, $id){
        $request->validate([
            'remarks' => 'required|string'
        ]);

        ExamWorkflow::where('exam_approval_id', $id)->update([
            'cod_status' => 2,
            'cod_remarks' => $request->remarks
        ]);
        return redirect()->back()->with('success', 'Exam rejected Successfully');
    }
    public function approveExamResults($id){
        ExamWorkflow::where('exam_approval_id', $id)->update([
            'cod_status' => 1,
            'cod_remarks' => 'Exam results accepted',
            'dean_status' => NULL
        ]);
        return redirect()->back()->with('success', 'Exam Accepted Successfully');
    }
    public function revertExamResults($id){
        $deptResults = ExamWorkflow::where('exam_approval_id', $id)->first();
        ExamWorkflow::where('exam_approval_id', $id)->update(['cod_status' => 2]);
        $examResults = ExamMarks::where('exam_approval_id', $id)->where('academic_year', $deptResults->academic_year)->where('academic_semester', $deptResults->academic_semester)->get();
        foreach ($examResults as $result){
            ExamMarks::where('exam_approval_id', $id)->where('academic_year', $deptResults->academic_year)->where('academic_semester', $deptResults->academic_semester)->where('student_number', $result->student_number)->update([
                'exam_approval_id' => NULL
            ]);
        }
        return redirect()->back()->with('success', 'Exam results reversed successfully');
    }
    public function submitExamResults($id){
           ExamWorkflow::where('exam_approval_id', $id)->update([
            'dean_status' => 0,
           ]);
        return redirect()->back()->with('success', 'Examination Results Submitted For Dean Approval');
    }

    public function downloadResults($sem, $year)
    {
        $hashedSem = Crypt::decrypt($sem);

        $hashedYear = Crypt::decrypt($year);

        $user = Auth::guard('user')->user();

        $role = $user->roles->first()->name;

        $school = auth()->guard('user')->user()->employmentDepartment->first()->schools->first()->name;

        $dept =  auth()->guard('user')->user()->employmentDepartment->first();


        $session = ExamMarks::where('department_id', $dept->id)
            ->where('academic_semester', $hashedSem)
            ->where('academic_year', $hashedYear)
            ->first();

        $classesResults  =   ExamMarks::where('department_id', $dept->id)
            ->where('academic_semester', $hashedSem)
            ->where('academic_year', $hashedYear)
            ->latest()
            ->get()
            ->groupBy('class_code');


        $RegResults  =   ExamMarks::where('department_id', $dept->id)
            ->where('academic_semester', $hashedSem)
            ->where('academic_year', $hashedYear)
            ->latest()
            ->get()
            ->groupBy('reg_number');


        $domPdfPath = base_path('vendor/dompdf/dompdf');
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $center = ['bold' => true];

        $table = new Table(array('unit' => TblWidth::TWIP));
        $headers = ['bold' => true, 'space' => ['before' => 2000, 'after' => 2000, 'rule' => 'exact']];

        foreach ($classesResults as $class => $classesResult) {

            $RegResults  =   ExamMarks::where('department_id', $dept->id)
                ->where('academic_semester', $hashedSem)
                ->where('academic_year', $hashedYear)
                ->where('class_code', $class)
                ->latest()
                ->get()
                ->groupBy('reg_number');

            // $regs = [];
            // foreach ($RegResults as $regNumber => $examMarks) {
            //     $regs[$regNumber] = $examMarks;
            // }
            $studentDetails  = [];
            $students = Student::all();
            foreach ($students as $stud) {
                if (isset($stud->reg_number[$stud->reg_number])) {

                    $studentDetails  =  $stud;
                }
            }


            $table->addRow();
            $table->addCell(6000, ['gridSpan' => 2,])->addText($dept->name . ' ' . '(' . $class . ')', $headers, ['spaceAfter' => 150, 'spaceBefore' => 150]);

            $table->addRow();
            $table->addCell(500, ['borderSize' => 1])->addText('S/N');
            $table->addCell(2750, ['borderSize' => 1])->addText('REG NO', $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 11, 'bold' => true]);
            $table->addCell(2750, ['borderSize' => 1])->addText('NAMES', $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 11, 'bold' => true]);

            foreach ($classesResult as $key =>  $student) {
                $table->addRow();
                $table->addCell(500, ['borderSize' => 1])->addText(++$key);
                $table->addCell(2750, ['borderSize' => 1, 'gridSpan' => 4])->addText($student->reg_number, $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 13, 'bold' => true]);


                // $table->addCell(2750, ['borderSize' => 1, 'gridSpan' => 4])->addText(, $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 13, 'bold' => true]);

            }


        }

        $results = new TemplateProcessor(storage_path('results_template.docx'));

        $results->setValue('initials', $role);
        $results->setValue('name', $school);
        $results->setValue('department', $dept->name);
        $results->setValue('year', $session->first()->academic_year);
        $results->setValue('academic_semester', $session->first()->academic_semester);
        $results->setValue('class', $session->first()->class_code);
        // $results->setValue('course', $courses->course_name);
        $results->setComplexBlock('{table}', $table);
        $docPath = 'Results/' . 'Results' . time() . ".docx";
        $results->saveAs($docPath);

        $contents = \PhpOffice\PhpWord\IOFactory::load($docPath);

        $pdfPath = 'Results/' . 'Results' . time() . ".pdf";

        return response()->download($docPath)->deleteFileAfterSend(true);
    }

    public function supSpecials(){
        $units = SupplementarySpecial::where('department_id', auth()->guard('user')->user()->employmentDepartment->first()->department_id)
            ->get()
            ->groupBY(['academic_year', 'academic_semester']);
        return view('cod::supSpecial.index')->with(['units' => $units]);
    }

    public function addSupSpecials(){
//        $today = Carbon::now();
        $today = '2023-09-22';
        $intake = Intake::where('intake_from', '<=', $today)->where('intake_to', '>=', $today)->first();
        $year = AcademicYear::where('year_id', $intake->academic_year_id)->first();
        $semester = Carbon::parse($intake->intake_from)->format('M').'/'.Carbon::parse($intake->intake_to)->format('M');
        $academic = Carbon::parse($year->year_from)->format('Y').'/'.Carbon::parse($year->year_end)->format('Y');
        $units = ModeratedResults::where(DB::raw('total_cat + total_exam'), '<', 45)->orWhere('total_exam', 'ABSENT')->get()->groupBy('unit_code');
        return view('cod::supSpecial.addSupSpecial')->with(['semester' => $semester, 'academic' => $academic, 'units' => $units]);
    }

    public function storeSupSpecials(Request $request){
        $request->validate([
            'units' => 'required|array',
            'semester' => 'required|string',
            'academic' => 'required|string',
        ]);
        $supID = new CustomIds();
        foreach ($request->units as $unit){
            if (!SupplementarySpecial::where('academic_year', $request->academic)->where('academic_semester', $request->semester)->where('unit_code', $unit)->exists()){
                $supSpecial = new SupplementarySpecial;
                $supSpecial->sup_special_id = $supID->generateId();
                $supSpecial->academic_year = $request->academic;
                $supSpecial->academic_semester = strtoupper($request->semester);
                $supSpecial->department_id = auth()->guard('user')->user()->employmentDepartment->first()->department_id;
                $supSpecial->unit_code = $unit;
                $supSpecial->save();
            }
        }
        return redirect()->route('department.supSpecials')->with('success', 'Supplementary and special units updated successfully');
    }

    public function viewSupSpecial($id){
        list($year, $semester) = explode(':', base64_decode($id));
        $units = SupplementarySpecial::where('academic_year', $year)->where('academic_semester', $semester)
            ->where('department_id', auth()->guard('user')->user()->employmentDepartment->first()->department_id)
            ->orderBy('unit_code', 'asc')
            ->get();
        return view('cod::supSpecial.viewSupSpecial')->with(['units' => $units, 'year' => $year, 'semester' => $semester]);
    }

    public function deleteSupSpecialUnit($id){
        SupplementarySpecial::where('sup_special_id', $id)->delete();
        return redirect()->back()->with('success', '1 unit was removed from the schedule');
    }
}
