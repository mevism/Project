<?php

namespace Modules\Workload\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserEmployment;
use Illuminate\Routing\Controller;
use PhpOffice\PhpWord\Element\Table;
use Illuminate\Support\Facades\Crypt;
use Modules\COD\Entities\ClassPattern;
use Modules\COD\Entities\SemesterUnit;
use Modules\Registrar\Entities\Intake;
use Modules\Registrar\Entities\Courses;
use Modules\Workload\Entities\Workload;
use PhpOffice\PhpWord\TemplateProcessor;
use Modules\Registrar\Entities\Department;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use Modules\Lecturer\Entities\TeachingArea;
use Illuminate\Contracts\Support\Renderable;
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

        $workload  =  Workload::where('academic_year', $class->academic_year)->where('academic_semester', $class->period)->get();

        $units = SemesterUnit::where('class_code', $class->class_code)->where('stage', $class->stage)->where('semester', $class->pattern_id)->latest()->get();

        return view('workload::workload.allocateUnits')->with(['units' => $units,'workload' => $workload, 'class' => $class, 'lecturers' => $lecturers]);
    }

    public function allocateUnit($staff_id, $unit_id)
    {

        $hashedStaff = Crypt::decrypt($staff_id);

        $hashedUnit = Crypt::decrypt($unit_id);

        $unit = SemesterUnit::findorFail($hashedUnit);

        $class = ClassPattern::where(['class_code' => $unit->class_code, 'stage' => $unit->stage, 'pattern_id' => $unit->semester])->first();

        $user = User::find($hashedStaff)->placedUser->first();
        // return $user->userRole;
        $workloads  =  Workload::where('user_id', $hashedStaff)
            ->where('academic_year', $class->academic_year)
            ->where('academic_semester', $class->period)
            ->count();

     
        if ($user->employment_terms == 'PT') {
            if ($workloads <= 3) {

                $workload = new Workload;
                $workload->department_id = auth()->guard('user')->user()->employmentDepartment->first()->id;
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
            if ($workloads <= 6) {

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
        }

        return redirect()->back()->with('success', 'Unit allocation successful');
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

        // ->where('department_id', auth()
        //     ->guard('user')
        //     ->user()
        //     ->employmentDepartment->first()->id)
        //     ->get()
        //     ->groupBy('user_id');


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
            $ApproveWorkload->registrar_status  = null;
            $ApproveWorkload->status  = 0;
            $ApproveWorkload->save();

            foreach ($workloads as $workload) {

                $newId   =   Workload::find($workload->id);
                $newId->workload_approval_id  =   $ApproveWorkload->id;
                $newId->status = 0;
                $newId->save();
            }
        } else {

            $newWorkload   =  new  ApproveWorkload;
            $newWorkload->academic_year  =  $hashedYear;
            $newWorkload->academic_semester  =  $hashedId;
            $newWorkload->department_id  = implode($work);
            $newWorkload->dean_status  = 0;
            $newWorkload->registrar_status  = null;
            $newWorkload->status  = 0;
            $newWorkload->save();

            foreach ($workloads as $workload) {

                $newId   =   Workload::find($workload->id);
                $newId->workload_approval_id  =   $newWorkload->id;
                $newId->save();
            }
        }

        return redirect()->back()->with('success', 'Workload Submitted Successfully');
    }

    public function printWorkload($id, $year)
    {

        $hashedId = Crypt::decrypt($id);

        $hashedYear   =   Crypt::decrypt($year);

        $users = User::all();

        foreach ($users as $user) {
            if ($user->hasRole('Lecturer')) {

                $lecturers[] = $user;
            }
        }

        $dept = auth()->guard('user')->user()->employmentDepartment->first();

        $session = Workload::where('department_id', $dept->id)->where('academic_semester', $hashedId)->where('academic_year', $hashedYear)->first();

        $school = auth()->guard('user')->user()->employmentDepartment->first()->schools->first();

        $workloads  =   Workload::where('department_id', $dept->id)->where('academic_semester', $hashedId)->where('academic_year', $hashedYear)->get()->groupBy('user_id');

        $domPdfPath = base_path('vendor/dompdf/dompdf');
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $center = ['bold' => true, 'size' => 9, 'name' => 'Book Antiqua'];
        $table = new Table(array('unit' => TblWidth::TWIP));
        $headers = ['bold' => true, 'space' => ['before' => 2000, 'after' => 2000, 'rule' => 'exact']];

        $table->addRow();
        $table->addCell(400, ['borderSize' => 1, 'vMerge' => 'restart'])->addText('#', $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 13, 'bold' => true]);
        $table->addCell(4300, ['borderSize' => 1, 'gridSpan' => 4])->addText('STAFF', $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 13, 'bold' => true]);
        $table->addCell(3400, ['borderSize' => 1, 'gridSpan' => 3])->addText('CLASS', $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 11, 'bold' => true]);
        $table->addCell(6400, ['borderSize' => 1, 'gridSpan' => 3])->addText('UNIT', $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 11, 'bold' => true]);
        $table->addCell(800, ['borderSize' => 1])->addText();

        $table->addRow();
        $table->addCell(400, ['borderSize' => 1, 'vMerge' => 'continue'])->addText('#');
        $table->addCell(1200, ['borderSize' => 1])->addText('Staff Number', $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 11, 'bold' => true]);
        $table->addCell(1400, ['borderSize' => 1])->addText('Staff Name', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
        $table->addCell(1000, ['borderSize' => 1])->addText('Qualification', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
        $table->addCell(1000, ['borderSize' => 1])->addText('Roles', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
        $table->addCell(2100, ['borderSize' => 1])->addText('Class Code', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
        $table->addCell(700, ['borderSize' => 1])->addText('Work' . "\n" . 'load', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
        $table->addCell(600, ['borderSize' => 1])->addText('Stds',  $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
        $table->addCell(1500, ['borderSize' => 1])->addText('Unit Code', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
        $table->addCell(4200, ['borderSize' => 1])->addText('Unit Name', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
        $table->addCell(700, ['borderSize' => 1])->addText('Level', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
        $table->addCell(800, ['borderSize' => 1])->addText('Signature', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);

        $sn = 0;

        foreach ($workloads as $user_id => $workload) {
            $qualifications = [];
            $roles = [];
            foreach ($lecturers as $lecturer) {
                if ($lecturer->id === $user_id) {
                    $staff = $lecturer;
                    foreach ($staff->lecturerQualfs()->where('status', 1)->get() as $qualification) {
                        $qualifications[] = $qualification->qualification;
                    }
                    foreach ($staff->roles as $role) {
                        $roles[] = $role->name;
                    }
                }
            }

            $table->addRow();
            $table->addCell(400, ['borderSize' => 1])->addText(++$sn, ['name' => 'Book Antiqua', 'size' => 10]);
            $table->addCell(1200, ['borderSize' => 1])->addText($staff->staff_number, ['name' => 'Book Antiqua', 'size' => 10]);
            $table->addCell(1400, ['borderSize' => 1])->addText($staff->title . '. ' . $staff->last_name . ' ' . $staff->first_name, ['name' => 'Book Antiqua', 'size' => 9, 'align' => 'left']);
            $table->addCell(1000, ['borderSize' => 1])->addText(implode(', ', $qualifications), ['name' => 'Book Antiqua', 'size' => 9, 'align' => 'left']);
            $table->addCell(1000, ['borderSize' => 1])->addText(implode(', ', $roles), ['name' => 'Book Antiqua', 'size' => 9, 'align' => 'left']);

            $class = $table->addCell(2100, ['borderSize' => 1]);
            $staffLoad = $table->addCell(700, ['borderSize' => 1]);
            $students = $table->addCell(600, ['borderSize' => 1]);
            $unit_code = $table->addCell(1500, ['borderSize' => 1]);
            $unit_name = $table->addCell(4200, ['borderSize' => 1]);
            $levels = $table->addCell(700, ['borderSize' => 1]);
            $signature = $table->addCell(800, ['borderSize' => 1]);

            $userLoad = $workload->count();

            foreach ($lecturers as $lecturer) {
                if ($lecturer->id === $user_id) {
                    $staff = $lecturer;
                    if ($staff->placedUser->first()->employment_terms == 'FT') {
                        for ($i = 0; $i < $userLoad; ++$i) {
                            if ($i < 3) {
                                $load = 'FT';
                                $staffLoad->addText($load, ['name' => 'Book Antiqua', 'size' => 10]);
                            } else {
                                $load = 'PT';
                                $staffLoad->addText($load, ['name' => 'Book Antiqua', 'size' => 10]);
                            }
                        }
                    } else {
                        for ($i = 0; $i < $userLoad; ++$i) {
                            if ($i < $userLoad) {
                                $load = 'PT';
                                $staffLoad->addText($load, ['name' => 'Book Antiqua', 'size' => 10]);
                            }
                        }
                    }
                }
            }

            foreach ($workload as $unit) {
                $class->addText($unit->class_code, ['name' => 'Book Antiqua', 'size' => 10]);
                $students->addText($unit->classWorkload->studentClass->count(), ['name' => 'Book Antiqua', 'size' => 10]);
                $unit_code->addText($unit->workloadUnit->unit_code, ['name' => 'Book Antiqua', 'size' => 10]);
                $unit_name->addText(substr($unit->workloadUnit->unit_name, 0, 40), ['name' => 'Book Antiqua', 'size' => 10, 'align' => 'left']);
                $levels->addText($unit->classWorkload->classCourse->level, ['name' => 'Book Antiqua', 'size' => 10]);
                $signature->addText();
            }
        }
        $workload = new TemplateProcessor(storage_path('workload_template.docx'));

        $workload->setValue('initials', $school->initials);
        $workload->setValue('name', $school->name);
        $workload->setValue('department', $dept->name);
        $workload->setValue('academic_year', $session->academic_year);
        $workload->setValue('academic_semester', $session->academic_semester);
        $workload->setComplexBlock('{table}', $table);
        $docPath = 'Fees/' . 'Workload' . time() . ".docx";
        $workload->saveAs($docPath);

        $contents = \PhpOffice\PhpWord\IOFactory::load($docPath);

        $pdfPath = 'Fees/' . 'Workload' . time() . ".pdf";

        //            $converter =  new OfficeConverter($docPath, 'Fees/');
        //            $converter->convertTo('Workload' . time() . ".pdf");

        //            if (file_exists($docPath)) {
        //                unlink($docPath);
        //            }


        //        return response()->download($pdfPath)->deleteFileAfterSend(true);

        return response()->download($docPath)->deleteFileAfterSend(true);
    }


    //    public function resubmitWorkload($id, $year)
    //    {
    //
    //        $hashedId   =   Crypt::decrypt($id);
    //
    //        $hashedYear   =   Crypt::decrypt($year);
    //
    //        $deptId = auth()->guard('user')->user()->employmentDepartment->first()->id;
    //
    //        $departments   =   Department::where('division_id', 1)->get();
    //
    //        foreach ($departments as $department) {
    //            if ($department->id == $deptId) {
    //
    //                $work[] = $department->id;
    //            }
    //        }
    //        $workloads   =   Workload::where('academic_year', $hashedYear)
    //            ->where('academic_semester', $hashedId)
    //            ->where('department_id', $work)
    //            ->get();
    //
    //        if (ApproveWorkload::where('academic_year', $hashedYear)->where('academic_semester', $hashedId)->where('department_id', $work)->exists()) {
    //
    //            $ApproveWorkload   =   ApproveWorkload::where('academic_year', $hashedYear)->where('academic_semester', $hashedId)->where('department_id', $work)->first();
    //            $ApproveWorkload->academic_year  =  $hashedYear;
    //            $ApproveWorkload->academic_semester  =  $hashedId;
    //            $ApproveWorkload->department_id  = implode($work);
    //            $ApproveWorkload->dean_status  = 0;
    //            $ApproveWorkload->dean_remarks  = null;
    //            $ApproveWorkload->registrar_status  = null;
    //            $ApproveWorkload->registrar_remarks  = null;
    //            $ApproveWorkload->save();
    //
    //            foreach ($workloads as $workload) {
    //
    //                $newId   =   Workload::find($workload->id);
    //                $newId->workload_approval_id  =   $ApproveWorkload->id;
    //                $newId->status  =   null;
    //                $newId->save();
    //            }
    //        } else {
    //
    //            $newWorkload   =  new  ApproveWorkload;
    //            $newWorkload->academic_year  =  $hashedYear;
    //            $newWorkload->academic_semester  =  $hashedId;
    //            $newWorkload->department_id  = implode($work);
    //            $newWorkload->dean_status  = 0;
    //            $newWorkload->dean_remarks  = null;
    //            $newWorkload->registrar_status  = null;
    //            $newWorkload->registrar_remarks  = null;
    //            $newWorkload->save();
    //
    //            foreach ($workloads as $workload) {
    //
    //                $newId   =   Workload::find($workload->id);
    //                $newId->workload_approval_id  =   $newWorkload->id;
    //                $newId->status  =   null;
    //                $newId->save();
    //            }
    //        }
    //
    //        return redirect()->back()->with('success', 'Workload Resubmitted Successfully');
    //    }

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
