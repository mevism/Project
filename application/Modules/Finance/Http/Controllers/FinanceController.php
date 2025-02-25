<?php

namespace Modules\Finance\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Crypt;
use Modules\Application\Entities\AdmissionApproval;
use Modules\Application\Entities\Application;
use Modules\Application\Entities\Education;
use Modules\COD\Entities\ClassPattern;
use Modules\Finance\Entities\FinanceLog;
use Illuminate\Support\Facades\Auth;
use Modules\Registrar\Entities\AcademicYear;
use Modules\Registrar\Entities\Classes;
use Modules\Registrar\Entities\Courses;
use Modules\Application\Entities\Notification;
use Modules\Registrar\Entities\Intake;
use Modules\Registrar\Entities\Student;
use Modules\Student\Entities\StudentCourse;
use Modules\Student\Entities\StudentDeposit;
use Modules\Student\Entities\StudentInfo;
use PhpParser\Node\Stmt\Return_;

class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function applications()
    {

        $applications = Application::where('cod_status', NULL)
            ->where('finance_status', '!=', 3)
            ->orderBy('id', 'DESC')
            ->get();

        return view('applications::applications.index')->with('apps', $applications);
    }

    public function viewApplication($id)
    {

        $hashedId = Crypt::decrypt($id);

        $app = Application::find($hashedId);

        return view('applications::applications.viewApplication')->with('app', $app);
    }

    public function previewApplication($id)
    {

        $hashedId = Crypt::decrypt($id);

        $app = Application::find($hashedId);
        return view('applications::applications.preview')->with('app', $app);
    }

    public function acceptApplication($id)
    {

        $hashedId = Crypt::decrypt($id);

        $app = Application::find($hashedId);
        $app->finance_status = 1;
        $app->save();

        $logs = new FinanceLog;
        $logs->application_id = $app->id;
        $logs->user = Auth::guard('user')->user()->name;
        $logs->user_role = Auth::guard('user')->user()->role_id;
        $logs->activity = 'Application accepted';
        $logs->save();

        return redirect()->route('finance.applications')->with('success', '1 applicant approved');
    }

    public function rejectApplication(Request $request, $id)
    {

        $hashedId = Crypt::decrypt($id);

        $app = Application::find($hashedId);
        $app->finance_status = 2;
        $app->finance_comments = $request->comment;
        $app->save();

        $logs = new FinanceLog;
        $logs->application_id = $app->id;
        $logs->user = Auth::guard('user')->user()->name;
        $logs->user_role = Auth::guard('user')->user()->role_id;
        $logs->comments = $request->comment;
        $logs->activity = 'Application rejected';
        $logs->save();

        return redirect()->route('finance.applications')->with('success', 'Application declined');
    }

    public function revertApplication(Request $request, $id)
    {
        $hashedId = Crypt::decrypt($id);

        $app = Application::find($hashedId);
        $app->finance_status = 4;
        $app->finance_comments = $request->comment;
        $app->save();

        $logs = new FinanceLog;
        $logs->application_id = $app->id;
        $logs->user = Auth::guard('user')->user()->name;
        $logs->user_role = Auth::guard('user')->user()->role_id;
        $logs->comments = $request->comment;
        $logs->activity = 'Application reverted for corrections';
        $logs->save();

        $comms = new Notification;
        $comms->application_id = $hashedId;
        $comms->role_id = Auth::guard('user')->user()->role_id;
        $comms->subject = 'Application Approval Process';
        $comms->comment = $request->comment;
        $comms->save();

        return redirect()->route('finance.applications')->with('success', 'Communications passed to the student for corrections');
    }

    public function batch()
    {
        $apps = Application::where('finance_status', '>', 0)
            ->where('finance_status', '!=', 3)
            ->where('cod_status', null)
            ->get();

        return view('applications::applications.batch')->with('apps', $apps);
    }

    public function batchSubmit(Request $request)
    {

        foreach ($request->submit as $id) {

            $app = Application::find($id);

            if ($app->finance_status == 2) {

                $app = Application::find($id);
                $app->finance_status = 3;
                $app->registrar_status = 0;
                $app->save();
            } elseif ($app->finance_status == 4) {

                $app = Application::find($id);
                $app->finance_status = NULL;
                $app->declaration = 0;
                $app->save();

                $notify = Notification::where('application_id', $id)->latest()->first();
                $notify->status = 1;
                $notify->save();
            } else {
                $app = Application::find($id);
                $app->cod_status = 0;
                $app->save();
            }

            $logs = new FinanceLog;
            $logs->application_id = $app->id;
            $logs->user = Auth::guard('user')->user()->name;
            $logs->user_role = Auth::guard('user')->user()->role_id;
            $logs->activity = 'Your application has been forwarded to COD for review';
            $logs->save();
        }

        return redirect()->route('finance.batch')->with('success', '1 Batch elevated for COD approval');
    }
    public function admissions()
    {

        $apps = AdmissionApproval::where('cod_status', 1)
            ->where('finance_status', '!=', NULL)
            ->where('medical_status', NULL)
            ->get();

        return view('applications::admissions.index')->with('applicant', $apps);
    }

    public function reviewAdmission($id)
    {

        $hashedId = Crypt::decrypt($id);

        $app = AdmissionApproval::find($hashedId);

        return view('applications::admissions.review')->with(['app' => $app]);
    }

    public function acceptAdmission($id)
    {

        $hashedId = Crypt::decrypt($id);

        $admission = AdmissionApproval::find($hashedId);
        $admission->finance_status = 1;
        $admission->save();

        return redirect()->route('finance.admissions')->with('success', 'New student verified successfully');
    }

    public function rejectAdmission(Request $request, $id)
    {

        $hashedId = Crypt::decrypt($id);

        AdmissionApproval::where('id', $hashedId)->update(['finance_status' => 2, 'finance_comments' => $request->comment]);

        return redirect()->route('finance.admissions')->with('warning', 'Admission request rejected');
    }

    public function withholdAdmission(Request $request, $id)
    {

        $hashedId = Crypt::decrypt($id);

        AdmissionApproval::where('id', $hashedId)->update(['finance_status' => 3, 'finance_comments' => $request->comment]);

        return redirect()->route('finance.admissions')->with('info', 'Admission request withheld');
    }

    public function submitAdmission($id)
    {

        $hashedId = Crypt::decrypt($id);

        $admission = AdmissionApproval::find($hashedId);
        $admission->medical_status = 0;
        $admission->save();

        return redirect(route('finance.admissions'))->with('success', 'Record submitted to Medical Officer');
    }

    public function submitAdmissionJab($id)
    {

        $hashedId = Crypt::decrypt($id);

        $admission = AdmissionApproval::find($hashedId);
        $admission->medical_status = 0;
        $admission->save();

        return redirect()->back()->with('success', 'Record submitted to Registrar');
    }

    public function allInvoices()
    {

        $invoices = StudentDeposit::latest()->get();

        return view('applications::invoices.index')->with(['invoices' => $invoices]);
    }

    public function addInvoice()
    {
        $classes = Classes::latest()->get();

        foreach ($classes as $class) {
            $results = StudentCourse::where('current_class', $class->name)
                ->where('status', 1)
                ->get();
        }
        // return $results;

        $students = StudentCourse::where('status', 1)->latest()->get();

      $studentsx = $classes->merge($students);

        return view('applications::invoices.addInvoice')->with(['students' => $studentsx, 'results' => $results]);
    }

    public function getInvoiceType(Request $request)
    {

        $classes = Classes::latest()->get();
        $students = StudentCourse::where('status', 1)->latest()->get();
        $invoice = '';
        $today = '2023-09-22';
        $intake = Intake::where('intake_from', '<=', $today)->where('intake_to', '>=', $today)->first();
        $year = AcademicYear::where('year_id', $intake->academic_year_id)->first();
        $semester = Carbon::parse($intake->intake_from)->format('M') . '/' . Carbon::parse($intake->intake_to)->format('M');
        $stage = Carbon::parse($year->year_start)->format('Y') . '/' . Carbon::parse($year->year_end)->format('Y');
        $studentsx = $classes->merge($students);
        foreach ($studentsx as $student) {
            if ($student->name == $request->code || $student->student_number == $request->code) {
                if ($student->class_id !== null) {
                    $pattern = ClassPattern::where('class_code', $student->name)->where('academic_year', $stage)->where('period', $semester)->first();
                    $class = Classes::where('name', $student->name)->first();
                    if ($pattern !== null) {
                        $invoice = array_merge($student->toArray(), $pattern->toArray(), $class->toArray());
                    }
                } elseif ($student->student_id !== null) {
                    $pattern = ClassPattern::where('class_code', $student->current_class)->where('academic_year', $stage)->where('period', $semester)->first();
                    $studentInfo = StudentInfo::where('student_id', $student->student_id)->first();
                    if ($pattern !== null) {
                        $invoice = array_merge($student->toArray(), $pattern->toArray(), $studentInfo->toArray());
                    }
                }
            }
        }

        return response()->json($invoice);
    }

    public function submitInvoice(Request $request)
    {
        //        $request->validate([
        //            'student' => 'required',
        //            'amount' => 'required',
        //            'description' => 'required',
        //        ]);

        $deposit = new StudentDeposit;

        $deposit->reg_number = '$request->student';
        $deposit->deposit = '$request->amount';
        $deposit->description = '$request->description';
        $deposit->invoice_number = 'INV' . time();
        $deposit->save();

        return redirect()->back()->with('success', 'Student invoiced successfully');
    }
 
}
