<?php

namespace Modules\Examination\Http\Controllers;

use App\Service\CustomIds;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Modules\COD\Entities\CourseSyllabus;
use Modules\COD\Entities\SemesterUnit;
use Modules\COD\Entities\Unit;
use Modules\Examination\Entities\Exam;
use Modules\Examination\Entities\ExamMarks;
use Modules\Examination\Entities\ExamWorkflow;
use Modules\Examination\Entities\ModeratedResults;
use Modules\Lecturer\Entities\ExamWeights;
use Modules\Registrar\Entities\ACADEMICDEPARTMENTS;
use Modules\Registrar\Entities\Classes;
use Modules\Registrar\Entities\Courses;
use Modules\Registrar\Entities\Student;
use Modules\Student\Entities\ExamResults;
use Modules\Student\Entities\StudentCourse;
use Modules\Workload\Entities\Workload;

class ExaminationController extends Controller
{
    public function index()
    {
        return view('examination::index');
    }

    public function registration(){
        $deptID = auth()->guard('user')->user()->employmentDepartment->first()->department_id;
        $courseIDs = Courses::where('department_id', $deptID)->pluck('course_id');
        $classNames = Classes::whereIn('course_id', $courseIDs)->pluck('name');
        $exams = ExamMarks::whereIn('class_code', $classNames)->get()->groupBy('academic_year');
        return view('examination::semester.registration')->with(['exams' => $exams]);
    }

    public function yearExams(Request $request){
        $deptID = auth()->guard('user')->user()->employmentDepartment->first()->department_id;
        $courseIDs = Courses::where('department_id', $deptID)->pluck('course_id');
        $classNames = Classes::whereIn('course_id', $courseIDs)->pluck('name');
        $exams = ExamMarks::whereIn('class_code', $classNames)->where('academic_year', $request->year)->get()->groupBy('academic_semester');
         return view('examination::exams.yearlyExams')->with(['exams' => $exams, 'year' => $request->year]);
    }

    public function semesterExams(Request $request){
        $deptID = auth()->guard('user')->user()->employmentDepartment->first()->department_id;
        $courseIDs = Courses::where('department_id', $deptID)->pluck('course_id');
        $classNames = Classes::whereIn('course_id', $courseIDs)->pluck('name');
        $exams = ExamMarks::whereIn('class_code', $classNames)->where('academic_year', $request->year)->where('academic_semester', $request->semester)->get()->groupBy('class_code');
        return view('examination::exams.semesterExams')->with(['exams' => $exams, 'year' => $request->year, 'semester' => $request->semester]);
    }

    public function previewExam(Request $request){
        $exams = ExamMarks::where('unit_code', $request->unit)->where('class_code', $request->class)->get();
        return view('examination::exams.previewExam')->with(['exams' => $exams]);
    }

    public function receiveExam(Request $request){
        $exams = ExamMarks::where('unit_code', $request->unit)->where('class_code', $request->class)->get();
        $route = ExamMarks::where('unit_code', $request->unit)->where('class_code', $request->class)->first();
        $examID = new CustomIds();
        $approvalID = $examID->generateId();
        foreach ($exams as $exam){
            $moderated = new ModeratedResults;
            $moderated->moderated_exam_id = $approvalID;
            $moderated->class_code = $exam->class_code;
            $moderated->unit_code = $exam->unit_code;
            $moderated->student_number = $exam->student_number;
            $moderated->academic_year = $exam->academic_year;
            $moderated->academic_semester = $exam->academic_semester;
            $moderated->stage = $exam->stage;
            $moderated->semester = $exam->semester;
            $moderated->total_cat = $exam->total_cat;
            $moderated->total_exam = $exam->total_exam;
            $moderated->attempt = '1.1';
            $moderated->save();
        }
        foreach ($exams as $exam){
            ExamMarks::where('unit_code', $request->unit)->where('class_code', $request->class)->where('student_number', $exam->student_number)->update([
                'status' => 1,
            ]);
        }
        $newRoute = route('examination.semesterExams', ['year' => $route->academic_year, 'semester' => $route->academic_semester]);
        return redirect()->to($newRoute)->with('success', 'Exam marks received successfully');
    }

