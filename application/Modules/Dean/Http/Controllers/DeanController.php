<?php

namespace Modules\Dean\Http\Controllers;

use Auth;
use App\Models\User;
use Carbon\Carbon;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Application\Entities\AdmissionDocument;
use Modules\Application\Entities\ApplicationApproval;
use Modules\COD\Entities\AcademicLeavesView;
use Modules\COD\Entities\ApplicationsView;
use Modules\COD\Entities\ReadmissionsView;
use Modules\Dean\Entities\DeanLog;
use Modules\Examination\Entities\ModeratedResults;
use Modules\Registrar\Entities\ACADEMICDEPARTMENTS;
use Modules\Registrar\Entities\Division;
use Modules\Registrar\Entities\SchoolDepartment;
use Modules\Student\Entities\CourseTransfersView;
use Modules\Student\Entities\StudentCourse;
use Modules\Student\Entities\StudentView;
use Modules\Workload\Entities\WorkloadView;
use PhpOffice\PhpWord\Element\Table;
use Illuminate\Support\Facades\Crypt;
use Modules\COD\Entities\Nominalroll;
use Modules\COD\Entities\ClassPattern;
use Modules\Registrar\Entities\Intake;
use Modules\Registrar\Entities\Classes;
use Modules\Registrar\Entities\Courses;
use Modules\Registrar\Entities\Student;
use Modules\Workload\Entities\Workload;
use PhpOffice\PhpWord\TemplateProcessor;
use Modules\Student\Entities\Readmission;
use Modules\COD\Entities\ReadmissionClass;
use Modules\Registrar\Entities\Department;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use Modules\Application\Entities\Education;
use Modules\Student\Entities\AcademicLeave;
use NcJoes\OfficeConverter\OfficeConverter;
use Illuminate\Contracts\Support\Renderable;
use Modules\Registrar\Entities\AcademicYear;
use Modules\Student\Entities\CourseTransfer;
use Modules\Application\Entities\Application;
use Modules\Examination\Entities\ExamMarks;
use Modules\Examination\Entities\ExamWorkflow;
use Modules\Student\Entities\ReadmissionApproval;
use Modules\Student\Entities\AcademicLeaveApproval;
use Modules\Student\Entities\CourseTransferApproval;
use Modules\Workload\Entities\ApproveWorkload;

class DeanController extends Controller{

    public function yearlyExams(){
        $school_id = auth()->guard('user')->user()->employmentDepartment()->first()->schools->first()->school_id;
        $deptIDs = ACADEMICDEPARTMENTS::where('school_id', $school_id)->pluck('department_id');
        $academicYears = ExamWorkflow::whereIn('department_id', $deptIDs)->latest()->get()->groupBy('academic_year');
        return view('dean::exams.yearlyExams')->with(['academicYears' => $academicYears]);
    }

    public function viewYearlyExams($id){
        $academic_year = base64_decode($id);
        $school_id = auth()->guard('user')->user()->employmentDepartment()->first()->schools->first()->school_id;
        $deptIDs = ACADEMICDEPARTMENTS::where('school_id', $school_id)->pluck('department_id');
        $semesters = ExamWorkflow::whereIn('department_id', $deptIDs)->where('academic_year', $academic_year)->latest()->get()->groupBy(['academic_semester', 'department_id']);
        return view('dean::exams.viewYearlyExams')->with(['semesters' => $semesters, 'year' => $academic_year]);
    }

    public function exams($id){
        $approval = ExamWorkflow::where('exam_approval_id', $id)->first();
        $results =  ModeratedResults::where('exam_approval_id', $id)
            ->orderBy('class_code', 'asc')
            ->get()
            ->groupBy(['class_code', 'unit_code', 'student_number']);
        return view('dean::exams.index')->with(['results' => $results, 'approval' => $approval]);
    }

    public function viewClasses( $id, $sem, $year)
    {
        $hashedId = Crypt::decrypt($id);

        $hashedSem = Crypt::decrypt($sem);

        $hashedYear = Crypt::decrypt($year);

        $exams = ExamMarks::where('workflow_id', $hashedId)
            ->where('academic_year', $hashedYear)
            ->where('academic_semester', $hashedSem)
            ->latest()
            ->get()
            ->groupBy('class_code');


        return  view('dean::exams.viewClasses')->with(['exams'  =>  $exams, 'id'  =>  $hashedId, 'sem'  =>  $hashedSem, 'year'  =>  $hashedYear]);
    }

