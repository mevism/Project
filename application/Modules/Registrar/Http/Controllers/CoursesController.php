<?php

namespace Modules\Registrar\Http\Controllers;

use QrCode;
use Carbon\Carbon;
use App\Models\User;
use App\Imports\UnitImport;
use Illuminate\Http\Request;
use App\Imports\CourseImport;
use App\Imports\KuccpsImport;
use Illuminate\Routing\Controller;
use App\Imports\UnitProgrammsImport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Registrar\Entities\Unit;
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
use Modules\Registrar\Entities\SemesterFee;
use Modules\Student\Entities\AcademicLeave;
use Modules\Student\Entities\DeferredClass;
use NcJoes\OfficeConverter\OfficeConverter;
use Modules\Finance\Entities\StudentInvoice;
use Modules\Registrar\Entities\AcademicYear;
use Modules\Registrar\Entities\RegistrarLog;
use Modules\Registrar\Entities\StudentLogin;
use Modules\Student\Entities\CourseTransfer;
use Modules\Student\Entities\StudentDeposit;
use Modules\Application\Entities\Application;
use Modules\Registrar\Entities\CourseHistory;
use Modules\Registrar\Entities\SchoolHistory;
use Modules\Registrar\Entities\StudentCourse;
use Modules\Registrar\Entities\UnitProgramms;
use Modules\Application\Entities\Notification;
use Modules\Registrar\Entities\ClusterWeights;
use Modules\Workload\Entities\ApproveWorkload;
use Modules\Registrar\emails\AcademicLeaveMail;
use Modules\Registrar\Entities\AvailableCourse;
use Modules\Registrar\Entities\ClusterSubjects;
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

    public function workload()
    {

        $schools   =   School::all();
        foreach ($schools as $school) {
            $data = ApproveWorkload::all()->groupBy('academic_year');
        }

        return view('registrar::workload.index')->with(['data' => $data, 'schools' => $schools]);
    }

    public function schoolWorkload($year)
    {

        $hashedYear  =  Crypt::decrypt($year);

        $schools =  School::all();



        return view('registrar::workload.schoolWorkload')->with(['year' => $hashedYear])->with(['schools'  =>  $schools]);
    }

    public function departmentalWorkload($id, $year)
    {

        $hashedYear  =  Crypt::decrypt($year);

        $hashedId = Crypt::decrypt($id);

        $departs   =   Department::where('division_id', 1)->get();

        foreach ($departs as $department) {
            if ($department->schools->first()->id == $hashedId) {

                $deptWorkloads[] = $department->id;
            }
        }

        $departments = [];

        foreach ($deptWorkloads as $wrkload) {

            $departments[] = ApproveWorkload::where('department_id', $wrkload)
                ->where('academic_year', $hashedYear)
                ->where('dean_status', '!=', null)
                ->latest()
                ->get();
        }


        return view('registrar::workload.departmentalWorkload')->with(['departs' => $departs, 'year'  =>  $hashedYear, 'departments' => $departments]);
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


    public function approveWorkload(Request $request, $id)
    {

        $hashedId = Crypt::decrypt($id);

         $workloadId  = Workload::where('workload_approval_id',$hashedId)->get();

            $updateApproval = ApproveWorkload::where('id', $hashedId)
                ->where('dean_status', '!=', null)
                ->first();
            $updateApproval->registrar_status = 1;
            $updateApproval->registrar_remarks = 'Workload Approved';
            $updateApproval->status = 1;
            $updateApproval->save();

            foreach($workloadId  as  $workload){

                $updateWorkload  =   Workload::find($workload->id);
                $updateWorkload->status  =  0;
                $updateWorkload->save();
            }
       
        return redirect()->back()->with('success', 'Workload Approved Successfully');
    }

    public function declineWorkload(Request $request, $id)
    {

        $hashedId = Crypt::decrypt($id);
      
            $updateApproval = ApproveWorkload::where('id', $hashedId)
                ->where('dean_status', '!=', null)
                ->first();

            $updateApproval->registrar_status = 2;
            $updateApproval->registrar_remarks = $request->remarks;
            $updateApproval->status = 2;
            $updateApproval->save();       

        return redirect()->back()->with('success', 'Workload Declined');
    }

    public function readmissions()
    {
        $schools   =   School::all();
        foreach ($schools as $school) {
            $data = Readmission::all()->groupBy('academic_year');
        }

        return  view('registrar::readmissions.index')->with(['data' => $data, 'schools' => $schools]);
    }
    public function yearlyReadmissions($year)
    {
        $hashedYear = Crypt::decrypt($year);
        $schools   =   School::all();
        $readmissions  =  Readmission::where('academic_year', $hashedYear)->get();

        return view('registrar::readmissions.yearlyReadmissions')->with(['readmissions' => $readmissions, 'schools' => $schools, 'year' => $hashedYear]);
    }

    public function acceptedReadmissions(Request $request)
    {

        $request->validate(['submit' => 'required']);

        foreach ($request->submit as $id) {

            $approval = Readmission::find($id);
            //  return $approval->studentReadmission->reg_number;

            if ($approval->readmissionApproval->dean_status == 1) {

                Mail::to($approval->studentReadmission->student_email)->send(new AcceptedReadmissionsMail($approval));

                StudentCourse::where('student_id', $approval->studentReadmission->id)->update(['class_code' => $approval->readmissionsReadmitClass->class_code, 'class' => $approval->readmissionsReadmitClass->class_code]);

                $approved = ReadmissionApproval::where('readmission_id', $id)->first();
                $approved->registrar_status  =  1;
                $approved->save();

                $student = Student::find($approval->student_id);
                $student->status = 1;
                $student->save();

                $approval->status = 1;
                $approval->save();
            } else {

                Mail::to($approval->studentLeave->student_email)->send(new RejectedReadmissionsMail($approval));

                $rejected = ReadmissionApproval::find($id);
                $rejected->registrar_status  =  1;
                $rejected->save();

                $approval->status = 2;
                $approval->save();
            }
        }



        return redirect()->back()->with('success', 'Email sent successfuly.');
    }

    public function leaves()
    {

        $schools   =   School::all();
        foreach ($schools as $school) {
            $data = AcademicLeave::all()->groupBy('academic_year');
        }

        return  view('registrar::leaves.yearlyLeaves')->with(['data' => $data, 'schools' => $schools]);
    }

    public function academicLeave($year)
    {
        $hashedYear = Crypt::decrypt($year);
        $schools   =   School::all();
        $leaves  =  AcademicLeave::where('academic_year', $hashedYear)->get();

        return view('registrar::leaves.index')->with(['leaves' => $leaves, 'schools' => $schools, 'year' => $hashedYear]);
    }

    public function acceptedAcademicLeaves(Request $request)
    {

        $request->validate(['submit' => 'required']);

        foreach ($request->submit as $id) {

            $approval = AcademicLeave::find($id);

            if ($approval->approveLeave->dean_status == 1) {

                Mail::to($approval->studentLeave->student_email)->send(new AcademicLeaveMail($approval));

                $approved = AcademicLeaveApproval::where('academic_leave_id', $id)->first();
                $approved->registrar_status  =  1;
                $approved->status  =  1;
                $approved->save();

                $student = Student::find($approval->student_id);
                $student->status = 3;
                $student->save();
            } else {

                Mail::to($approval->studentLeave->student_email)->send(new RejectedAcademicMail($approval));

                $rejected = AcademicLeaveApproval::find($id);
                $rejected->registrar_status  =  1;
                $rejected->status  =  2;
                $rejected->save();
            }

            return $newStudentCourse          =       new StudentCourse;
        }

        return redirect()->back()->with('success', 'Email sent successfuly.');
    }

    public function acceptedTransfers(Request $request)
    {

        $request->validate(['submit' => 'required']);

        //  return $request->all();

        foreach ($request->submit as $id) {


            $approvedID = CourseTransferApproval::find($id);

            $approval = CourseTransfer::find($approvedID->course_transfer_id);
            if ($approvedID->dean_status == 1) {

                $date = Carbon::now()->format('Y-m-d');

                $intakes  =  Intake::where('intake_from', '<', $date)
                    ->where('intake_to', '>', $date)
                    ->latest()
                    ->first();

                $registered = StudentCourse::withTrashed()
                    ->where('intake_id', $intakes->id)
                    ->where('course_id', $approval->course_id)
                    ->count();

                $course = Courses::find($approval->course_id);

                $regNumber = $course->course_code . '/' . str_pad($registered + 1, 3, "0", STR_PAD_LEFT) . "J/" . Carbon::parse($intakes->academicYear->year_start)->format('Y');

                $refNumber = 'XFER/' . date('Y') . "/" . str_pad(0000000 + $approval->id, 6, "0", STR_PAD_LEFT);

                $student = $approval->studentTransfer;

                $domPdfPath        =         base_path('vendor/dompdf/dompdf');
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
                $my_template->setValue('from', Carbon::parse($intakes->intake_from)->format('D, d-m-Y'));
                $my_template->setValue('to', Carbon::parse($intakes->intake_from)->addDays(4)->format('D, d-m-Y'));

                $docPath         =         storage_path(str_replace('/', '_', $refNumber) . ".docx");

                $my_template->saveAs($docPath);

                $contents         =         \PhpOffice\PhpWord\IOFactory::load(storage_path(str_replace('/', '_', $refNumber) . ".docx"));

                $pdfPath          =          storage_path(str_replace('/', '_', $refNumber) . ".pdf");

                if (file_exists($pdfPath)) {
                    unlink($pdfPath);
                }

                //                    $converter     =     new OfficeConverter($docPath, storage_path());
                //                    $converter->convertTo(str_replace('/', '_', $refNumber).".pdf");
                //
                //                    if(file_exists($docPath)){
                //                        unlink($docPath);
                //                    }



                $record = Student::withTrashed()->find($approval->student_id)->delete();

                $oldRecord = Student::withTrashed()->find($approval->student_id);

                StudentCourse::where('student_id', $approval->student_id)->delete();
                StudentLogin::where('student_id', $approval->student_id)->delete();

                // return $s = StudentInvoice::where($record->reg_number)->get();

                $invoices  =  StudentInvoice::where('reg_number', 'BSIT/002J/2023')->get();
                $deposits  =  StudentDeposit::where('reg_number', $oldRecord->reg_number)->get();


                $record = Student::withTrashed()->find($approval->student_id)->delete();

                $oldRecord = Student::withTrashed()->find($approval->student_id);

                StudentCourse::where('student_id', $approval->student_id)->delete();
                StudentLogin::where('student_id', $approval->student_id)->delete();

                // return $s = StudentInvoice::where($record->reg_number)->get();

                $invoices  =  StudentInvoice::where('reg_number', $oldRecord->reg_number)->get();
                $deposits  =  StudentDeposit::where('reg_number', $oldRecord->reg_number)->get();

                $oldstudent = Student::withTrashed()->find($id);

                $newStudent               =             new Student;

                $newStudent->reg_number   =             $regNumber;
                $newStudent->ref_number   =             $refNumber;
                $newStudent->sname        =             $student->sname;
                $newStudent->fname        =             $student->fname;
                $newStudent->mname        =             $student->mname;
                $newStudent->email        =             $student->email;
                $newStudent->student_email =            strtolower(str_replace('/', '', $regNumber) . '@students.tum.ac.ke');
                $newStudent->mobile       =             $student->mobile;
                $newStudent->alt_mobile   =             $student->alt_mobile;
                $newStudent->title        =             $student->title;
                $newStudent->marital_status =           $student->marital_status;
                $newStudent->gender       =             $student->gender;
                $newStudent->dob          =             $student->dob;
                $newStudent->id_number    =             $student->id_number;
                $newStudent->citizen      =             $student->citizen;
                $newStudent->county       =             $student->county;
                $newStudent->sub_county   =             $student->sub_county;
                $newStudent->town         =             $student->town;
                $newStudent->address      =             $student->address;
                $newStudent->postal_code  =             $student->postal_code;
                $newStudent->disabled     =             $student->disabled;
                $newStudent->disability   =             $student->disability;
                $newStudent->save();


                $newStudCourse                =             new StudentCourse;
                $newStudCourse->student_id    =             $newStudent->id;
                $newStudCourse->student_type  =             2;
                $newStudCourse->department_id =             $approval->department_id;
                $newStudCourse->course_id     =             $approval->course_id;
                $newStudCourse->intake_id     =             $intakes->id;
                $newStudCourse->academic_year_id =          $intakes->academic_year_id;
                $newStudCourse->class_code    =             strtoupper($approval->classTransfer->name);
                $newStudCourse->class         =             strtoupper($approval->classTransfer->name);
                $newStudCourse->course_duration =           $course->courseRequirements->course_duration;
                $newStudCourse->save();

                $newStudLogin    =  new StudentLogin;
                $newStudLogin->student_id       =   $newStudent->id;
                $newStudLogin->username         =   $newStudent->reg_number;
                $newStudLogin->password         =   Hash::make($newStudent->id_number);
                $newStudLogin->save();

                $oldStudentInvoice  =  StudentInvoice::find($id);

                foreach ($invoices as $invoice) {

                    $newInvoice  =  new StudentInvoice;
                    $newInvoice->student_id  =  $newStudent->id;
                    $newInvoice->reg_number  =  $newStudent->reg_number;
                    $newInvoice->invoice_number = $oldStudentInvoice->invoice_number;
                    $newInvoice->stage = $oldStudentInvoice->stage;
                    $newInvoice->amount = $oldStudentInvoice->amount;
                    $newInvoice->description = $oldStudentInvoice->description;
                    $newInvoice->save();

                    StudentInvoice::find($invoice->id)->delete();
                }

                $oldStudentDeposit  =  StudentDeposit::find($id);
                foreach ($deposits as $deposit) {

                    $newDeposit  =  new StudentDeposit;
                    $newDeposit->reg_number  =  $newStudent->reg_number;
                    $newDeposit->deposit = $oldStudentDeposit->deposit;
                    $newDeposit->description = $oldStudentDeposit->description;
                    $newDeposit->invoice_number = $oldStudentDeposit->invoice_number;
                    $newDeposit->save();

                    StudentDeposit::find($deposit->id)->delete();
                }


                Mail::to($newStudent->email)->send(new CourseTransferMails($newStudent));

                $approved = CourseTransferApproval::find($id);
                $approved->registrar_status  =  1;
                $approved->status  =  1;
                $approved->save();

                $approval->status = 2;
                $approval->save();
            } else {

                $rejectedMail = CourseTransferApproval::find($id);
                $oldStud =  $rejectedMail->transferApproval;

                // return $oldStud;

                Mail::to($oldStud->studentTransfer->email)->send(new CourseTransferRejectedMails($oldStud));


                $rejectedMail->registrar_status  =  1;
                $rejectedMail->status  =  2;
                $rejectedMail->save();

                $transferStatus =  CourseTransfer::find($rejectedMail->course_transfer_id);
                $transferStatus->status = 3;
                $transferStatus->save();
            }
        }

        return redirect()->back()->with('success', 'Course Transfer Letters Generated');
    }
    public function coursePreview($id)
    {
        return $courseName = Courses::find($id);
        $data = CourseHistory::where('course_id', $id)->latest()->get();
        return view('registrar::course.preview')->with(['data' => $data, 'courseName' => $courseName]);
    }

    public function departmentPreview($id)
    {
        $departmentName = Department::find($id);
        $data = DepartmentHistory::where('department_id', $id)->latest()->get();
        return view('registrar::department.preview')->with(['data' => $data, 'departmentName' => $departmentName]);
    }

    public function schoolPreview($id)
    {
        $schoolName = School::find($id);
        $data = SchoolHistory::where('school_id', $id)->latest()->get();
        return view('registrar::school.preview')->with(['data' => $data, 'schoolName' => $schoolName]);
    }

    public function transfer($year)
    {
        $hashedYear = Crypt::decrypt($year);
        $schools   =   School::all();

        $transfers  =  CourseTransfer::where('academic_year', $hashedYear)->get();
        foreach ($transfers as $record) {

            $transfer[] = CourseTransferApproval::where('course_transfer_id', $record->id)
                ->where('dean_status', '!=', null)
                ->latest()
                ->get();
            // ->groupBy($record->department_id);
        }
        // return $transfer;

        return view('registrar::transfers.index')->with(['transfer' => $transfer, 'schools' => $schools, 'year' => $hashedYear, 'year' => $hashedYear]);
    }

    public function yearly()
    {

        $schools   =   School::all();
        foreach ($schools as $school) {
            $data = CourseTransfer::all()->groupBy('academic_year');
        }

        return  view('registrar::transfers.yearlyTransfers')->with(['data' => $data, 'schools' => $schools]);
    }

    public function requestedTransfers($year)
    {
        $hashedYear = Crypt::decrypt($year);
        $user = Auth::guard('user')->user();
        $by = $user->name;
        $role = $user->roles->first()->name;
        $school  =  "UNIVERSITY INTER/INTRA FACULTY COURSE TRANSFERS";
        $dept = 'ACADEMIC AFFAIRS';

        $transfers = CourseTransfer::where('academic_year', $hashedYear)
            ->latest()
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
                if ($listed->id == $course) {
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
                $name = $list->studentTransfer->reg_number . "<w:br/>\n" . $list->studentTransfer->sname . ' ' . $list->studentTransfer->fname . ' ' . $list->studentTransfer->mname;
                if ($list->approvedTransfer == null) {
                    $remarks = 'Missed Deadline';
                    $deanRemark = 'Declined';
                } else {
                    $remarks = $list->approvedTransfer->cod_remarks;
                    $deanRemark = $list->approvedTransfer->dean_remarks;
                }
                $table->addRow();
                $table->addCell(200, ['borderSize' => 1])->addText(++$key);
                $table->addCell(2800, ['borderSize' => 1])->addText($name);
                $table->addCell(1900, ['borderSize' => 1])->addText($list->studentTransfer->courseStudent->studentCourse->course_code);
                $table->addCell(1900, ['borderSize' => 1])->addText($list->courseTransfer->course_code);
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
                if ($listed->id == $group) {
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

        $converter =  new OfficeConverter($docPath, 'Fees/');
        $converter->convertTo('Transfers' . time() . ".pdf");

        if (file_exists($docPath)) {
            unlink($docPath);
        }

        return response()->download($pdfPath)->deleteFileAfterSend(true);
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
    /**
     * voteheads
     *
     * @return void
     */
    public function voteheads()
    {

        return view('registrar::fee.voteheads');
    }

    public function showVoteheads()
    {
        $show  = VoteHead::latest()->get();

        return view('registrar::fee.showVoteheads', compact('show'));
    }

    public function storeVoteheads(Request $request)
    {

        $voteheads  = new VoteHead();
        $voteheads->name  =  $request->input('name');
        $voteheads->save();

        return redirect()->route('courses.showVoteheads')->with('success', 'votehead added successfully.');
    }

    public function editVotehead($id)
    {
        $hashedId  =  Crypt::decrypt($id);
        $data                  =         VoteHead::find($hashedId);
        return view('registrar::fee.editVotehead')->with(['data' => $data]);
    }

    public function updateVotehead(Request $request, $id)
    {

        $data                  =         VoteHead::find($id);
        $data->name            =         $request->input('name');
        $data->update();

        return redirect()->route('courses.showVoteheads')->with('status', 'Data Updated Successfully');
    }

    public function destroyVotehead($id)
    {
        $data             =            VoteHead::find($id);
        $data->delete();
        return redirect()->route('courses.showVoteheads');
    }
    /**
     * semester fees
     *
     * @return void
     */
    public function semFee()
    {
        $courses  =  Courses::all();
        $modes    =  Attendance::all();
        $levels   =  Level::all();
        $votes    =  VoteHead::all();

        return view('registrar::fee.semFee')->with(['courses' => $courses, 'modes' => $modes, 'levels' => $levels, 'votes' => $votes]);
    }
    public function showSemFee()
    {

        $courses  = CourseLevelMode::latest()->get();

        return view('registrar::fee.showsemFee')->with(['courses' => $courses]);
    }

    public function storeSemFee(Request $request)
    {

        $request->validate([

            'course' => 'required',
            'level' => 'required',
            'attendance' => 'required'

        ]);

        $courseFee = new CourseLevelMode();
        $courseFee->course_id = $request->input('course');
        $courseFee->level_id = $request->input('level');
        $courseFee->attendance_id = $request->input('attendance');
        $courseFee->save();


        $voteheads = $request->voteheads;
        $semester1_amount = $request->semester1;
        $semester2_amount = $request->semester2;

        for ($i = 0; $i < count($semester1_amount); $i++) {

            if (empty($semester1_amount[$i])) continue; // skip all the blank ones

            $semester = [
                'course_level_mode_id' => $courseFee->id,
                'voteheads_id'   =>  $voteheads[$i],
                'semesterI'    =>  $semester1_amount[$i],
                'semesterII'    =>  $semester2_amount[$i]
            ];
            SemesterFee::create($semester);
        }

        return redirect()->route('courses.showSemFee')->with('success', 'Fee added successfully.');
    }

    public function viewSemFee($id)
    {
        $hashedId  =  Crypt::decrypt($id);
        $course =  CourseLevelMode::find($hashedId);
        $semester = SemesterFee::where('course_level_mode_id', $hashedId)
            ->orderBy('voteheads_id', 'asc')->get();

        return view('registrar::fee.viewSemFee')->with(['semesterI' => $semester, 'course' => $course, 'id' => $hashedId]);
    }

    public function printFee($id)
    {
        $hashedId  =  Crypt::decrypt($id);
        $course =  CourseLevelMode::find($hashedId);

        $semester = SemesterFee::where('course_level_mode_id', $hashedId)->orderBy('voteheads_id', 'asc')->get();

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

    public function syllabus($id)
    {
        $hashedId  =  Crypt::decrypt($id);
        $course   =   Courses::find($hashedId);
        $unit   =  UnitProgramms::where('course_code', $course->course_code)->get();
        return view('registrar::course.syllabus')->with(['units' => $unit, 'course' => $course]);
    }

    public function createUnits(Request $request, $id)
    {
        $hashedId  =  Crypt::decrypt($id);
        $course = Courses::find($hashedId);

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
        $app                     =         Application::find($id);
        $app->registrar_status   =         1;
        $app->save();

        $logs                    =         new     RegistrarLog;
        $logs->application_id            =         $app->id;
        $logs->user              =         Auth::guard('user')->user()->name;
        $logs->user_role         =         Auth::guard('user')->user()->role_id;
        $logs->activity          =         'Application accepted';
        $logs->save();
        return redirect()->route('courses.applications')->with('success', '1 applicant approved');
    }

    public function rejectApplication(Request $request, $id)
    {
        $app                       =        Application::find($id);
        $app->registrar_status     =        2;
        $app->registrar_comments   =        $request->comment;
        $app->save();
        $logs                      =       new RegistrarLog;
        $logs->application_id              =       $app->id;
        $logs->user                =       Auth::guard('user')->user()->name;
        $logs->user_role           =       Auth::guard('user')->user()->role_id;
        $logs->activity            =       'Application rejected';
        $logs->comments            =       $request->comment;
        $logs->save();
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

        $app                       =        Application::find($id);
        $school                    =        Education::where('applicant_id', $app->applicant->id)->get();

        return view('registrar::offer.viewApplication')->with(['app' => $app, 'school' => $school]);
    }

    public function accepted()
    {

        $kuccps         =          KuccpsApplicant::where('status', 0)->get();
        foreach ($kuccps as $applicant) {
            // return $applicant->kuccpsApplication->course_code;

            $course        =          Courses::where('course_code', $applicant->kuccpsApplication->course_code)->first();
            // return $course;
            $regNumber     = Application::where('course_id', $course->id)
                ->where('intake_id', $applicant->kuccpsApplication->intake_id)
                ->where('student_type', 2)
                ->count();
            $app                   =        new Applicant;

            $app->index_number     =         $applicant->index_number;
            $app->password         =         Hash::make($applicant->index_number);
            $app->username         =         $applicant->index_number;
            $app->email            =         $applicant->email;
            $app->alt_email        =         $applicant->alt_email;
            $app->sname            =         $applicant->sname;
            $app->fname            =         $applicant->fname;
            $app->mname            =         $applicant->mname;
            $app->gender           =         $applicant->gender;
            $app->phone_verification =       1;
            $app->email_verified_at =        date('d-m-Y');
            $app->mobile            =        $applicant->mobile;
            $app->alt_mobile        =        $applicant->alt_mobile;
            $app->town              =        $applicant->town;
            $app->address           =        $applicant->BOX;
            $app->postal_code       =        $applicant->postal;
            $app->student_type      =         2;
            $app->save();

            $app_course                 =            new Application;
            $app_course->applicant_id        =            $app->id;
            $app_course->intake_id      =            $applicant->kuccpsApplication->intake_id;
            $app_course->department_id  =            $course->department_id;
            $app_course->school_id      =            $course->getCourseDept->school_id;
            $app_course->course_id      =            $course->id;
            $app_course->finance_status =            1;
            $app_course->cod_status     =            1;
            $app_course->dean_status    =            1;
            $app_course->registrar_status =          3;
            $app_course->status         =            1;
            $app_course->student_type   =            2;
            $app_course->ref_number     =            'APP/' . date('Y') . "/" . str_pad(0000000 + $applicant->id, 6, "0", STR_PAD_LEFT);
            $app_course->reg_number     =            $applicant->kuccpsApplication->course_code . "/" . str_pad($regNumber + 1, 3, "0", STR_PAD_LEFT) . "J" . "/" . Carbon::parse($applicant->kuccpsApplication->kuccpsIntake->intake_from)->format('Y');
            $app_course->adm_letter     =            'APP' . "_" . date('Y') . "_" . str_pad(0000000 + $applicant->id, 6, "0", STR_PAD_LEFT) . '.pdf';
            $app_course->save();

            $domPdfPath     =    base_path('vendor/dompdf/dompdf');
            \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
            \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

            $my_template            =          new TemplateProcessor(storage_path('adm_template.docx'));

            $my_template->setValue('name', strtoupper($applicant->sname . " " . $applicant->mname . " " . $applicant->fname));
            $my_template->setValue('box', strtoupper($applicant->BOX));
            $my_template->setValue('address', strtoupper($applicant->address));
            $my_template->setValue('postal_code', strtoupper($applicant->postal_code));
            $my_template->setValue('town', strtoupper($applicant->town));
            $my_template->setValue('course', $applicant->kuccpsApplication->course_name);
            $my_template->setValue('department', $course->getCourseDept->name);
            $my_template->setValue('duration', $course->courseRequirements->course_duration);
            $my_template->setValue('from', Carbon::parse($applicant->kuccpsApplication->kuccpsIntake->intake_from)->format('d-m-Y'));
            $my_template->setValue('to', Carbon::parse($applicant->kuccpsApplication->kuccpsIntake->intake_to)->format('d-m-Y'));
            $my_template->setValue('reg_number', $applicant->kuccpsApplication->course_code . "/" . str_pad(1 + $regNumber, 3, "0", STR_PAD_LEFT) . "J" . "/" . Carbon::parse($applicant->kuccpsApplication->kuccpsIntake->intake_from)->format('Y'));
            $my_template->setValue('ref_number', 'APP/' . date('Y') . "/" . str_pad(0000000 + $applicant->id, 6, "0", STR_PAD_LEFT));
            $my_template->setValue('date',  date('d-M-Y'));

            $docPath         =         storage_path('APP' . "_" . date('Y') . "_" . str_pad(0000000 + $applicant->id, 6, "0", STR_PAD_LEFT) . ".docx");

            $my_template->saveAs($docPath);

            $contents         =         \PhpOffice\PhpWord\IOFactory::load($docPath);

            $pdfPath          =          storage_path('APP' . "_" . date('Y') . "_" . str_pad(0000000 + $applicant->id, 6, "0", STR_PAD_LEFT) . ".pdf");

            if (file_exists($pdfPath)) {
                unlink($pdfPath);
            }

            $converter     =     new OfficeConverter(storage_path('APP' . "_" . date('Y') . "_" . str_pad(0000000 + $applicant->id, 6, "0", STR_PAD_LEFT) . ".docx"), storage_path());
            $converter->convertTo('APP' . "_" . date('Y') . "_" . str_pad(0000000 + $applicant->id, 6, "0", STR_PAD_LEFT) . '.pdf');
            if (file_exists($docPath)) {
                unlink($docPath);
            }
            Application::where('applicant_id', $applicant->id)->update(['status' => 0]);
            KuccpsApplicant::where('id', $applicant->id)->update(['status' => 1]);
            if ($applicant->alt_email != null) {
                Mail::to($applicant->alt_email)->send(new KuccpsMails($applicant));
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
        $up        =         UnitProgramms::all();
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
        $vz        =          $request->validate([
            'excel_file'   =>    'required|mimes:xlsx'
        ]);
        $excel_file         =         $request->excel_file;
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
        $vz        =         $request->validate([
            'excel_file'   =>    'required|mimes:xlsx'
        ]);
        $excel_file         =         $request->excel_file;
        Excel::import(new UnitProgrammsImport(), $excel_file);
        return back()->with('success', 'Data Imported Successfully');
    }

    public function importUnits(Request $request)
    {
        $vz            =        $request->validate([
            'excel_file'   =>    'required|mimes:xlsx'
        ]);
        $excel_file         =         $request->excel_file;
        Excel::import(new UnitImport(), $excel_file);
        return back()->with('success', 'Data Imported Successfully');
    }

    public function importkuccps(Request $request)
    {
        $vz         =          $request->validate([

            'excel_file'   =>    'required|mimes:xlsx'
        ]);
        $excel_file          =           $request->excel_file;
        $intake_id           =           $request->intake;
        Excel::import(new KuccpsImport($intake_id), $excel_file);
        return back()->with('success', 'Data Imported Successfully');
    }

    public function applications()
    {
        $accepted              =          Application::where('registrar_status', '>=', 0)
            ->where('registrar_status', '!=', 3)
            ->where('registrar_status', '!=', 4)
            ->get();
        return view('registrar::offer.applications')->with('accepted', $accepted);
    }

    public function showKuccps()
    {
        $kuccps           =        KuccpsApplicant::orderBy('id', 'desc')->get();
        return view('registrar::offer.showKuccps')->with(['kuccps' => $kuccps]);
    }

    public function offer()
    {
        $active         =         Intake::where('status', 1)->get();
        if (count($active) == 0) {
            $courses       =        $active;
            return view('registrar::offer.coursesOffer', compact('courses'));
        } else {
            foreach ($active as $intake) {

                $courses[]        =        AvailableCourse::where('intake_id', $intake->id)->get();
            }
            return view('registrar::offer.coursesOffer', compact('courses', 'active'));
        }
    }

    public function profile()
    {
        return view('registrar::profilepage');
    }

    public function acceptedMail(Request $request)
    {
        $request->validate([
            'submit'       =>      'required'
        ]);
        foreach ($request->submit as $id) {

            $app       =      Application::find($id);

            if ($app->registrar_status == 1 && $app->cod_status == 1) {

                $regNo         =        Application::where('course_id', $app->course_id)
                    ->where('intake_id', $app->intake_id)
                    ->where('student_type', 1)
                    ->where('registrar_status', 3)
                    ->count();

                $domPdfPath        =         base_path('vendor/dompdf/dompdf');
                \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
                \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

                $my_template         =        new TemplateProcessor(storage_path('adm_template.docx'));

                $my_template->setValue('name', strtoupper($app->applicant->sname . " " . $app->applicant->mname . " " . $app->applicant->fname));
                $my_template->setValue('box', strtoupper($app->applicant->address));
                $my_template->setValue('postal_code', strtoupper($app->applicant->postal_code));
                $my_template->setValue('town', strtoupper($app->applicant->town));
                $my_template->setValue('course', $app->courses->course_name);
                $my_template->setValue('department', $app->courses->getCourseDept->name);
                $my_template->setValue('duration', $app->courses->courseRequirements->course_duration);
                $my_template->setValue('from', Carbon::parse($app->app_intake->intake_from)->format('d - m - Y'));
                $my_template->setValue('to', Carbon::parse($app->app_intake->intake_from)->addDays(4)->format('d - m - Y'));
                $my_template->setValue('campus', $app->courses->courseXAvailable->courseXCampus->name);
                $my_template->setValue('reg_number', $app->courses->course_code . "/" . str_pad(1 + $regNo, 4, "0", STR_PAD_LEFT) . "/" . Carbon::parse($app->app_intake->intake_from)->format('Y'));
                $my_template->setValue('ref_number', 'APP/' . date('Y') . "/" . str_pad(0000000 + $app->id, 6, "0", STR_PAD_LEFT));
                $my_template->setValue('date',  date('d-M-Y'));

                $docPath       =        storage_path('APP' . "_" . date('Y') . "_" . str_pad(0000000 + $app->id, 6, "0", STR_PAD_LEFT) . ".docx");

                $my_template->saveAs($docPath);

                $contents       =        \PhpOffice\PhpWord\IOFactory::load($docPath);

                $pdfPath        =        storage_path('APP' . "_" . date('Y') . "_" . str_pad(0000000 + $app->id, 6, "0", STR_PAD_LEFT) . ".pdf");

                if (file_exists($pdfPath)) {
                    unlink($pdfPath);
                }

                $converter      =        new OfficeConverter(storage_path('APP' . "_" . date('Y') . "_" . str_pad(0000000 + $app->id, 6, "0", STR_PAD_LEFT) . ".docx"), storage_path());
                $converter->convertTo('APP' . "_" . date('Y') . "_" . str_pad(0000000 + $app->id, 6, "0", STR_PAD_LEFT) . '.pdf');

                if (file_exists($docPath)) {
                    unlink($docPath);
                }

                $update          =       Application::find($id);
                $update->registrar_status       =    3;
                $update->status                 =    0;
                $update->ref_number             =    'APP/' . date('Y') . "/" . str_pad(0000000 + $app->id, 6, "0", STR_PAD_LEFT);
                $update->reg_number             =    $app->courses->course_code . "/" . str_pad(1 + $regNo, 4, "0", STR_PAD_LEFT) . "/" . Carbon::parse($app->app_intake->intake_from)->format('Y');
                $update->adm_letter             =    'APP' . "_" . date('Y') . "_" . str_pad(0000000 + $app->id, 6, "0", STR_PAD_LEFT) . ".pdf";
                $update->save();

                $comms = new Notification;
                $comms->application_id = $id;
                $comms->role_id = Auth::guard('user')->user()->role_id;
                $comms->subject = 'Application Approval Process';
                $comms->comment = 'Congratulations! Your application was successful. Got to My Courses section to download your admission letter.';
                $comms->status = 1;
                $comms->save();
                Mail::to($app->applicant->email)->send(new \App\Mail\RegistrarEmails($app->applicant));
            }
            if ($app->finance_status == 3 && $app->registrar_status == 1) {

                $update          =         Application::find($id);
                $update->finance_status         =       0;
                $update->registrar_status       =       NULL;
                $update->save();
            }
            if ($app->cod_status == 1 && $app->registrar_status == 2) {

                Application::where('id', $id)->update(['cod_status' => 3, 'dean_status' => 3, 'registrar_status' => 4]);
            }
            if ($app->cod_status == 2 && $app->registrar_status == 1) {

                Application::where('id', $id)->update(['cod_status' => 3, 'dean_status' => 3, 'registrar_status' => 4]);
            }
            if ($app->cod_status == 2 && $app->registrar_status == 1) {

                $update         =         Application::find($id);
                $update->registrar_status         =        3;
                $update->save();

                $comms = new Notification;
                $comms->application_id = $id;
                $comms->role_id = Auth::guard('user')->user()->role_id;
                $comms->subject = 'Application Approval Process';
                $comms->comment = 'Oops! Your application was not successful. You can go to Courses on offer section and apply for another course that you meet the minimum course requirements.';
                $comms->status = 1;
                $comms->save();

                Mail::to($app->applicant->email)->send(new \App\Mail\RegistrarEmails1($app->applicant));

                $update = Application::find($id);
                $update->registrar_status = 3;
                $update->save();
            }
        }
        return redirect()->back()->with('success', 'Report Generated');
    }

    public function addYear()
    {
        return view('registrar::academicYear.addAcademicYear');
    }

    public function academicYear()
    {
        $years          =          AcademicYear::latest()->get();
        return view('registrar::academicYear.showAcademicYear')->with('years', $years);
    }

    public function storeYear(Request $request)
    {
        $vz = $request->validate([
            'year_start'             =>      'required',
            'year_end'               =>      'required'

        ]);
        $year                         =         new AcademicYear();
        $year->year_start             =         $request->input('year_start');
        $year->year_end               =         $request->input('year_end');
        $year->status                 =         0;
        $year->save();

        return redirect()->route('courses.academicYear')->with('success', 'Academic Year Created successfuly');
    }

    public function destroyYear($id)
    {
        $data           =          AcademicYear::find($id);
        $data->delete();
        return redirect()->route('courses.academicYear');
    }

    public function showSemester($id)
    {

        $hashedId  =  Crypt::decrypt($id);
        $year      = AcademicYear::find($hashedId);
        $intakes     =   Intake::where('academic_year_id', $hashedId)->latest()->get();
        return view('registrar::academicYear.showSemester')->with(['intakes' => $intakes, 'year' => $year]);
    }

    /**
     * Show the form for a new Intake Information.
     *
     */
    public function addIntake($id)
    {
        $hashedId  =  Crypt::decrypt($id);
        $years         =         AcademicYear::find($hashedId);
        $data          =         Intake::all();
        $courses       =         Courses::all();


        return view('registrar::intake.addIntake')->with(['data' => $data, 'years' => $years, 'courses' => $courses]);
    }

    public function editstatusIntake($id)
    {

        $hashedId = Crypt::decrypt($id);
        $data        =      Intake::find($hashedId);
        return view('registrar::intake.editstatusIntake')->with(['data' => $data]);
    }

    public function statusIntake(Request $request, $id)
    {
        $request->validate(['status' => 'required']);

        $hashedId  =  Crypt::decrypt($id);
        if ($request->status == 1) {
            Intake::where('status', 1)->update(['status' => 2]);
            AvailableCourse::where('status', 1)->update(['status' => 0]);

            $data               =       Intake::find($hashedId);
            $data->status       =       $request->input('status');
            $data->save();

            AvailableCourse::where('intake_id', $hashedId)->update(['status' => 1]);
        } else {

            $data             =       Intake::find($hashedId);
            $data->status     =       $request->input('status');
            $data->save();

            AvailableCourse::where('intake_id', $hashedId)->update(['status' => 0]);
        }

        return redirect()->route('courses.showSemester', ['id' => Crypt::encrypt($data->academic_year_id)])->with('status', 'Data Updated Successfully');
    }

    public function storeIntake(Request $request, $id)
    {
        $vz = $request->validate([
            'year'                  =>       'required',
            'intake_name_from'      =>       'required',
            'intake_name_to'        =>       'required'

        ]);


        $intake                     =         new Intake;
        $intake->academic_year_id   =         $request->input('year');
        $intake->intake_from        =         $request->input('intake_name_from');
        $intake->intake_to          =         $request->input('intake_name_to');
        $intake->status             =         0;
        $intake->save();

        return redirect()->route('courses.showSemester', ['id' => Crypt::encrypt($id)])->with('success', 'Intake Created successfuly');
    }

    public function showIntake()
    {
        $data       =      Intake::latest()->paginate(5);
        return view('registrar::intake.showIntake')->with('data', $data);
    }

    public function editIntake($id)
    {
        $courses        =         Courses::all();
        $data           =         Intake::find($id);
        $course[]      =         AvailableCourse::find($id);
        return view('registrar::intake.editIntake')->with(['data' => $data, 'courses' => $courses, 'course' => $course]);
    }


    public function updateIntake(Request $request, $id)
    {
        $data                   =      Intake::find($id);
        $data->intake_from      =      $request->input('intake_name_from');
        $data->intake_to        =      $request->input('intake_name_to');
        $data->save();
        foreach ($request->input('course') as $course_id) {
            $intakes               =        AvailableCourse::find($course_id)->id;
            $intakes->course_id    =        $course_id;
            $intakes->intake_id    =        $data->id;
            $intakes->save();
        }
        $data->intake_to           =        $request->input('intake_name_to');
        $data->update();
        return redirect()->route('courses.showIntake')->with('status', 'Data Updated Successfully');
    }

    public function destroyIntake($id)
    {
        $data         =       Intake::find($id);
        $data->delete();
        return redirect()->back()->with('success', 'record deleted successfully');
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
        $hashedId  =  Crypt::decrypt($id);
        $data         =        Attendance::find($hashedId);
        return view('registrar::attendance.editAttendance')->with('data', $data);
    }
    public function updateAttendance(Request $request, $id)
    {

        $data                       =         Attendance::find($id);
        $data->attendance_code      =         $request->input('code');
        $data->attendance_name      =         $request->input('name');
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
        $data      =     School::latest()->get();
        return view('registrar::school.showSchool')->with('data', $data);
    }

    public function editSchool($id)
    {
        $hashedId  =  Crypt::decrypt($id);
        $data      =     School::find($hashedId);
        return view('registrar::school.editSchool')->with('data', $data);
    }

    public function updateSchool(Request $request, $id)
    {
        $data                  =         School::find($id);

        $oldSchool = new SchoolHistory;
        $oldSchool->school_id = $data->id;
        $oldSchool->initials = $data->initials;
        $oldSchool->name = $data->name;
        $oldSchool->created_at = $data->created_at;
        $oldSchool->updated_at = $data->updated_at;
        $oldSchool->save();

        $newSchool = School::find($id);

        $newSchool->initials        =         $request->input('initials');
        $newSchool->name            =         $request->input('name');
        $newSchool->update();

        return redirect()->route('courses.showSchool')->with('status', 'Data Updated Successfully');
    }

    public function storeSchool(Request $request)
    {
        $vz                    =        $request->validate([
            // 'initials'         =>       'required|unique:schools',
            'name'             =>       'required|unique:schools'
        ]);
        $schools               =        new School;
        $schools->initials     =         $request->input('initials');
        $schools->name         =        $request->input('name');
        $schools->save();
        return redirect()->route('courses.showSchool')->with('success', 'School Created');
    }

    public function destroySchool($id)
    {
        $data         =        School::find($id);
        $data->delete();
        return redirect()->route('courses.showSchool');
    }

    /**
     *
     * Information about departments
     */
    public function addDepartment()
    {
        $schools       =       School::all();
        return view('registrar::department.addDepartment')->with('schools', $schools);
    }

    public function showDepartment()
    {

        $data      =       Department::where('division_id', 1)->latest()->get();
        return view('registrar::department.showDepartment')->with('data', $data);
    }

    public function storeDepartment(Request $request)
    {
        $vz                       =        $request->validate([
            'dept_code'           =>       'required|unique:departments',
            'name'                =>       'required|unique:departments'

        ]);
        $departments                =        new Department;
        $departments->school_id     =        $request->input('school');
        $departments->dept_code     =        $request->input('dept_code');
        $departments->name          =        $request->input('name');
        $departments->save();

        return redirect()->route('courses.showDepartment')->with('success', 'Department Created');
    }

    public function editDepartment($id)
    {
        $hashedId  =  Crypt::decrypt($id);
        $data            =        Department::find($hashedId);
        $schools         =        School::all();
        return view('registrar::department.editDepartment')->with(['data' => $data, 'schools' => $schools]);
    }

    public function updateDepartment(Request $request, $id)
    {

        $data                 =         Department::find($id);

        $oldDepartment  =  new DepartmentHistory;
        $oldDepartment->department_id = $data->id;
        $oldDepartment->school_id  = $data->school_id;
        $oldDepartment->name  = $data->name;
        $oldDepartment->dept_code  =  $data->dept_code;
        $oldDepartment->created_at = $data->created_at;
        $oldDepartment->updated_at = $data->updated_at;
        $oldDepartment->save();

        $newDepartment   = Department::find($id);
        $newDepartment->school_id      =         $request->input('school');
        $newDepartment->dept_code      =         $request->input('dept_code');
        $newDepartment->name           =         $request->input('name');
        $newDepartment->update();
        return redirect()->route('courses.showDepartment')->with('status', 'Data Updated Successfully');
    }

    public function destroyDepartment($id)
    {
        $data        =      Department::find($id);
        $data->delete();
        return redirect()->route('courses.showDepartment');
    }

    /**
     *
     * Information about Course
     */
    public function addCourse()
    {
        $schools             =        School::all();
        $departments         =        Department::where('division_id', 1)->latest()->get();
        $group               =        \Modules\Registrar\Entities\Group::all();
        return view('registrar::course.addCourse')->with(['schools' => $schools, 'departments' => $departments,  'groups' => $group]);
    }

    public function storeCourse(Request $request)
    {

        $vz = $request->validate([
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

        $subject          =          $request->subject;
        $subject1         =          $request->subject1;
        $subject2         =          $request->subject2;
        $subject3         =          $request->subject3;
        $data             =          implode(",", $subject);
        $data1            =          implode(",", $subject1);
        $data2            =          implode(",", $subject2);
        $data3            =          implode(",", $subject3);

        $courses                      =          new Courses();
        $courses->department_id       =          $request->input('department');
        $courses->course_name         =          $request->input('course_name');
        $courses->course_code         =          $request->input('course_code');
        $courses->level               =          $request->input('level');
        $courses->save();

        $requirement                      =         new CourseRequirement;
        $requirement->course_id           =         $courses->id;
        $requirement->course_duration     =         $request->input('course_duration');
        if ($request->level  == 1) {
            $requirement->fee  = '500';
        } elseif ($request->level  == 2) {
            $requirement->fee  = '500';
        } elseif ($request->level  == 3) {
            $requirement->fee  = '1000';
        } else {
            $requirement->fee  = '1500';
        }
        $requirement->course_requirements =           $request->input('course_requirements');
        $requirement->subject1            =           str_replace(',', '/', $data) . " " . $request->grade1;
        $requirement->subject2            =           str_replace(',', '/', $data1) . " " . $request->grade2;
        $requirement->subject3            =           str_replace(',', '/', $data2) . " " . $request->grade2;
        $requirement->subject4            =           str_replace(',', '/', $data3) . " " . $request->grade3;
        $requirement->save();

        return redirect()->route('courses.showCourse')->with('success', 'Course Created');
    }

    public function showCourse()
    {
        $data        =          Courses::orderBy('id', 'desc')->get();
        return view('registrar::course.showCourse')->with('data', $data);
    }

    public function editCourse($id)
    {


        $hashedId  =  Crypt::decrypt($id);

        $schools              =          School::all();
        $departments          =          Department::all();
        $data                 =          Courses::find($hashedId);
        $group                =          \Modules\Registrar\Entities\Group::all();
        return view('registrar::course.editCourse')->with(['groups' => $group, 'data' => $data, 'schools' => $schools, 'departments' => $departments]);
    }

    public function updateCourse(Request $request, $id)
    {

        $vz = $request->validate([
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

        $subject          =          $request->subject;
        $subject1         =          $request->subject1;
        $subject2         =          $request->subject2;
        $subject3         =          $request->subject3;
        $record             =          implode(",", $subject);
        $record1            =          implode(",", $subject1);
        $record2            =          implode(",", $subject2);
        $record3            =          implode(",", $subject3);

        $data                      =           Courses::find($id);

        if ($request->department == $data->department_id) {

            $oldCourse                      =      new  CourseHistory;
            $oldCourse->course_id           =           $data->id;
            $oldCourse->course_name         =           $data->course_name;
            $oldCourse->department_id       =           $data->department_id;
            $oldCourse->level               =           $data->level;
            $oldCourse->course_code         =           $data->course_code;
            $oldCourse->save();
        } else {

            return "null";
        }
        $newCourse                      =     Courses::find($id);
        $newCourse->course_name         =           $request->input('course_name');
        $newCourse->department_id       =           $request->input('department');
        $newCourse->level               =           $request->input('level');
        $newCourse->course_code         =           $request->input('course_code');
        $newCourse->save();

        $req              =             CourseRequirement::where('course_id', $id)->first();
        $req->course_duration           =             $request->input('course_duration');
        $req->course_requirements       =             $request->input('course_requirements');
        if ($request->level  == 1) {
            $req->fee  = '500';
        } elseif ($request->level  == 2) {
            $req->fee  = '500';
        } elseif ($request->level  == 3) {
            $req->fee  = '1000';
        } else {
            $req->fee  = '1500';
        }

        $req->subject1            =           str_replace(',', '/', $record) . " " . $request->grade1;
        $req->subject2            =           str_replace(',', '/', $record1) . " " . $request->grade2;
        $req->subject3            =           str_replace(',', '/', $record2) . " " . $request->grade3;
        $req->subject4            =           str_replace(',', '/', $record3) . " " . $request->grade4;
        $req->save();
        return redirect()->route('courses.showCourse')->with('status', 'Data Updated Successfully');
    }

    public function destroyCourse($id)
    {

        CourseRequirement::where('course_id', $id)->delete();
        Courses::find($id)->delete();

        return redirect()->route('courses.showCourse');
    }
    public function archived()
    {
        $archived             =          Application::where('registrar_status', 3)->get();
        return view('registrar::offer.archived')->with('archived', $archived);
    }

    public function destroyCoursesAvailable(Request $request, $id)
    {
        $course          =          AvailableCourse::find($id)->delete();
        return redirect()->route('courses.offer');
    }

    public function admissions()
    {
        $admission     =    AdmissionApproval::where('medical_status', 1)
            ->where('status', NULL)
            ->get();

        return view('registrar::admissions.index')->with('admission', $admission);
    }

    public function admissionsJab()
    {

        $admission      =      AdmissionApproval::where('medical_status', 1)
            ->where('student_type', 2)
            ->where('status', NULL)
            ->get();
        return view('registrar::admissions.kuccps')->with('admission', $admission);
    }

    public function admitStudent($id)
    {
        $app          =           AdmissionApproval::find($id);
        $student               =             new Student;

        $student->reg_number   =             $app->appApprovals->reg_number;
        $student->ref_number   =             $app->appApprovals->ref_number;
        $student->sname        =             $app->appApprovals->applicant->sname;
        $student->fname        =             $app->appApprovals->applicant->fname;
        $student->mname        =             $app->appApprovals->applicant->mname;
        $student->email        =             $app->appApprovals->applicant->email;
        $student->student_email =            strtolower(str_replace('/', '', $app->appApprovals->reg_number) . '@students.tum.ac.ke');
        $student->mobile       =             $app->appApprovals->applicant->mobile;
        $student->alt_mobile   =             $app->appApprovals->applicant->alt_mobile;
        $student->title        =             $app->appApprovals->applicant->title;
        $student->marital_status =           $app->appApprovals->applicant->marital_status;
        $student->gender       =             $app->appApprovals->applicant->gender;
        $student->dob          =             $app->appApprovals->applicant->DOB;
        $student->id_number    =             $app->appApprovals->applicant->id_number;
        $student->citizen      =             $app->appApprovals->applicant->nationality;
        $student->county       =             $app->appApprovals->applicant->county;
        $student->sub_county   =             $app->appApprovals->applicant->sub_county;
        $student->town         =             $app->appApprovals->applicant->town;
        $student->address      =             $app->appApprovals->applicant->address;
        $student->postal_code  =             $app->appApprovals->applicant->postal_code;
        $student->disabled     =             $app->appApprovals->applicant->disabled;
        $student->disability   =             $app->appApprovals->applicant->disability;
        $student->save();


        $studCourse                =             new StudentCourse;
        $studCourse->student_id    =             $student->id;
        $studCourse->student_type  =             $app->appApprovals->applicant->student_type;
        $studCourse->department_id =             $app->appApprovals->courses->department_id;
        $studCourse->course_id     =             $app->appApprovals->course_id;
        $studCourse->intake_id     =             $app->appApprovals->intake_id;
        $studCourse->academic_year_id =          $app->appApprovals->app_intake->academicYear->id;
        if ($app->appApprovals->applicant->student_type == 1) {
            $studCourse->class_code    =             strtoupper($app->appApprovals->courses->course_code . '/' . Carbon::parse($app->appApprovals->app_intake->intake_from)->format('MY') . '/S-FT');
            $studCourse->class         =             strtoupper($app->appApprovals->courses->course_code . '/' . Carbon::parse($app->appApprovals->app_intake->intake_from)->format('MY') . '/S-FT');
        } else {
            $studCourse->class_code    =             strtoupper($app->appApprovals->courses->course_code . '/' . Carbon::parse($app->appApprovals->app_intake->intake_from)->format('MY') . '/J-FT');
            $studCourse->class         =             strtoupper($app->appApprovals->courses->course_code . '/' . Carbon::parse($app->appApprovals->app_intake->intake_from)->format('MY') . '/J-FT');
        }
        $studCourse->course_duration =           $app->appApprovals->courses->courseRequirements->course_duration;
        $studCourse->save();

        $studLogin                 =             new StudentLogin;
        $studLogin->username       =             $app->appApprovals->reg_number;
        $studLogin->password       =             Hash::make($app->appApprovals->applicant->id_number);
        $studLogin->student_id     =             $student->id;
        $studLogin->save();

        $admin                     =             AdmissionApproval::find($id);
        $admin->registrar_status   =             1;
        $admin->accommodation_status =           0;
        $admin->save();

        $comms = new Notification;
        $comms->application_id = $app->appApprovals->id;
        $comms->role_id = Auth::guard('user')->user()->role_id;
        $comms->subject = 'Application Admission Process';
        $comms->comment = 'Congratulations! Your admission was successful. You are now a bona-fied student at TUM. You can now log in as a student using your registration number as user ID and ID/PASSPORT/BIRTH certificate number.';
        $comms->status = 1;
        $comms->save();

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

        $data         =           ClusterSubjects::where('group_id', $request->id)->get();
        return response()->json($data);
    }
}
