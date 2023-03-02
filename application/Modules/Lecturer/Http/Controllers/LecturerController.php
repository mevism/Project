<?php

namespace Modules\Lecturer\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Lecturer\Entities\LecturerQualification;
use Modules\Lecturer\Entities\TeachingArea;
use Modules\Registrar\Entities\Courses;
use Modules\Registrar\Entities\UnitProgramms;

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

        $workloads = [];

        return view('lecturer::workload.viewworkload');

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

        return $request->all();
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
