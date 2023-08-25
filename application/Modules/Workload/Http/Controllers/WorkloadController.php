<?php

namespace Modules\Workload\Http\Controllers;

use App\Service\CustomIds;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserEmployment;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\COD\Entities\CourseSyllabus;
use Modules\COD\Entities\Unit;
use Modules\Registrar\Entities\ACADEMICDEPARTMENTS;
use Modules\Registrar\Entities\Classes;
use Modules\Registrar\Entities\Division;
use Modules\User\Entities\StaffInfo;
use NcJoes\OfficeConverter\OfficeConverter;
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
    public function workloads(){
        $academicYears = AcademicYear::orderBy('year_start', 'desc')->get();
        return view('workload::workload.index')->with(['academicYears' => $academicYears]);
    }

    public function yearlyWorkloads($id){
        $semesters = Intake::where('academic_year_id', $id)->orderBy('intake_from', 'desc')->get();
        return view('workload::workload.yearlyWorkload')->with(['semesters' => $semesters]);
    }

    public function semesterWorkload($id){
        $classes = [];
        $semester = Intake::where('intake_id', $id)->first();
        $academicYear = Carbon::parse($semester->academicYear->year_start)->format('Y') . '/' . Carbon::parse($semester->academicYear->year_end)->format('Y');
        $period = Carbon::parse($semester->intake_from)->format('M') . '/' . Carbon::parse($semester->intake_to)->format('M');
        $department_id = auth()->guard('user')->user()->employmentDepartment->first()->department_id;
        $courses = Courses::where('department_id', $department_id)->latest()->get();
        foreach ($courses as $course) {
            $course_id[] = $course->course_id;
        }
        $classPatterns = ClassPattern::where('academic_year', $academicYear)->where('period', $period)->orderBy('class_code', 'desc')->get();
        foreach ($classPatterns as $patterns) {
            if (in_array($patterns->classSchedule->course_id, $course_id, false)) {
                $classes[] = $patterns;
            }
        }
        return view('workload::workload.semesterWorkload')->with(['classes' => $classes]);
    }

    public function classUnits($id){
        $users = User::all();
        $lecturers = [];
        foreach ($users as $user) {
            if ($user->hasRole('LECTURER')) {
                $lecturers[] = $user;
            }
        }
        $pattern = ClassPattern::where('class_pattern_id', $id)->first();
        $class = Classes::where('name', $pattern->class_code)->first();
        $intake = DB::table('academicperiods')->where('academic_year', $pattern->academic_year)->where('intake_month', $pattern->period)->first();
        $workloads =  Workload::where('intake_id', $intake->intake_id)->get();
        $units = CourseSyllabus::where('course_code', $class->classCourse->course_code)
                                ->where('stage', $pattern->stage)
                                ->where('semester', $pattern->pattern_id)
                                ->where('version', $class->syllabus_name)
                                ->orderBy('unit_code', 'asc')
                                ->get();
        return view('workload::workload.allocateUnits')->with(['units' => $units,'workloads' => $workloads, 'class' => $pattern, 'lecturers' => $lecturers, 'intake' => $intake]);
    }

    public function allocateUnit(Request $request){
//        return $request->all();
        $lecturer = User::where('user_id', $request->staffId)->first();
        $pattern = ClassPattern::where('class_pattern_id', $request->patternId)->first();
        $intake = DB::table('academicperiods')->where('academic_year', $pattern->academic_year)->where('intake_month', $pattern->period)->first();
        $workloads  =  Workload::where('user_id', $request->staffId)->where('intake_id', $intake->intake_id)->count();
        if ($lecturer->employments->first()->employment_terms == 'PT') {
            if ($workloads <= 3) {
                $workloadId = new CustomIds();
                $workload = new Workload;
                $workload->workload_id = $workloadId->generateId();
                $workload->department_id = auth()->guard('user')->user()->employmentDepartment->first()->department_id;
                $workload->intake_id = $intake->intake_id;
                $workload->user_id = $request->staffId;
                $workload->unit_code = $request->unitId;
                $workload->class_code = $pattern->class_code;
                $workload->save();
                return redirect()->back()->with('success', 'Unit allocation successful');
            } else {
                return redirect()->back()->with('info', 'Lecturer Fully Loaded.');
            }
        } else {
            if ($workloads <= 6) {
                $workloadId = new CustomIds();
                $workload = new Workload;
                $workload->workload_id = $workloadId->generateId();
                $workload->intake_id = $intake->intake_id;
                $workload->department_id = auth()->guard('user')->user()->employmentDepartment->first()->department_id;
                $workload->user_id = $request->staffId;
                $workload->unit_code = $request->unitId;
                $workload->class_code = $pattern->class_code;
                $workload->save();
                return redirect()->back()->with('success', 'Unit allocation successful');
            } else {
                return redirect()->back()->with('info', 'Lecturer Fully Loaded.');
            }
        }
    }

    public function deleteWorkload($id){
        Workload::where('workload_id', $id)->delete();
        return redirect()->back()->with('success', 'Record deleted successfully');
    }

    public function viewWorkload(){
       $workloads = AcademicYear::orderBy('year_start', 'desc')->get();
        return view('workload::workload.viewWorkload')->with(['workloads' => $workloads]);
    }

    public function viewYearWorkload($id){
        $year = AcademicYear::where('year_id', $id)->first();
        $academic_year = Carbon::parse($year->year_start)->format('Y').'/'.Carbon::parse($year->year_end)->format('Y');
        $intakes = DB::table('academicperiods')->where('academic_year', $academic_year)->pluck('intake_id');
        $workloads = Workload::whereIn('intake_id', $intakes)->where('department_id', auth()->guard('user')->user()->employmentDepartment->first()->department_id)->latest()->get()->groupBy('intake_id');
        return view('workload::workload.viewYearWorkload')->with(['workloads' => $workloads, 'year' => $academic_year]);
    }

    public function viewSemesterWorkload($id){
        $users = User::all();
        foreach ($users as $user) {
            if ($user->hasRole('LECTURER')) {
                $lecturers[] = $user;
            }
        }
       $workloads = Workload::where('intake_id', $id)->where('department_id', auth()->guard('user')->user()->employmentDepartment->first()->department_id)->get()->groupBy('user_id');

        return view('workload::workload.viewSemesterWorkload')->with(['semester' => $id, 'workloads' => $workloads, 'lecturers' => $lecturers]);
    }

    public function submitWorkload($id){
        $deptId = auth()->guard('user')->user()->employmentDepartment->first()->department_id;
        $workload = Workload::where('intake_id', $id)->where('department_id', $deptId)->where('workload_approval_id', '!=', null)->first();
        if ($workload == null){
            $approvalID = new CustomIds();
            $newWorkload = new  ApproveWorkload;
            $newWorkload->workload_approval_id = $approvalID->generateId();
            $newWorkload->dean_status  = 0;
            $newWorkload->save();
            $workloads = Workload::where('intake_id', $id)->where('department_id', $deptId)->get();
            foreach ($workloads as $workload) {
                Workload::where('workload_id', $workload->workload_id)->update(['workload_approval_id' => $newWorkload->workload_approval_id, 'status' => 0]);
            }

        }else{
            $workloads = Workload::where('intake_id', $id)->where('department_id', $deptId)->get();
            ApproveWorkload::where('workload_approval_id', $workloads->first()->workload_approval_id)->update([
                'status' => '',
                'registrar_remarks' => null,
                'registrar_status' => null,
                'dean_remarks' => null,
                'dean_status' => 0
            ]);

            foreach ($workloads as $workload) {
                Workload::where('workload_id', $workload->workload_id)->update(['status' => 0]);
            }
        }

        return redirect()->back()->with('success', 'Workload Submitted Successfully');
    }

    public function printWorkload($id){
        $userID = Workload::where('department_id', auth()->guard('user')->user()->employmentDepartment->first()->department_id)->where('intake_id', $id)->distinct()->pluck('user_id');
        $users = User::whereIn('user_id', $userID)->get();
        foreach ($users as $user) {
            if ($user->hasRole('LECTURER')) {
                $lecturers[] = $user;
            }
        }
        $session = DB::table('academicperiods')->where('intake_id', $id)->first();
        $school = auth()->guard('user')->user()->employmentDepartment->first()->schools->first();
        $workloads = Workload::where('department_id', auth()->guard('user')->user()->employmentDepartment->first()->department_id)->where('intake_id', $id)->get()->groupBy('user_id');
        $depatment = Department::where('department_id', auth()->guard('user')->user()->employmentDepartment->first()->department_id)->first()->name;

        $domPdfPath = base_path('vendor/dompdf/dompdf');
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('DomPDF');

        $center = ['bold' => true, 'size' => 9, 'name' => 'Book Antiqua'];
        $table = new Table(['unit' => \PhpOffice\PhpWord\SimpleType\TblWidth::TWIP, 'width' => 1400 * 1400, 'align' => 'center']);
        $headers = ['bold' => true, 'space' => ['before' => 2000, 'after' => 2000, 'rule' => 'exact']];
        $left = array('align' => 'left', 'size' => 10, 'name' => 'Book Antiqua');
        $right = array('align' => 'right', 'size' => 10, 'name' => 'Book Antiqua');

        $table->addRow();
        $table->addCell(400, ['borderSize' => 1, 'vMerge' => 'restart'])->addText('#', $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 13, 'bold' => true]);
        $table->addCell(5750, ['borderSize' => 1, 'gridSpan' => 4])->addText('STAFF', $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 13, 'bold' => true]);
        $table->addCell(3600, ['borderSize' => 1, 'gridSpan' => 3])->addText('CLASS', $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 11, 'bold' => true]);
        $table->addCell(5500, ['borderSize' => 1, 'gridSpan' => 3])->addText('UNIT', $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 11, 'bold' => true]);
        $table->addCell(800, ['borderSize' => 1])->addText();

        $table->addRow();
        $table->addCell(400, ['borderSize' => 1, 'vMerge' => 'continue'])->addText('#');
        $table->addCell(1400, ['borderSize' => 1])->addText('Staff Number', $center, ['align' => 'center', 'name' => 'Book Antiqua', 'size' => 11, 'bold' => true]);
        $table->addCell(1300, ['borderSize' => 1])->addText('Staff Name', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
        $table->addCell(1550, ['borderSize' => 1])->addText('Qualification', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
        $table->addCell(1400, ['borderSize' => 1])->addText('Roles', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
        $table->addCell(2200, ['borderSize' => 1])->addText('Class Code', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
        $table->addCell(800, ['borderSize' => 1])->addText('Work' . "\n" . 'load', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
        $table->addCell(700, ['borderSize' => 1])->addText('Stds',  $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
        $table->addCell(1100, ['borderSize' => 1])->addText('Unit Code', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
        $table->addCell(3500, ['borderSize' => 1])->addText('Unit Name', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
        $table->addCell(800, ['borderSize' => 1])->addText('Level', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
        $table->addCell(500, ['borderSize' => 1])->addText('Sign', $center, ['name' => 'Book Antiqua', 'size' => 11, 'bold' => true, 'align' => 'center']);
        $sn = 0;
        foreach ($workloads as $user_id => $workload) {
            $qualifications = [];
            $roles = [];
            foreach ($lecturers as $lecturer) {
                if ($lecturer->user_id == $user_id) {
                    $staff = $lecturer;
                    foreach ($staff->lecturerQualfs()->where('status', 1)->get() as $qualification) {
                        $qualifications[] = substr($qualification->qualification, 0 , 25);
                    }
                    foreach ($staff->roles as $role) {
                        $roles[] = $role->name;
                    }
                }
            }

            $table->addRow();
            $table->addCell(200, ['borderSize' => 1])->addText(++$sn, $left, ['name' => 'Book Antiqua', 'size' => 10]);
            $table->addCell(800, ['borderSize' => 1])->addText($staff->staffInfos->staff_number, $left, ['name' => 'Book Antiqua', 'size' => 10]);
            $table->addCell(1000, ['borderSize' => 1])->addText($staff->staffInfos->title . '. ' . $staff->staffInfos->last_name . ' ' . $staff->staffInfos->first_name, $left, ['name' => 'Book Antiqua', 'size' => 9, 'align' => 'left']);
            $table->addCell(700, ['borderSize' => 1])->addText(implode(', ', $qualifications), $left, ['name' => 'Book Antiqua', 'size' => 9, 'align' => 'left']);
            $table->addCell(800, ['borderSize' => 1])->addText(implode(', ', $roles), $left, ['name' => 'Book Antiqua', 'size' => 9, 'align' => 'left']);


            $class = $table->addCell(2200, ['borderSize' => 1]);
            $staffLoad = $table->addCell(800, ['borderSize' => 1]);
            $students = $table->addCell(700, ['borderSize' => 1]);
            $unit_code = $table->addCell(1100, ['borderSize' => 1]);
            $unit_name = $table->addCell(3500, ['borderSize' => 1]);
            $levels = $table->addCell(800, ['borderSize' => 1]);
            $signature = $table->addCell(500, ['borderSize' => 1]);

           $userLoad = $workload->count();

            foreach ($lecturers as $lecturer) {
                if ($lecturer->user_id === $user_id) {
                    $staff = $lecturer;
                    if ($staff->employments->first()->employment_terms == 'FT' && $staff->hasRole('LECTURER')) {
                        for ($i = 0; $i < $userLoad; ++$i) {
                            if ($i < 3) {
                                $load = 'FT';
                                $staffLoad->addText($load, $left, ['name' => 'Book Antiqua', 'size' => 9]);
                            } else {
                                $load = 'PT';
                                $staffLoad->addText($load, $left, ['name' => 'Book Antiqua', 'size' => 9]);
                            }
                        }
                    } elseif ($staff->employments->first()->employment_terms == 'FT' && $staff->hasRole('CHAIRPERSON OF DEPARTMENT') || $staff->employments->first()->employment_terms == 'FT' && $staff->hasRole('DIRECTOR/DEAN')) {
                        for ($i = 0; $i < $userLoad; ++$i) {
                            if ($i < 2) {
                                $load = 'FT';
                                $staffLoad->addText($load, $left, ['name' => 'Book Antiqua', 'size' => 9]);
                            } else {
                                $load = 'PT';
                                $staffLoad->addText($load, $left, ['name' => 'Book Antiqua', 'size' => 9]);
                            }
                        }
                    }else{
                        for ($i = 0; $i < $userLoad; ++$i) {
                            if ($i < $userLoad) {
                                $load = 'PT';
                                $staffLoad->addText($load, $left, ['name' => 'Book Antiqua', 'size' => 9]);
                            }
                        }
                    }
                }
            }

            foreach ($workload as $unit) {
                $class->addText($unit->class_code, $left, ['name' => 'Book Antiqua', 'size' => 10]);
                $students->addText(str_pad($unit->classWorkload->studentClass->count(), 2, 0, STR_PAD_LEFT), $right, ['name' => 'Book Antiqua', 'size' => 10]);
                $unit_code->addText($unit->workloadUnit->unit_code, $left, ['name' => 'Book Antiqua', 'size' => 10]);
                $unit_name->addText(substr($unit->workloadUnit->unit_name, 0, 30), $left, ['name' => 'Book Antiqua', 'size' => 10, 'align' => 'left']);
                $levels->addText($unit->classWorkload->classCourse->level_id, $right, ['name' => 'Book Antiqua', 'size' => 10]);
                $signature->addText();
            }
        }
        $workload = new TemplateProcessor(storage_path('workload_template.docx'));

        $workload->setValue('initials', $school->initials);
        $workload->setValue('name', $school->name);
        $workload->setValue('department', $depatment);
        $workload->setValue('academic_year', $session->academic_year);
        $workload->setValue('academic_semester', $session->intake_month);
        $workload->setComplexBlock('{table}', $table);
        $docPath = 'Fees/' . 'Workload' . time() . ".docx";
        $workload->saveAs($docPath);

        $contents = \PhpOffice\PhpWord\IOFactory::load($docPath);

        $pdfPath = 'Fees/' . 'Workload' . time() . ".pdf";

                    $converter =  new OfficeConverter($docPath, 'Fees/');
                    $converter->convertTo('Workload' . time() . ".pdf");

                    if (file_exists($docPath)) {
                        unlink($docPath);
                    }


                return response()->download($pdfPath)->deleteFileAfterSend(true);
//
//        return response()->download($docPath)->deleteFileAfterSend(true);
    }
}
