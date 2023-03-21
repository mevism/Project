<?php

namespace Modules\Dean\Http\Controllers;

use Auth;
use LDAP\Result;
use App\Models\User;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Dean\Entities\DeanLog;
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
use Modules\Student\Entities\ReadmissionApproval;
use Modules\Student\Entities\AcademicLeaveApproval;
use Modules\Student\Entities\CourseTransferApproval;
use Modules\Workload\Entities\ApproveWorkload;

class DeanController extends Controller
{

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

       return $hashedId = Crypt::decrypt($id);

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
                       
        foreach($workloads  as  $workload){

        $updateLoad  =  Workload::find($workload->id);
        $updateLoad->status  =  1;
        $updateLoad->save();

       }

        return redirect()->back()->with('success', 'Workload Published Successfully');
    }

    public function submitWorkload($id){

        $hashedId = Crypt::decrypt($id);

        $submitApproval = ApproveWorkload::where('id', $hashedId)->first();
        $submitApproval->registrar_status = 0;
        $submitApproval->save();    

        return redirect()->back()->with('success', 'Workload Approved Successfully');
    }

    public function revertWorkload($id){

        $hashedId = Crypt::decrypt($id);

        $revert        =      ApproveWorkload::where('id', $hashedId)->where('dean_status', '>',  1)->latest()->first();
        
        $workloads = Workload::where('workload_approval_id', $hashedId)->get();

        foreach($workloads  as  $workload){

            $updateLoad  =  Workload::find($workload->id);
            $updateLoad->status  =  0;
            $updateLoad->save();
    
           }

        return redirect()->back()->with('success', 'Workload Reverted to COD Successfully.');
    }


    public function printWorkload($id){

        $hashedId = Crypt::decrypt($id);

        $user = Auth()->guard('user')->user();

        $staff_number = $user->staff_number;

        $name = $user->first_name.' '.$user->last_name.' '. $user->middle_name;

        $school = auth()->guard('user')->user()->employmentDepartment->first()->schools->first();

        $roles  =  $user->roles->first()->name;

        $dept = auth()->guard('user')->user()->employmentDepartment->first()->id;
        
        $workloads  =  Workload::where('department_id', $dept)->where('status', 1)->where('workload_approval_id', $hashedId)->get();

        $domPdfPath = base_path('vendor/dompdf/dompdf');
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $center = ['bold' => true];

        $table = new Table(array('unit' => TblWidth::TWIP));
        $headers = ['bold' => true, 'space' => ['before' => 2000, 'after' => 2000, 'rule' => 'exact']];
        $table->addRow();
        $table->addCell(200, ['borderSize' => 1])->addText('#', $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 11, 'bold' => true]);
        $table->addCell(5000, ['borderSize' => 1])->addText('STAFF', $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 11, 'bold' => true]);
        $table->addCell(5000, ['borderSize' => 1])->addText('CLASS', $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 11, 'bold' => true]);
        $table->addCell(5000, ['borderSize' => 1])->addText('UNIT', $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 11, 'bold' => true]);

        $table->addRow();
        $table->addCell(200, ['borderSize' => 1])->addText('#');
            $table->addCell(1500, ['borderSize' => 1])->addText('Staff Number', $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 11, 'bold' => true]);
            $table->addCell(1500, ['borderSize' => 1])->addText('Staff Name', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
            $table->addCell(1500, ['borderSize' => 1])->addText('Qualification', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
            $table->addCell(1750, ['borderSize' => 1])->addText('Responsibility', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
            $table->addCell(1000, ['borderSize' => 1])->addText('Class Code', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
            $table->addCell(2600, ['borderSize' => 1])->addText('Workload', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
            $table->addCell(1500, ['borderSize' => 1])->addText('Students',  $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
            $table->addCell(1750, ['borderSize' => 1])->addText('Unit Code', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
            $table->addCell(1750, ['borderSize' => 1])->addText('Unit Name', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
            $table->addCell(1750, ['borderSize' => 1])->addText('Level', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
            $table->addCell(1750, ['borderSize' => 1])->addText('Signature', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);




        
        // foreach ($workloads as $key =>  $workload) {
          
        //     
        //     $table->addRow(600);
            

        //     foreach ($workload as $key => $list) {
        //         $table->addRow();
        //         $table->addCell(200, ['borderSize' => 1])->addText(++$key);
        //         $table->addCell(2800, ['borderSize' => 1])->addText($staff_number);
        //         $table->addCell(1900, ['borderSize' => 1])->addText($name);
        //         $table->addCell(1900, ['borderSize' => 1])->addText($name);
        //         $table->addCell(1750, ['borderSize' => 1])->addText($roles);
        //         $table->addCell(1000, ['borderSize' => 1])->addText($roles);
        //         $table->addCell(2600, ['borderSize' => 1])->addText($roles);
        //         $table->addCell(1500, ['borderSize' => 1])->addText($staff_number);
        //         $table->addCell(1500, ['borderSize' => 1])->addText($staff_number);
        //         $table->addCell(1500, ['borderSize' => 1])->addText($staff_number);
        //         $table->addCell(1500, ['borderSize' => 1])->addText($staff_number);
        //         $table->addCell(1750, ['borderSize' => 1])->addText();
        //     }
        // }
            $workload = new TemplateProcessor(storage_path('workload_template.docx'));

            $workload->setValue('initials', $school->initials);
            $workload->setValue('name', $school->name);
            $workload->setValue('academic_year', $workloads->first()->academic_year);
            $workload->setValue('academic_semester', $workloads->first()->academic_semester);
            $workload->setComplexBlock('{table}', $table);
            $docPath = 'Fees/' . 'Workload' . time() . ".docx";
            $workload->saveAs($docPath);

            $contents = \PhpOffice\PhpWord\IOFactory::load($docPath);

            // $pdfPath = 'Fees/' . 'Workload' . time() . ".pdf";

            // $converter =  new OfficeConverter($docPath, 'Fees/');
            // $converter->convertTo('Workload' . time() . ".pdf");

            // if (file_exists($docPath)) {
            //     unlink($docPath);
            // }
        

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

    public function requestedTransfers($year)
    {
        $hashedYear = Crypt::decrypt($year);

        $user = Auth::guard('user')->user();
        $by = $user->name;
        $dept = $user->getSch->initials;
        $role = $user->userRoles->name;

        $departments   =   Department::where('school_id', auth()->guard('user')->user()->school_id)->get();
        foreach ($departments as $department) {
            $transfers[] = CourseTransfer::where('department_id', $department->id)
                ->where('academic_year', $hashedYear)
                ->latest()
                ->get()
                ->groupBy('course_id');
        }

        $school = Auth::guard('user')->user()->getSch->name;
        $courses = Courses::all();

        $domPdfPath = base_path('vendor/dompdf/dompdf');
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $center = ['bold' => true];

        $table = new Table(array('unit' => TblWidth::TWIP));

        foreach ($transfers as $transfered) {
            foreach ($transfered as $course_id => $transfer) {
                foreach ($courses as $listed) {
                    if ($listed->id == $course_id) {
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
                    $name = $list->studentTransfer->reg_number . "<w:br/>\n" . $list->studentTransfer->sname . ' ' . $list->studentTransfer->fname . ' ' . $list->studentTransfer->mname;
                    if ($list->approveTransfer == null) {
                        $remarks = 'Missed Deadline';
                        $deanRemark = 'Declined';
                    } else {
                        $remarks = $list->approvedTransfer->cod_remarks;
                        $deanRemark = $list->approvedTransfer->dean_remarks;
                    }
                    $table->addRow();
                    $table->addCell(400, ['borderSize' => 1])->addText(++$key);
                    $table->addCell(2700, ['borderSize' => 1])->addText($name);
                    $table->addCell(1900, ['borderSize' => 1])->addText($list->studentTransfer->courseStudent->studentCourse->course_code);
                    $table->addCell(1900, ['borderSize' => 1])->addText($list->courseTransfer->course_code);
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
                    if ($listed->id == $course_id) {
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

        $converter =  new OfficeConverter($docPath, 'Fees/');
        $converter->convertTo('Transfers' . time() . ".pdf");

        if (file_exists($docPath)) {
            unlink($docPath);
        }

        //        return response()->download($docPath)->deleteFileAfterSend(true);
        return response()->download($pdfPath)->deleteFileAfterSend(true);
    }


    public function yearly()
    {

        $school_id = auth()->guard('user')->user()->employmentDepartment->first()->schools->first()->id;

        $departments   =   Department::where('division_id', 1)->get();
        foreach ($departments as $department) {
            if ($department->schools->first()->id == $school_id) {

                $deptTransfers[] = $department->schools->first()->id;
            }
        }

        foreach ($deptTransfers as $deptTransfer) {
            $data[] = CourseTransfer::where('department_id', $deptTransfer)
                ->latest()
                ->get()
                ->groupBy('academic_year');
        }

        return  view('dean::transfers.yearly')->with(['data' => $data, 'departments' => $departments]);
    }


    public function declineTransferRequest(Request $request, $id)
    {
        $hashedId = Crypt::decrypt($id);
        $year = CourseTransferApproval::find($hashedId)->transferApproval->academic_year;

        $approval = CourseTransferApproval::find($hashedId);
        $approval->dean_status = 2;
        $approval->dean_remarks = $request->remarks;
        $approval->save();


        return redirect()->route('dean.transfer', ['year' => Crypt::encrypt($year)])->with('success', 'Course transfer request accepted');
    }

    public function acceptTransferRequest($id)
    {

        $hashedId = Crypt::decrypt($id);

        $year = CourseTransferApproval::find($hashedId)->transferApproval->academic_year;

        $approval = CourseTransferApproval::find($hashedId);
        $approval->dean_status = 1;
        $approval->dean_remarks = 'Admit Student';
        $approval->save();

        return redirect()->route('dean.transfer', ['year' => Crypt::encrypt($year)])->with('success', 'Course transfer request accepted');
    }

    public function viewUploadedDocument($id)
    {

        $hashedId = Crypt::decrypt($id);

        $course = CourseTransferApproval::find($hashedId);

        $document = Application::where('reg_number', $course->transferApproval->studentTransfer->reg_number)->first();


        return response()->file('Admissions/Certificates/' . $document->admissionDoc->certificates);
    }

    public function transfer($year)
    {
        $hashedYear = Crypt::decrypt($year);

        $departments   =   Department::where('school_id', auth()->guard('user')->user()->school_id)->get();

        foreach ($departments as $department) {

            $transfers = CourseTransfer::where('department_id', $department->id)
                ->where('academic_year', $hashedYear)
                ->latest()
                ->get();
            foreach ($transfers as $record) {
                $transfer[] = CourseTransferApproval::where('course_transfer_id', $record->id)
                    ->where('cod_status', '!=', null)
                    ->latest()
                    ->get();
            }
        }

        return view('dean::transfers.index')->with(['transfer' => $transfer, 'departments' => $departments, 'year' => $hashedYear]);
    }

    public function viewTransfer($id)
    {

        $hashedId = Crypt::decrypt($id);


        $data = CourseTransferApproval::find($hashedId);

        return view('dean::transfers.viewTransfer')->with(['data' => $data]);
    }

    public function preview($id)
    {

        $hashedId = Crypt::decrypt($id);
        $data = CourseTransferApproval::find($hashedId);
        return view('dean::transfers.preview')->with(['data' => $data]);
    }



    public function applications()
    {

        $applications = Application::where('dean_status', '!=', 3)
            ->where('school_id', auth()->guard('user')->user()->school_id)
            ->where('registrar_status', null)
            ->orWhere('registrar_status', 4)
            ->orderBy('id', 'DESC')
            ->get();

        return view('dean::applications.index')->with('apps', $applications);
    }

    public function viewApplication($id)
    {

        $hashedId = Crypt::decrypt($id);

        $app = Application::find($hashedId);
        $school = Education::where('applicant_id', $app->applicant->id)->get();

        return view('dean::applications.viewApplication')->with(['app' => $app, 'school' => $school]);
    }

    public function previewApplication($id)
    {

        $hashedId = Crypt::decrypt($id);

        $app = Application::find($hashedId);
        $school = Education::where('applicant_id', $app->applicant->id)->get();
        return view('dean::applications.preview')->with(['app' => $app, 'school' => $school]);
    }

    public function acceptApplication($id)
    {

        $hashedId = Crypt::decrypt($id);

        $app = Application::find($hashedId);
        $app->dean_status = 1;
        if ($app->registrar_status != NULL) {
            $app->registrar_status = NULL;
        }
        $app->save();

        $logs = new DeanLog;
        $logs->application_id = $app->id;
        $logs->user = Auth::guard('user')->user()->name;
        $logs->user_role = Auth::guard('user')->user()->role_id;
        $logs->activity = 'Application accepted';
        $logs->save();

        return redirect()->route('dean.applications')->with('success', '1 applicant approved');
    }

    public function rejectApplication(Request $request, $id)
    {

        $hashedId = Crypt::decrypt($id);

        $app = Application::find($hashedId);
        $app->dean_status = 2;
        $app->dean_comments = $request->comment;
        $app->save();

        $logs = new DeanLog;
        $logs->application_id = $app->id;
        $logs->user = Auth::guard('user')->user()->name;
        $logs->user_role = Auth::guard('user')->user()->role_id;
        $logs->activity = 'Application rejected';
        $logs->comments = $request->comment;
        $logs->save();

        return redirect()->route('dean.applications')->with('success', 'Application declined');
    }

    public function batch()
    {
        $apps = Application::where('dean_status', '>', 0)
            ->where('school_id', auth()->guard('user')->user()->school_id)
            ->where('registrar_status', null)
            ->where('dean_status', '!=', 3)
            ->where('cod_status', '<=', 2)
            ->orwhere('registrar_status', 4)
            ->get();

        return view('dean::applications.batch')->with('apps', $apps);
    }

    public function batchSubmit(Request $request)
    {

        foreach ($request->submit as $item) {
            $app = Application::find($item);
            if ($app->dean_status == 2) {
                $app->dean_status = 3;
                $app->cod_status = 3;
            }
            if ($app->dean_status == 1) {
                $app->registrar_status = 0;
            }
            $app->save();

            $logs = new DeanLog;
            $logs->application_id = $app->id;
            $logs->user = Auth::guard('user')->user()->name;
            $logs->user_role = Auth::guard('user')->user()->role_id;

            if ($app->dean_status == 3) {

                $logs->activity = 'Your application has been reverted to COD office for review';
            } else {
                $logs->activity = 'Your Application has been forwarded to registry office';
            }

            $logs->save();
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
