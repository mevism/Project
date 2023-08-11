<?php

namespace Modules\Medical\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Crypt;
use Modules\Application\Entities\AdmissionApproval;
use Modules\COD\Entities\AdmissionsView;

class MedicalController extends Controller
{
    public function index()
    {
        return view('medical::medical.index');
    }

    public function admissions(){
        $adm = AdmissionsView::where('cod_status', 1)
            ->where('registrar_status', NULL)
            ->latest()
            ->get();

        return view('medical::admissions.index')->with('admission', $adm);
    }

    public function acceptAdmission($id){
            AdmissionApproval::where('application_id', $id)->update([
                'medical_status' => 1,
                'medical_comments' => 'Medical report validated',
                'medical_user_id' => auth()->guard('user')->user()->user_id
            ]);
        return redirect()->route('medical.admissions')->with('success', 'New student successfully verified');
    }

    public function rejectAdmission(Request $request, $id){
        AdmissionApproval::where('application_id', $id)->update(['medical_status' => 2, 'medical_user_id' => auth()->guard('user')->user()->user_id, 'medical_comments' => $request->comment]);
        return redirect()->route('medical.admissions')->with('error', 'Admission request rejected');
    }

    public function submitAdmission($id){
        AdmissionApproval::where('application_id', $id)->update(['registrar_status' => 0]);
        return redirect()->route('medical.admissions')->with('success', 'New student approved successfully');
    }

    public function reviewAdmission($id){
        $admission = AdmissionsView::where('application_id', $id)->first();
        return view('medical::admissions.viewAdmission')->with('admission', $admission);
    }

    public function withholdAdmission(Request $request, $id){
        AdmissionApproval::where('application_id', $id)->update(['medical_status' => 3, 'medical_user_id' => auth()->guard('user')->user()->user_id, 'medical_comments' => $request->comment]);
        return redirect()->route('medical.admissions')->with('error', 'Admission request rejected');
    }
}
