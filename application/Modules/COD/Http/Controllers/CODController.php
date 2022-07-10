<?php

namespace Modules\COD\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Application\Entities\Application;
use Modules\Application\Entities\Education;
use Modules\Finance\Entities\FinanceLog;
use Modules\COD\Entities\CODLog;
use Auth;

class CODController extends Controller
{

    public function applications(){

        $applications = Application::where('cod_status', '>=', 0)
            ->where('dean_status', null)
            ->orWhere('dean_status', 3)
            ->orderby('id', 'DESC')
            ->get();

        return view('cod::applications.index')->with('apps', $applications);
    }

    public function viewApplication($id){

        $app = Application::find($id);
        $school = Education::where('user_id', $app->applicant->id)->first();

        return view('cod::applications.viewApplication')->with(['app' => $app, 'school' => $school]);
    }

    public function previewApplication($id){

        $app = Application::find($id);
        $school = Education::where('user_id', $app->applicant->id)->first();
        return view('cod::applications.preview')->with(['app' => $app, 'school' => $school]);
    }

    public function acceptApplication($id){

        $app = Application::find($id);
        $app->cod_status = 1;
        $app->cod_comments = NULL;
        $app->save();

        $logs = new CODLog;
        $logs->app_id = $app->id;
        $logs->user = Auth::guard('user')->user()->name;
        $logs->user_role = Auth::guard('user')->user()->role_id;
        $logs->activity = 'Application accepted';
        $logs->save();

        return redirect()->route('cod.applications')->with('success', '1 applicant approved');
    }

    public function rejectApplication(Request $request, $id){


            $request->validate([
                'comment' => 'required|string'
            ]);
        $app = Application::find($id);
        $app->cod_status = 2;
        $app->cod_comments = $request->comment;
        $app->save();

        $logs = new CODLog;
        $logs->app_id = $app->id;
        $logs->user = Auth::guard('user')->user()->name;
        $logs->user_role = Auth::guard('user')->user()->role_id;
        $logs->comments = $request->comment;
        if ($app->dean_status === 3){
            $logs->activity = 'Application reviewed by COD';
        }
        $logs->activity = 'Application rejected';
        $logs->save();

        return redirect()->route('cod.applications')->with('success', 'Application declined');
    }

    public function batch(){
        $apps = Application::where('cod_status', '>', 0)
            ->where('dean_status', null)
            ->orWhere('dean_status', 3)
            ->where('cod_status', '!=', 3)
            ->get();

        return view('cod::applications.batch')->with('apps', $apps);
    }

    public function batchSubmit(Request $request){

        foreach ($request->submit as $item){
            $app = Application::find($item);
            $app->dean_status = 0;
            $app->save();

            $logs = new CODLog;
            $logs->app_id = $app->id;
            $logs->user = Auth::guard('user')->user()->name;
            $logs->user_role = Auth::guard('user')->user()->role_id;
            $logs->activity = "Application awaiting Dean's Verification";
            $logs->save();

        }

        return redirect()->route('cod.batch')->with('success', '1 Batch elevated for Dean approval');
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('cod::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('cod::create');
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
        return view('cod::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('cod::edit');
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