    public function viewStudents($id, $sem, $year, $class)
    {
        $hashedId = Crypt::decrypt($id);

        $hashedClass = Crypt::decrypt($class);

        $hashedSem = Crypt::decrypt($sem);

        $hashedYear = Crypt::decrypt($year);


        $exams = ExamMarks::where('class_code', $hashedClass)
            ->where('workflow_id', $hashedId)
            ->where('academic_year', $hashedYear)
            ->where('academic_semester', $hashedSem)
            ->latest()
            ->get()
            ->groupBy('reg_number');

        $regs = [];
        foreach ($exams as $regNumber => $examMarks) {
            $regs[$regNumber] = $examMarks;
        }
        $studentDetails  = [];
        $students = Student::all();
        foreach ($students as $student) {
            if (isset($regs[$student->reg_number])) {

                $studentDetails[]  =  $student;
            }
        }

        return view('dean::exams.viewStudents')->with(['studentDetails'  =>  $studentDetails, 'regs'  =>  $regs]);
    }

    public function approveExamMarks($id){
        ExamWorkflow::where('exam_approval_id', $id)->update([
            'dean_status' => 1,
            'dean_remarks' => 'Exam Marks Approved',
        ]);
      return redirect()->back()->with('success', 'Exam Marks Approved Successfully');
    }

    public function submitExamMarks($id){
        ExamWorkflow::where('exam_approval_id', $id)->update([
            'registrar_status' => 0
            ]);
        return redirect()->back()->with('success', 'Exam Marks submitted Successfully');
      }

    public function declineExams(Request $request, $id){
        ExamWorkflow::where('exam_approval_id', $id)->update([
            'dean_status' => 2,
            'dean_remarks' => $request->remarks
        ]);
        return redirect()->back()->with('success', 'Exam Marks Declined');
      }

      public function revertExamMarks($id){
          ExamWorkflow::where('exam_approval_id', $id)->update([
              'cod_status' => 3,
          ]);
        return redirect()->back()->with('success', 'Exam Marks Reverted to COD Successfully.');
    }

    public function publishResults($id){
        ModeratedResults::where('exam_approval_id', $id)->update(['status' => 1]);
        return redirect()->back()->with('success', 'Exam Results Published Successfully.');
    }

    public function viewWorkloads(){
        $intakes = Workload::select('intake_id')->distinct()->pluck('intake_id');
        $academicYears = DB::table('academicperiods')->whereIn('intake_id', $intakes)->get();
        return view('dean::workload.index')->with(['academicYears' => $academicYears]);
    }

    public function yearlyWorkload($id){
        $academicYear = DB::table('academicperiods')->where('academic_year', base64_decode($id))->pluck('intake_id');
        $departments = ACADEMICDEPARTMENTS::where('school_id', auth()->guard('user')->user()->employmentDepartment->first()->schools->first()->school_id)->pluck('department_id');
        $workloads =  WorkloadView::whereIn('department_id', $departments)->whereIn('intake_id', $academicYear)->get()->groupBy(['department_id', 'intake_id']);

        return view('dean::workload.workloadPerSemester')->with(['workloads' => $workloads, 'year'=> $id]);
    }

    public function semesterWorkload($id){
        $workloads = [];
        $departments = [];
        $schoolId = auth()->guard('user')->user()->employmentDepartment->first()->schools->first()->school_id;
        $departments = ACADEMICDEPARTMENTS::where('school_id', $schoolId)->get();
        $year = ApproveWorkload::where('workload_approval_id', $id)->first();
        foreach ($departments as $department) {
            $workloads[] = WorkloadView::where('department_id', $department->department_id)
                ->where('workload_approval_id', $id)
                ->get();
        }
        return view('dean::workload.semestersWorkload')->with(['workloads' => $workloads, 'year' => $year]);
    }

    public function viewWorkload($id){
        list($department, $semester) = explode(':', base64_decode($id));
        $users = User::all();
        foreach ($users as $user) {
            if ($user->hasRole('LECTURER')) {
                $lectures[] = $user;
            }
        }
        $workloads = WorkloadView::where('department_id', $department)->where('intake_id', $semester)->where('status', '!=', 2)->get()->groupBy(['department_id', 'user_id']);
        return view('dean::workload.viewWorkload')->with(['workloads' => $workloads, 'users' => $users]);
    }

