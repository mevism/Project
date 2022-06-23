<?php

namespace Modules\Finance\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Application\Entities\Application;
use Modules\Finance\Entities\FinanceLog;
use Auth;
class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function applications(){

        $applications = Application::where('cod_status', null )
            ->orderby('id', 'DESC')
            ->get();

        return view('applications::applications.index')->with('apps', $applications);
    }

    public function viewApplication($id){

        $app = Application::find($id);
        return view('applications::applications.viewApplication')->with('app', $app);
    }

    public function acceptApplication($id){

        $app = Application::find($id);
        $app->finance_status = 1;
        $app->save();

        $logs = new FinanceLog;
        $logs->app_id = $app->id;
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
        $logs->app_id = $app->id;
        $logs->user = Auth::guard('user')->user()->name;
        $logs->user_role = Auth::guard('user')->user()->role_id;
        $logs->activity = 'Application rejected';
        $logs->save();

        return redirect()->route('finance.applications')->with('success', 'Application declined');
    }

    public function batch(){
        $apps = Application::where('finance_status', '>', 0)
                ->where('cod_status', null)
                ->get();

        return view('applications::applications.batch')->with('apps', $apps);
    }

    public function batchSubmit(Request $request){

        foreach ($request->submit as $item){
            $app = Application::find($item);
            $app->cod_status = 0;
            $app->save();
                }

            $logs = new FinanceLog;
            $logs->app_id = $app->id;
            $logs->user = Auth::guard('user')->user()->name;
            $logs->user_role = Auth::guard('user')->user()->role_id;
            $logs->activity = 'Batch submitted';
            $logs->save();

        return redirect()->route('finance.batch')->with('success', '1 Batch elevated for COD approval');
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
