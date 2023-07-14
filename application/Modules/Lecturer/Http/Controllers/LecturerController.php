<?php

namespace Modules\Lecturer\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Modules\COD\Entities\SemesterUnit;
use Modules\COD\Entities\Unit;
use Modules\Examination\Entities\ExamMarks;
use Modules\Lecturer\Entities\ExamWeights;
use Modules\Lecturer\Entities\LecturerQualification;
use Modules\Lecturer\Entities\QualificationRemarks;
use Crypt;
use Modules\Lecturer\Entities\TeachingArea;
use Modules\Registrar\Entities\Courses;
use Modules\Registrar\Entities\StudentCourse;
use Modules\Registrar\Entities\UnitProgramms;
use Modules\Workload\Entities\Workload;
use \App\Models\StaffInfo;
use \App\Models\User;
use \App\Service\CustomIds;
use Hash;


class LecturerController extends Controller
{
//    public function __construct(){
//        auth()->setDefaultDriver('user');
//        $this->middleware(['web','auth']);
//    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(){
        return view('lecturer::index');
    }

    public function viewworkload(){

        $workloads = Workload::where('user_id', auth()->guard('user')->user()->user_id)
            ->where('status', 1)
            ->latest()
            ->get();

        return view('lecturer::workload.viewworkload')->with(['workloads' => $workloads]);

    }

    public function qualifications(){
        $qualification = LecturerQualification::where('user_id', auth()->guard('user')->user()->staffInfos->user_id)
            ->latest()
            ->get();
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
       $qualID = new CustomIds();
       $qualification = new LecturerQualification;
       $qualification->qualification_id = $qualID->generateId();
       $qualification->user_id = auth()->guard('user')->user()->staffInfos->user_id;
       $qualification->level = $request->level;
       $qualification->qualification = $request->qualification;
       $qualification->institution = $request ->institution;
       $qualification->save();
        return redirect()->route('lecturer.qualifications')->with('Success', '1 qualification added successfully');
    }

    public function editQualifications($id){
        $qualification = LecturerQualification::where('qualification_id', $id)->first();
        return view('lecturer::profile.editqualifications')->with(['qualification' => $qualification]);
    }

    public function updateQualifications(Request $request, $id){
        $request->validate([
            'level' => 'required',
            'qualification' =>'required',
            'institution' => 'required'
        ]);
        LecturerQualification::where('qualification_id', $id)->update([
            'level' => $request->level,
            'qualification' => $request->qualification,
            'institution' => $request ->institution,
            'status' => 0
        ]);
        return redirect()->route('lecturer.qualifications')->with('success', 'Updated successfully');
    }

    public function deleteQualification($id){
        LecturerQualification::where('qualification_id', $id)->delete();
        QualificationRemarks::where('qualification_id', $id)->delete();
        return redirect()->route('lecturer.qualifications')->with('success', 'Deleted successfully');
    }

    public function teachingAreas(){
        $myUnits = TeachingArea::where('user_id', auth()->guard('user')->user()->user_id)
            ->latest()
            ->get();
        return view('lecturer::profile.teachingArea')->with(['units' => $myUnits]);
    }

    public function addTeachingAreas(){
       $userQualifications = [];
       $qualifications = auth()->guard('user')->user()->lecturerQualification->where('status', 1);
        foreach($qualifications as $qualification){
            $userQualifications[] =$qualification->level;
        }
       $highestQualification = ($userQualifications == null) ? 0 : max($userQualifications);
       $units = Unit::where('department_id', auth()->guard('user')->user()->employmentDepartment->first()->department_id)
            ->latest()
            ->get();
        $myAreas = auth()->guard('user')->user()->LecturersArea->pluck('unit_code')->toArray();
        return view('lecturer::profile.addTeachingAreas')->with(['units' => $units, 'highest' => $highestQualification, 'myAreas' => $myAreas]);
    }

    public function storeTeachingAreas(Request $request){
        $request->validate([
           'units' => 'required'
        ]);
        foreach ($request->units as $id){
            $unitID = new CustomIds();
            $unit = Unit::where('unit_id', $id)->first();
            $teachingArea =  new TeachingArea;
            $teachingArea->teaching_area_id = $unitID->generateId();
            $teachingArea->user_id = auth()->guard('user')->user()->user_id;
            $teachingArea->unit_code = $unit->unit_code;
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

        $workloads = Workload::where('user_id', auth()->guard('user')->user()->id)->latest()->get();

        $setting = ExamWeights::latest()->get();


        return view('lecturer::examination.index')->with(['workloads' => $workloads, 'settings' => $setting]);

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
        $unit = SemesterUnit::findorFail($hashedUnit);

        $examMarks = ExamMarks::where('class_code', $class)->where('unit_code', $unit->unit_code)->get();
        $weights = ExamWeights::where('class_code', $class)->where('unit_code', $unit->unit_code)->first();


        if (count($examMarks) == 0) {

           $classList = StudentCourse::where('class_code', $class)->orderBy('student_id', 'asc')->get();

            foreach ($classList as $student) {

                $students [] = $student->student;
            }

            if ($request->filled('exam')) {

                $selectedUnit = SemesterUnit::find($hashedUnit);
                $selectedWorkload = Workload::findorFail($hashedId);

                $request->validate([

                    'exam' => 'required|numeric',
                    'cat' => 'required|numeric',
                    'assignment' => Rule::requiredIf($selectedUnit->assingment != null),
                    'practical' => Rule::requiredIf($selectedUnit->practical != null)
                ]);

                if (ExamWeights::where('academic_year', $selectedWorkload->academic_year)->where('academic_semester', $selectedWorkload->academic_semester)->where('unit_code', $selectedUnit->unit_code)->exists()) {
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

                } else {
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
            }

            return view('lecturer::examination.exam')->with(['class' => $class, 'unit' => $unit, 'students' => $students, 'unit' => $unit, 'weights' => $weights, 'semester' => $semester]);


        }else{

            if ($request->filled('exam')) {

                $selectedUnit = SemesterUnit::find($hashedUnit);
                $selectedWorkload = Workload::findorFail($hashedId);

                $request->validate([

                    'exam' => 'required|numeric',
                    'cat' => 'required|numeric',
                    'assignment' => Rule::requiredIf($selectedUnit->assingment != null),
                    'practical' => Rule::requiredIf($selectedUnit->practical != null)
                ]);

                if (ExamWeights::where('academic_year', $selectedWorkload->academic_year)->where('academic_semester', $selectedWorkload->academic_semester)->where('unit_code', $selectedUnit->unit_code)->exists()) {
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

                } else {
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
            }

            $students = new Collection;

            $classList = StudentCourse::where('class_code', $class)->orderBy('student_id', 'asc')->get();

            foreach ($classList as $student) {

               $mark = ExamMarks::where('class_code', $class)->where('unit_code', $unit->unit_code)->where('reg_number', $student->student->reg_number)->first();

               $studentList = $student->student;

               $students[] = collect($mark)->merge($studentList);

            }

//            return $students->sname;

            return view('lecturer::examination.editExam')->with(['class' => $class, 'unit' => $unit, 'students' => $students, 'unit' => $unit, 'weights' => $weights, 'semester' => $semester, 'marks' => $examMarks]);
        }

    }

    public function storeMarks(Request $request){

        $marks = $request->data;
        $semester = $request->unit;
        $workload = $request->workload;

            foreach ($marks as $mark){

                if (ExamMarks::where('class_code', $semester['class_code'])->where('unit_code', $semester['unit_code'])->where('reg_number', $mark[0])->exists()){

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

                }else{

                    $exams = new ExamMarks;
                    $exams->class_code = $semester['class_code'];
                    $exams->unit_code = $semester['unit_code'];
                    $exams->reg_number = $mark[0];
                    $exams->academic_year = $workload['academic_year'];
                    $exams->academic_semester = $workload['academic_semester'];
                    $exams->stage = $semester['stage'];
                    $exams->semester = $semester['semester'];
                    if ($mark[2] == null){ $exams->cat = 0; }else{ $exams->cat = $mark[2]; }
                    $exams->assignment = $mark[3];
                    $exams->practical = $mark[4];
                    if ($mark[5] == null){ $exams->exam = 'ABSENT'; }else{ $exams->exam = round($mark[5],0); }
                    if ($mark[6] == 0){ $exams->total_cat = 0; }else{ $exams->total_cat = $mark[6]; }
                    if ($mark[5] == null){ $exams->total_exam = 'ABSENT'; }else{ $exams->total_exam = round($mark[7],0); }
                    if ($mark[5] == null){ $exams->total_mark = 'ABSENT'; }else{ $exams->total_mark = round($mark[8],0); }
                    $exams->attempt = '$mark[10]';
                    $exams->save();

                }

            }


        return redirect()->route('lecturer.examination')->with('success', 'Student Marks Saved Successfully');

    }

    public function updateMarks(Request $request){
        $marks = $request->data;
        $semester = $request->unit;
        $workload = $request->workload;

            foreach ($marks as $mark){
//                return $mark[5];
            }

        return redirect()->back()->with('success', 'Student Marks Updated Successfully');
    }


    public function deleteTeachingArea($id){
        $hashedId = Crypt::decrypt($id);

        $teachingArea = TeachingArea::find($hashedId);
        $teachingArea->delete();

        return redirect()->back()->with('success', 'Deleted successfully');
    }


       public function myProfile(){

            $qualifications = LecturerQualification::where ('user_id', auth()->guard('user')->user()->staffInfos->id)->where('status' ,1)->latest()->get();

            return view('lecturer::profile.myprofile')->with('qualifications',$qualifications);

       }
       public function editMyprofile(){


        return  view('lecturer::profile.editMyprofile');

    }

    public function updateMyprofile(Request $request, $id){


        $request->validate([
            'title' => 'required',
            'lname' => 'required',
            'fname' =>'required',
            'username' => 'required',
            'profile_image'=>'image|nullable|max:1999'
        ]);

        $users = StaffInfo::where('user_id', $id)->first();
        $users->title = $request->title;
        $users->last_name = $request->lname;
        $users->first_name = $request ->fname;
        $users->middle_name = $request->mname;
        $users->phone_number = $request->phone_number;
        if ($request->hasFile('profile_image')){
            $filenameWithExt = $request->file('profile_image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('profile_image')->getClientOriginalExtension();
            $fileNameToStore = time().'.'.$extension;
            $path = $request->profile_image->move('media/profile/', $fileNameToStore);
            $users->profile_image = $fileNameToStore;
        }
        $users->office_email = $request ->office_email;
        $users->personal_email = $request->personal_email;
        $users->gender = $request ->gender;
        $users->save();

      return redirect()->route('lecturer.myProfile')->with('success', 'Updated successfully');

    }

     public function changePassword(Request $request, $id){

        $request ->validate([
            'password' => 'required|confirmed',

        ]);
        $users = User::find($id);
        $users->password = Hash::make($request->password);
        $users->save();
        return redirect()->route('lecturer.myProfile')->with('success', 'Password Updated successfully');
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



