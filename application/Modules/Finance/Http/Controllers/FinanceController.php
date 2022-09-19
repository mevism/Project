<?php

namespace Modules\Finance\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Application\Entities\AdmissionApproval;
use Modules\Application\Entities\Application;
use Modules\Application\Entities\Education;
use Modules\Finance\Entities\FinanceLog;
use Auth;
use Modules\Registrar\Entities\Courses;

class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function applications(){

        $applications = Application::where('cod_status', NULL )
            ->where('finance_status', '!=', 3)
            ->orderBy('id', 'DESC')
            ->get();

        return view('applications::applications.index')->with('apps', $applications);
    }

    public function viewApplication($id){

        $app = Application::find($id);
        return view('applications::applications.viewApplication')->with('app', $app);
    }

    public function previewApplication($id){

        $app = Application::find($id);
        return view('applications::applications.preview')->with('app', $app);
    }

    public function acceptApplication($id){

        $app = Application::find($id);
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

    public function rejectApplication(Request $request, $id){

        $app = Application::find($id);
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

    public function batch(){
        $apps = Application::where('finance_status', '>', 0)
                ->where('finance_status', '!=', 3)
                ->where('cod_status', null)
                ->get();

        return view('applications::applications.batch')->with('apps', $apps);
    }

    public function batchSubmit(Request $request){

        foreach ($request->submit as $id){

            $app = Application::find($id);

                if ($app->finance_status == 2){

                    $app = Application::find($id);
                    $app->finance_status = 3;
                    $app->registrar_status = 0;
                    $app->save();

                }else{
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
    public function admissions(){

        $apps = AdmissionApproval::where('cod_status', 1)
//            ->where('student_type', 1)
            ->where('finance_status', '!=', NULL)
            ->where('medical_status', NULL)
            ->get();

//        return $apps->appApproval->applicant;

        return view('applications::admissions.index')->with('applicant', $apps);
    }

    public function admissionsJab(){

            $admission = AdmissionApproval::where('cod_status', 1)
                ->where('student_type', 2)
                ->where('finance_status', '!=', NULL)
                ->where('medical_status', NULL)
                ->get();

        return view('applications::admissions.kuccps')->with('applicant', $admission);
    }

    public function reviewAdmission($id){

        $app = AdmissionApproval::find($id);

//        return $app->appApproval->applicant;

        return view('applications::admissions.review')->with(['app' => $app]);
    }

    public function acceptAdmission($id){

            $admission = AdmissionApproval::find($id);
            $admission->finance_status = 1;
            $admission->save();

        return redirect()->route('finance.admissions')->with('success', 'New student verified successfully');
    }

        public function acceptAdmissionJab($id){

                $admission = AdmissionApproval::find($id);
                $admission->finance_status = 1;
                $admission->save();

            return redirect()->back()->with('success', 'New student verified successfully');
        }

    public function rejectAdmission(Request $request, $id){

        AdmissionApproval::where('id', $id)->update(['finance_status' => 2, 'finance_comments' => $request->comment]);

        return redirect()->route('finance.admissions')->with('warning', 'Admission request rejected');
    }

    public function submitAdmission($id){

        $admission = AdmissionApproval::find($id);
        $admission->medical_status = 0;
        $admission->save();

        return redirect(route('finance.admissions'))->with('success', 'Record submitted to Medical Officer');
    }

    public function submitAdmissionJab($id){

        $admission = AdmissionApproval::find($id);
        $admission->medical_status = 0;
        $admission->save();

        return redirect()->back()->with('success', 'Record submitted to Registrar');
    }

    public function index()
    {
        return view('applications::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('applications::create');
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
        return view('applications::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('applications::edit');
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
