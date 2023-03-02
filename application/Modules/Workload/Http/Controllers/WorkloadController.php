<?php

namespace Modules\Workload\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Crypt;
use Modules\COD\Entities\ClassPattern;
use Modules\COD\Entities\SemesterUnit;
use Modules\Registrar\Entities\AcademicYear;
use Modules\Registrar\Entities\Courses;
use Modules\Registrar\Entities\Intake;
use Modules\Workload\Entities\Workload;

class WorkloadController extends Controller
{

    public function workloads(){

        $academicYears = AcademicYear::latest()->get();

        return view('workload::workload.index')->with('academicYears', $academicYears);
    }

    public function yearlyWorkloads($id){

        $hashedId = Crypt::decrypt($id);

        $semesters = Intake::where('academic_year_id', $hashedId)->latest()->get();

        return view('workload::workload.yearlyWorkload')->with(['semesters' => $semesters]);
    }

    public function semesterWorkload($id){

        $hashedId = Crypt::decrypt($id);

        $classes = [];

        $semester = Intake::findorFail($hashedId);

        $academicYear = Carbon::parse($semester->academicYear->year_start)->format('Y').'/'.Carbon::parse($semester->academicYear->year_end)->format('Y');

        $period = Carbon::parse($semester->intake_from)->format('M').'/'.Carbon::parse($semester->intake_to)->format('M');

        $department_id = auth()->guard('user')->user()->employmentDepartment->first()->id;

        $courses = Courses::where('department_id', $department_id)->latest()->get();

        foreach ($courses as $course){

            $course_id[] = $course->id;
        }

        $classPatterns = ClassPattern::where('academic_year', $academicYear)->where('period', $period)->latest()->get();

        foreach ($classPatterns as $patterns){

            if (in_array($patterns->classSchedule->course_id, $course_id, false)){

                $classes[] = $patterns;
            }
        }

        return view('workload::workload.semesterWorkload')->with(['classes' => $classes]);

    }

    public function classUnits($id){

        $users = User::all();

        $lecturers = [];

        foreach ($users as $user){
            if ($user->hasRole('Lecturer')){

               $lecturers[] = $user;
            }
        }

        $hashedId = Crypt::decrypt($id);

        $class = ClassPattern::findorFail($hashedId);

        $units = SemesterUnit::where('class_code', $class->class_code)->where('stage', $class->stage)->where('semester', $class->pattern_id)->latest()->get();

        return view('workload::workload.allocateUnits')->with(['units' => $units, 'lecturers' => $lecturers]);
    }

    public function allocateUnit($staff_id, $unit_id){

        $hashedStaff = Crypt::decrypt($staff_id);

        $hashedUnit = Crypt::decrypt($unit_id);

        $unit = SemesterUnit::findorFail($hashedUnit);

        $class = ClassPattern::where(['class_code' => $unit->class_code, 'stage' => $unit->stage, 'pattern_id' => $unit->semester])->first();

        $workload = new Workload;
        $workload->academic_year = $class->academic_year;
        $workload->academic_semester = $class->period;
        $workload->user_id = $hashedStaff;
        $workload->unit_id = $unit->id;
        $workload->class_code = $class->class_code;
        $workload->save();

        return redirect()->back()->with('success', 'Unit allocation successful');

    }

    public function viewWorkload(){

        $workloads = Workload::latest()->get()->groupBy('academic_year');

        return view('workload::workload.viewWorkload')->with(['workloads' => $workloads]);

    }

    public function viewYearWorkload($year){

        $hashedYear = Crypt::decrypt($year);

        $workloads = Workload::where('academic_year', $hashedYear)->latest()->get()->groupBy('academic_semester');

        return view('workload::workload.viewYearWorkload')->with(['workloads' => $workloads, 'year' => $hashedYear]);

    }

    public function viewSemesterWorkload($semester, $year){

       $hashedSemester = Crypt::decrypt($semester);

        $hashedYear = Crypt::decrypt($year);

        $users = User::all();

        foreach ($users as $user){

            if ($user->hasRole('Lecturer')){

                $lectures[] = $user;

            }
        }

        $workloads = Workload::where('academic_year', $hashedYear)->where('academic_semester', $hashedSemester)->get()->groupBy('user_id');

        return view('workload::workload.viewSemesterWorkload')->with(['semester' => $hashedSemester, 'year' => $hashedYear, 'workloads' => $workloads, 'lecturers' => $lectures]);
    }

    public function deleteWorkload($id){
        $hashedId           =          Crypt::decrypt($id);
        $workload           =          Workload::where('unit_id',$hashedId)->first();
        $workload->delete();
        return redirect()->back()->with('success', 'Record deleted successfully');
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('workload::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('workload::create');
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
        return view('workload::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('workload::edit');
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