    public function approveWorkload($id){
        list($department, $semester) = explode(':', base64_decode($id));
        $workload = WorkloadView::where('department_id', $department)->where('intake_id', $semester)->first();
        ApproveWorkload::where('workload_approval_id', $workload->workload_approval_id)->update([
            'dean_status' => 1,
            'dean_remarks' => 'Workload Approved',
            'dean_user_id' => auth()->guard('user')->user()->user_id,
        ]);
        return redirect()->back()->with('success', 'Workload Approved Successfully');
    }

    public function declineWorkload(Request $request, $id){
        list($department, $semester) = explode(':', base64_decode($id));
        $workload = WorkloadView::where('department_id', $department)->where('intake_id', $semester)->first();
        ApproveWorkload::where('workload_approval_id', $workload->workload_approval_id)->update([
            'dean_status' => 2,
            'dean_remarks' => $request->remarks,
            'dean_user_id' => auth()->guard('user')->user()->user_id,
        ]);
        return redirect()->back()->with('success', 'Workload Declined');
    }

    public function workloadPublished($id){
        list($department, $semester) = explode(':', base64_decode($id));
        $workloads = WorkloadView::where('department_id', $department)->where('intake_id', $semester)->get();
        foreach ($workloads  as  $workload) {
            Workload::where('workload_id', $workload->workload_id)->update(['status' => 1]);
        }
        return redirect()->back()->with('success', 'Workload Published Successfully');
    }

    public function submitWorkload($id){
        list($department, $semester) = explode(':', base64_decode($id));
        $workload = WorkloadView::where('department_id', $department)->where('intake_id', $semester)->first();
        ApproveWorkload::where('workload_approval_id', $workload->workload_approval_id)->update(['registrar_status' => 0, 'registrar_remarks' => null, 'registrar_user_id' => null]);
        return redirect()->back()->with('success', 'Workload Approved Successfully');
    }

    public function revertWorkload($id){
        list($department, $semester) = explode(':', base64_decode($id));
        $workloads = WorkloadView::where('department_id', $department)->where('intake_id', $semester)->get();
        foreach ($workloads  as  $workload) {
            Workload::where('workload_id', $workload->workload_id)->update(['status' => 2]);
        }
        return redirect()->back()->with('success', 'Workload Reverted to COD Successfully.');
    }

