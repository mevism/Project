
<?php

namespace Modules\Lecturer\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Lecturer\Entities\LecturerQualification;
use Crypt;
use Modules\Lecturer\Entities\TeachingArea;
use Modules\Registrar\Entities\Courses;
use Modules\Registrar\Entities\UnitProgramms;
use Modules\Workload\Entities\Workload;


class LecturerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('lecturer::index');
    }

    public function viewworkload(){

        $workloads = Workload::where('user_id', auth()->guard('user')->user()->id)->latest()->get()->groupBy('academic_year');

        return view('lecturer::workload.viewworkload')->with(['workloads' => $workloads]);

    }

    public function qualifications(){

      $qualification = LecturerQualification::where('user_id', auth()->guard('user')->user()->id)->latest()->get();

        return view('lecturer::profile.qualifications')->with ('qualifications', $qualification);

    }

    public function addqualifications(){

        $lecturer = [];

        return view('lecturer::profile.addqualifications');

    }
    public function storeQualifications(REQUEST $request){

       $request->validate([
            'level' => 'required',
            'qualification' =>'required',
            'institution' => 'required'

       ]);

       $qualification = new LecturerQualification;
       $qualification->user_id = auth()->guard('user')->user()->id;
       $qualification->level = $request->level;
       $qualification->qualification = $request->qualification;
       $qualification->institution = $request ->institution;
       $qualification->save();

        return redirect()->route('lecturer.qualifications')->with('Success', '1 qualification added successfully');

    }

    public function editQualifications($id){

        $hashedId = Crypt::decrypt($id);

        $qualification = LecturerQualification::find($hashedId);

        return view('lecturer::profile.editqualifications')->with(['qualification' => $qualification]);

    }

    public function updateQualifications(Request $request, $id){

        $request->validate([
            'level' => 'required',
            'qualification' =>'required',
            'institution' => 'required'
        ]);

        $qualification = LecturerQualification::find($id);
        $qualification->user_id = auth()->guard('user')->user()->id;
       $qualification->level = $request->level;
       $qualification->qualification = $request->qualification;
       $qualification->institution = $request ->institution;
       $qualification->save();

        return redirect()->route('lecturer.qualifications')->with('success', 'Updated successfully');

    }

    public function deleteQualification($id){
        $hashedId = Crypt::decrypt($id);

        $qualification = LecturerQualification::find($hashedId);
        $qualification->delete();

        return redirect()->route('lecturer.qualifications')->with('success', 'Deleted successfully');
    }

    public function teachingAreas(){

        $myUnits = TeachingArea::where('user_id', auth()->guard('user')->user()->id)->latest()->get();

        return view('lecturer::profile.teachingArea')->with('units', $myUnits);
    }

    public function addTeachingAreas(){

        $userSchool = auth()->guard('user')->user()->employmentDepartment->first()->schools->first();

        foreach ($userSchool->departments as $department){
            $Allcourses[] = Courses::where('department_id', $department->id)->latest()->get();
        }

        foreach ($Allcourses as $courses){
            foreach ($courses as $course){
                $units[] = UnitProgramms::where('course_code', $course->course_code)->latest()->get();
            }
        }

        return view('lecturer::profile.addTeachingAreas')->with(['units' => $units]);
    }

    public function storeTeachingAreas(Request $request){

        $request->validate([
           'units' => 'required'
        ]);

        foreach ($request->units as $id){

            $unit = UnitProgramms::find($id);

            $teachingArea =  new TeachingArea;
            $teachingArea->user_id = auth()->guard('user')->user()->id;
            $teachingArea->unit_code = $unit->course_unit_code;
            $teachingArea->level = $unit->courseLevel->level;
            $teachingArea->save();

        }

        return redirect()->route('lecturer.teachingAreas')->with('success', 'Teaching areas added successfully');
    }

    public function yearlyWorkloads($id){

        $hashedId = Crypt::decrypt($id);

        $workloads = Workload::where('academic_year', $hashedId)->latest()->get()->groupBy('academic_semester');

        return view('lecturer::workload.yearlyWorkload')->with(['workloads' => $workloads, 'year' => $hashedId]);

    }

    public function semesterWorkload($year, $semester){

        $hashedYear = Crypt::decrypt($year);
        $hashedSemester = Crypt::decrypt($semester);

        $workloads = Workload::where('academic_year', $hashedYear)->where('academic_semester', $hashedSemester)->latest()->get();

        return view('lecturer::workload.semesterWorkload')->with(['workloads' => $workloads, 'year' => $hashedYear, 'semester' => $hashedSemester]);
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('lecturer::create');
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
        return view('lecturer::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('lecturer::edit');
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