    public function processExam(Request $request){
        $classview = DB::table('classesview')->where('name', $request->class)->first()->course_code;
        $unit = Unit::where('unit_code', $request->unit)->first();
        $examMarks = ModeratedResults::where('class_code', $request->class)->where('unit_code', $request->unit)->get();
        $weights = Unit::where('unit_code', $request->unit)->first();
        $syllabus = CourseSyllabus::where('course_code', $classview)->where('unit_code', $request->unit)->first();
        $students = new Collection;
        $classList = StudentCourse::where('current_class', $request->class)
            ->orderBy('student_number', 'asc')
            ->get();

        foreach ($classList as $student) {
            $mark = ModeratedResults::where('class_code', $request->class)
                ->where('unit_code', $request->unit)
                ->where('student_number', $student->student_number)
                ->first();

            if ($mark) {
                $studentList = $student->StudentCourseInfo;
                $mergedData = collect($mark)->merge($studentList)->put('student_number', $student->student_number)->put('attempt', $syllabus->stage.'.'.$syllabus->semester);
                $students->push($mergedData);
            }
        }
        return view('examination::exams.processExam')->with(['class' => $request->class, 'students' => $students, 'unit' => $unit, 'weights' => $weights, 'semester' => $request->semester, 'exams' => $examMarks]);
    }

    public function processMarks(Request $request){
        $marks = $request->data;
        $semester = $request->unit;
        foreach ($marks as $mark){
            ModeratedResults::where('student_number', $mark[0])->where('unit_code', $semester['unit_code'])->update([
                'total_cat' => $mark[2] ?? 0,
                'total_exam' => $mark[3] === null || $mark[3] === 'ABSENT' ? 'ABSENT' : round($mark[3], 0),
            ]);
        }
    }

    public function submitMarks(Request $request){
        $deptID = auth()->guard('user')->user()->employmentDepartment->first()->department_id;
        $exam = ExamMarks::where('unit_code', $request->unit)->where('class_code', $request->class)->first();

        if (ExamWorkflow::where('academic_year', $exam->academic_year)->where('academic_semester', $exam->academic_semester)->where('department_id', $deptID)->exists()){
            $deptApprovalId = ExamWorkflow::where('academic_year', $exam->academic_year)->where('academic_semester', $exam->academic_semester)->where('department_id', $deptID)->first();
            ExamWorkflow::where('academic_year', $exam->academic_year)->where('academic_semester', $exam->academic_semester)->where('department_id', $deptID)->update(['cod_status' => 0, 'cod_remarks' => null]);
            $results = ModeratedResults::where('class_code', $request->class)->where('unit_code', $request->unit)->get();
            foreach ($results as $result){
                ModeratedResults::where('class_code', $request->class)->where('unit_code', $request->unit)->where('student_number', $result->student_number)->update([
                    'exam_approval_id' => $deptApprovalId->exam_approval_id
                ]);
            }
            $exams =  ExamMarks::where('class_code', $request->class)->where('unit_code', $request->unit)->get();
            foreach ($exams as $moderatedExam){
                ExamMarks::where('class_code', $request->class)->where('unit_code', $request->unit)->where('student_number', $moderatedExam->student_number)->update([
                    'exam_approval_id' => $deptApprovalId->exam_approval_id
                ]);
            }
        }else{
            $approveID = new CustomIds();
            $examApproval =  new ExamWorkflow;
            $examApproval->exam_approval_id = $approveID->generateId();
            $examApproval->department_id = $deptID;
            $examApproval->academic_year = $exam->academic_year;
            $examApproval->academic_semester = $exam->academic_semester;
            $examApproval->cod_status = 0;
            $examApproval->save();

            $exams =  ExamMarks::where('class_code', $request->class)->where('unit_code', $request->unit)->get();
            foreach ($exams as $moderatedExam){
                ExamMarks::where('class_code', $request->class)->where('unit_code', $request->unit)->where('student_number', $moderatedExam->student_number)->update([
                    'exam_approval_id' => $examApproval->exam_approval_id
                ]);
            }
        }

        $newRoute = route('examination.semesterExams', ['year' => $exam->academic_year, 'semester' => $exam->academic_semester]);
        return redirect()->to($newRoute)->with('success', 'Exam marks received successfully');
    }
}

