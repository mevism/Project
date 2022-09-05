<?php

namespace Modules\Medical\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Application\Entities\AdmissionApproval;

class MedicalController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('medical::medical.index');
    }

    public function admissions(){
        $adm = AdmissionApproval::where('finance_status', 1)
            ->where('registrar_status', NULL)
            ->get();

        return view('medical::admissions.index')->with('admission', $adm);
    }

    public function admissionsJab(){
        $adm = AdmissionApproval::where('finance_status', 1)
            ->where('student_type', 2)
            ->where('registrar_status', NULL)
            ->get();

        return view('medical::admissions.kuccps')->with('admission', $adm);
    }

    public function acceptAdmission($id){

            $admission = AdmissionApproval::find($id);
            $admission->medical_status = 1;
            $admission->save();

        return redirect()->route('medical.admissions')->with('success', 'New student successfully verified');
    }


    public function acceptAdmissionJab($id){

        $admission = AdmissionApproval::find($id);
        $admission->medical_status = 1;
        $admission->save();

        return redirect()->back()->with('success', 'New student successfully verified');
    }

    public function rejectAdmission(Request $request, $id){

        AdmissionApproval::where('id', $id)->update(['medical_status' => 2, 'medical_comments' => $request->comment]);

        return redirect()->route('medical.admissions')->with('error', 'Admission request rejected');
    }

    public function submitAdmission($id){

        $admission = AdmissionApproval::find($id);
        $admission->registrar_status = 0;
        $admission->save();

        return redirect()->route('medical.admissions')->with('success', 'New student approved successfully');

    }

    public function submitAdmissionJab($id){

        $admission = AdmissionApproval::find($id);
        $admission->registrar_status = 0;
        $admission->save();

        return redirect()->back()->with('success', 'New student approved successfully');

    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('medical::create');
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
        return view('medical::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('medical::edit');
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
