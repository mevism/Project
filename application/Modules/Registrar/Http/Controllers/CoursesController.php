<?php

namespace Modules\Registrar\Http\Controllers;
use App\Http\Apis\AppApis;
use App\Service\CustomIds;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Modules\Application\Entities\ApplicantAddress;
use Modules\Application\Entities\ApplicantContact;
use Modules\Application\Entities\ApplicantInfo;
use Modules\Application\Entities\ApplicantLogin;
use Modules\Application\Entities\ApplicationApproval;
use Modules\Application\Entities\ApplicationSubject;
use Modules\COD\Entities\AcademicLeavesView;
use Modules\COD\Entities\AdmissionsView;
use Modules\COD\Entities\ApplicationsView;
use Modules\COD\Entities\CourseCluster;
use Modules\COD\Entities\CourseSyllabus;
use Modules\COD\Entities\Nominalroll;
use Modules\COD\Entities\ReadmissionsView;
use Modules\COD\Entities\Unit;
use Modules\Registrar\Entities\academicdepartments;
use Modules\Examination\Entities\ModeratedResults;
use Modules\Examination\Entities\SchoolExamWorkflow;
use Modules\Registrar\Entities\Campus;
use Modules\Registrar\Entities\Classes;
use Modules\Registrar\Entities\ClusterGroup;
use Modules\Registrar\Entities\ClusterSubject;
use Modules\Registrar\Entities\Division;
use Modules\Registrar\Entities\Group;
use Modules\Registrar\Entities\SchoolDepartment;
use Modules\Student\Entities\CourseClusterGroups;
use Modules\Student\Entities\CourseSoftDelete;
use Modules\Student\Entities\CourseTransfersView;
use Modules\Student\Entities\OldStudentCourse;
use Modules\Student\Entities\StudentAddress;
use Modules\Student\Entities\StudentContact;
use Modules\Student\Entities\StudentCourse;
use Modules\Student\Entities\StudentDisability;
use Modules\Student\Entities\StudentInfo;
use Modules\Student\Entities\StudentLogin;
use Modules\Student\Entities\StudentView;
use Modules\Workload\Entities\WorkloadView;
use QrCode;
use Carbon\Carbon;
use App\Models\User;
use App\Imports\UnitImport;
use Illuminate\Http\Request;
use App\Imports\CourseImport;
use App\Imports\KuccpsImport;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Routing\Controller;
use App\Imports\UnitProgrammsImport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpWord\Element\Table;
use App\Imports\ClusterWeightsImport;
use Illuminate\Support\Facades\Crypt;
use Modules\Registrar\Entities\Event;
use Modules\Registrar\Entities\Level;
use Modules\Registrar\Entities\Intake;
use Modules\Registrar\Entities\School;
use Illuminate\Support\Facades\Storage;
use Modules\Registrar\Entities\Courses;
use Modules\Registrar\Entities\Student;
use Modules\Workload\Entities\Workload;
use Modules\Registrar\Entities\VoteHead;
use PhpOffice\PhpWord\TemplateProcessor;
use Modules\Registrar\emails\KuccpsMails;
use Modules\Student\Entities\Readmission;
use Modules\Registrar\Entities\Attendance;
use Modules\Registrar\Entities\Department;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use Modules\Application\Entities\Applicant;
use Modules\Application\Entities\Education;
use Modules\Examination\Entities\ExamMarks;
use Modules\Registrar\Entities\SemesterFee;
use Modules\Student\Entities\AcademicLeave;
use NcJoes\OfficeConverter\OfficeConverter;
use Modules\Finance\Entities\StudentInvoice;
use Modules\Registrar\Entities\AcademicYear;
use Modules\Registrar\Entities\RegistrarLog;
use Modules\Student\Entities\CourseTransfer;
use Modules\Student\Entities\StudentDeposit;
use Modules\Application\Entities\Application;
use Modules\Registrar\Entities\CourseHistory;
use Modules\Registrar\Entities\SchoolHistory;
use Modules\Registrar\Entities\UnitProgramms;
use Modules\Application\Entities\Notification;
use Modules\Examination\Entities\ExamWorkflow;
use Modules\Registrar\Entities\ClusterWeights;
use Modules\Workload\Entities\ApproveWorkload;
use Modules\Registrar\emails\AcademicLeaveMail;
use Modules\Registrar\Entities\AvailableCourse;
use Modules\Registrar\Entities\CourseLevelMode;
use Modules\Registrar\Entities\KuccpsApplicant;
use Modules\Registrar\Entities\CalenderOfEvents;
use Modules\Registrar\emails\CourseTransferMails;
use Modules\Registrar\Entities\CourseRequirement;
use Modules\Registrar\Entities\DepartmentHistory;
use Modules\Student\Entities\ReadmissionApproval;
use Modules\Registrar\emails\RejectedAcademicMail;
use Modules\Application\Entities\AdmissionApproval;
use Modules\Student\Entities\AcademicLeaveApproval;
use Modules\Student\Entities\CourseTransferApproval;
use Modules\Registrar\emails\AcceptedReadmissionsMail;
use Modules\Registrar\emails\RejectedReadmissionsMail;
use Modules\Registrar\emails\CourseTransferRejectedMails;

class CoursesController extends Controller
{
    public $appApi;
    public function __construct(AppApis $appApi)
    {
        $this->appApi  =  $appApi;
    }
    public function  yearlyExamMarks(){
        $academicYears = ExamWorkflow::latest()->get()->groupBy('academic_year');
        return view('registrar::marks.index')->with(['academicYears' => $academicYears]);
    }

    public function semesterExamMarks($id){
        $semesters = ExamWorkflow::where('academic_year', base64_decode($id))->latest()->get()->groupBy('academic_semester');
        return view('registrar::marks.semesterExamMarks')->with(['semesters' => $semesters, 'year' => base64_decode($id)]);
    }

    public function schoolExamMarks($id){
        list($year, $semester) = explode(':', base64_decode($id));
        $schools =  SchoolExamWorkflow::where('academic_year', $year)->where('academic_semester', $semester)->get()->groupBy('school_id');
        return view('registrar::marks.schoolExamMarks')->with(['schools'  =>  $schools, 'year'  =>  $year, 'semester'  =>  $semester ]);
    }

    public function viewExamMarks($id){
       $approval = SchoolExamWorkflow::where('exam_approval_id', $id)->first();
       $deptIDs = SchoolDepartment::where('school_id', $approval->school_id)->pluck('department_id');
       $departments = ExamWorkflow::whereIn('department_id', $deptIDs)->where('academic_year', $approval->academic_year)->where('academic_semester', $approval->academic_semester)->get();
       return view('registrar::marks.departmentalExamMarks')->with(['departments' => $departments, 'period' => $approval]);
    }

    public function approveExamMarks($id){
        $approval = DB::table('schoolexamworkflow')->where('exam_approval_id', $id)->first();
        $deptIDs = SchoolDepartment::where('school_id', $approval->school_id)->pluck('department_id');
        foreach ($deptIDs as $ids){
            ExamWorkflow::where('department_id', $ids)->update(['registrar_status' => 1, 'registrar_remarks' => 'Exam Marks Approved']);
        }
        return redirect()->back()->with('success', 'Exam Marks Approved Successfully');
    }

    public function declineExamMarks(Request $request, $id){
        $approval = SchoolExamWorkflow::where('exam_approval_id', $id)->first();
        $deptIDs = SchoolDepartment::where('school_id', $approval->school_id)->pluck('department_id');
        foreach ($deptIDs as $ids) {
            ExamWorkflow::where('department_id', $ids)->update(['registrar_status' => 2, 'registrar_remarks' => $request->remarks]);
        }
        return redirect()->back()->with('success', 'Exam Marks Declined');
    }

    public function revertExamMarks($id){
        $approval = SchoolExamWorkflow::where('exam_approval_id', $id)->first();
        $deptIDs = SchoolDepartment::where('school_id', $approval->school_id)->pluck('department_id');
        foreach ($deptIDs as $ids) {
            ExamWorkflow::where('exam_approval_id', $ids)->update(['dean_status' => 3]);
        }
        return redirect()->back()->with('success', 'Exam results reversed to Dean for correction');
    }

    public function submitExamMarks($id){
        $approval = SchoolExamWorkflow::where('exam_approval_id', $id)->first();
        $deptIDs = SchoolDepartment::where('school_id', $approval->school_id)->pluck('department_id');
        foreach ($deptIDs as $ids) {
            ExamWorkflow::where('department_id', $ids)->update(['status' => 1]);
        }
        return redirect()->back()->with('success', 'Exam results submitted to Dean for publishing');
    }

