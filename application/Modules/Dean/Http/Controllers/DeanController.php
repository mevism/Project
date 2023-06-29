<?php

namespace Modules\Dean\Http\Controllers;

use Auth;
use App\Models\User;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Application\Entities\ApplicationApproval;
use Modules\COD\Entities\ApplicationsView;
use Modules\Dean\Entities\DeanLog;
use Modules\Registrar\Entities\ACADEMICDEPARTMENTS;
use Modules\Student\Entities\StudentView;
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

    public function yearlyExams()
    {
        $academicYears = ExamMarks::latest()->get()->groupBy('academic_year');

        return view('dean::exams.yearlyExams')->with(['academicYears' => $academicYears]);
    }

    public function viewYearlyExams($year)
    {

        $hashedYear = Crypt::decrypt($year);

        $semesters = ExamMarks::where('academic_year', $hashedYear)->latest()->get()->groupBy('academic_semester');

        return view('dean::exams.viewYearlyExams')->with(['semesters' => $semesters, 'year' => $hashedYear]);
    }

    public function exams($sem, $year)
    {
        $hashedSem = Crypt::decrypt($sem);
        $hashedYear = Crypt::decrypt($year);
        $schoolId = auth()->guard('user')->user()->employmentDepartment->first()->schools->first()->id;
        $departs   =   Department::where('division_id', 1)->get();

        foreach ($departs as $department) {

            if ($department->schools->first()->id == $schoolId) {

                $deptWorkloads[] = $department->id;
            }
        }
        $departments = [];

        foreach ($deptWorkloads as $load) {

            $departments[] = ExamWorkflow::where('department_id', $load)
                ->where('academic_year', $hashedYear)
                ->where('academic_semester', $hashedSem)
                ->latest()
                ->get()
                ->groupBy('department_id');
        }

        return view('dean::exams.index')->with(['departments' => $departments, 'sem' => $hashedSem, 'year' => $hashedYear]);
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

      $hashedId = Crypt::decrypt($id);

      $updateApprovals = ExamWorkflow::where('id', $hashedId)->first();
        $updateApprovals->dean_status = 1;
        $updateApprovals->dean_remarks = 'Exam Marks Approved';
        $updateApprovals->save();


      return redirect()->back()->with('success', 'Exam Marks Approved Successfully');
    }

    public function submitExamMarks($id){

        $hashedId = Crypt::decrypt($id);

            $updateApprovals = ExamWorkflow::where('id', $hashedId)->first();
            $updateApprovals->registrar_status = 0;
            $updateApprovals->save();


        return redirect()->back()->with('success', 'Exam Marks submitted Successfully');
      }

    public function declineExams(Request $request, $id){

        $hashedId = Crypt::decrypt($id);

        $updateApprovals = ExamWorkflow::where('id', $hashedId)->first();
            $updateApprovals->dean_status = 2;
            $updateApprovals->dean_remarks = $request->remarks;
            $updateApprovals->save();


        return redirect()->back()->with('success', 'Exam Marks Declined');
      }

      public function revertExamMarks($id)
    {

        $hashedId = Crypt::decrypt($id);

        $revert        =      ExamWorkflow::find($hashedId);
        $revert->dean_status = 2;
        $revert->save();

        $examMarks = ExamMarks::where('workflow_id', $hashedId)->get();

        foreach ($examMarks  as  $exam) {

            $exam  =  ExamMarks::find($exam->id);
            $exam->status  =  2;
            $exam->save();
        }

        return redirect()->back()->with('success', 'Exam Marks Reverted to COD Successfully.');
    }
    //workload
    public function yearlyWorkload()
    {
        $schoolId = auth()->guard('user')->user()->employmentDepartment->first()->schools->first()->id;
        $departs   =   Department::where('division_id', 1)->get();

        foreach ($departs as $department) {

            if ($department->schools->first()->id == $schoolId) {

                $deptWorkloads[] = $department->id;
            }
        }
        $departments = [];

        foreach ($deptWorkloads as $load) {

            $departments[] = ApproveWorkload::where('department_id', $load)
                ->latest()
                ->get();
        }

        return view('dean::workload.index')->with(['departments' => $departments]);
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

        return view('dean::workload.viewWorkload')->with(['semester' => $hashedId, 'workloads' => $workloads, 'users' => $users, 'id' => $hashedId]);
    }

    public function approveWorkload($id)
    {
        $hashedId = Crypt::decrypt($id);

        $updateApproval = ApproveWorkload::where('id', $hashedId)->first();
        $updateApproval->dean_status = 1;
        $updateApproval->dean_remarks = 'Workload Approved';
        $updateApproval->save();

        return redirect()->back()->with('success', 'Workload Approved Successfully');
    }

    public function declineWorkload(Request $request, $id)
    {
        $hashedId = Crypt::decrypt($id);

        $updateApproval = ApproveWorkload::where('id', $hashedId)->first();
        $updateApproval->dean_status = 2;
        $updateApproval->dean_remarks = $request->remarks;
        $updateApproval->save();


        return redirect()->back()->with('success', 'Workload Declined');
    }

    public function workloadPublished($id)
    {

        $hashedId = Crypt::decrypt($id);
        $workloads = Workload::where('workload_approval_id', $hashedId)->get();

        $workload        =      ApproveWorkload::where('id', $hashedId)
            ->where('dean_status', '!=', null)
            ->where('registrar_status', '==', 1)
            ->where('status', '==', 1)
            ->latest()
            ->get();

        foreach ($workloads  as  $workload) {

            $updateLoad  =  Workload::find($workload->id);
            $updateLoad->status  =  1;
            $updateLoad->save();
        }

        return redirect()->back()->with('success', 'Workload Published Successfully');
    }

    public function submitWorkload($id)
    {

        $hashedId = Crypt::decrypt($id);

        $submitApproval = ApproveWorkload::where('id', $hashedId)->first();
        $submitApproval->registrar_status = 0;
        $submitApproval->save();

        return redirect()->back()->with('success', 'Workload Approved Successfully');
    }

    public function revertWorkload($id){

        $hashedId = Crypt::decrypt($id);

        $revert        =      ApproveWorkload::find($hashedId);
        $revert->dean_status = 2;
        $revert->save();

        $workloads = Workload::where('workload_approval_id', $hashedId)->get();

        foreach ($workloads  as  $workload) {

            $updateLoad  =  Workload::find($workload->id);
            $updateLoad->status  =  2;
            $updateLoad->save();
        }

        return redirect()->back()->with('success', 'Workload Reverted to COD Successfully.');
    }

    public function printWorkload($id)
    {

        $hashedId = Crypt::decrypt($id);

        $users = User::all();

        foreach ($users as $user) {
            if ($user->hasRole('Lecturer')) {

                $lecturers[] = $user;
            }
        }

        $dept = auth()->guard('user')->user()->employmentDepartment->first();

        $session = Workload::where('department_id', $dept->id)->where('workload_approval_id', $hashedId)->first();

        $school = auth()->guard('user')->user()->employmentDepartment->first()->schools->first();

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
                    foreach ($staff->lecturerQualfs()->where('status', 1)->get() as $qualification) {
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

        $workload->setValue('initials', $school->initials);
        $workload->setValue('name', $school->name);
        $workload->setValue('department', $dept->name);
        $workload->setValue('academic_year', $session->academic_year);
        $workload->setValue('academic_semester', $session->academic_semester);
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


    public function readmissions()
    {

        $readmissions = Readmission::latest()->get()->groupBy('academic_year');

        return view('dean::readmissions.yearlyReadmissions')->with(['readmissions' => $readmissions]);
    }

    public function yearlyReadmissions($year)
    {

        $hashedYear = Crypt::decrypt($year);

        $admissions = Readmission::where('academic_year', $hashedYear)->latest()->get()->groupBy('academic_semester');

        return view('dean::readmissions.yearly')->with(['admissions' => $admissions, 'year' => $hashedYear]);
    }

    public function intakeReadmissions($intake, $year)
    {

        $hashedIntake = Crypt::decrypt($intake);
        $hashedYear = Crypt::decrypt($year);

        $school_id = auth()->guard('user')->user()->employmentDepartment->first()->schools->first()->id;

        $departments   =   Department::where('division_id', 1)->get();
        foreach ($departments as $department) {
            if ($department->schools->first()->id == $school_id) {

                $deptAdmission[] = $department->id;
            }
        }

        $readmissions = Readmission::where('academic_year', $hashedYear)->where('academic_semester', $hashedIntake)->get();

        $allReadmissions = [];

        foreach ($readmissions as $readmission) {
            if (in_array($readmission->leaves->studentLeave->courseStudent->department_id, $deptAdmission, false)) {
                $allReadmissions[] = $readmission;
            }
        }

        return view('dean::readmissions.intakeReadmissions')->with(['readmissions' => $allReadmissions, 'year' => $hashedYear]);
    }

    public function selectedReadmission($id)
    {

        $hashedId = Crypt::decrypt($id);

        $leave = Readmission::find($hashedId);

        $stage = Nominalroll::where('student_id', $leave->leaves->studentLeave->id)
            ->latest()
            ->first();
        $studentStage = $stage->year_study . '.' . $stage->semester_study;

        $patterns = ClassPattern::where('academic_year', '>', $stage->academic_year)
            ->where('period', $stage->academic_semester)
            ->where('semester', $studentStage)
            ->get()
            ->groupBy('class_code');

        if (count($patterns) == 0) {

            $classes = [];
        } else {

            foreach ($patterns as $class_code => $pattern) {

                $classes[] = Classes::where('name', $class_code)
                    ->where('course_id', $leave->leaves->studentLeave->courseStudent->course_id)
                    ->where('attendance_code', $leave->leaves->studentLeave->courseStudent->typeStudent->attendance_code)
                    ->where('name', '!=', $leave->leaves->studentLeave->courseStudent->class_code)
                    ->get()
                    ->groupBy('name');
            }
        }

        return view('dean::readmissions.selectedReadmission')->with(['classes' => $classes, 'leave' => $leave, 'stage' => $stage]);
    }
    public function acceptReadmission(Request $request, $id)
    {

        $request->validate([
            'class' => 'required'
        ]);

        $hashedId = Crypt::decrypt($id);

        $route = Readmission::find($hashedId);

        if (ReadmissionApproval::where('readmission_id', $hashedId)->exists()) {

            $placement = new ReadmissionClass;
            $placement->readmission_id = $hashedId;
            $placement->class_code = $request->class;
            $placement->save();


            $readmission = ReadmissionApproval::where('readmission_id', $hashedId)->first();
            $readmission->dean_status = 1;
            $readmission->dean_remarks = 'Admit student to ' . $request->class . ' class.';
            $readmission->save();
        } else {

            $placement = new ReadmissionClass;
            $placement->readmission_id = $hashedId;
            $placement->class_code = $request->class;
            $placement->save();

            $readmission = new ReadmissionApproval;
            $readmission->readmission_id = $hashedId;
            $readmission->dean_status = 1;
            $readmission->dean_remarks = 'Admit student to ' . $request->class . ' class.';
            $readmission->save();
        }

        return redirect()->route('dean.intakeReadmissions', ['intake' => Crypt::encrypt($route->academic_semester), 'year' => Crypt::encrypt($route->academic_year)])->with('success', 'Readmission request accepted');
    }

    public function declineReadmission(Request $request, $id)
    {

        $request->validate([
            'remarks' => 'required'
        ]);

        $hashedId = Crypt::decrypt($id);

        $route = Readmission::find($hashedId);

        if (ReadmissionApproval::where('readmission_id', $hashedId)->exists()) {

            ReadmissionClass::where('readmission_id', $hashedId)->delete();

            $readmission = ReadmissionApproval::where('readmission_id', $hashedId)->first();
            $readmission->dean_status = 2;
            $readmission->dean_remarks = $request->remarks;
            $readmission->save();
        } else {

            $readmission = new ReadmissionApproval;
            $readmission->readmission_id = $hashedId;
            $readmission->dean_status = 2;
            $readmission->dean_remarks = $request->remarks;
            $readmission->save();
        }

        return redirect()->route('dean.intakeReadmissions', ['intake' => Crypt::encrypt($route->academic_semester), 'year' => Crypt::encrypt($route->academic_year)])->with('success', 'Readmission request declined');
    }

    public function academicLeave()
    {

        $requests = AcademicLeave::latest()->get()->groupBy('academic_year');

        return view('dean::defferment.index')->with(['leaves' => $requests]);
    }

    public function yearlyAcademicLeave($year)
    {

        $hashedYear = Crypt::decrypt($year);

        $school_id = auth()->guard('user')->user()->employmentDepartment->first()->schools->first()->id;

        $departments   =   Department::where('division_id', 1)->get();
        foreach ($departments as $department) {
            if ($department->schools->first()->id == $school_id) {

                $deptLeaves[] = $department->id;
            }
        }

        $leaves = AcademicLeave::where('academic_year', $hashedYear)->latest()->get();

        $allLeaves = [];

        //        foreach ($departments as $department){
        //            $deptIds[] = $department->id;
        //        }

        foreach ($leaves as $leave) {

            // return $leave->studentLeave->courseStudent->department_id;
            if (in_array($leave->studentLeave->courseStudent->department_id, $deptLeaves, false)) {
                $allLeaves[] = $leave;
            }
        }


        return view('dean::defferment.annualLeaves')->with(['leaves' => $allLeaves, 'year' => $hashedYear]);
    }

    public function viewLeaveRequest($id)
    {

        $hashedId = Crypt::decrypt($id);

        $leave = AcademicLeave::find($hashedId);

        $student = Student::find($leave->student_id);

        $currentStage = Nominalroll::where('student_id', $leave->student_id)
            ->latest()
            ->first();

        return view('dean::defferment.viewRequests')->with(['leave' => $leave, 'current' => $currentStage, 'student' => $student]);
    }

    public function acceptLeaveRequest($id)
    {

        $hashedId = Crypt::decrypt($id);

        $leave = AcademicLeave::find($hashedId);

        if (AcademicLeaveApproval::where('academic_leave_id', $hashedId)->exists()) {

            $updateApproval = AcademicLeaveApproval::where('academic_leave_id', $hashedId)->first();
            $updateApproval->dean_status = 1;
            $updateApproval->dean_remarks = 'Request Accepted';
            $updateApproval->save();
        } else {

            $newApproval = new AcademicLeaveApproval;
            $newApproval->academic_leave_id = $hashedId;
            $newApproval->dean_status = 1;
            $newApproval->dean_remarks = 'Request Accepted';
            $newApproval->save();
        }

        return redirect()->route('dean.yearlyLeaves', ['year' => Crypt::encrypt($leave->academic_year)])->with('success', 'Deferment/Academic leave approved');
    }

    public function declineLeaveRequest(Request $request, $id)
    {

        $hashedId = Crypt::decrypt($id);

        $leave = AcademicLeave::find($hashedId);

        if (AcademicLeaveApproval::where('academic_leave_id', $hashedId)->exists()) {

            $updateApproval = AcademicLeaveApproval::where('academic_leave_id', $hashedId)->first();
            $updateApproval->dean_status = 2;
            $updateApproval->dean_remarks = $request->remarks;
            $updateApproval->save();
        } else {

            $newApproval = new AcademicLeaveApproval;
            $newApproval->academic_leave_id = $hashedId;
            $newApproval->dean_status = 2;
            $newApproval->dean_remarks = $request->remarks;
            $newApproval->save();
        }

        return redirect()->route('dean.yearlyLeaves', ['year' => Crypt::encrypt($leave->academic_year)])->with('success', 'Deferment/Academic leave declined.');
    }

    public function requestedTransfers($id) {
        $user = auth()->guard('user')->user();
        $by = $user->staffInfos->title." ".$user->staffInfos->last_name." ".$user->staffInfos->first_name." ".$user->staffInfos->miidle_name;
        $school = $user->employmentDepartment->first()->schools->first();
        $dept = $user->employmentDepartment->first()->name;
        $role = $user->roles->first()->name;
       $departments = ACADEMICDEPARTMENTS::where('school_id', $school->school_id)->get();
        foreach ($departments as $department) {
           $transfers[] = DB::table('coursetransfersview')->where('department_id', $department->department_id)
                ->where('intake_id', $id)
                ->get()
                ->groupBy('course_id');
        }

        $courses = Courses::all();

        $domPdfPath = base_path('vendor/dompdf/dompdf');
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $center = ['bold' => true];

        $table = new Table(array('unit' => TblWidth::TWIP));

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
                $table->addCell(5000, ['gridSpan' => 9,])->addText($courseName . ' ' . '(' . $courseCode . ')', $headers, ['spaceAfter' => 300, 'spaceBefore' => 300]);
                $table->addRow();
                $table->addCell(400, ['borderSize' => 1])->addText('#');
                $table->addCell(2700, ['borderSize' => 1])->addText('Student Name/ Reg. Number', $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 11, 'bold' => true]);
                $table->addCell(1900, ['borderSize' => 1])->addText('Programme/ Course Admitted', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
                $table->addCell(1900, ['borderSize' => 1])->addText('Programme/ Course Transferring', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
                $table->addCell(1750, ['borderSize' => 1])->addText('Programme/ Course Cut-off Points', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
                $table->addCell(1000, ['borderSize' => 1])->addText('Student Cut-off Points', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
                $table->addCell(2600, ['borderSize' => 1])->addText('COD Remarks', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
                $table->addCell(1500, ['borderSize' => 1])->addText('Dean Remarks', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
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

//                    return $list;
                    $table->addRow();
                    $table->addCell(400, ['borderSize' => 1])->addText(++$key);
                    $table->addCell(2700, ['borderSize' => 1])->addText($name);
                    $table->addCell(1900, ['borderSize' => 1])->addText($student->course_code);
                    $table->addCell(1900, ['borderSize' => 1])->addText($list->course_code);
                    $table->addCell(1750, ['borderSize' => 1])->addText($list->class_points);
                    $table->addCell(1000, ['borderSize' => 1])->addText($list->student_points);
                    $table->addCell(2600, ['borderSize' => 1])->addText($remarks);
                    $table->addCell(1500, ['borderSize' => 1])->addText($deanRemark);
                    $table->addCell(1750, ['borderSize' => 1])->addText();
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
                $summary->addCell(5000, ['borderSize' => 1])->addText($courseName, ['bold' => true]);
                $summary->addCell(1250, ['borderSize' => 1])->addText($courseCode, ['bold' => true]);
                $summary->addCell(1250, ['borderSize' => 1])->addText($transfer->count());

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


    public function yearly() {

        $user = auth()->guard('user')->user();
        $school_id = $user->employmentDepartment->first()->schools->first()->school_id;
        $departments = ACADEMICDEPARTMENTS::where('school_id', $school_id)->get();

        foreach ($departments as $deptmentTransfer) {
            $data[] = CourseTransfer::where('department_id', $deptmentTransfer->department_id)
                ->latest()
                ->withTrashed()
                ->get()
                ->groupBy('intake_id');
        }

        return  view('dean::transfers.yearly')->with(['data' => $data, 'departments' => $departments]);
    }


    public function declineTransferRequest(Request $request, $id){
        $intake = DB::table('coursetransfersview')->where('course_transfer_id', $id)->first()->intake_id;
        CourseTransferApproval::where('course_transfer_id', $id)->update([
            'dean_status' => 2,
            'dean_remarks' => $request->remarks,
        ]);
        return redirect()->route('dean.transfer', $intake)->with('success', 'Course transfer request accepted');
    }

    public function acceptTransferRequest($id){

        $intake = DB::table('coursetransfersview')->where('course_transfer_id', $id)->first()->intake_id;
        CourseTransferApproval::where('course_transfer_id', $id)->update([
            'dean_status' => 1,
            'dean_remarks' => 'Admit Student'
        ]);

        return redirect()->route('dean.transfer', $intake)->with('success', 'Course transfer request accepted');
    }

    public function viewUploadedDocument($id){
        $course = CourseTransfer::where('course_transfer_id', $id)->withTrashed()->first();
        $document = ApplicationApproval::where('reg_number', $course->studentTransfer->enrolledCourse->student_number)->first()->ApplicationsDocments;
        return response()->file('Admissions/Certificates/' . $document->certificates);
    }

    public function transfer($id) {
        $user = auth()->guard('user')->user();
        $school_id = $user->employmentDepartment->first()->schools->first()->school_id;
        $departments = ACADEMICDEPARTMENTS::where('school_id', $school_id)->get();

        foreach ($departments as $deptmentTransfer) {
            $data[] = DB::table('coursetransfersview')->where('department_id', $deptmentTransfer->department_id)
                ->where('cod_status', '>=', 1)
//                ->latest()
                ->get();
        }

        return view('dean::transfers.index')->with(['transfer' => $data, 'departments' => $departments, 'intake' => $id]);
    }

    public function viewTransfer($id) {
        $data =  DB::table('coursetransfersview')->where('course_transfer_id', $id)->first();
        $student_id = CourseTransfer::where('course_transfer_id', $id)->withTrashed()->first()->student_id;
        $student = StudentView::where('student_id', $student_id)->first();
        return view('dean::transfers.viewTransfer')->with(['data' => $data, 'student' => $student]);
    }

    public function applications() {
       $applications = ApplicationsView::where('dean_status', '!=', 3)
            ->where('school_id', auth()->guard('user')->user()->employmentDepartment->first()->schools->first()->school_id)
            ->where('registrar_status', null)
            ->orWhere('registrar_status', 4)
            ->latest()
            ->get();

        return view('dean::applications.index')->with('apps', $applications);
    }

    public function viewApplication($id)
    {

        $app = ApplicationsView::where('application_id', $id)->first();
        $school = Education::where('applicant_id', $app->applicant_id)->get();

        return view('dean::applications.viewApplication')->with(['app' => $app, 'school' => $school]);
    }

    public function previewApplication($id)
    {
        $app = ApplicationsView::where('application_id', $id)->first();
        $school = Education::where('applicant_id', $app->applicant_id)->get();
        return view('dean::applications.preview')->with(['app' => $app, 'school' => $school]);
    }

    public function acceptApplication($id)
    {
        $app = ApplicationApproval::where('application_id', $id)->first();
        $app->dean_status = 1;
        $app->dean_comments = 'Application Accepted';
        if ($app->registrar_status != NULL) {
            $app->registrar_status = NULL;
        }
        $app->save();

//        $logs = new DeanLog;
//        $logs->application_id = $app->id;
//        $logs->user = Auth::guard('user')->user()->name;
//        $logs->user_role = Auth::guard('user')->user()->role_id;
//        $logs->activity = 'Application accepted';
//        $logs->save();

        return redirect()->route('dean.applications')->with('success', '1 applicant approved');
    }

    public function rejectApplication(Request $request, $id)
    {
        $app = ApplicationApproval::where('application_id', $id)->first();
        $app->dean_status = 2;
        $app->dean_comments = $request->comment;
        if ($app->registrar_status != NULL) {
            $app->registrar_status = NULL;
        }
        $app->save();

//        $logs = new DeanLog;
//        $logs->application_id = $app->id;
//        $logs->user = Auth::guard('user')->user()->name;
//        $logs->user_role = Auth::guard('user')->user()->role_id;
//        $logs->activity = 'Application rejected';
//        $logs->comments = $request->comment;
//        $logs->save();

        return redirect()->route('dean.applications')->with('success', 'Application declined');
    }

    public function batch()
    {
        $apps = ApplicationsView::where('dean_status', '>', 0)
            ->where('school_id', auth()->guard('user')->user()->employmentDepartment->first()->schools->first()->school_id)
            ->where('registrar_status', null)
            ->where('dean_status', '<=', 3)
            ->where('cod_status', '<=', 2)
            ->latest()
            ->get();

        return view('dean::applications.batch')->with('apps', $apps);
    }

    public function batchSubmit(Request $request)
    {

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

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('dean::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('dean::create');
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
        return view('dean::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('dean::edit');
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
