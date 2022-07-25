<?php

namespace Modules\Dean\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Auth;
use Modules\Application\Entities\Application;
use Modules\Application\Entities\Education;
use Modules\Dean\Entities\DeanLog;

class DeanController extends Controller
{

    public function applications(){

        $applications = Application::where('dean_status', '!=', 3)
            ->where('registrar_status', null)
            ->orWhere('registrar_status', 4)
            ->orderBy('id', 'DESC')
            ->get();

        return view('dean::applications.index')->with('apps', $applications);
    }

    public function viewApplication($id){

        $app = Application::find($id);
        $school = Education::where('user_id', $app->applicant->id)->first();
        return view('dean::applications.viewApplication')->with(['app' => $app, 'school' => $school]);
    }

    public function previewApplication($id){

        $app = Application::find($id);
        $school = Education::where('user_id', $app->applicant->id)->first();
        return view('dean::applications.preview')->with(['app' => $app, 'school' => $school]);
    }

    public function acceptApplication($id){

        $app = Application::find($id);
        $app->dean_status = 1;
        $app->save();

        $logs = new DeanLog;
        $logs->app_id = $app->id;
        $logs->user = Auth::guard('user')->user()->name;
        $logs->user_role = Auth::guard('user')->user()->role_id;
        $logs->activity = 'Application accepted';
        $logs->save();

        return redirect()->route('dean.applications')->with('success', '1 applicant approved');
    }

    public function rejectApplication(Request $request, $id){
        $app = Application::find($id);
        $app->dean_status = 2;
        $app->dean_comments = $request->comment;
        $app->save();

        $logs = new DeanLog;
        $logs->app_id = $app->id;
        $logs->user = Auth::guard('user')->user()->name;
        $logs->user_role = Auth::guard('user')->user()->role_id;
        $logs->activity = 'Application rejected';
        $logs->comments = $request->comment;
        $logs->save();

        return redirect()->route('dean.applications')->with('success', 'Application declined');
    }

    public function batch(){
        $apps = Application::where('dean_status', '>', 0)
            ->where('registrar_status', null)
            ->orwhere('registrar_status', 4)
            ->where('dean_status', '!=', 3)
            ->get();

        return view('dean::applications.batch')->with('apps', $apps);
    }

    public function batchSubmit(Request $request){

        foreach ($request->submit as $item){
            $app = Application::find($item);
            if ($app->dean_status === 2){
                $app->dean_status = 3;
                $app->cod_status = 3;
            }
            if ($app->dean_status === 1) {
                $app->registrar_status = 0;
            }
            $app->save();

            $logs = new DeanLog;
            $logs->app_id = $app->id;
            $logs->user = Auth::guard('user')->user()->name;
            $logs->user_role = Auth::guard('user')->user()->role_id;

            if ($app->dean_status === 3){

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