    public function downloadExamMarks($id, $year, $sem)
    {

        $hashedId = Crypt::decrypt($id);
        $hashedYear = Crypt::decrypt($year);
        $hashedSem = Crypt::decrypt($sem);

        $school = School::find($hashedId);

        $depts = $school->departments;

        $domPdfPath = base_path('vendor/dompdf/dompdf');
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $center = ['bold' => true, 'size' => 9, 'name' => 'Book Antiqua'];
        $table = new Table(array('unit' => TblWidth::TWIP));
        $headers = ['bold' => true, 'space' => ['before' => 2000, 'after' => 2000, 'rule' => 'exact']];

        foreach ($depts as $dept) {

            if (ExamMarks::where('department_id', $dept->id)->where('academic_year', $hashedYear)->where('academic_semester', $hashedSem)->exists()) {
                $results = ExamMarks::where('department_id', $dept->id)
                    ->where('academic_year', $hashedYear)
                    ->where('academic_semester', $hashedSem)
                    ->get()
                    ->groupBy('class_code');

                foreach ($results as $class => $result) {
                    // $table = new Table(array('unit' => TblWidth::TWIP));
                    $table->addRow();
                    $table->addCell(5900, ['borderSize' => 1, 'gridSpan' => 4])->addText($dept->name, $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 13, 'bold' => true]);
                    $table->addCell(5900, ['borderSize' => 1, 'gridSpan' => 4])->addText($class, $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 13, 'bold' => true]);

                    foreach ($result as $student) {
                        $table->addRow();
                        $table->addCell(5900, ['borderSize' => 1, 'gridSpan' => 4])->addText($student->id, $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 13, 'bold' => true]);
                        $table->addCell(5900, ['borderSize' => 1, 'gridSpan' => 4])->addText($student->reg_number, $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 13, 'bold' => true]);
                    }
                }
            }
        }

        // return $results;

        $logedUser  =  auth()->guard('user')->user()->roles->first();

        $session = ExamMarks::where('department_id', $dept->id)
            ->where('academic_year', $hashedYear)
            ->where('academic_semester', $hashedSem)
            ->first();


        $exams = ExamMarks::/* where('class_code', $result) */
            // ->where('workflow_id', $hashedId)
            /* -> */where('academic_year', $hashedYear)
            ->where('academic_semester', $hashedSem)
            ->latest()
            ->get()
            ->groupBy('reg_number');

        // $table->addRow();
        // $table->addCell(5900, ['borderSize' => 1, 'gridSpan' => 4])->addText('SEMESTER UNITS AND MARKS', $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 13, 'bold' => true]);
        // // $table->addCell(800, ['borderSize' => 1])->addText();

        // $table->addRow();
        // $table->addCell(400, ['borderSize' => 1])->addText('#', $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 11, 'bold' => true]);
        // $table->addCell(1700, ['borderSize' => 1])->addText('Reg No:', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
        // $table->addCell(3100, ['borderSize' => 1])->addText(trim('Names'), $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);

        // $table->addCell(700, ['borderSize' => 1])->addText('Sex', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);

        // $sn = 0;

        // foreach ($students as $student) {
        //     $regNo  =  $student->reg_number;

        //     $studentsDetails = Student::where('reg_number', $regNo)->first();

        //     $table->addRow();
        //     $table->addCell(400, ['borderSize' => 1])->addText(++$sn, ['name' => 'Book Antiqua', 'size' => 10]);
        //     $table->addCell(1200, ['borderSize' => 1])->addText($student->reg_number, ['name' => 'Book Antiqua', 'size' => 10]);
        //     $table->addCell(1400, ['borderSize' => 1])->addText($studentsDetails->sname . ' ' . $studentsDetails->fname . ' ' . $studentsDetails->mname, ['name' => 'Book Antiqua', 'size' => 9, 'align' => 'left']);
        //     $table->addCell(1400, ['borderSize' => 1])->addText($studentsDetails->gender, ['name' => 'Book Antiqua', 'size' => 9, 'align' => 'left']);
        // }

        $class = $session->first()->class_code;
        $parts = explode("/", $class);

        $courses = Courses::where('course_code', $parts[0])->first();

        $results = new TemplateProcessor(storage_path('results_template.docx'));

        $results->setValue('initials', $logedUser->name);
        $results->setValue('name', $school->name);
        $results->setValue('department', $depts->first()->name);
        $results->setValue('year', $session->first()->academic_year);
        $results->setValue('academic_semester', $session->first()->academic_semester);
        $results->setValue('class', $session->first()->class_code);
        $results->setValue('course', $courses->course_name);
        $results->setComplexBlock('{table}', $table);
        $docPath = 'Results/' . 'Results' . time() . ".docx";
        $results->saveAs($docPath);

        $contents = \PhpOffice\PhpWord\IOFactory::load($docPath);

        $pdfPath = 'Results/' . 'Results' . time() . ".pdf";

        //            $converter =  new OfficeConverter($docPath, 'Results/');
        //            $converter->convertTo('Results' . time() . ".pdf");

        //            if (file_exists($docPath)) {
        //                unlink($docPath);
        //            }


        //        return response()->download($pdfPath)->deleteFileAfterSend(true);

        return response()->download($docPath)->deleteFileAfterSend(true);
    }

    /* Workload */
    public function workload()
    {
        $years = AcademicYear::orderBy('year_start', 'desc')->get();
        return view('registrar::workload.index')->with(['years' => $years]);
    }

    public function schoolWorkload($id)
    {
        $year = AcademicYear::where('year_id', $id)->first();
        $academicYear = Carbon::parse($year->year_start)->format('Y') . '/' . Carbon::parse($year->year_end)->format('Y');
        $workloads = WorkloadView::where('academic_year', $academicYear)
            ->where('dean_status', 1)
            ->get()
            ->groupBy(['school_id', 'academic_semester']);
        return view('registrar::workload.schoolWorkload')->with(['year' => $year, 'workloads' => $workloads]);
    }

    public function departmentalWorkload(Request $request)
    {
        $users = User::all();
        foreach ($users as $user) {
            if ($user->hasRole('Lecturer')) {
                $lectures[] = $user;
            }
        }
        $workloads = WorkloadView::where('school_id', $request->school)
            ->where('academic_year', $request->year)
            ->where('academic_semester', $request->semester)
            ->get()
            ->groupBy(['department_id', 'user_id']);
        return view('registrar::workload.departmentalWorkload')->with(['workloads' => $workloads, 'users' => $users]);
    }

    public function viewWorkload($id)
    {

        $hashedId = Crypt::decrypt($id);

        $users = User::all();
        foreach ($users as $user) {
            if ($user->hasRole('Lecturer')) {
                $lectures[] = $user;
            }
        }
        $workloads = Workload::where('workload_approval_id', $hashedId)->get()
            ->groupBy('user_id');

        return view('registrar::workload.viewWorkload')->with(['workloads' => $workloads, 'lecturers' => $lectures,  'id' => $hashedId]);
    }

    public function approveWorkload(Request $request)
    {
        $workloadID = WorkloadView::where('school_id', $request->school)
            ->where('academic_year', $request->year)
            ->where('academic_semester', $request->semester)
            ->first()
            ->workload_approval_id;
        ApproveWorkload::where('workload_approval_id', $workloadID)->update([
            'registrar_status' => 1,
            'registrar_remarks' => 'Workload Approved',
            'status' => 0
        ]);
        return redirect()->back()->with('success', 'Workload Approved Successfully');
    }

    public function declineWorkload(Request $request)
    {
        $workloadID = WorkloadView::where('school_id', $request->school)
            ->where('academic_year', $request->year)
            ->where('academic_semester', $request->semester)
            ->first()
            ->workload_approval_id;
        ApproveWorkload::where('workload_approval_id', $workloadID)->update([
            'registrar_status' => 2,
            'registrar_remarks' => $request->remarks,
            'status' => 0
        ]);

        return redirect()->back()->with('success', 'Workload Declined');
    }

    public function submitWorkload(Request $request)
    {
        $workloadID = WorkloadView::where('school_id', $request->school)
            ->where('academic_year', $request->year)
            ->where('academic_semester', $request->semester)
            ->first()
            ->workload_approval_id;

        ApproveWorkload::where('workload_approval_id', $workloadID)->update([
            'status' => 1
        ]);
        return redirect()->back()->with('success', 'Workload approved for publishing Successfully');
    }

    public function revertWorkload(Request $request)
    {
        $workloadID = WorkloadView::where('school_id', $request->school)
            ->where('academic_year', $request->year)
            ->where('academic_semester', $request->semester)
            ->first()
            ->workload_approval_id;
        $workloads = ApproveWorkload::where('workload_approval_id', $workloadID)->get();
        foreach ($workloads  as  $workload) {
            ApproveWorkload::where('workload_approval_id', $workload->workload_approval_id)->update(['status' => 2]);
        }
        return redirect()->back()->with('success', 'Workload Reverted to Dean Successfully.');
    }

    public function printWorkload($id)
    {
        $hashedId = Crypt::decrypt($id);

        $load = ApproveWorkload::find($hashedId);

        $dept  =  $load->workloadProcessed->first()->workloadDept;

        $school = $dept->schools->first();

        $logedUser  =  auth()->guard('user')->user()->roles->first();

        $users = User::all();

        foreach ($users as $user) {
            if ($user->hasRole('Lecturer')) {

                $lecturers[] = $user;
            }
        }

        $session = Workload::where('department_id', $dept->id)->where('workload_approval_id', $hashedId)->first();

        $workloads  =  Workload::where('department_id', $dept->id)->where('workload_approval_id', $hashedId)->get()->groupBy('user_id');

        $domPdfPath = base_path('vendor/dompdf/dompdf');
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $center = ['bold' => true, 'size' => 9, 'name' => 'Book Antiqua'];
        $table = new Table(array('unit' => TblWidth::TWIP));
        $headers = ['bold' => true, 'space' => ['before' => 2000, 'after' => 2000, 'rule' => 'exact']];

        $table->addRow();
        $table->addCell(400, ['borderSize' => 1, 'vMerge' => 'restart'])->addText('#', $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 13, 'bold' => true]);
        $table->addCell(4300, ['borderSize' => 1, 'gridSpan' => 4])->addText('STAFF', $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 13, 'bold' => true]);
        $table->addCell(3400, ['borderSize' => 1, 'gridSpan' => 3])->addText('CLASS', $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 11, 'bold' => true]);
        $table->addCell(6400, ['borderSize' => 1, 'gridSpan' => 3])->addText('UNIT', $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 11, 'bold' => true]);
        $table->addCell(800, ['borderSize' => 1])->addText();

        $table->addRow();
        $table->addCell(400, ['borderSize' => 1, 'vMerge' => 'continue'])->addText('#');
        $table->addCell(1200, ['borderSize' => 1])->addText('Staff Number', $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 11, 'bold' => true]);
        $table->addCell(1400, ['borderSize' => 1])->addText('Staff Name', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
        $table->addCell(1000, ['borderSize' => 1])->addText('Qualification', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
        $table->addCell(1000, ['borderSize' => 1])->addText('Roles', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
        $table->addCell(2100, ['borderSize' => 1])->addText('Class Code', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
        $table->addCell(700, ['borderSize' => 1])->addText('Work' . "\n" . 'load', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
        $table->addCell(600, ['borderSize' => 1])->addText('Stds',  $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
        $table->addCell(1500, ['borderSize' => 1])->addText('Unit Code', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
        $table->addCell(4200, ['borderSize' => 1])->addText('Unit Name', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
        $table->addCell(700, ['borderSize' => 1])->addText('Level', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
        $table->addCell(800, ['borderSize' => 1])->addText('Signature', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);

        $sn = 0;

        foreach ($workloads as $user_id => $workload) {
            $qualifications = [];
            $roles = [];
            foreach ($lecturers as $lecturer) {
                if ($lecturer->id === $user_id) {
                    $staff = $lecturer;
                    foreach ($staff->lecturerQualfs as $qualification) {
                        $qualifications[] = $qualification->qualification;
                    }
                    foreach ($staff->roles as $role) {
                        $roles[] = $role->name;
                    }
                }
            }

            $table->addRow();
            $table->addCell(400, ['borderSize' => 1])->addText(++$sn, ['name' => 'Book Antiqua', 'size' => 10]);
            $table->addCell(1200, ['borderSize' => 1])->addText($staff->staff_number, ['name' => 'Book Antiqua', 'size' => 10]);
            $table->addCell(1400, ['borderSize' => 1])->addText($staff->title . '. ' . $staff->last_name . ' ' . $staff->first_name, ['name' => 'Book Antiqua', 'size' => 9, 'align' => 'left']);
            $table->addCell(1000, ['borderSize' => 1])->addText(implode(', ', $qualifications), ['name' => 'Book Antiqua', 'size' => 9, 'align' => 'left']);
            $table->addCell(1000, ['borderSize' => 1])->addText(implode(', ', $roles), ['name' => 'Book Antiqua', 'size' => 9, 'align' => 'left']);

            $class = $table->addCell(2100, ['borderSize' => 1]);
            $staffLoad = $table->addCell(700, ['borderSize' => 1]);
            $students = $table->addCell(600, ['borderSize' => 1]);
            $unit_code = $table->addCell(1500, ['borderSize' => 1]);
            $unit_name = $table->addCell(4200, ['borderSize' => 1]);
            $levels = $table->addCell(700, ['borderSize' => 1]);
            $signature = $table->addCell(800, ['borderSize' => 1]);

            $userLoad = $workload->count();

            foreach ($lecturers as $lecturer) {
                if ($lecturer->id === $user_id) {
                    $staff = $lecturer;
                    if ($staff->placedUser->first()->employment_terms == 'FT') {
                        for ($i = 0; $i < $userLoad; ++$i) {
                            if ($i < 3) {
                                $load = 'FT';
                                $staffLoad->addText($load, ['name' => 'Book Antiqua', 'size' => 10]);
                            } else {
                                $load = 'PT';
                                $staffLoad->addText($load, ['name' => 'Book Antiqua', 'size' => 10]);
                            }
                        }
                    } else {
                        for ($i = 0; $i < $userLoad; ++$i) {
                            if ($i < $userLoad) {
                                $load = 'PT';
                                $staffLoad->addText($load, ['name' => 'Book Antiqua', 'size' => 10]);
                            }
                        }
                    }
                }
            }

            foreach ($workload as $unit) {
                $class->addText($unit->class_code, ['name' => 'Book Antiqua', 'size' => 10]);
                $students->addText($unit->classWorkload->studentClass->count(), ['name' => 'Book Antiqua', 'size' => 10]);
                $unit_code->addText($unit->workloadUnit->unit_code, ['name' => 'Book Antiqua', 'size' => 10]);
                $unit_name->addText(substr($unit->workloadUnit->unit_name, 0, 40), ['name' => 'Book Antiqua', 'size' => 10, 'align' => 'left']);
                $levels->addText($unit->classWorkload->classCourse->level, ['name' => 'Book Antiqua', 'size' => 10]);
                $signature->addText();
            }
        }
        $workload = new TemplateProcessor(storage_path('workload_template.docx'));

        $workload->setValue('initials', $logedUser->name);
        $workload->setValue('name', $school->name);
        $workload->setValue('department', $dept->name);
        $workload->setValue('academic_year', $session->academic_year);
        $workload->setValue('academic_semester', $session->academic_semester);
        $workload->setComplexBlock('{table}', $table);
        $docPath = 'Results/' . 'Workload' . time() . ".docx";
        $workload->saveAs($docPath);

        $contents = \PhpOffice\PhpWord\IOFactory::load($docPath);

        $pdfPath = 'Results/' . 'Workload' . time() . ".pdf";

        $converter =  new OfficeConverter($docPath, 'Results/');
        $converter->convertTo('Workload' . time() . ".pdf");

        if (file_exists($docPath)) {
            unlink($docPath);
        }

        return response()->download($pdfPath)->deleteFileAfterSend(true);
    }

    public function readmissions()
    {
        $data = ReadmissionsView::all()->groupBy('intake_id');
        return  view('registrar::readmissions.index')->with(['data' => $data]);
    }

    public function yearlyReadmissions($id)
    {
        $readmissions = ReadmissionsView::where('intake_id', $id)->where('dean_status', '>', 0)->get();
        return view('registrar::readmissions.yearlyReadmissions')->with(['readmissions' => $readmissions, 'intake' => $id]);
    }

    public function acceptedReadmissions(Request $request)
    {
        $request->validate(['submit' => 'required']);
        foreach ($request->submit as $id) {
            $approval = ReadmissionsView::where('readmision_id', $id)->first();
            if ($approval->cod_status == 1) {
                StudentCourse::where('student_id', $approval->student_id)->update([
                    'current_class' => $approval->ReadmissionClass->readmission_class,
                    'status' => 1,
                ]);
                ReadmissionApproval::where('readmission_id', $id)->update([
                    'registrar_status'  =>  1
                ]);
                Readmission::where('readmision_id', $id)->update([
                    'status' => 1
                ]);
                Mail::to($approval->student_email)->send(new AcceptedReadmissionsMail($approval));
            } else {
                ReadmissionApproval::where('readmission_id', $id)->update([
                    'registrar_status'  =>  1,
                ]);
                Readmission::where('readmision_id', $id)->update([
                    'status' => 2
                ]);
                Mail::to($approval->student_email)->send(new RejectedReadmissionsMail($approval));
            }
        }

        return redirect()->back()->with('success', 'Readmission requests processed successfully.');
    }

    public function leaves()
    {
        $leaves = AcademicLeave::all()->groupBy('intake_id');
        return  view('registrar::leaves.yearlyLeaves')->with(['leaves' => $leaves]);
    }

    public function academicLeave($id)
    {
        $leaves  =  AcademicLeavesView::where('intake_id', $id)->where('dean_status', '>', 0)->get();
        return view('registrar::leaves.index')->with(['leaves' => $leaves]);
    }

    public function acceptedAcademicLeaves(Request $request)
    {
        $request->validate(['submit' => 'required']);

        foreach ($request->submit as $id) {
            $approval = AcademicLeavesView::where('leave_id', $id)->first();
            if ($approval->dean_status == 1) {
                AcademicLeaveApproval::where('leave_id', $id)->update([
                    'registrar_status'  =>  1,
                    'status'  =>  1
                ]);

                StudentCourse::where('student_id', $approval->student_id)->update([
                    'status' => 3
                ]);
                Mail::to($approval->student_email)->send(new AcademicLeaveMail($approval));
            } else {
                AcademicLeaveApproval::where('leave_id', $id)->update([
                    'registrar_status'  =>  1,
                    'status'  =>  2,
                ]);
                Mail::to($approval->student_email)->send(new RejectedAcademicMail($approval));
            }
        }

        return redirect()->back()->with('success', 'Email sent successfully.');
    }

    public function acceptedTransfers(Request $request)
    {
        $request->validate(['submit' => 'required']);
        foreach ($request->submit as $id) {
            $approval = CourseTransfersView::where('course_transfer_id', $id)->first();
            if ($approval->dean_status == 1) {
                $intake = Intake::where('intake_id', $approval->intake_id)->first();
                $registered = StudentCourse::where('intake_id', $approval->intake_id)
                    ->where('course_id', $approval->course_id)
                    ->count();
                $course = Courses::where('course_id', $approval->course_id)->first();

                $regNumber = $course->course_code . '/' . str_pad($registered + 1, 3, "0", STR_PAD_LEFT) . "J/" . Carbon::parse($intake->academicYear->year_start)->format('Y');

                $refNumber = 'TRANSFER' . time();
                $student = StudentView::where('student_id', $approval->student_id)->first();

                StudentInfo::where('student_id', $student->student_id)->first()->id_number;

                $domPdfPath = base_path('vendor/dompdf/dompdf');
                \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
                \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

                $my_template         =        new TemplateProcessor(storage_path('adm_template.docx'));

                $my_template->setValue('name', strtoupper($student->sname . ' ' . $student->fname . ' ' . $student->mname));
                $my_template->setValue('reg_number', strtoupper($regNumber));
                $my_template->setValue('date',  date('d-M-Y'));
                $my_template->setValue('ref_number', $refNumber);
                $my_template->setValue('course', strtoupper($course->course_name));
                $my_template->setValue('box', strtoupper($student->address));
                $my_template->setValue('postal_code', strtoupper($student->postal_code));
                $my_template->setValue('town', strtoupper($student->town));
                $my_template->setValue('duration', strtoupper($course->courseRequirements->course_duration));
                $my_template->setValue('department', strtoupper($course->getCourseDept->name));
                $my_template->setValue('campus', 'MAIN');
                $my_template->setValue('from', Carbon::parse($intake->intake_from)->format('D, d-m-Y'));
                $my_template->setValue('to', Carbon::parse($intake->intake_from)->addDays(4)->format('D, d-m-Y'));

                $docPath = 'AdmissionLetters/' . $refNumber . ".docx";

                $my_template->saveAs($docPath);

                $contents = \PhpOffice\PhpWord\IOFactory::load('AdmissionLetters/' . $refNumber . ".docx");

                $pdfPath = 'AdmissionLetters/' . $refNumber . ".pdf";

                if (file_exists($pdfPath)) {
                    unlink($pdfPath);
                }

                //                    $converter     =     new OfficeConverter($docPath, storage_path());
                //                    $converter->convertTo(str_replace('/', '_', $refNumber).".pdf");
                //
                //                    if(file_exists($docPath)){
                //                        unlink($docPath);
                //                    }

                $currentCourse = StudentCourse::where('student_id', $student->student_id)->first();

                $oldStudentCourse = new OldStudentCourse;
                $oldStudentCourse->student_id  = $currentCourse->student_id;
                $oldStudentCourse->student_number  = $currentCourse->student_number;
                $oldStudentCourse->reference_number  = $currentCourse->reference_number;
                $oldStudentCourse->student_type  = $currentCourse->student_type;
                $oldStudentCourse->course_id  = $currentCourse->course_id;
                $oldStudentCourse->department_id  = $currentCourse->department_id;
                $oldStudentCourse->intake_id  = $currentCourse->intake_id;
                $oldStudentCourse->current_class  = $currentCourse->current_class;
                $oldStudentCourse->entry_class  = $currentCourse->entry_class;
                $oldStudentCourse->status  = 10;
                $oldStudentCourse->save();

                $invoices  =  StudentInvoice::where('reg_number', $currentCourse->student_number)->get();

                $deposits  =  StudentDeposit::where('reg_number', $currentCourse->student_number)->get();

                DB::beginTransaction();

                try {
                    foreach ($invoices as $invoice) {
                        $invoiceId = new CustomIds();
                        $newDeposit  =  new StudentDeposit;
                        $newDeposit->invoice_id = $invoiceId->generateId();
                        $newDeposit->reg_number  =  $invoice->reg_number;
                        $newDeposit->deposit = $invoice->amount;
                        $newDeposit->description = $invoice->description;
                        $newDeposit->invoice_number = $invoice->invoice_number;
                        $newDeposit->save();
                    }

                    foreach ($deposits as $deposit) {
                        $newInvoice  =  new StudentInvoice;
                        $newInvoice->student_id  =  $student->student_id;
                        $newInvoice->reg_number  =  $deposit->reg_number;
                        $newInvoice->invoice_number = $deposit->invoice_number;
                        $newInvoice->stage = '1.1';
                        $newInvoice->amount = $deposit->deposit;
                        $newInvoice->description = $deposit->description;
                        $newInvoice->save();
                    }

                    foreach ($deposits as $invoice) {
                        $newDeposit = new StudentDeposit;
                        $newDeposit->reg_number = $regNumber;
                        $newDeposit->deposit = $invoice->deposit;
                        $newDeposit->description = $invoice->description;
                        $newDeposit->invoice_number = $invoice->invoice_number;
                        $newDeposit->save();
                    }

                    foreach ($invoices as $deposit) {
                        $newInvoice  =  new StudentInvoice;
                        $newInvoice->student_id  =  $deposit->student_id;
                        $newInvoice->reg_number  =  $regNumber;
                        $newInvoice->invoice_number = $deposit->invoice_number;
                        $newInvoice->stage = '1.1';
                        $newInvoice->amount = $deposit->amount;
                        $newInvoice->description = $deposit->description;
                        $newInvoice->save();
                    }
                    DB::commit();
                } catch (ModelNotFoundException $e) {
                    // Model not found, handle the exception (e.g., log or display a message)
                    // ...

                    // Roll back the transaction
                    DB::rollBack();
                } catch (\Exception $e) {
                    // An error occurred, handle the exception (e.g., log or display a message)
                    // ...

                    // Roll back the transaction
                    DB::rollBack();
                }

                $class = Classes::where('class_id', $approval->class_id)->first();
                $newStudCourse = new StudentCourse;
                $newStudCourse->student_id = $student->student_id;
                $newStudCourse->student_number = $regNumber;
                $newStudCourse->reference_number = $refNumber;
                $newStudCourse->student_type = 2;
                $newStudCourse->department_id = $approval->department_id;
                $newStudCourse->course_id = $approval->course_id;
                $newStudCourse->intake_id = $intake->intake_id;
                $newStudCourse->current_class = strtoupper($class->name);
                $newStudCourse->entry_class = strtoupper($class->name);
                $newStudCourse->status = 1;
                $newStudCourse->save();

                $newStudLogin = new StudentLogin;
                $newStudLogin->student_id = $student->student_id;
                $newStudLogin->username = $regNumber;
                $newStudLogin->password = Hash::make(StudentInfo::where('student_id', $student->student_id)->first()->id_number);
                $newStudLogin->save();

                Mail::to($student->email)->send(new CourseTransferMails($student, $approval, $regNumber));

                $studentNumber = $student->student_number;
                StudentLogin::where('username', $studentNumber)->delete();
                StudentCourse::where('student_number', $studentNumber)->delete();

                $nominalId = new CustomIds();
                $registration = [
                    'nominal_id' => $nominalId->generateId(),
                    'student_id' => $student->student_id,
                    'reg_number' => $regNumber,
                    'year_study' => 1,
                    'semester_study' => 1,
                    'academic_year' =>  Carbon::parse($intake->academicYear->year_start)->format('Y') . '/' . Carbon::parse($intake->academicYear->year_end)->format('Y'),
                    'academic_semester' => strtoupper(Carbon::parse($intake->intake_from)->format('MY')),
                    'pattern_id' => 1,
                    'class_code' => $newStudCourse->current_class,
                    'registration' => 1,
                    'activation' => 1
                ];
                Nominalroll::create($registration);
                CourseTransferApproval::where('course_transfer_id', $approval->course_transfer_id)
                    ->update([
                        'registrar_status'  =>  1,
                        'status' => 1
                    ]);

                CourseTransfer::where('course_transfer_id', $approval->course_transfer_id)
                    ->update([
                        'status' => 1
                    ]);
            } else {

                $transfer = CourseTransfersView::where('course_transfer_id', $id)->first();

                $oldStudent = StudentView::where('student_id', $transfer->student_id)->first();

                Mail::to($oldStudent->email)->send(new CourseTransferRejectedMails($oldStudent));

                CourseTransferApproval::where('course_transfer_id', $approval->course_transfer_id)
                    ->update([
                        'registrar_status'  =>  1,
                        'status' => 1
                    ]);

                CourseTransfer::where('course_transfer_id', $approval->course_transfer_id)
                    ->update([
                        'status' => 3
                    ]);
            }
        }

        return redirect()->back()->with('success', 'Course Transfer Letters Generated');
    }

    public function transfer($id)
    {
        $transfers  =  CourseTransfersView::where('intake_id', $id)
            ->where('dean_status', '!=', null)
            ->get();
        return view('registrar::transfers.index')->with(['transfer' => $transfers, 'intake' => $id]);
    }

    public function yearly()
    {
        $data = CourseTransfer::get()->groupBy('intake_id');
        return  view('registrar::transfers.yearlyTransfers')->with(['data' => $data]);
    }

    public function requestedTransfers($id)
    {
        $user = auth()->guard('user')->user();
        $by = $user->staffInfos->title . " " . $user->staffInfos->last_name . " " . $user->staffInfos->first_name . " " . $user->staffInfos->miidle_name;
        $role = $user->roles->first()->name;
        $school  =  "UNIVERSITY INTER/INTRA FACULTY COURSE TRANSFERS";
        $dept = 'ACADEMIC AFFAIRS';

        $transfers = DB::table('coursetransfersview')->where('intake_id', $id)
            ->where('dean_status', '>=', 1)
            ->get()
            ->groupBy('course_id');

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
            $table->addCell(200, ['borderSize' => 1])->addText('#');
            $table->addCell(2800, ['borderSize' => 1])->addText('Student Name/ Reg. Number', $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 11, 'bold' => true]);
            $table->addCell(1900, ['borderSize' => 1])->addText('Programme/ Course Admitted', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
            $table->addCell(1900, ['borderSize' => 1])->addText('Programme/ Course Transferring', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
            $table->addCell(1750, ['borderSize' => 1])->addText('Programme/ Course Cut-off Points', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
            $table->addCell(1000, ['borderSize' => 1])->addText('Student Cut-off Points', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
            $table->addCell(2600, ['borderSize' => 1])->addText('COD Remarks', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
            $table->addCell(1500, ['borderSize' => 1])->addText('Dean Remarks',  $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
            $table->addCell(1750, ['borderSize' => 1])->addText('Deans Committee Remarks', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);

            foreach ($transfer as $key => $list) {
                $name = $list->student_number . "<w:br/>\n" . $list->sname . ' ' . $list->fname . ' ' . $list->mname;
                $student_id = DB::table('coursetransfersview')->where('student_id', $list->student_id)
                    ->first()->student_id;
                $student = StudentView::where('student_id', $student_id)->first();
                if ($list->cod_status == null) {
                    $remarks = 'Missed Deadline';
                    $deanRemark = 'Declined';
                } else {
                    $remarks = $list->cod_remarks;
                    $deanRemark = $list->dean_remarks;
                }
                $table->addRow();
                $table->addCell(200, ['borderSize' => 1])->addText(++$key);
                $table->addCell(2800, ['borderSize' => 1])->addText($name);
                $table->addCell(1900, ['borderSize' => 1])->addText($student->course_code);
                $table->addCell(1900, ['borderSize' => 1])->addText($list->course_code);
                $table->addCell(1750, ['borderSize' => 1])->addText($list->class_points);
                $table->addCell(1000, ['borderSize' => 1])->addText($list->student_points);
                $table->addCell(2600, ['borderSize' => 1])->addText($remarks);
                $table->addCell(1500, ['borderSize' => 1])->addText($deanRemark);
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

        //        $pdfPath = 'Fees/' . 'Transfers' . time() . ".pdf";
        //
        //        $converter =  new OfficeConverter($docPath, 'Fees/');
        //        $converter->convertTo('Transfers' . time() . ".pdf");
        //
        //        if (file_exists($docPath)) {
        //            unlink($docPath);
        //        }

        return response()->download($docPath)->deleteFileAfterSend(true);
        //        return response()->download($pdfPath)->deleteFileAfterSend(true);
    }

    /**
     * academic calender
     *
     * @returnvoid
     */

    public function addCalenderOfEvents()
    {
        $academicyear  =  AcademicYear::latest()->get();
        $events        =  Event::all();

        return view('registrar::eventsCalender.addCalenderOfEvents')->with(['academicyear'  =>  $academicyear, 'events'  => $events]);
    }

    public function showCalenderOfEvents()
    {
        $calender  = CalenderOfEvents::latest()->get();

        return view('registrar::eventsCalender.showCalenderOfEvents')->with(['calender' => $calender]);
    }

    public function storeCalenderOfEvents(Request $request)
    {
        $data = new CalenderOfEvents();
        $data->academic_year_id =  $request->input('academicyear');
        $data->intake_id =  $request->input('semester');
        $data->event_id =  $request->input('events');
        $data->start_date =  $request->input('start_date');
        $data->end_date =  $request->input('end_date');

        $data->save();

        return redirect()->route('courses.showCalenderOfEvents')->with('success', 'Calender created successfuly.');
    }

    public function editCalenderOfEvents($id)
    {
        $hashedId  =  Crypt::decrypt($id);
        $academicyear  =  AcademicYear::latest()->get();
        $intakes =  Intake::all();
        $events =  Event::all();
        $data =  CalenderOfEvents::find($hashedId);

        return view('registrar::eventsCalender.editCalenderOfEvents')->with(['data' => $data, 'academicyear' => $academicyear, 'events' => $events, 'intakes' => $intakes]);
    }

    public function updateCalenderOfEvents(Request $request, $id)
    {
        $hashedId  =  Crypt::decrypt($id);

        $data                 =         CalenderOfEvents::find($hashedId);
        $data->academic_year_id =  $request->input('academicyear');
        $data->intake_id =  $request->input('semester');
        $data->event_id =  $request->input('events');
        $data->start_date =  $request->input('start_date');
        $data->end_date =  $request->input('end_date');
        $data->update();

        return redirect()->route('courses.showCalenderOfEvents')->with('status', 'Data Updated Successfully');
    }

    public function destroyCalenderOfEvents($id)
    {
        $data         =       CalenderOfEvents::find($id)->delete();

        return redirect()->route('courses.showCalenderOfEvents');
    }

    /**
     * Events
     *
     * @returnvoid
     */
    public function addEvent()
    {
        return view('registrar::events.addEvent');
    }

    public function showEvent()
    {
        $events   =  Event::latest()->get();
        return view('registrar::events.showEvent', compact('events'));
    }

    public function storeEvent(Request $request)
    {
        $events = new Event();
        $events->name =  $request->input('name');
        $events->save();

        return redirect()->route('courses.showEvent')->with('success', 'Event created successfuly.');
    }

    public function editEvent($id)
    {

        $hashedId = Crypt::decrypt($id);
        $data = Event::find($hashedId);
        return view('registrar::events.editEvent')->with(['data' => $data]);
    }

    public function updateEvent(Request $request, $id)
    {
        $data              =      Event::find($id);
        $data->name        =      $request->input('name');
        $data->update();

        return redirect()->route('courses.showEvent')->with('success', 'Event updated successfully.');
    }

    public function destroyEvent($id)
    {
        $data         =       Event::find($id);
        $data->delete();
        return redirect()->route('courses.showEvent');
    }

    public function getVoteheads(Request $request){
        $query = $request->input('query');
        $dataPayload = $this->appApi->fetchVoteheads();
        $filteredVoteheads = array_filter($dataPayload, function ($votehead) use ($query) {
            $nameMatch = stripos($votehead['name'], $query) !== false;
            $idMatch = stripos($votehead['id'], $query) !== false;
            return $nameMatch || $idMatch;
        });
        $filteredDataPayload = [
            'data' => array_values($filteredVoteheads), // Reset array keys for correct JSON formatting
        ];
        return response()->json($filteredDataPayload);
    }

    public function voteheads(){
        return view('registrar::fee.voteheads');
    }

    public function showVoteheads(){
        $show = VoteHead::latest()->get();
        return view('registrar::fee.showVoteheads')->with(['show' => $show]);
    }

    public function storeVoteheads(Request $request){
       $votes = json_decode($request->voteheads);

        foreach ($votes as $vote){
            $voteID = new CustomIds();
            $voteheads  = new VoteHead;
            $voteheads->votehead_id = $voteID->generateId();
            $voteheads->vote_id = $vote->votehead;
            $voteheads->vote_name = $vote->voteheadName;
            $voteheads->vote_category = $vote->voteheadCategory;
            $voteheads->vote_type = $vote->voteheadType;
            $voteheads->save();
        }
        return redirect()->route('courses.showVoteheads')->with('success', 'votehead added successfully.');
    }

    public function editVotehead($id){
        $data = VoteHead::where('votehead_id', $id)->first();
        return view('registrar::fee.editVotehead')->with(['data' => $data]);
    }

    public function updateVotehead(Request $request, $id){
        VoteHead::where('votehead_id', $id)->update([
            'vote_name' => $request->name,
            'vote_id' => $request->voteID,
            'vote_category' => $request->category,
            'vote_type' => $request->type,]);
        return redirect()->route('courses.showVoteheads')->with('status', 'Data Updated Successfully');
    }

    public function destroyVotehead($id){
        VoteHead::where('votehead_id', $id)->delete();
        return redirect()->back()->with('success', '1 record destroyed successfully');
    }
    public function semFee($id){
        $course = Courses::where('course_id', $id)->first();
        $modes    =  Attendance::all();
        $syllabus = CourseSyllabus::where('course_code', $course->course_code)
            ->get()
            ->groupBy('stage')
            ->map(function ($group, $stage) {
                return $group->pluck('semester')->map(function ($semester) use ($stage) {
                    return $stage . '.' . $semester;
                });
            })
            ->flatten()
            ->unique()
            ->values()
            ->toArray();
        $votes    =  VoteHead::where('vote_category', 1)->orderBy('vote_id', 'asc')->get();

        return view('registrar::fee.semFee')->with(['modes' => $modes, 'votes' => $votes, 'syllabus' => $syllabus, 'course' => $course]);
    }
    public function showSemFee(){
        $courses  = Courses::latest()->get();
        return view('registrar::fee.showsemFee')->with(['courses' => $courses]);
    }
    public function courseFeeStures($id){
        $course = Courses::where('course_id', $id)->first();
        $feeStructures = SemesterFee::where('course_code', $course->course_code)
            ->get()
            ->groupBy(['attendance_id', 'version']);
        return view('registrar::fee.courseFeeStuctures')->with(['feeSstructures' => $feeStructures, 'course' => $course]);
    }
    public function storeSemFee(Request $request){
        $request->validate([
            'attendance' => 'required',
            'semesterFee' => 'required'
        ]);
//        return $request->attendance;
        $feeStructure = json_decode($request->semesterFee, true);
        foreach ($feeStructure as $votehead){
            foreach ($votehead['semesters'] as $semester){
                $feeId = new CustomIds();
                SemesterFee::create([
                    'semester_fee_id' => $feeId->generateId(),
                    'course_code' => $request->course_code,
                    'vote_id' => $votehead['votehead'],
                    'semester' => $semester,
                    'attendance_id' => $request->attendance,
                    'amount' => $votehead['amount'],
                    'version' => 'v.'.date('Y'),
                ]);
            }
        }
        return redirect()->route('courses.showSemFee')->with('success', 'Fee added successfully.');
    }

    public function viewSemFee($id){
        list($course_code, $attendance, $version) = explode(':', base64_decode($id));
        $course = Courses::where('course_code', $course_code)->first();
        $semesterFees = SemesterFee::where('course_code', $course_code)
            ->where('attendance_id', $attendance)
            ->where('version', $version)
            ->orderBy('semester', 'asc')
            ->get()
            ->groupBy('vote_id')
            ->map(function ($group) {
                return $group->groupBy('semester');
            });

        $semesters = SemesterFee::where('course_code', $course_code)
            ->where('attendance_id', $attendance)
            ->where('version', $version)
            ->orderBy('semester', 'asc')
            ->get()
            ->groupBy('semester')
            ->map(function ($group) {
                return $group->groupBy('vote_id');
            });

        return view('registrar::fee.viewSemFee')->with(['semesters' => $semesters, 'semesterFees' => $semesterFees, 'course' => $course]);
    }

    public function printFee($id)
    {
        $course =  CourseLevelMode::where('course_level_mode_id', $id)->first();
        $semester = SemesterFee::where('course_level_mode_id', $id)->orderBy('votehead_id', 'asc')->get();

        $semester1 = 0;
        $semester2 = 0;

        foreach ($semester as $fee) {

            $semester1 += $fee->semesterI;

            $semester2 += $fee->semesterII;
        }

        $image = time() . '.png';

        $route = route('courses.printFee', $id);

        QrCode::size(200)
            ->format('png')
            ->generate($route, 'QrCodes/' . $image);

        $domPdfPath = base_path('vendor/dompdf/dompdf');
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $boldedtext = array('bold' => true, 'size' => 12);
        $boldedtext1 = array('align' => 'right', 'size' => 12);

        $table = new Table(array('unit' => TblWidth::TWIP));
        foreach ($semester as $detail) {
            $table->addRow();
            $table->addCell(5000, ['borderSize' => 2])->addText($detail->semVotehead->name,  $boldedtext1, ['name' => 'Book Antiqua', 'size' => 13]);
            $table->addCell(2000, ['borderSize' => 2])->addText(number_format($detail->semesterI, 2), $boldedtext1, array('align' => 'right', 'size' => 12));
            $table->addCell(2000, ['borderSize' => 2])->addText(number_format($detail->semesterII, 2), $boldedtext1, array('align' => 'right', 'size' => 12));
        }
        $table->addRow();
        $table->addCell(3000, ['borderSize' => 2])->addText("TOTAL PAYABLE FEE", $boldedtext);
        $table->addCell(3000, ['borderSize' => 2])->addText(number_format($semester1, 2), $boldedtext, array('align' => 'right', 'size' => 12));
        $table->addCell(3000, ['borderSize' => 2])->addText(number_format($semester2, 2), $boldedtext, array('align' => 'right', 'size' => 12));

        $my_template = new TemplateProcessor(storage_path('fee_structure.docx'));

        $my_template->setValue('course', strtoupper($course->courseclm->course_name));
        $my_template->setComplexBlock('{table}', $table);
        $my_template->setValue('mode', $course->modeofstudy->attendance_code);
        $docPath = 'FeeStructure/' . $course->courseclm->course_code . ".docx";
        $my_template->setImageValue('qr', array('path' => 'QrCodes/' . $image, 'width' => 80, 'height' => 80, 'ratio' => true));
        $my_template->saveAs($docPath);

        $pdfPath = 'FeeStructure/' . $course->courseclm->course_code . ".pdf";

        $convert = new OfficeConverter('FeeStructure/' . $course->courseclm->course_code . ".docx", 'FeeStucture/');
        $convert->convertTo($course->courseclm->course_code . ".pdf");

        if (file_exists($docPath)) {
            unlink($docPath);
        }

        unlink('QrCodes/' . $image);

        return response()->download($pdfPath)->deleteFileAfterSend(true);
    }

    public function createUnits(Request $request, $id)
    {
        return $hashedId  =  Crypt::decrypt($id);
        $course = Courses::where('course_id', $hashedId)->first();

        return view('registrar::offer.createUnits', compact('course'));
    }

    public function storeCreatedUnits(Request $request)
    {
        $request->validate([
            'course_unit_code'           =>       'required|unique:unit_programms',
            'unit_name'                =>       'required|unique:unit_programms',
            'stage'                =>       'required',
            'semester'                =>       'required',
            'type'                =>       'required'


        ]);
        $units  =  new Unit;
        $units->colSubjectId   =   $request->input('course_unit_code');
        $units->colSubjectName   =   $request->input('unit_name');
        $units->save();

        $unitprogram  =  new UnitProgramms;
        $unitprogram->course_code   =   $request->input('course_code');
        $unitprogram->course_unit_code   =   $request->input('course_unit_code');
        $unitprogram->unit_name   =   $request->input('unit_name');
        $unitprogram->stage   =   $request->input('stage');
        $unitprogram->semester   =   $request->input('semester');
        $unitprogram->type   =   $request->input('type');
        $unitprogram->save();
        return redirect()->back()->with('success', 'Good');
    }

    public function importExportclusterWeights()
    {
        $clusters        =        ClusterWeights::all();
        return view('registrar::offer.clusterweights')->with('clusters', $clusters);
    }

    public function importclusterWeights(Request $request)
    {
        $vz        =          $request->validate([
            'excel_file'   =>    'required|mimes:xlsx,csv'
        ]);
        $excel_file         =         $request->excel_file;
        Excel::import(new ClusterWeightsImport(), $excel_file);

        return back()->with('success', 'Data Imported Successfully');
    }

    public function acceptApplication($id)
    {
        $app = ApplicationApproval::where('application_id', $id)->first();
        $app->registrar_status   =  1;
        $app->save();

        //        $logs = new     RegistrarLog;
        //        $logs->application_id = $app->id;
        //        $logs->user = Auth::guard('user')->user()->name;
        //        $logs->user_role = Auth::guard('user')->user()->role_id;
        //        $logs->activity = 'Application accepted';
        //        $logs->save();
        return redirect()->route('courses.applications')->with('success', '1 applicant approved');
    }

    public function rejectApplication(Request $request, $id)
    {
        $app = ApplicationApproval::where('application_id', $id)->first();
        $app->registrar_status = 2;
        $app->registrar_comments = $request->comment;
        $app->save();

        //        $logs                      =       new RegistrarLog;
        //        $logs->application_id              =       $app->id;
        //        $logs->user                =       Auth::guard('user')->user()->name;
        //        $logs->user_role           =       Auth::guard('user')->user()->role_id;
        //        $logs->activity            =       'Application rejected';
        //        $logs->comments            =       $request->comment;
        //        $logs->save();

        return redirect()->route('courses.applications')->with('success', 'Application declined');
    }

    public function preview($id)
    {
        $app                       =        Application::find($id);
        $school                    =        Education::where('applicant_id', $app->applicant->id)->first();
        return view('registrar::offer.preview')->with(['app' => $app, 'school' => $school]);
    }

    public function viewApplication($id)
    {
        $app = ApplicationsView::where('application_id', $id)->first();
        $school = Education::where('applicant_id', $app->applicant_id)->get();
        return view('registrar::offer.viewApplication')->with(['app' => $app, 'school' => $school]);
    }

    public function accepted()
    {
        $kuccps = KuccpsApplicant::where('status', 0)->get();
        foreach ($kuccps as $applicant) {

            $campus = Campus::where('name', 'MAIN CAMPUS')->first();
            $course = Courses::where('course_code', $applicant->kuccpsApplication->course_code)->first();
            $regNumber = Application::where('course_id', $course->course_id)
                ->where('intake_id', $applicant->kuccpsApplication->intake_id)
                ->where('student_type', 2)
                ->count();

            $studentNumber = $applicant->kuccpsApplication->course_code . "/" . str_pad($regNumber + 1, 3, "0", STR_PAD_LEFT) . "J/" . Carbon::parse($applicant->kuccpsApplication->kuccpsIntake->intake_from)->format('Y');

            ApplicantInfo::create([
                'applicant_id' => $applicant->applicant_id,
                'fname' => $applicant->fname,
                'mname' => $applicant->mname,
                'sname' => $applicant->sname,
                'gender' => $applicant->gender,
                'index_number' => $applicant->index_number
            ]);

            ApplicantLogin::create([
                'applicant_id' => $applicant->applicant_id,
                'username' => $applicant->index_number,
                'password' => Hash::make($applicant->index_number),
                'phone_verification' => 1,
                'student_type' => 2,
                'email_verified_at' => Carbon::parse()->format('Y-m-d')
            ]);

            ApplicantContact::create([
                'applicant_id' => $applicant->applicant_id,
                'email' => $applicant->email,
                'alt_email' => $applicant->alt_email,
                'mobile' => $applicant->mobile,
                'alt_mobile' => $applicant->alt_mobile,
            ]);

            ApplicantAddress::create([
                'applicant_id' => $applicant->applicant_id,
                'town' => $applicant->town,
                'address' => $applicant->BOX,
                'postal_code' => $applicant->postal
            ]);

            $app = new CustomIds();
            $application_id = $app->generateId();
            $application_No = 'APP' . time();

            Application::create([
                'application_id' => $application_id,
                'applicant_id' => $applicant->applicant_id,
                'ref_number' => $application_No,
                'intake_id' => $applicant->kuccpsApplication->intake_id,
                'student_type' => 2,
                'campus_id' => $campus->campus_id,
                'school_id' => $course->getCourseDept->schools->first()->school_id,
                'department_id' => $course->department_id,
                'course_id' => $course->course_id,
                'declaration' => 1,
            ]);

            ApplicationApproval::create([
                'application_id' => $application_id,
                'applicant_id' => $applicant->applicant_id,
                'finance_status' => 1,
                'invoice_number' => 'KUCCPS',
                'cod_status' => '1',
                'cod_comments' => 'KUCCPS approved',
                'dean_status' => 1,
                'dean_comments' => 'KUCCPS approved',
                'registrar_status' => 3,
                'registrar_comments' => 'KUCCPS approved',
                'reg_number' => $studentNumber,
                'admission_letter' => $application_No . ".docx"
            ]);

            ApplicationSubject::create([
                'application_id' => $application_id, 'subject_1' => 'KUCCPS', 'subject_2' => 'KUCCPS', 'subject_3' => 'KUCCPS', 'subject_4' => 'KUCCPS'
            ]);

            $domPdfPath     =    base_path('vendor/dompdf/dompdf');
            \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
            \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

            $my_template = new TemplateProcessor(storage_path('adm_template.docx'));
            $my_template->setValue('name', strtoupper($applicant->sname . " " . $applicant->mname . " " . $applicant->fname));
            $my_template->setValue('box', strtoupper($applicant->BOX));
            $my_template->setValue('address', strtoupper($applicant->address));
            $my_template->setValue('postal_code', strtoupper($applicant->postal_code));
            $my_template->setValue('town', strtoupper($applicant->town));
            $my_template->setValue('course', strtoupper($applicant->kuccpsApplication->course_name));
            $my_template->setValue('department', strtoupper($course->getCourseDept->name));
            $my_template->setValue('department', strtoupper($course->getCourseDept->name));
            $my_template->setValue('campus', strtoupper($campus->name));
            $my_template->setValue('duration', strtoupper($course->courseRequirements->course_duration));
            $my_template->setValue('from', Carbon::parse($applicant->kuccpsApplication->kuccpsIntake->intake_from)->format('d-m-Y'));
            $my_template->setValue('to', Carbon::parse($applicant->kuccpsApplication->kuccpsIntake->intake_to)->format('d-m-Y'));
            $my_template->setValue('reg_number', strtoupper($studentNumber));
            $my_template->setValue('ref_number', $application_No);
            $my_template->setValue('date',  date('d-M-Y'));
            $docPath = 'AdmissionLetters/' . $application_No . ".docx";
            $my_template->saveAs($docPath);

            $contents = \PhpOffice\PhpWord\IOFactory::load($docPath);
            $pdfPath = 'AdmissionLetters/' . $application_No . ".pdf";

            if (file_exists($pdfPath)) {
                unlink($pdfPath);
            }

            //            $converter = new OfficeConverter('AdmissionLetters/'. ".docx", 'AdmissionLetters/');
            //            $converter->convertTo($application_No.".pdf");

            //            if (file_exists($docPath)) {
            //                unlink($docPath);
            //            }

            Application::where('applicant_id', $applicant->applicant_id)->update(['status' => 0]);
            KuccpsApplicant::where('applicant_id', $applicant->applicant_id)->update(['status' => 1]);
            if ($applicant->email != null) {
                Mail::to($applicant->email)->send(new KuccpsMails($applicant));
            }
        }
        return redirect()->back()->with('success', 'Admission letters generated and emails send');
    }

    public function index()
    {
        return view('registrar::index');
    }

    public function approveIndex()
    {
        return view('registrar::approval.approveIndex');
    }

    public function importUnitProgramms()
    {
        $up = UnitProgramms::all();
        return view('registrar::offer.unitprog')->with('up', $up);
    }

    public function importUnit()
    {
        $units        =          Unit::all();
        return view('registrar::offer.unit')->with('units', $units);
    }

    public function importExportCourses()
    {
        $courses        =        Courses::all();
        return view('registrar::course.importExportCourses')->with('courses', $courses);
    }

    public function importCourses(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx'
        ]);
        $excel_file = $request->excel_file;
        Excel::import(new CourseImport(), $excel_file);
        return back()->with('success', 'Data Imported Successfully');
    }

    public function importExportViewkuccps()
    {
        $intakes        =        Intake::where('status', 1)->get();
        $newstudents    =         KuccpsApplicant::where('status', 0)->get();
        return view('registrar::offer.kuccps')->with(['intakes' => $intakes, 'new' => $newstudents]);
    }

    public function importUnitProg(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx'
        ]);

        $excel_file = $request->excel_file;
        Excel::import(new UnitProgrammsImport(), $excel_file);
        return back()->with('success', 'Data Imported Successfully');
    }

    public function importUnits(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx'
        ]);

        $excel_file         =         $request->excel_file;
        Excel::import(new UnitImport(), $excel_file);
        return back()->with('success', 'Data Imported Successfully');
    }

    public function importkuccps(Request $request)
    {
        $request->validate([
            'excel_file'   =>    'required|mimes:xlsx'
        ]);
        $excel_file = $request->excel_file;
        $intake_id  = $request->intake;
        Excel::import(new KuccpsImport($intake_id), $excel_file);

        return back()->with('success', 'Data Imported Successfully');
    }

    public function applications()
    {
        $accepted = ApplicationsView::where('registrar_status', '>=', 0)
            ->where('registrar_status', '!=', 3)
            ->where('registrar_status', '!=', 4)
            ->latest()
            ->get();
        return view('registrar::offer.applications')->with('accepted', $accepted);
    }

    public function showKuccps()
    {
        $kuccps = KuccpsApplicant::latest()->get();
        return view('registrar::offer.showKuccps')->with(['kuccps' => $kuccps]);
    }

    public function offer()
    {
        $intake = Intake::where('status', 1)->first();
        $courses = DB::table('COURESONOFFERVIEW')->where('intake_id', $intake->intake_id)
            ->latest()->get();

        return view('registrar::offer.coursesOffer')->with(['courses' => $courses]);
    }

    public function profile()
    {
        return view('registrar::profilepage');
    }

    public function acceptedMail(Request $request)
    {
        $request->validate([
            'submit' => 'required'
        ]);
        foreach ($request->submit as $id) {
            $app = ApplicationsView::where('application_id', $id)->first();

            if ($app->registrar_status == 1 && $app->cod_status == 1) {

                $regNo = ApplicationsView::where('course_id', $app->course_id)
                    ->where('intake_id', $app->intake_id)
                    ->where('student_type', 1)
                    ->where('registrar_status', 3)
                    ->count();
                $studentNumber = $app->DepartmentCourse->course_code . "/" . str_pad(1 + $regNo, 4, "0", STR_PAD_LEFT) . "/" . Carbon::parse($app->ApplicationIntake->intake_from)->format('Y');

                $domPdfPath        =         base_path('vendor/dompdf/dompdf');
                \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
                \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

                $my_template = new TemplateProcessor(storage_path('adm_template.docx'));
                $my_template->setValue('name', strtoupper($app->sname . " " . $app->mname . " " . $app->fname));
                $my_template->setValue('box', strtoupper($app->address));
                $my_template->setValue('postal_code', strtoupper($app->postal_code));
                $my_template->setValue('town', strtoupper($app->town));
                $my_template->setValue('course', $app->DepartmentCourse->course_name);
                $my_template->setValue('department', $app->DepartmentCourse->getCourseDept->name);
                $my_template->setValue('duration', $app->DepartmentCourse->courseRequirements->course_duration);
                $my_template->setValue('from', Carbon::parse($app->ApplicationIntake->intake_from)->format('d-m-Y'));
                $my_template->setValue('to', Carbon::parse($app->ApplicationIntake->intake_from)->addDays(4)->format('d-m- Y'));
                $my_template->setValue('campus', $app->ApplcationCampus->name);
                $my_template->setValue('reg_number', $studentNumber);
                $my_template->setValue('ref_number', $app->ref_number);
                $my_template->setValue('date',  date('d-M-Y'));
                $docPath = "AdmissionLetters/". str_replace('/', '', $app->ref_number) . ".docx";
                $my_template->saveAs($docPath);

                $contents = \PhpOffice\PhpWord\IOFactory::load($docPath);

                $pdfPath =  'AdmissionLetters/'.str_replace('/', '', $app->ref_number).".pdf";

                if (file_exists($pdfPath)) {
                    unlink($pdfPath);
                }

                //                $converter = new OfficeConverter('AdmissionLetters/'.$app->ref_number.".docx",'AdmissionLetters/');
                //                $converter->convertTo('AdmissionLetters/'.$app->ref_number.".pdf");

                //                if (file_exists($docPath)) {
                //                    unlink($docPath);
                //                }

                $update = ApplicationApproval::where('application_id', $id)->first();
                $update->registrar_status = 3;
                $update->registrar_comments = 'Admission letter generated';
                $update->reg_number = $studentNumber;
                $update->admission_letter = str_replace('/', '', $app->ref_number).".docx";
                $update->save();

                $status = Application::where('application_id', $id)->first();
                $status->status = 0;
                $status->save();

                //                $comms = new Notification;
                //                $comms->application_id = $id;
                //                $comms->role_id = Auth::guard('user')->user()->role_id;
                //                $comms->subject = 'Application Approval Process';
                //                $comms->comment = 'Congratulations! Your application was successful. Got to My Courses section to download your admission letter.';
                //                $comms->status = 1;
                //                $comms->save();

                Mail::to($app->email)->send(new \App\Mail\RegistrarEmails($app));
            }
            //            if ($app->finance_status == 3 && $app->registrar_status == 1) {
            //
            //                $update          =         Application::find($id);
            //                $update->finance_status         =       0;
            //                $update->registrar_status       =       NULL;
            //                $update->save();
            //            }
            if ($app->cod_status == 1 && $app->registrar_status == 2) {

                ApplicationApproval::where('application_id', $id)->update(['dean_status' => 3, 'registrar_status' => 4]);
            }
            if ($app->cod_status == 2 && $app->registrar_status == 2) {

                ApplicationApproval::where('application_id', $id)->update(['dean_status' => 3, 'registrar_status' => 4]);
            }
            if ($app->cod_status == 2 && $app->registrar_status == 1) {
                $update = ApplicationApproval::where('application_id', $id)->first();
                $update->registrar_status = 3;
                $update->save();

                //                $comms = new Notification;
                //                $comms->application_id = $id;
                //                $comms->role_id = Auth::guard('user')->user()->role_id;
                //                $comms->subject = 'Application Approval Process';
                //                $comms->comment = 'Oops! Your application was not successful. You can go to Courses on offer section and apply for another course that you meet the minimum course requirements.';
                //                $comms->status = 1;
                //                $comms->save();
                Mail::to($app->email)->send(new \App\Mail\RegistrarEmails1($app));

                $update = ApplicationApproval::where('application_id', $id)->first();
                $update->registrar_status = 3;
                $update->save();
            }
        }

        return redirect()->back()->with('success', 'Admission letters generated and communication send');
    }

    public function addYear()
    {
        return view('registrar::academicYear.addAcademicYear');
    }

    public function academicYear()
    {
        $years = AcademicYear::latest()->get();
        return view('registrar::academicYear.showAcademicYear')->with('years', $years);
    }

    public function storeYear(Request $request)
    {
        $request->validate([
            'year_start'             =>      'required',
            'year_end'               =>      'required'
        ]);
        $yearId = new CustomIds();

        $year = new AcademicYear();
        $year->year_id = $yearId->generateId();
        $year->year_start = $request->year_start;
        $year->year_end = $request->year_end;
        $year->status = 0;
        $year->save();

        return redirect()->route('courses.academicYear')->with('success', 'Academic year created successfully');
    }

    public function editAcademicYear($id)
    {

        $academicYear = AcademicYear::where('year_id', $id)->first();

        return view('registrar::academicYear.editAcademicYear')->with(['academicYear' => $academicYear]);
    }

    public function updateAcademicYear(Request $request, $id)
    {

        $request->validate([
            'year_start'             =>      'required',
            'year_end'               =>      'required'
        ]);

        $academicYear = AcademicYear::where('year_id', $id)->first();
        $academicYear->year_start = $request->year_start;
        $academicYear->year_end = $request->year_end;
        $academicYear->save();

        return redirect()->route('courses.academicYear')->with('success', 'Academic year updated successfully');
    }

    public function showSemester($id)
    {
        $year = AcademicYear::where('year_id', $id)->first();
        $intakes = Intake::where('academic_year_id', $id)->latest()->get();
        return view('registrar::academicYear.showSemester')->with(['intakes' => $intakes, 'year' => $year]);
    }

    /**
     * Show the form for a new Intake Information.
     *
     */
    public function addIntake($id)
    {
        $years = AcademicYear::where('year_id', $id)->first();
        $data = Intake::all();
        $courses = Courses::all();

        return view('registrar::intake.addIntake')->with(['data' => $data, 'years' => $years, 'courses' => $courses]);
    }

    public function editstatusIntake($id)
    {
        $data = Intake::where('intake_id', $id)->first();
        return view('registrar::intake.editstatusIntake')->with(['data' => $data]);
    }

    public function statusIntake(Request $request, $id)
    {
        $request->validate(['status' => 'required']);

        if ($request->status == 1) {
            Intake::where('status', 1)->update(['status' => 2]);
            AvailableCourse::where('status', 1)->update(['status' => 0]);

            $data = Intake::where('intake_id', $id)->first();
            $data->status = $request->input('status');
            $data->save();

            AvailableCourse::where('intake_id', $id)->update(['status' => 1]);
        } else {

            $data             =       Intake::where('intake_id', $id)->first();
            $data->status     =       $request->input('status');
            $data->save();

            AvailableCourse::where('intake_id', $id)->update(['status' => 0]);
        }

        return redirect()->route('courses.showSemester', $data->academic_year_id)->with('status', 'Semester status updated successfully');
    }

    public function storeIntake(Request $request, $id)
    {
        $request->validate([
            'year'                  =>       'required',
            'intake_name_from'      =>       'required|before:intake_name_to',
            'intake_name_to'        =>       'required|after:intake_name_from'
        ]);

        $academicYear = AcademicYear::where('year_id', $request->year)->first();

        if (Carbon::parse($academicYear->year_start)->format('Y-m-d') <= Carbon::parse($request->intake_name_from)->format('Y-m-d') && Carbon::parse($academicYear->year_end)->format('Y-m-d') >= Carbon::parse($request->intake_name_to)->format('Y-m-d') && Carbon::parse($academicYear->year_end)->format('Y-m-d') > Carbon::parse($request->intake_name_from)->format('Y-m-d')) {

            $intakeId = new CustomIds();

            $intake = new Intake;
            $intake->intake_id = $intakeId->generateId();
            $intake->academic_year_id = $request->year;
            $intake->intake_from = $request->intake_name_from;
            $intake->intake_to = $request->intake_name_to;
            $intake->status = 0;
            $intake->save();

            return redirect()->route('courses.showSemester', $id)->with('success', 'Intake created successfully');
        } else {
            return redirect()->back()->with('error', 'Confirm dates to be within the academic year dates');
        }
    }



    public function showIntake()
    {
        $data = Intake::latest()->get();
        return view('registrar::intake.showIntake')->with('data', $data);
    }

    public function editIntake($id)
    {
        $intake = Intake::where('intake_id', $id)->first();
        return view('registrar::intake.editIntake')->with(['intake' => $intake]);
    }


    public function updateIntake(Request $request, $id)
    {
        $request->validate([
            'intake_name_from'      =>       'required|before:intake_name_to',
            'intake_name_to'        =>       'required|after:intake_name_from'
        ]);

        $academicYear = Intake::where('intake_id', $id)->first()->academicYear;

        if (Carbon::parse($academicYear->year_start)->format('Y-m-d') <= Carbon::parse($request->intake_name_from)->format('Y-m-d') && Carbon::parse($academicYear->year_end)->format('Y-m-d') >= Carbon::parse($request->intake_name_to)->format('Y-m-d') && Carbon::parse($academicYear->year_end)->format('Y-m-d') > Carbon::parse($request->intake_name_from)->format('Y-m-d')) {

            $intake = Intake::where('intake_id', $id)->first();
            $intake->intake_from = $request->intake_name_from;
            $intake->intake_to = $request->intake_name_to;
            $intake->save();

            return redirect()->route('courses.showSemester', $academicYear->year_id)->with('success', 'Intake updated successfully');
        } else {

            return redirect()->back()->with('error', 'Confirm dates to be within the academic year dates');
        }
    }

    /**
     *
     * Information about School
     */
    public function addAttendance()
    {
        return view('registrar::attendance.addAttendance');
    }

    public function showAttendance()
    {
        $data = Attendance::latest()->get();
        return view('registrar::attendance.showAttendance')->with('data', $data);
    }

    public function editAttendance($id)
    {
        $hashedId = Crypt::decrypt($id);
        $data = Attendance::find($hashedId);
        return view('registrar::attendance.editAttendance')->with('data', $data);
    }
    public function updateAttendance(Request $request, $id)
    {
        $data = Attendance::find($id);
        $data->attendance_code = $request->input('code');
        $data->attendance_name = $request->input('name');
        $data->update();

        return redirect()->route('courses.showAttendance')->with('status', 'Data Updated Successfully');
    }

    public function storeAttendance(Request $request)
    {
        $request->validate([
            'name'      =>     'required',
            'code'      =>     'required'
        ]);
        $attendance                     =     new Attendance;
        $attendance->attendance_code    =     $request->input('code');
        $attendance->attendance_name    =     $request->input('name');
        $attendance->save();
        return redirect()->route('courses.showAttendance')->with('success', 'Mode of Study Created');
    }

    public function destroyAttendance($id)
    {
        $data      =    Attendance::find($id);
        $data->delete();
        return redirect()->route('courses.showAttendance');
    }

    /**
     *
     * Information about School
     */
    public function  addschool()
    {
        return view('registrar::school.addSchool');
    }

    public function  showSchool()
    {

        $data = School::latest()->get();
        return view('registrar::school.showSchool')->with('data', $data);
    }

    public function editSchool($id)
    {

        $data = School::where('school_id', $id)->first();
        return view('registrar::school.editSchool')->with('data', $data);
    }

    public function updateSchool(Request $request, $id)
    {
        $request->validate([
            'initials'         =>       'required|unique:schools',
            'name'             =>       'required|unique:schools'
        ]);

        $data = School::where('school_id', $id)->first();
        $data->initials        =         $request->initials;
        $data->name            =         $request->name;
        $data->save();

        $oldSchool = new SchoolHistory;
        $oldSchool->school_id = $data->school_id;
        $oldSchool->initials = $data->initials;
        $oldSchool->name = $data->name;
        $oldSchool->created_at = $data->created_at;
        $oldSchool->updated_at = $data->updated_at;
        $oldSchool->save();

        return redirect()->route('courses.showSchool')->with('status', 'Data Updated Successfully');
    }

    public function storeSchool(Request $request)
    {
        $request->validate([
            'initials'         =>       'required|unique:schools',
            'name'             =>       'required|unique:schools'
        ]);

        $id = new CustomIds();

        $schools = new School;
        $schools->school_id = $id->generateId();
        $schools->initials = $request->input('initials');
        $schools->name = $request->input('name');
        $schools->save();

        return redirect()->route('courses.showSchool')->with('success', 'School Created');
    }

    public function schoolPreview($id)
    {
        $schoolName = School::where('school_id', $id)->first();
        $data = SchoolHistory::where('school_id', $id)->latest()->get();
        return view('registrar::school.preview')->with(['data' => $data, 'schoolName' => $schoolName]);
    }
    /**
     *
     * Information about departments
     */
    public function addDepartment()
    {
        $schools = School::all();
        return view('registrar::department.addDepartment')->with('schools', $schools);
    }

    public function showDepartment()
    {
         $data = academicdepartments::latest()->get();
        return view('registrar::department.showDepartment')->with('data', $data);
    }

    public function storeDepartment(Request $request)
    {
        $request->validate([
            'dept_code' => 'required|unique:departments',
            'name' => 'required|unique:departments'
        ]);

        $id = new CustomIds();
        $division = Division::where('name', 'ACADEMIC DIVISION')->first();

        $departments = new Department;
        $departments->department_id = $id->generateId();
        $departments->division_id = $division->division_id;
        $departments->dept_code = $request->input('dept_code');
        $departments->name = $request->input('name');
        $departments->save();

        $school = new SchoolDepartment;
        $school->school_id = $request->school;
        $school->department_id = $departments->department_id;
        $school->save();

        return redirect()->route('courses.showDepartment')->with('success', 'Department Created');
    }

    public function editDepartment($id)
    {
        $data = ACADEMICDEPARTMENTS::where('department_id', $id)->first();
        $schools = School::all();
        return view('registrar::department.editDepartment')->with(['data' => $data, 'schools' => $schools]);
    }

    public function updateDepartment(Request $request, $id)
    {
        $data = ACADEMICDEPARTMENTS::where('department_id', $id)->first();

        $oldDepartment  =  new DepartmentHistory;
        $oldDepartment->department_id = $data->department_id;
        $oldDepartment->school_id  = $data->school_id;
        $oldDepartment->name  = $data->name;
        $oldDepartment->dept_code  =  $data->dept_code;
        $oldDepartment->created_at = $data->created_at;
        $oldDepartment->updated_at = $data->updated_at;
        $oldDepartment->save();

        $newDepartment = Department::where('department_id', $data->department_id)->first();
        $newDepartment->dept_code = $request->dept_code;
        $newDepartment->name = $request->name;
        $newDepartment->save();

        SchoolDepartment::where('department_id', $data->department_id)->update(['school_id' => $request->school]);

        return redirect()->route('courses.showDepartment')->with('status', 'Data Updated Successfully');
    }

    public function departmentPreview($id)
    {
        $departmentName = Department::where('department_id', $id)->first();
        $data = DepartmentHistory::where('department_id', $id)->latest()->get();
        return view('registrar::department.preview')->with(['data' => $data, 'departmentName' => $departmentName]);
    }
    /**
     *
     * Information about Course
     */
    public function addCourse()
    {
        $departments = ACADEMICDEPARTMENTS::latest()->get();
        $group = Group::all();
        $clusters = CourseClusterGroups::all();
        $levels = Level::all();
        return view('registrar::course.addCourse')->with(['departments' => $departments,  'groups' => $group, 'clusters' => $clusters, 'levels' => $levels]);
    }

    public function storeCourse(Request $request)
    {
        $request->validate([
            'department'                =>       'required',
            'course_name'               =>       'required',
            'course_code'               =>       'required',
            'level'                     =>       'required',
            'course_duration'           =>       'required',
            'course_requirements'       =>       'required',
            'subject1'                  =>       'required',
            'subject2'                  =>       'required',
            'subject3'                  =>       'required',
            'subject'                   =>       'required'
        ]);

        if ($request->level == 3) {
            $request->validate([
                'cluster_group' => 'required|string'
            ]);
        }

        $subject          =          $request->subject;
        $subject1         =          $request->subject1;
        $subject2         =          $request->subject2;
        $subject3         =          $request->subject3;
        $data             =          implode(",", $subject);
        $data1            =          implode(",", $subject1);
        $data2            =          implode(",", $subject2);
        $data3            =          implode(",", $subject3);

        $courseId = new CustomIds();
        $courses = new Courses();
        $courses->course_id = $courseId->generateId();
        $courses->department_id = $request->department;
        $courses->course_name = $request->course_name;
        $courses->course_code = $request->course_code;
        $courses->level = $request->level;
        $courses->save();

        $requirement  =  new CourseRequirement;
        $requirement->course_id  = $courses->course_id;
        $requirement->course_duration = $request->course_duration;
        if ($request->level  == 1) {
            $requirement->application_fee  = '500';
        } elseif ($request->level  == 2) {
            $requirement->application_fee  = '500';
        } elseif ($request->level  == 3) {
            $requirement->application_fee  = '1000';
        } else {
            $requirement->application_fee  = '1500';
        }
        $requirement->course_requirements = $request->input('course_requirements');
        $requirement->subject1 = str_replace(',', '/', $data) . " " . $request->grade1;
        $requirement->subject2 = str_replace(',', '/', $data1) . " " . $request->grade2;
        $requirement->subject3 = str_replace(',', '/', $data2) . " " . $request->grade2;
        $requirement->subject4 = str_replace(',', '/', $data3) . " " . $request->grade3;
        $requirement->save();

        if ($request->level == 3) {
            $cluster = new CourseCluster;
            $cluster->course_id = $courses->course_id;
            $cluster->cluster = $request->cluster_group;
            $cluster->save();
        }

        return redirect()->route('courses.showCourse')->with('success', 'Course Created');
    }

    public function showCourse()
    {
        $data = Courses::orderBy('course_id', 'desc')->get();
        return view('registrar::course.showCourse')->with('data', $data);
    }

    public function editCourse($id)
    {
        $departments = Department::latest()->get();
        $data = Courses::where('course_id', $id)->first();
        $group = Group::all();
        $levels = Level::all();
        $clusters = CourseClusterGroups::all();
        return view('registrar::course.editCourse')->with(['groups' => $group, 'data' => $data, 'departments' => $departments, 'levels' => $levels, 'clusters' => $clusters]);
    }

    public function updateCourse(Request $request, $id)
    {
        $request->validate([
            'department' => 'required',
            'course_name' =>       'required',
            'course_code' =>       'required',
            'level' => 'required',
            'course_duration' => 'required',
            'course_requirements' => 'required',
            'subject1' => 'required',
            'subject2' => 'required',
            'subject3' => 'required',
            'subject'  => 'required'
        ]);

        if ($request->level == 3) {
            $request->validate(['cluster_group' => 'required|string']);
        }

        $subject =  $request->subject;
        $subject1 = $request->subject1;
        $subject2 = $request->subject2;
        $subject3 = $request->subject3;
        $record = implode(",", $subject);
        $record1 = implode(",", $subject1);
        $record2 = implode(",", $subject2);
        $record3 = implode(",", $subject3);

        $data = Courses::where('course_id', $id)->first();

        $oldCourse = new  CourseHistory;
        $oldCourse->course_id = $data->course_id;
        $oldCourse->course_name = $data->course_name;
        $oldCourse->department_id = $data->department_id;
        $oldCourse->level = $data->level;
        $oldCourse->course_code = $data->course_code;
        $oldCourse->save();

        $newCourse = Courses::where('course_id', $id)->first();
        $newCourse->course_name = $request->course_name;
        $newCourse->department_id = $request->department;
        $newCourse->level = $request->level;
        $newCourse->course_code = $request->course_code;
        $newCourse->save();

        $req = CourseRequirement::where('course_id', $id)->first();
        $req->course_duration = $request->course_duration;
        $req->course_requirements = $request->course_requirements;
        if ($request->level  == 1) {
            $req->application_fee  = '500';
        } elseif ($request->level  == 2) {
            $req->application_fee  = '500';
        } elseif ($request->level  == 3) {
            $req->application_fee  = '1000';
        } else {
            $req->application_fee  = '1500';
        }
        $req->subject1 = str_replace(',', '/', $record) . " " . $request->grade1;
        $req->subject2 = str_replace(',', '/', $record1) . " " . $request->grade2;
        $req->subject3 = str_replace(',', '/', $record2) . " " . $request->grade3;
        $req->subject4 = str_replace(',', '/', $record3) . " " . $request->grade4;
        $req->save();

        return redirect()->route('courses.showCourse')->with('status', 'Data Updated Successfully');
    }

    public function coursePreview($id)
    {
        $courseName = Courses::where('course_id', $id)->first();
        $data = CourseHistory::where('course_id', $id)->latest()->get();
        return view('registrar::course.preview')->with(['data' => $data, 'courseName' => $courseName]);
    }

    public function syllabus($course_id)
    {
        $hashedId  =  Crypt::decrypt($course_id);
        $course   =   Courses::where('course_id', $hashedId)->first();
        $unit   =  UnitProgramms::where('course_code', $course->course_code)->get();
        return view('registrar::course.syllabus')->with(['units' => $unit, 'course' => $course]);
    }

    public function archived()
    {
        $archived = ApplicationsView::where('registrar_status', 3)->latest()->get();
        return view('registrar::offer.archived')->with('archived', $archived);
    }

    public function destroyCoursesAvailable(Request $request, $id)
    {
        $course = AvailableCourse::find($id)->delete();
        return redirect()->route('courses.offer');
    }

    public function admissions()
    {
        $admission = AdmissionsView::where('medical_status', 1)
            //            ->where('status', NULL)
            ->get();

        return view('registrar::admissions.index')->with('admission', $admission);
    }

    public function admitStudent($id){

        $admission = AdmissionsView::where('application_id', $id)->first();
        $course = Courses::where('course_id', $admission->course_id)->first();
        $intake = Intake::where('intake_id', $admission->intake_id)->first();
        if ($admission->student_type == 1){
            $code  = 'S-FT';
            $group = 'SSP';
        }elseif ($admission->student_type == 2){
            $code  = 'J-FT';
            $group = 'KUCCPS';
        }else{
            $code  = 'S-PT';
            $group = 'SSP';
        }

        $class = $course->course_code.'/'.strtoupper(Carbon::parse($intake->intake_from)->format('MY')).'/'.$code;
        $student = [
            'student_number' => $admission->reg_number,
            'full_name' => $admission->fname.' '.$admission->mname.' '.$admission->sname,
            'class_code' => $class,
            'group_code' => $group,
            'course_code' => $course->course_code
        ];

        $this->appApi->createStudent($student);
        $studentID = new CustomIds();

        $generatedStudentID  =  $studentID->generateId();

        $studLogin = new StudentLogin;
        $studLogin->username = $admission->reg_number;
        $studLogin->password = Hash::make($admission->id_number);
        $studLogin->student_id = $generatedStudentID;
        $studLogin->save();

        $student = new StudentInfo;
        $student->student_id = $generatedStudentID;
        $student->sname = $admission->sname;
        $student->fname = $admission->fname;
        $student->mname = $admission->mname;
        $student->title = $admission->title;
        $student->marital_status = $admission->marital_status;
        $student->gender = $admission->gender;
        $student->dob = $admission->dob;
        $student->id_number = $admission->id_number;
        $student->disabled = $admission->disabled;
        $student->save();

        if ($admission->disabled == "YES") {
            $studentdisability = new StudentDisability;
            $studentdisability->student_id = $generatedStudentID;
            $studentdisability->disability = $admission->disability;
            $studentdisability->save();
        }

        $studentcontact = new StudentContact;
        $studentcontact->student_id = $generatedStudentID;
        $studentcontact->email = $admission->email;
        $studentcontact->student_email = strtolower(str_replace('/', '', $admission->reg_number) . '@students.tum.ac.ke');
        $studentcontact->mobile = $admission->mobile;
        $studentcontact->alt_mobile = $admission->alt_mobile;
        $studentcontact->alt_email = $admission->alt_email;
        $studentcontact->save();

        $studentAddress = new StudentAddress;
        $studentAddress->student_id = $generatedStudentID;
        $studentAddress->citizen = $admission->nationality;
        $studentAddress->county = $admission->county;
        $studentAddress->sub_county = $admission->sub_county;
        $studentAddress->town = $admission->town;
        $studentAddress->address = $admission->address;
        $studentAddress->postal_code = $admission->postal_code;
        $studentAddress->save();

        $studCourse = new StudentCourse;
        $studCourse->student_id = $generatedStudentID;
        $studCourse->student_number = $admission->reg_number;
        $studCourse->reference_number = $admission->ref_number;
        $studCourse->student_type = $admission->student_type;
        $studCourse->department_id = $admission->department_id;
        $studCourse->course_id = $admission->course_id;
        $studCourse->intake_id = $admission->intake_id;
        $studCourse->status = 1;
        if ($admission->student_type == 1) {
            $studCourse->current_class = strtoupper($admission->admissionCourse->course_code . '/' . Carbon::parse($admission->admissionIntake->intake_from)->format('MY') . '/S-FT');
            $studCourse->entry_class = strtoupper($admission->admissionCourse->course_code . '/' . Carbon::parse($admission->admissionIntake->intake_from)->format('MY') . '/S-FT');
        } else {
            $studCourse->current_class = strtoupper($admission->admissionCourse->course_code . '/' . Carbon::parse($admission->admissionIntake->intake_from)->format('MY') . '/J-FT');
            $studCourse->entry_class = strtoupper($admission->admissionCourse->course_code . '/' . Carbon::parse($admission->admissionIntake->intake_from)->format('MY') . '/J-FT');
        }
        $studCourse->save();

        $approval = AdmissionApproval::where('application_id', $id)->first();
        $approval->registrar_status   =             1;
        $approval->accommodation_status =           0;
        $approval->save();

//                $comms = new Notification;
//                $comms->application_id = $admission->id;
//                $comms->role_id = Auth::guard('user')->user()->role_id;
//                $comms->subject = 'Application Admission Process';
//                $comms->comment = 'Congratulations! Your admission was successful. You are now a bona-fied student at TUM. You can now log in as a student using your registration number as user ID and ID/PASSPORT/BIRTH certificate number.';
//                $comms->status = 1;
//                $comms->save();

        return redirect()->back()->with('success', 'New student admission completed successfully');
    }

    public function rejectAdmission(Request $request, $id)
    {
        AdmissionApproval::where('id', $id)->update(['registrar_status' => 2, 'registrar_comments' => $request->comment]);
        return redirect()->route('medical.admissions')->with('error', 'Admission request rejected');
    }

    public function studentID($id)
    {
        $studentID          =          AdmissionApproval::find($id);
        return view('registrar::admissions.studentID')->with('app', $studentID);
    }

    public function storeStudentID(Request $request, $id)
    {
        $request->validate([
            'image'             =>          'required'
        ]);
        $studID                =           AdmissionApproval::find($id);
        $img                   =           $request->image;
        $folderPath            =           "studentID/";
        $image_parts           =           explode(";base64,", $img);
        $image_type_aux        =           explode("image/", $image_parts[0]);
        $image_type            =           $image_type_aux[1];
        $image_base64          =           base64_decode($image_parts[1]);
        $fileName              =           strtoupper(str_replace('/', '', $studID->appApprovals->reg_number)) . '.png';
        $file                  =           $folderPath . $fileName;

        Storage::put($file, $image_base64);

        AdmissionApproval::where('id', $id)->update(['id_status' => 1]);

        Student::where('reg_number', $studID->appApprovals->reg_number)->update(['ID_photo' => $fileName]);

        return redirect()->route('courses.admissions')->with('success', 'ID photo uploaded successfully');
    }

    public function fetchSubjects(Request $request)
    {
        $data = ClusterSubject::where('group_id', $request->id)->get();

        return response()->json($data);
    }
}
