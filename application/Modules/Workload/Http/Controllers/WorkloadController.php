<?php

namespace Modules\Workload\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserEmployment;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Crypt;
use Modules\COD\Entities\ClassPattern;
use Modules\COD\Entities\SemesterUnit;
use Modules\Registrar\Entities\Intake;
use Modules\Registrar\Entities\Courses;
use Modules\Workload\Entities\Workload;
use Modules\Registrar\Entities\Department;
use Illuminate\Contracts\Support\Renderable;
use Modules\Lecturer\Entities\TeachingArea;
use Modules\Registrar\Entities\AcademicYear;
use Modules\Workload\Entities\ApproveWorkload;

class WorkloadController extends Controller
{
    public function workloads()
    {

        $academicYears = AcademicYear::latest()->get();

        return view('workload::workload.index')->with(['academicYears' => $academicYears]);
    }

    public function yearlyWorkloads($id)
    {

        $hashedId = Crypt::decrypt($id);

        $semesters = Intake::where('academic_year_id', $hashedId)->latest()->get();

        return view('workload::workload.yearlyWorkload')->with(['semesters' => $semesters]);
    }

    public function semesterWorkload($id)
    {

        $hashedId = Crypt::decrypt($id);

        $classes = [];

        $semester = Intake::findorFail($hashedId);

        $academicYear = Carbon::parse($semester->academicYear->year_start)->format('Y') . '/' . Carbon::parse($semester->academicYear->year_end)->format('Y');

        $period = Carbon::parse($semester->intake_from)->format('M') . '/' . Carbon::parse($semester->intake_to)->format('M');

        $department_id = auth()->guard('user')->user()->employmentDepartment->first()->id;

        $courses = Courses::where('department_id', $department_id)->latest()->get();

        foreach ($courses as $course) {

            $course_id[] = $course->id;
        }

        $classPatterns = ClassPattern::where('academic_year', $academicYear)->where('period', $period)->latest()->get();

        foreach ($classPatterns as $patterns) {

            if (in_array($patterns->classSchedule->course_id, $course_id, false)) {

                $classes[] = $patterns;
            }
        }

        return view('workload::workload.semesterWorkload')->with(['classes' => $classes]);
    }

    public function classUnits($id)
    {

        $users = User::all();

        $lecturers = [];

        foreach ($users as $user) {
            if ($user->hasRole('Lecturer')) {

                $lecturers[] = $user;
            }
        }

        $hashedId = Crypt::decrypt($id);

        $class = ClassPattern::findorFail($hashedId);

         $teaching = TeachingArea::where('user_id')->get();

        $units = SemesterUnit::where('class_code', $class->class_code)->where('stage', $class->stage)->where('semester', $class->pattern_id)->latest()->get();

        return view('workload::workload.allocateUnits')->with(['units' => $units, 'lecturers' => $lecturers]);
    }

    public function allocateUnit($staff_id, $unit_id)
    {

        $hashedStaff = Crypt::decrypt($staff_id);

        $hashedUnit = Crypt::decrypt($unit_id);

        $unit = SemesterUnit::findorFail($hashedUnit);

        $class = ClassPattern::where(['class_code' => $unit->class_code, 'stage' => $unit->stage, 'pattern_id' => $unit->semester])->first();

        $user = User::find($hashedStaff)->placedUser->first();



        $workloads  =  Workload::where('user_id', $hashedStaff)
            ->where('academic_year', $class->academic_year)
            ->where('academic_semester', $class->period)
            ->count();

        if ($user->employment_terms == 'PT') {
            if ($workloads < 5) {

                $workload = new Workload;
                $workload->academic_year = $class->academic_year;
                $workload->academic_semester = $class->period;
                $workload->user_id = $hashedStaff;
                $workload->unit_id = $unit->id;
                $workload->class_code = $class->class_code;
                $workload->department_id = auth()->guard('user')->user()->employmentDepartment->first()->id;
                $workload->save();

                return redirect()->back()->with('success', 'Unit allocation successful');
            } else {

                return redirect()->back()->with('info', 'Lecturer Fully Loaded.');
            }
        } else {

            $workload = new Workload;
            $workload->academic_year = $class->academic_year;
            $workload->academic_semester = $class->period;
            $workload->user_id = $hashedStaff;
            $workload->unit_id = $unit->id;
            $workload->class_code = $class->class_code;
            $workload->department_id = auth()->guard('user')->user()->employmentDepartment->first()->id;
            $workload->save();

            return redirect()->back()->with('success', 'Unit allocation successful');
        }
    }

    public function viewWorkload()
    {

        $workloads = Workload::latest()->get()->groupBy('academic_year');

        return view('workload::workload.viewWorkload')->with(['workloads' => $workloads]);
    }

    public function viewYearWorkload($year)
    {

        $hashedYear = Crypt::decrypt($year);

        $workloads = Workload::where('academic_year', $hashedYear)->latest()->get()->groupBy('academic_semester');

        return view('workload::workload.viewYearWorkload')->with(['workloads' => $workloads, 'year' => $hashedYear]);
    }