    public function printWorkload($id){
        list($department, $semester) = explode(':', base64_decode($id));
        $users = User::all();
            foreach ($users as $user) {
                if ($user->hasRole('LECTURER')) {
                    $lecturers[] = $user;
                }
            }
        $depart = Department::where('department_id', $department)->first()->name;
        $session = DB::table('academicperiods')->where('intake_id', $semester)->first();
        $school = auth()->guard('user')->user()->employmentDepartment->first()->schools->first();
        $workloads = WorkloadView::where('department_id', $department)->where('intake_id', $semester)->get()->groupBy('user_id');

        $domPdfPath = base_path('vendor/dompdf/dompdf');
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $center = ['bold' => true, 'size' => 9, 'name' => 'Book Antiqua'];
        $table = new Table(['unit' => \PhpOffice\PhpWord\SimpleType\TblWidth::TWIP, 'width' => 1400 * 1400, 'align' => 'center']);
        $headers = ['bold' => true, 'space' => ['before' => 2000, 'after' => 2000, 'rule' => 'exact']];
        $left = array('align' => 'left', 'size' => 10, 'name' => 'Book Antiqua');

        $table->addRow();
        $table->addCell(200, ['borderSize' => 1, 'vMerge' => 'restart'])->addText('#', $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 13, 'bold' => true]);
        $table->addCell(3600, ['borderSize' => 1, 'gridSpan' => 4])->addText('STAFF', $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 13, 'bold' => true]);
        $table->addCell(3400, ['borderSize' => 1, 'gridSpan' => 3])->addText('CLASS', $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 11, 'bold' => true]);
        $table->addCell(7200, ['borderSize' => 1, 'gridSpan' => 3])->addText('UNIT', $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 11, 'bold' => true]);
        $table->addCell(800, ['borderSize' => 1])->addText();

        $table->addRow();
        $table->addCell(200, ['borderSize' => 1, 'vMerge' => 'continue'])->addText('#');
        $table->addCell(800, ['borderSize' => 1])->addText('Staff Number', $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 11, 'bold' => true]);
        $table->addCell(1000, ['borderSize' => 1])->addText('Staff Name', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
        $table->addCell(800, ['borderSize' => 1])->addText('Qualification', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
        $table->addCell(700, ['borderSize' => 1])->addText('Roles', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
        $table->addCell(2400, ['borderSize' => 1])->addText('Class Code', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
        $table->addCell(700, ['borderSize' => 1])->addText('Work' . "\n" . 'load', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
        $table->addCell(600, ['borderSize' => 1])->addText('Stds',  $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
        $table->addCell(1500, ['borderSize' => 1])->addText('Unit Code', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
        $table->addCell(5000, ['borderSize' => 1])->addText('Unit Name', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
        $table->addCell(700, ['borderSize' => 1])->addText('Level', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
        $table->addCell(800, ['borderSize' => 1])->addText('Signature', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);

        $sn = 0;

        foreach ($workloads as $user_id => $workload) {
            $qualifications = [];
            $roles = [];
            foreach ($lecturers as $lecturer) {
                if ($lecturer->user_id === $user_id) {
                    $staff = $lecturer;
                    foreach ($staff->lecturerQualfs()->where('status', 1)->get() as $qualification) {
                        $qualifications[] = substr($qualification->qualification, 0 , 20);
                    }
                    foreach ($staff->roles as $role) {
                        $roles[] = $role->name;
                    }
                }
            }

            $table->addRow();
            $table->addCell(200, ['borderSize' => 1])->addText(++$sn, $left, ['name' => 'Book Antiqua', 'size' => 10]);
            $table->addCell(800, ['borderSize' => 1])->addText($staff->staffInfos->staff_number, $left, ['name' => 'Book Antiqua', 'size' => 10]);
            $table->addCell(1000, ['borderSize' => 1])->addText($staff->staffInfos->title . '. ' . $staff->staffInfos->last_name . ' ' . $staff->staffInfos->first_name, $left, ['name' => 'Book Antiqua', 'size' => 9, 'align' => 'left']);
            $table->addCell(700, ['borderSize' => 1])->addText(implode(', ', $qualifications), $left, ['name' => 'Book Antiqua', 'size' => 9, 'align' => 'left']);
            $table->addCell(800, ['borderSize' => 1])->addText(implode(', ', $roles), $left, ['name' => 'Book Antiqua', 'size' => 9, 'align' => 'left']);

            $class = $table->addCell(2100, ['borderSize' => 1]);
            $staffLoad = $table->addCell(700, ['borderSize' => 1]);
            $students = $table->addCell(600, ['borderSize' => 1]);
            $unit_code = $table->addCell(1500, ['borderSize' => 1]);
            $unit_name = $table->addCell(5000, ['borderSize' => 1]);
            $levels = $table->addCell(700, ['borderSize' => 1]);
            $signature = $table->addCell(800, ['borderSize' => 1]);

            $userLoad = $workload->count();

            foreach ($lecturers as $lecturer) {
                if ($lecturer->user_id === $user_id) {
                    $staff = $lecturer;
                    if ($staff->employments->first()->employment_terms == 'FT' && $staff->hasRole('LECTURER')) {
                        for ($i = 0; $i < $userLoad; ++$i) {
                            if ($i < 3) {
                                $load = 'FT';
                                $staffLoad->addText($load, ['name' => 'Book Antiqua', 'size' => 10]);
                            } else {
                                $load = 'PT';
                                $staffLoad->addText($load, ['name' => 'Book Antiqua', 'size' => 10]);
                            }
                        }
                    } elseif ($staff->employments->first()->employment_terms == 'FT' && $staff->hasRole('CHAIRPERSON OF DEPARTMENT') || $staff->employments->first()->employment_terms == 'FT' && $staff->hasRole('DEAN/DIRECTOR')) {

                        for ($i = 0; $i < $userLoad; ++$i) {
                            if ($i < 2) {
                                $load = 'FT';
                                $staffLoad->addText($load, ['name' => 'Book Antiqua', 'size' => 10]);
                            } else {
                                $load = 'PT';
                                $staffLoad->addText($load, ['name' => 'Book Antiqua', 'size' => 10]);
                            }
                        }
                    }else{

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
                $class->addText($unit->class_code, $left, ['name' => 'Book Antiqua', 'size' => 10]);
                $students->addText($unit->classWorkloadView->studentClass->count(), $left, ['name' => 'Book Antiqua', 'size' => 10]);
                $unit_code->addText($unit->workloadUnitView->unit_code, $left, ['name' => 'Book Antiqua', 'size' => 10]);
                $unit_name->addText(substr($unit->workloadUnitView->unit_name, 0, 31), $left, ['name' => 'Book Antiqua', 'size' => 10, 'align' => 'left']);
                $levels->addText($unit->classWorkloadView->classCourse->level_id, $left, ['name' => 'Book Antiqua', 'size' => 10]);
                $signature->addText();
            }
        }
        $workload = new TemplateProcessor(storage_path('workload_template.docx'));

        $workload->setValue('initials', $school->initials);
        $workload->setValue('name', $school->name);
        $workload->setValue('department', $depart);
        $workload->setValue('academic_year', $session->academic_year);
        $workload->setValue('academic_semester', $session->intake_month);
        $workload->setComplexBlock('{table}', $table);
        $docPath = 'Fees/' . 'Workload' . time() . ".docx";
        $workload->saveAs($docPath);

        $contents = \PhpOffice\PhpWord\IOFactory::load($docPath);

        $pdfPath = 'Fees/' . 'Workload' . time() . ".pdf";

        //            $converter =  new OfficeConverter($docPath, 'Fees/');
        //            $converter->convertTo('Workload' . time() . ".pdf");

        //            if (file_exists($docPath)) {
        //                unlink($docPath);
        //            }


        //        return response()->download($pdfPath)->deleteFileAfterSend(true);

        return response()->download($docPath)->deleteFileAfterSend(true);
    }


    public function readmissions(){
        $readmissions = Readmission::latest()->get()->groupBy('intake_id');
        return view('dean::readmissions.yearlyReadmissions')->with(['readmissions' => $readmissions]);
    }

    public function intakeReadmissions($id){
        $school_id = auth()->guard('user')->user()->employmentDepartment->first()->schools->first()->school_id;
        $departments = ACADEMICDEPARTMENTS::where('school_id', $school_id)->pluck('department_id');
        $courses = Courses::whereIn('department_id', $departments)->pluck('course_id');
        $students = StudentCourse::whereIn('course_id', $courses)->pluck('student_id');
        $leaves = AcademicLeavesView::whereIn('student_id', $students)->pluck('leave_id');
        $readmissions = ReadmissionsView::whereIn('leave_id', $leaves)->latest()->get();
        return view('dean::readmissions.intakeReadmissions')->with(['readmissions' => $readmissions, 'intake' => $id]);
    }

    public function selectedReadmission($id){
        $leave = ReadmissionsView::where('readmission_id', $id)->first();
        return view('dean::readmissions.selectedReadmission')->with(['leave' => $leave]);
    }
    public function acceptReadmission(Request $request, $id){
        $intake = Readmission::where('readmission_id', $id)->first()->intake_id;
        ReadmissionApproval::where('readmission_id', $id)->update([
                'dean_status' => 1,
                'dean_remarks' => 'Readmission request accepted',
                'dean_user_id' => auth()->guard('user')->user()->user_id,
            ]);

        return redirect()->route('dean.intakeReadmissions', $intake)->with('success', 'Readmission request accepted');
    }

    public function declineReadmission(Request $request, $id){
        $request->validate([
            'remarks' => 'required'
        ]);
        $intake = Readmission::where('readmission_id', $id)->first()->intake_id;
        ReadmissionApproval::where('readmission_id', $id)->update([
            'dean_status' => 2,
            'dean_remarks' => $request->remarks,
            'dean_user_id' => auth()->guard('user')->user()->user_id,
        ]);
        return redirect()->route('dean.intakeReadmissions', $intake)->with('success', 'Readmission request accepted');
    }

    public function academicLeave(){
        $requests = AcademicLeave::latest()->get()->groupBy('intake_id');
        return view('dean::defferment.index')->with(['leaves' => $requests]);
    }

    public function yearlyAcademicLeave($id){
        $school_id = auth()->guard('user')->user()->employmentDepartment->first()->schools->first()->school_id;
        $departments = ACADEMICDEPARTMENTS::where('school_id', $school_id)->pluck('department_id');
        $courses = Courses::whereIn('department_id', $departments)->pluck('course_id');
        $student = StudentCourse::whereIn('course_id', $courses)->where('status', 1)->pluck('student_id');
        $leaves = AcademicLeavesView::whereIn('student_id', $student)->latest()->get();
        return view('dean::defferment.annualLeaves')->with(['leaves' => $leaves, 'intake' => $id]);
    }

    public function viewLeaveRequest($id){
        $leave = AcademicLeavesView::where('leave_id', $id)->first();
        return view('dean::defferment.viewRequests')->with(['leave' => $leave]);
    }

    public function acceptLeaveRequest($id){
        $leave = AcademicLeavesView::where('leave_id', $id)->first();
            AcademicLeaveApproval::where('leave_id', $id)->update([
                'dean_status' => 1,
                'dean_remarks' => 'Request Accepted'
            ]);
        return redirect()->route('dean.yearlyLeaves', $leave->intake_id)->with('success', 'Deferment/Academic leave approved');
    }

    public function declineLeaveRequest(Request $request, $id){
        $leave = AcademicLeavesView::where('leave_id', $id)->first();
        AcademicLeaveApproval::where('leave_id', $id)->update([
            'dean_status' => 2,
            'dean_remarks' => $request->remarks
        ]);
        return redirect()->route('dean.yearlyLeaves', $leave->intake_id)->with('success', 'Deferment/Academic leave declined.');
    }

    public function requestedTransfers($id) {
        $user = auth()->guard('user')->user();
        $by = $user->staffInfos->title." ".$user->staffInfos->last_name." ".$user->staffInfos->first_name." ".$user->staffInfos->miidle_name;
        $school = $user->employmentDepartment->first()->schools->first();
        $dept = $user->employmentDepartment->first()->name;
        $role = $user->roles->first()->name;
       $departments = ACADEMICDEPARTMENTS::where('school_id', $school->school_id)->get();
        foreach ($departments as $department) {
           $transfers[] = CourseTransfersView::where('department_id', $department->department_id)
                ->where('intake_id', $id)
                ->get()
                ->groupBy('course_id');
        }

        $courses = Courses::all();

        $domPdfPath = base_path('vendor/dompdf/dompdf');
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $center = ['bold' => true];

        $table = new Table(array('unit' => TblWidth::TWIP, 'align' => 'center'));

        foreach ($transfers as $transfered) {
            foreach ($transfered as $course_id => $transfer) {
                foreach ($courses as $listed) {
                    if ($listed->course_id == $course_id) {
                        $courseName = $listed->course_name;
                        $courseCode = $listed->course_code;
                    }
                }

                $headers = ['bold' => true, 'space' => ['before' => 2000, 'after' => 2000, 'rule' => 'exact']];

                $table->addRow(600);
                $table->addCell(10000, ['gridSpan' => 9,])->addText($courseName . ' ' . '(' . $courseCode . ')', $headers, ['spaceAfter' => 300, 'spaceBefore' => 300]);
                $table->addRow();
                $table->addCell(200, ['borderSize' => 1])->addText('#');
                $table->addCell(2500, ['borderSize' => 1])->addText('Student Name/ Reg. Number', $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 11, 'bold' => true]);
                $table->addCell(1850, ['borderSize' => 1])->addText('Course Admitted', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
                $table->addCell(1850, ['borderSize' => 1])->addText('Course Transferring to', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
                $table->addCell(2500, ['borderSize' => 1])->addText('Course Cutoff Grade/Points', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
                $table->addCell(1500, ['borderSize' => 1])->addText('Student Points/Grade', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
                $table->addCell(2500, ['borderSize' => 1])->addText('COD Remarks', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
                $table->addCell(2500, ['borderSize' => 1])->addText('Dean Remarks', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
                $table->addCell(2500, ['borderSize' => 1])->addText('Deans Committee Remarks', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);

                foreach ($transfer as $key => $list) {
                    $name = $list->student_number . "<w:br/>\n" . $list->surname . ' ' . $list->first_name . ' ' . $list->middle_name;
                    $student_id = CourseTransfersView::where('student_id', $list->student_id)->first()->student_id;
                    $student = StudentView::where('student_id', $student_id)->first();
                    if ($list->cod_status == null) {
                        $remarks = 'Missed Deadline';
                        $deanRemark = 'Declined';
                    } else {
                        $remarks = $list->cod_remarks;
                        $deanRemark = $list->dean_remarks;
                    }

//                    return $list;
                    $table->addRow();
                    $table->addCell(200, ['borderSize' => 1])->addText(++$key);
                    $table->addCell(2500, ['borderSize' => 1])->addText($name, ['name' => 'Book Antiqua', 'size' => 10, ]);
                    $table->addCell(1850, ['borderSize' => 1])->addText($list->StudentsTransferCourse->StudentsCourse->course_code, ['name' => 'Book Antiqua', 'size' => 10, 'align' => 'center']);
                    $table->addCell(1850, ['borderSize' => 1])->addText($list->course_code, ['name' => 'Book Antiqua', 'size' => 10, 'align' => 'center']);
                    $table->addCell(2500, ['borderSize' => 1])->addText(strtoupper($list->class_points), ['name' => 'Book Antiqua', 'size' => 10, 'align' => 'center']);
                    $table->addCell(1500, ['borderSize' => 1])->addText($list->student_points, ['name' => 'Book Antiqua', 'size' => 10, 'align' => 'center']);
                    $table->addCell(2500, ['borderSize' => 1])->addText($remarks, ['name' => 'Book Antiqua', 'size' => 10, 'align' => 'center']);
                    $table->addCell(2500, ['borderSize' => 1])->addText($deanRemark, ['name' => 'Book Antiqua', 'size' => 10, 'align' => 'center']);
                    $table->addCell(2500, ['borderSize' => 1])->addText();
                }
            }
        }

        $summary = new Table(array('unit' => TblWidth::TWIP));
        $total = 0;
        foreach ($transfers as $transfered) {
            foreach ($transfered as $course_id => $transfer) {
                foreach ($courses as $listed) {
                    if ($listed->course_id == $course_id) {
                        $total_courses[] = $course_id;
                        $courseName = $listed->course_name;
                        $courseCode = $listed->course_code;
                    }
                }

                $summary->addRow();
                $summary->addCell(800, ['borderSize' => 1])->addText($courseName, ['bold' => true]);
                $summary->addCell(2500, ['borderSize' => 1])->addText($courseCode, ['bold' => true]);
                $summary->addCell(2500, ['borderSize' => 1])->addText($transfer->count());

                $total += $transfer->count();
            }
        }
        $summary->addRow();
        $summary->addCell(6250, ['borderSize' => 1])->addText('Totals', ['bold' => true]);
        $summary->addCell(1250, ['borderSize' => 1])->addText(sizeof($total_courses), ['bold' => true]);
        $summary->addCell(1250, ['borderSize' => 1])->addText($total, ['bold' => true]);

        $my_template = new TemplateProcessor(storage_path('course_transfers.docx'));

        $my_template->setValue('school', $school->name);
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


    public function yearly(){
        $user = auth()->guard('user')->user();
        $school_id = $user->employmentDepartment->first()->schools->first()->school_id;
        $departments = ACADEMICDEPARTMENTS::where('school_id', $school_id)->pluck('department_id');
        $data = CourseTransfersView::whereIn('department_id', $departments)->latest()->get()->groupBy('intake_id');
        return  view('dean::transfers.yearly')->with(['data' => $data, 'departments' => $departments]);
    }

    public function declineTransferRequest(Request $request, $id){
        $intake = CourseTransfersView::where('course_transfer_id', $id)->first()->intake_id;
        CourseTransferApproval::where('course_transfer_id', $id)->update([
            'dean_status' => 2,
            'dean_remarks' => $request->remarks,
            'dean_user_id' => auth()->guard('user')->user()->user_id
        ]);
        return redirect()->route('dean.transfer', $intake)->with('success', 'Course transfer request accepted');
    }

    public function acceptTransferRequest($id){
        $intake = CourseTransfersView::where('course_transfer_id', $id)->first()->intake_id;
        CourseTransferApproval::where('course_transfer_id', $id)->update([
            'dean_status' => 1,
            'dean_remarks' => 'Admission approved',
            'dean_user_id' => auth()->guard('user')->user()->user_id
        ]);
        return redirect()->route('dean.transfer', $intake)->with('success', 'Course transfer request accepted');
    }

    public function viewUploadedDocument($id){
        $course = CourseTransfersView::where('course_transfer_id', $id)->first();
        $document = AdmissionDocument::where('application_id', $course->application_id)->first();
        return response()->file('Admissions/Certificates/' . $document->certificates);
    }

    public function transfer($id) {
        $user = auth()->guard('user')->user();
        $school_id = $user->employmentDepartment->first()->schools->first()->school_id;
        $departments = ACADEMICDEPARTMENTS::where('school_id', $school_id)->pluck('department_id');
        $data = CourseTransfersView::whereIn('department_id', $departments)->where('cod_status', '!=', null)->orderBy('department_id', 'asc')->get();
        return view('dean::transfers.index')->with(['transfer' => $data, 'departments' => $departments, 'intake' => $id]);
    }

    public function viewTransfer($id) {
        $student =  CourseTransfersView::where('course_transfer_id', $id)->first();
        return view('dean::transfers.viewTransfer')->with(['student' => $student]);
    }

    public function applications() {
        $departments = SchoolDepartment::where('school_id', auth()->guard('user')->user()->employmentDepartment->first()->schools->first()->school_id)->pluck('department_id');
        $courses = Courses::whereIn('department_id', $departments)->pluck('course_id');
        $applications = ApplicationsView::whereIn('course_id', $courses)
            ->where('dean_status', '!=', 3)
            ->where('registrar_status', null)
            ->orWhere('registrar_status', 4)
            ->latest()
            ->get();

        return view('dean::applications.index')->with('apps', $applications);
    }

    public function viewApplication($id){
        $app = ApplicationsView::where('application_id', $id)->first();
        $school = Education::where('applicant_id', $app->applicant_id)->get();
        return view('dean::applications.viewApplication')->with(['app' => $app, 'school' => $school]);
    }

    public function previewApplication($id){
        $app = ApplicationsView::where('application_id', $id)->first();
        $school = Education::where('applicant_id', $app->applicant_id)->get();
        return view('dean::applications.preview')->with(['app' => $app, 'school' => $school]);
    }

    public function acceptApplication($id){
        $app = ApplicationApproval::where('application_id', $id)->first();
        $app->dean_status = 1;
        $app->dean_comments = 'Application Accepted';
        if ($app->registrar_status != NULL) {
            $app->registrar_status = NULL;
        }
        $app->dean_user_id = auth()->guard('user')->user()->user_id;
        $app->save();

        return redirect()->route('dean.applications')->with('success', '1 applicant approved');
    }

    public function rejectApplication(Request $request, $id){
        $app = ApplicationApproval::where('application_id', $id)->first();
        $app->dean_status = 2;
        $app->dean_comments = $request->comment;
        if ($app->registrar_status != NULL) {
            $app->registrar_status = NULL;
        }
        $app->dean_user_id = auth()->guard('user')->user()->user_id;
        $app->save();
        return redirect()->route('dean.applications')->with('success', 'Application declined');
    }

    public function batch(){
        $departments = SchoolDepartment::where('school_id', auth()->guard('user')->user()->employmentDepartment->first()->schools->first()->school_id)->pluck('department_id');
        $courses = Courses::whereIn('department_id', $departments)->pluck('course_id');
        $applications = ApplicationsView::whereIn('course_id', $courses)
            ->where('registrar_status', null)
            ->where('dean_status', '<=', 3)
            ->where('cod_status', '<=', 2)
            ->latest()
            ->get();
        return view('dean::applications.batch')->with('apps', $applications);
    }

    public function batchSubmit(Request $request){

        foreach ($request->submit as $item) {
            $app = ApplicationApproval::where('application_id', $item)->first();
            if ($app->dean_status == 2) {
                $app->dean_status = null;
                $app->registrar_status = null;
                $app->cod_status = 3;
            }
            if ($app->dean_status == 1) {
                $app->registrar_status = 0;
            }
            $app->save();

//            $logs = new DeanLog;
//            $logs->application_id = $app->id;
//            $logs->user = Auth::guard('user')->user()->name;
//            $logs->user_role = Auth::guard('user')->user()->role_id;
//
//            if ($app->dean_status == 3) {
//
//                $logs->activity = 'Your application has been reverted to COD office for review';
//            } else {
//                $logs->activity = 'Your Application has been forwarded to registry office';
//            }
//
//            $logs->save();
        }

        return redirect()->route('dean.batch')->with('success', '1 Batch send to next level of approval');
    }
}
