<?php

namespace Modules\Dean\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Dean\Entities\DeanLog;
use Illuminate\Support\Facades\Crypt;
use Modules\Application\Entities\Education;
use Illuminate\Contracts\Support\Renderable;
use Modules\Student\Entities\CourseTransfer;
use Modules\Application\Entities\Application;
use Modules\Student\Entities\CourseTransferApproval;

class DeanController extends Controller
{
    public function declineTransferRequest(Request $request, $id){

        if (CourseTransferApproval::find($id)->exists()){

            $approval = CourseTransferApproval::find($id);
            $approval->dean_status = 2;
            $approval->dean_remarks = $request->remarks;
            $approval->save();

        }else{

            $approval = new CourseTransferApproval;
            $approval->course_transfer_id = $id;
            $approval->dean_status = 2;
            $approval->dean_remarks = $request->remarks;
            $approval->save();

        }

        return redirect()->route('dean.transfer')->with('success', 'Course transfer request accepted');
    }

    public function acceptTransferRequest($id){
        //  return $id;
        if (CourseTransferApproval::find($id)->exists()){

            $approval = CourseTransferApproval::find($id);
            $approval->dean_status = 1;
            $approval->dean_remarks = 'Admit';
            $approval->save();

        }else{

            $approval = new CourseTransferApproval;
            $approval->course_transfer_id = $id;
            $approval->dean_status = 1;
            $approval->dean_remarks = 'Admit';
            $approval->save();
        }

        return redirect()->route('dean.transfer')->with('success', 'Course transfer request accepted');

    }

    public function viewUploadedDocument($id){

        // $hashedId = Crypt::decrypt($id);

        $course = CourseTransfer::find($id);

        $document = Application::where('reg_number', $course->studentTransfer->reg_number)->first();

        // return $document->admissionDoc;

        return response()->file('Admissions/Certificates/'.$document->admissionDoc->certificates);

    }
    
    public function transfer(){

        $transfer  =  CourseTransferApproval::where('cod_status', '>=', 1)
        ->where('registrar_status', null)
        ->get();

        return view('dean::transfers.index')->with(['transfer' => $transfer]);
    }

    public function viewTransfer($id){

        //  $hashedId = Crypt::decrypt($id);
        //  return $hashedId;

        $data = CourseTransferApproval::find($id);
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