    public function viewSemesterWorkload($semester, $year)
    {

        $hashedSemester = Crypt::decrypt($semester);

        $hashedYear = Crypt::decrypt($year);

        $deptId = auth()->guard('user')->user()->employmentDepartment->first()->id;

        $departments   =   Department::where('division_id', 1)->get();

        foreach ($departments as $department) {
            if ($department->id == $deptId) {

                $work[] = $department->id;
            }
        }

        $users = User::all();

        foreach ($users as $user) {

            if ($user->hasRole('Lecturer')) {

                $lectures[] = $user;
            }
        }

        $workloads = Workload::where('academic_year', $hashedYear)
            ->where('academic_semester', $hashedSemester)
            ->where('department_id', $work)
            ->get()->groupBy('user_id');

        return view('workload::workload.viewSemesterWorkload')->with(['semester' => $hashedSemester, 'year' => $hashedYear, 'workloads' => $workloads, 'lecturers' => $lectures]);
    }

    public function submitWorkload($id, $year)
    {

        $hashedId   =   Crypt::decrypt($id);

        $hashedYear   =   Crypt::decrypt($year);

        $deptId = auth()->guard('user')->user()->employmentDepartment->first()->id;

        $departments   =   Department::where('division_id', 1)->get();

        foreach ($departments as $department) {
            if ($department->id == $deptId) {

                $work[] = $department->id;
            }
        }
        $workloads   =   Workload::where('academic_year', $hashedYear)
            ->where('academic_semester', $hashedId)
            ->where('department_id', $work)
            ->get();

        if (ApproveWorkload::where('academic_year', $hashedYear)->where('academic_semester', $hashedId)->where('department_id', $work)->exists()) {

            $ApproveWorkload   =   ApproveWorkload::where('academic_year', $hashedYear)->where('academic_semester', $hashedId)->where('department_id', $work)->first();
            $ApproveWorkload->academic_year  =  $hashedYear;
            $ApproveWorkload->academic_semester  =  $hashedId;
            $ApproveWorkload->department_id  = implode($work);
            $ApproveWorkload->dean_status  = 0;
            $ApproveWorkload->save();

            foreach ($workloads as $workload) {

                $newId   =   Workload::find($workload->id);
                $newId->workload_approval_id  =   $ApproveWorkload->id;
                $newId->save();
            }
        } else {

            $newWorkload   =  new  ApproveWorkload;
            $newWorkload->academic_year  =  $hashedYear;
            $newWorkload->academic_semester  =  $hashedId;
            $newWorkload->department_id  = implode($work);
            $newWorkload->dean_status  = 0;
            $newWorkload->save();

            foreach ($workloads as $workload) {

                $newId   =   Workload::find($workload->id);
                $newId->workload_approval_id  =   $newWorkload->id;
                $newId->save();
            }
        }

        return redirect()->back()->with('success', 'Workload Submitted Successfully');
    }
    public function resubmitWorkload($id, $year)
    {

        $hashedId   =   Crypt::decrypt($id);

        $hashedYear   =   Crypt::decrypt($year);

        $deptId = auth()->guard('user')->user()->employmentDepartment->first()->id;

        $departments   =   Department::where('division_id', 1)->get();

        foreach ($departments as $department) {
            if ($department->id == $deptId) {

                $work[] = $department->id;
            }
        }
        $workloads   =   Workload::where('academic_year', $hashedYear)
            ->where('academic_semester', $hashedId)
            ->where('department_id', $work)
            ->get();

        if (ApproveWorkload::where('academic_year', $hashedYear)->where('academic_semester', $hashedId)->where('department_id', $work)->exists()) {

            $ApproveWorkload   =   ApproveWorkload::where('academic_year', $hashedYear)->where('academic_semester', $hashedId)->where('department_id', $work)->first();
            $ApproveWorkload->academic_year  =  $hashedYear;
            $ApproveWorkload->academic_semester  =  $hashedId;
            $ApproveWorkload->department_id  = implode($work);
            $ApproveWorkload->dean_status  = 0;
            $ApproveWorkload->dean_remarks  = null;
            $ApproveWorkload->registrar_status  = null;
            $ApproveWorkload->registrar_remarks  = null;
            $ApproveWorkload->save();

            foreach ($workloads as $workload) {

                $newId   =   Workload::find($workload->id);
                $newId->workload_approval_id  =   $ApproveWorkload->id;
                $newId->status  =   null;
                $newId->save();
            }
        } else {

            $newWorkload   =  new  ApproveWorkload;
            $newWorkload->academic_year  =  $hashedYear;
            $newWorkload->academic_semester  =  $hashedId;
            $newWorkload->department_id  = implode($work);
            $newWorkload->dean_status  = 0;
            $newWorkload->dean_remarks  = null;
            $newWorkload->registrar_status  = null;
            $newWorkload->registrar_remarks  = null;
            $newWorkload->save();

            foreach ($workloads as $workload) {

                $newId   =   Workload::find($workload->id);
                $newId->workload_approval_id  =   $newWorkload->id;
                $newId->status  =   null;
                $newId->save();
            }
        }

        return redirect()->back()->with('success', 'Workload Resubmitted Successfully');
    }

    public function deleteWorkload($id)
    {
        $hashedId           =          Crypt::decrypt($id);
        $workload           =          Workload::where('unit_id', $hashedId)->first();
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
