<?php

namespace Modules\Dean\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Dean\Entities\DeanLog;
use Illuminate\Support\Facades\Crypt;
use Modules\Registrar\Entities\Courses;
use PhpOffice\PhpWord\TemplateProcessor;
use Modules\Registrar\Entities\Department;
use Modules\Application\Entities\Education;
use NcJoes\OfficeConverter\OfficeConverter;
use Illuminate\Contracts\Support\Renderable;
use Modules\Student\Entities\CourseTransfer;
use Modules\Application\Entities\Application;
use Modules\Student\Entities\CourseTransferApproval;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\SimpleType\TblWidth;


class DeanController extends Controller
{

    public function requestedTransfers($year){
        $hashedYear = Crypt::decrypt($year);

        $user = Auth::guard('user')->user();
        $by = $user->name;
        $dept = $user->getSch->initials;
        $role = $user->userRoles->name;
        
        $departments   =   Department::where('school_id', auth()->guard('user')->user()->school_id)->get();
        foreach($departments as $department){
        $transfers[] = CourseTransfer::where('department_id', $department->id)
        $transfers[] = CourseTransfer::where('department_id', $department->id)
                    ->where('academic_year', $hashedYear)
                    ->latest()
                    ->get()
                    ->groupBy('course_id');
        }

        // return $transfers;

        // foreach
        

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
                        $total_courses [] = $course_id;
                        $courseName = $listed->course_name;
                        $courseCode = $listed->course_code;
                    }
                }

                $summary->addRow();
                $summary->addCell(5000, ['borderSize' => 1])->addText($courseName, ['bold' => true]);
                $summary->addCell(1250, ['borderSize' => 1])->addText($courseCode, ['bold' => true]);
                $summary->addCell(1250, ['borderSize' => 1])->addText($transfer->count());
                $summary->addRow();
                $summary->addCell(5000, ['borderSize' => 1])->addText($courseName, ['bold' => true]);
                $summary->addCell(1250, ['borderSize' => 1])->addText($courseCode, ['bold' => true]);
                $summary->addCell(1250, ['borderSize' => 1])->addText($transfer->count());

                $total += $transfer->count();
            }
                $total += $transfer->count();
            }
        }
    
       // return $number;

        // return $arr;
    
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
        $docPath = 'Fees/'.'Transfers'.time().".docx";
        $my_template->saveAs($docPath);

        $contents = \PhpOffice\PhpWord\IOFactory::load($docPath);

        $pdfPath = 'Fees/'.'Transfers'.time().".pdf"; 

        $converter =  new OfficeConverter($docPath, 'Fees/');
        $converter->convertTo('Transfers'.time().".pdf");

                    if(file_exists($docPath)){
                        unlink($docPath);
                    }

//        return response()->download($docPath)->deleteFileAfterSend(true);
        return response()->download($pdfPath)->deleteFileAfterSend(true);
    }

    public function yearly(){
        $departments   =   Department::where('school_id', auth()->guard('user')->user()->school_id)->get();
        foreach($departments as $department){
            $data[] = CourseTransfer::where('department_id', $department->id)
                    ->latest()
                    ->get()
                    ->groupBy('academic_year');
                }

        return  view('dean::transfers.yearly')->with(['data'=> $data, 'departments'=>$departments]);
    }


    public function declineTransferRequest(Request $request, $id){
        $hashedId = Crypt::decrypt($id);
        $year = CourseTransferApproval::find($hashedId)->transferApproval->academic_year;

            $approval = CourseTransferApproval::find($hashedId);
            $approval->dean_status = 2;
            $approval->dean_remarks = $request->remarks;
            $approval->save();

        
        return redirect()->route('dean.transfer',['year' => Crypt::encrypt($year)])->with('success', 'Course transfer request accepted');
    }

    public function acceptTransferRequest($id){

        $hashedId = Crypt::decrypt($id);

        $year = CourseTransferApproval::find($hashedId)->transferApproval->academic_year;

            $approval = CourseTransferApproval::find($hashedId);
            $approval->dean_status = 1;
            $approval->dean_remarks = 'Admit Student';
            $approval->save();

        return redirect()->route('dean.transfer',['year' => Crypt::encrypt($year)])->with('success', 'Course transfer request accepted');

    }

    public function viewUploadedDocument($id){

        $hashedId = Crypt::decrypt($id);

        $course = CourseTransferApproval::find($hashedId);

             $document = Application::where('reg_number', $course->transferApproval->studentTransfer->reg_number)->first();


        return response()->file('Admissions/Certificates/'.$document->admissionDoc->certificates);

    }

    public function transfer($year){
        $hashedYear = Crypt::decrypt($year);
        $departments   =   Department::where('school_id', auth()->guard('user')->user()->school_id)->get();
        foreach($departments as $department){

            $transfers = CourseTransfer::where('department_id', $department->id)
                             ->where('academic_year', $hashedYear)
                            ->latest()
                            ->get();
            foreach($transfers as $record){
                $transfer[] = CourseTransferApproval::where('course_transfer_id', $record->id)
                                ->where('cod_status', '!=', null)
                                ->latest()
                                ->get();
            }
    
        }

        return view('dean::transfers.index')->with(['transfer' => $transfer, 'departments' => $departments, 'year'=>$hashedYear]);
    }

    public function viewTransfer($id){

        $hashedId = Crypt::decrypt($id);
    

        $data = CourseTransferApproval::find($hashedId);

        return view('dean::transfers.viewTransfer')->with(['data' => $data]);
    }

    public function preview($id){

         $hashedId = Crypt::decrypt($id);
        $data = CourseTransferApproval::find($hashedId);
        return view('dean::transfers.preview')->with(['data' => $data]);
    }



    public function applications(){

        $applications = Application::where('dean_status', '!=', 3)
            ->where('school_id', auth()->guard('user')->user()->school_id)
            ->where('registrar_status', null)
            ->orWhere('registrar_status', 4)
            ->orderBy('id', 'DESC')
            ->get();

        return view('dean::applications.index')->with('apps', $applications);
    }

    public function viewApplication($id){

        $hashedId = Crypt::decrypt($id);

        $app = Application::find($hashedId);
        $school = Education::where('applicant_id', $app->applicant->id)->get();

        return view('dean::applications.viewApplication')->with(['app' => $app, 'school' => $school]);
    }

    public function previewApplication($id){

        $hashedId = Crypt::decrypt($id);

        $app = Application::find($hashedId);
        $school = Education::where('applicant_id', $app->applicant->id)->get();
        return view('dean::applications.preview')->with(['app' => $app, 'school' => $school]);
    }

    public function acceptApplication($id){

        $hashedId = Crypt::decrypt($id);

        $app = Application::find($hashedId);
        $app->dean_status = 1;
            if ($app->registrar_status != NULL){
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

    public function rejectApplication(Request $request, $id){

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

    public function batch(){
        $apps = Application::where('dean_status', '>', 0)
            ->where('school_id', auth()->guard('user')->user()->school_id)
            ->where('registrar_status', null)
            ->where('dean_status', '!=', 3)
            ->where('cod_status', '<=', 2)
            ->orwhere('registrar_status', 4)
            ->get();

        return view('dean::applications.batch')->with('apps', $apps);
    }

    public function batchSubmit(Request $request){

        foreach ($request->submit as $item){
            $app = Application::find($item);
            if ($app->dean_status == 2){
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

            if ($app->dean_status == 3){

                $logs->activity = 'Your application has been reverted to COD office for review';
            }else{
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
