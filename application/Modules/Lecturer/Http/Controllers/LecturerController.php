<?php

namespace Modules\Lecturer\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Modules\COD\Entities\SemesterUnit;
use Modules\Examination\Entities\ExamMarks;
use Modules\Lecturer\Entities\ExamWeights;
use Modules\Lecturer\Entities\LecturerQualification;
use Crypt;
use Modules\Lecturer\Entities\TeachingArea;
use Modules\Registrar\Entities\Courses;
use Modules\Registrar\Entities\StudentCourse;
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

        $workloads = Workload::where('academic_year', $hashedYear)->where('academic_semester', $hashedSemester)->where('user_id', auth()->guard('user')->user()->id)->latest()->get();

        return view('lecturer::workload.semesterWorkload')->with(['workloads' => $workloads, 'year' => $hashedYear, 'semester' => $hashedSemester]);

    }

    public function examination(){

        $workloads = Workload::where('user_id', auth()->guard('user')->user()->id)->latest()->get()->groupBy('academic_year');

        return view('lecturer::examination.index')->with(['workloads' => $workloads]);

    }


    public function yearlyExams($id){

        $hashedId = Crypt::decrypt($id);

        $workloads = Workload::where('academic_year', $hashedId)->latest()->get()->groupBy('academic_semester');

        return view('lecturer::examination.yearlyExams')->with(['workloads' => $workloads, 'year' => $hashedId]);
    }

    public function semesterExamination($year, $semester){

        $hashedYear = Crypt::decrypt($year);
        $hashedSemester = Crypt::decrypt($semester);

        $workloads = Workload::where('academic_year', $hashedYear)->where('academic_semester', $hashedSemester)->where('user_id', auth()->guard('user')->user()->id)->latest()->get();

        $setting = ExamWeights::where('academic_year', $hashedYear)->where('academic_semester', $hashedSemester)->latest()->get();

        return view('lecturer::examination.semesterExams')->with(['workloads' => $workloads, 'year' => $hashedYear, 'semester' => $hashedSemester, 'settings' => $setting]);
    }

    public function getClassStudents(Request $request, $id, $unit_id){
        $hashedId = Crypt::decrypt($id);
        $hashedUnit = Crypt::decrypt($unit_id);

        $students = [];

        $semester = Workload::findorFail($hashedId);

        $class = Workload::findorFail($hashedId)->class_code;
        $unit = SemesterUnit::findorFail($hashedUnit)->id;

        $classList = StudentCourse::where('class_code', $class)->orderBy('student_id', 'asc')->get();

        foreach ($classList as $student){

            $students [] = $student->student;
        }

//        return $students;

        $unit = SemesterUnit::findorFail($unit);

        $weights = ExamWeights::where('class_code', $class)->where('unit_code', $unit->unit_code)->first();


        if ($request->filled('exam')){

            $selectedUnit = SemesterUnit::find($hashedUnit);
            $selectedWorkload = Workload::findorFail($hashedId);

            $request->validate([

                'exam' => 'required|numeric',
                'cat' => 'required|numeric',
                'assignment' => Rule::requiredIf($selectedUnit->assingment != null),
                'practical' => Rule::requiredIf($selectedUnit->practical != null)
            ]);

            if (ExamWeights::where('academic_year', $selectedWorkload->academic_year)->where('academic_semester', $selectedWorkload->academic_semester)->where('unit_code', $selectedUnit->unit_code)->exists()){
                $settings = ExamWeights::where('academic_year', $selectedWorkload->academic_year)->where('academic_semester', $selectedWorkload->academic_semester)->where('unit_code', $selectedUnit->unit_code)->first();
                $settings->unit_code = $selectedUnit->unit_code;
                $settings->class_code = $class;
                $settings->academic_year = $selectedWorkload->academic_year;
                $settings->academic_semester = $selectedWorkload->academic_semester;
                $settings->cat = $request->cat;
                $settings->exam = $request->exam;
                $settings->assignment = $request->assignment;
                $settings->practical = $request->practical;
                $settings->save();

            }else{
                $setting = new ExamWeights;
                $setting->unit_code = $selectedUnit->unit_code;
                $setting->class_code = $class;
                $setting->academic_year = $selectedWorkload->academic_year;
                $setting->academic_semester = $selectedWorkload->academic_semester;
                $setting->cat = $request->cat;
                $setting->exam = $request->exam;
                $setting->assignment = $request->assignment;
                $setting->practical = $request->practical;
                $setting->save();
            }

            return view('lecturer::examination.exam')->with(['class' => $class, 'unit' => $unit, 'students' => $students, 'unit' => $unit, 'weights' => $weights, 'semester' => $semester]);
        }

        return view('lecturer::examination.exam')->with(['class' => $class, 'unit' => $unit, 'students' => $students, 'unit' => $unit, 'weights' => $weights, 'semester' => $semester]);

    }

    public function storeMarks(Request $request){

        $marks = $request->data;
        $semester = $request->unit;
        $workload = $request->workload;

        if (ExamMarks::where('class_code', $semester['class_code'])->where('unit_code', $semester['unit_code'])->exists()){

            foreach ($marks as $mark){
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
                if ($mark[5] == 0){ $exams->exam = 'ABSENT'; }else{ $exams->exam = round($mark[5],0); }
                $exams->total_cat = $mark[6];
                if ($mark[7] == 0){ $exams->total_exam = 'ABSENT'; }else{ $exams->total_exam = round($mark[7],0); }
                if ($mark[7] == 0){ $exams->total_mark = 'ABSENT'; }else{ $exams->total_mark = round($mark[8],0); }
                $exams->attempt = '$mark[10]';
                $exams->save();

            }

        }else{

            foreach ($marks as $mark){

                $exams = new ExamMarks;
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
                if ($mark[5] == 0){ $exams->exam = 'ABSENT'; }else{ $exams->exam = round($mark[5],0); }
                $exams->total_cat = $mark[6];
                if ($mark[7] == 0){ $exams->total_exam = 'ABSENT'; }else{ $exams->total_exam = round($mark[7],0); }
                if ($mark[7] == 0){ $exams->total_mark = 'ABSENT'; }else{ $exams->total_mark = round($mark[8],0); }
                $exams->attempt = '$mark[10]';
                $exams->save();

            }


        }


        return redirect()->back()->with('success', 'Student Marks Saved Successfully');

    }


    public function deleteTeachingArea($id){
        $hashedId = Crypt::decrypt($id);

        $teachingArea = TeachingArea::find($hashedId);
        $teachingArea->delete();

        return redirect()->back()->with('success', 'Deleted successfully');
    }



       public function myProfile(){

            $qualifications = LecturerQualification::where ('user_id', auth()->guard('user')->user()->id)->latest()->get();

             return view('lecturer::profile.myprofile')->with('qualifications',$qualifications);
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



