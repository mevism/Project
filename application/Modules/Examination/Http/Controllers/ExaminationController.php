<?php

namespace Modules\Examination\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;
use Modules\COD\Entities\SemesterUnit;
use Modules\Examination\Entities\Exam;
use Modules\Examination\Entities\ExamMarks;
use Modules\Lecturer\Entities\ExamWeights;
use Modules\Registrar\Entities\Student;
use Modules\Registrar\Entities\StudentCourse;
use Modules\Student\Entities\ExamResults;
use Modules\Workload\Entities\Workload;

class ExaminationController extends Controller
{
//    public function __construct(){
//        auth()->setDefaultDriver('user');
//        $this->middleware(['web','auth', 'is_cod', 'dean', 'admin']);
//    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('examination::index');
    }

    public function registration(){

       $grouped = ExamMarks::latest()->get()->groupBy(['academic_semester']);

       foreach ($grouped as $group){
           $data [] = $group->groupBy('academic_year');
       }

        return view('examination::semester.registration')->with(['data' => $data]);
    }

    public function semesterExams($year, $semester){

        $exams = ExamMarks::where('academic_year', Crypt::decrypt($year))->where('academic_semester', Crypt::decrypt($semester))->get()->groupBy('class_code');

        return view('examination::exams.semesterExams')->with(['exams' => $exams]);

    }

    public function previewExam($class, $code){

        $exams = ExamMarks::where('unit_code', Crypt::decrypt($code))->where('class_code', Crypt::decrypt($class))->get();

        return view('examination::exams.previewExam')->with(['exams' => $exams]);
    }

    public function receiveExam($class, $code){

        $exams = ExamMarks::where('unit_code', Crypt::decrypt($code))->where('class_code', Crypt::decrypt($class))->get();

        foreach ($exams as $exam){
            $received = ExamMarks::find($exam->id);
            $received->status = 1;
            $received->save();
        }

        return redirect()->back()->with('success', 'Exam received successfully');

    }

    public function processExam($class, $code){

        $students = [];

        $weights = ExamWeights::where('class_code', Crypt::decrypt($class))->where('unit_code', Crypt::decrypt($code))->first();
        $exams = ExamMarks::where('class_code', Crypt::decrypt($class))->where('unit_code', Crypt::decrypt($code))->first();
        $unit = SemesterUnit::where('unit_code', Crypt::decrypt($code))->where('class_code',Crypt::decrypt($class))->first();
        $workload = Workload::where('unit_id', $unit->id)->first();

            $students = new Collection;

            $classList = StudentCourse::where('class_code', Crypt::decrypt($class))->orderBy('student_id', 'asc')->get();

            foreach ($classList as $student) {

                $mark = ExamMarks::where('class_code', Crypt::decrypt($class))->where('unit_code', Crypt::decrypt($code))->where('reg_number', $student->student->reg_number)->first();

                $studentList = $student->student;

                $students[] = collect($mark)->merge($studentList);

                }

        return view('examination::exams.processExam')->with(['class' => $class, 'students' => $students, 'unit' => $unit, 'weights' => $weights, 'workload' => $workload, 'exams' => $exams]);

    }

    public function processMarks(Request $request){

        $marks = $request->data;
        $semester = $request->unit;
        $workload = $request->workload;

        foreach ($marks as $mark){
//            return $mark;
                $exams = ExamMarks::where('class_code', $semester['class_code'])->where('unit_code', $semester['unit_code'])->where('reg_number', $mark[0])->first();
                $exams->class_code = $semester['class_code'];
                $exams->unit_code = $semester['unit_code'];
                $exams->reg_number = $mark[0];
                $exams->academic_year = $workload['academic_year'];
                $exams->academic_semester = $workload['academic_semester'];
                $exams->stage = $semester['stage'];
                $exams->semester = $semester['semester'];
                $exams->cat = $mark[2];
                $exams->assignment = $mark[3];
                $exams->practical = $mark[4];
                if ($mark[5] == null){ $exams->exam = 'ABSENT'; }else{ $exams->exam = round(intval($mark[5]),0); }
                $exams->total_cat = $mark[6];
                if ($mark[7] == 'NaN' || $mark[7] == 'ABSENT'){ $exams->total_exam = 'ABSENT'; }else{ $exams->total_exam = round($mark[7],0); }
                if ($mark[7] == 'NaN' || $mark[7] == 'ABSENT'){ $exams->total_mark = 'ABSENT'; }else{ $exams->total_mark = round($mark[8],0); }
                $exams->attempt = '$mark[10]';
                $exams->save();

//                return $mark;

            }

    }


















    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('examination::create');
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
        return view('examination::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('examination::edit');
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
