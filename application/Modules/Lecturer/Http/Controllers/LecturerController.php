<?php

namespace Modules\Lecturer\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Modules\COD\Entities\CourseSyllabus;
use Modules\COD\Entities\SemesterUnit;
use Modules\COD\Entities\Unit;
use Modules\Examination\Entities\ExamMarks;
use Modules\Lecturer\Entities\ExamWeights;
use Modules\Lecturer\Entities\LecturerQualification;
use Modules\Lecturer\Entities\QualificationRemarks;
use Crypt;
use Modules\Lecturer\Entities\TeachingArea;
use Modules\Registrar\Entities\Courses;
use Modules\Registrar\Entities\UnitProgramms;
use Modules\Student\Entities\StudentCourse;
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

    public function examination(){
        $workloads = Workload::where('user_id', auth()->guard('user')->user()->user_id)
            ->where('status',1)
            ->latest()
            ->get()
            ->groupBy(['academic_year', 'academic_semester']);
        $setting = ExamWeights::latest()->get();

        return view('lecturer::examination.index')->with(['workloads' => $workloads, 'settings' => $setting]);

    }

    public function semesterWorkload($year, $semester){

        $hashedYear = Crypt::decrypt($year);
        $hashedSemester = Crypt::decrypt($semester);

        $workloads = Workload::where('academic_year', $hashedYear)->where('academic_semester', $hashedSemester)->where('user_id', auth()->guard('user')->user()->id)->latest()->get();

        return view('lecturer::workload.semesterWorkload')->with(['workloads' => $workloads, 'year' => $hashedYear, 'semester' => $hashedSemester]);

    }




    public function yearlyExams($id){

        $hashedId = Crypt::decrypt($id);

        $workloads = Workload::where('academic_year', $hashedId)->latest()->get()->groupBy('academic_semester');

        return view('lecturer::examination.yearlyExams')->with(['workloads' => $workloads, 'year' => $hashedId]);
    }

    public function semesterExamination(Request $request){
       $classes = Workload::where('user_id', auth()->guard('user')->user()->user_id)
                            ->where('academic_year', $request->year)
                            ->where('academic_semester', $request->semester)
                            ->where('status', 1)
                            ->orderBy('class_code', 'asc')
                            ->get();
        $setting = ExamWeights::where('academic_year', $request->year)->where('academic_semester', $request->semester)->latest()->get();
        return view('lecturer::examination.semesterExams')->with(['classes' => $classes, 'year' => $request->year, 'semester' => $request->semester, 'settings' => $setting]);
    }

    public function getClassStudents(Request $request){
        $examStatus = ExamMarks::where('class_code', $request->class)->where('unit_code', $request->unit)->whereIn('status', [null, 0])->get();
        if (count($examStatus) > 0){
            if ($request->filled('exam')) {
                $selectedUnit = Unit::where('unit_code', $request->unit)->first();
                $request->validate([

                    'exam' => 'required|numeric',
                    'cat' => 'required|numeric',
                    'assignment' => Rule::requiredIf($selectedUnit->assingment != 0),
                    'practical' => Rule::requiredIf($selectedUnit->practical != 0)
                ]);
                if ($request->assignment == null || $request->practical == null){
                    $request->assignment = 0;
                    $request->practical = 0;
                }
                if (ExamWeights::where('academic_year', $request->year)->where('academic_semester', $request->semester)->where('unit_code', $request->unit)->exists()) {
                    ExamWeights::where('academic_year', $request->year)->where('academic_semester', $request->semester)->where('unit_code', $request->unit)->update([
                        'unit_code' => $request->unit,
                        'class_code' => $request->class,
                        'academic_year' =>  $request->year,
                        'academic_semester' =>  $request->semester,
                        'cat' => $request->cat,
                        'exam' => $request->exam,
                        'assignment' => $request->assignment,
                        'practical' => $request->practical
                    ]);
                } else {
                    $setting = new ExamWeights;
                    $setting->unit_code = $request->unit;
                    $setting->class_code = $request->class;
                    $setting->academic_year = $request->year;
                    $setting->academic_semester = $request->semester;
                    $setting->cat = $request->cat;
                    $setting->exam = $request->exam;
                    if ($request->assignment == null)
                        $setting->assignment = $request->assignment;
                    $setting->practical = $request->practical;
                    $setting->save();
                }
            }
        }
        $classview = DB::table('classesview')->where('name', $request->class)->first()->course_code;
        $unit = Unit::where('unit_code', $request->unit)->first();
        $examMarks = ExamMarks::where('class_code', $request->class)->where('unit_code', $request->unit)->get();
        $weights = ExamWeights::where('class_code', $request->class)->where('unit_code', $request->unit)->first();
        $syllabus = CourseSyllabus::where('course_code', $classview)->where('unit_code', $request->unit)->first();
        $students = new Collection;
        $classList = StudentCourse::where('current_class', $request->class)
            ->orderBy('student_number', 'asc')
            ->get();

        foreach ($classList as $student) {
            $mark = ExamMarks::where('class_code', $request->class)
                ->where('unit_code', $request->unit)
                ->where('student_number', $student->student_number)
                ->first();

            if ($mark) {
                $studentList = $student->StudentCourseInfo;
                $mergedData = collect($mark)->merge($studentList)->put('student_number', $student->student_number)->put('attempt', $syllabus->stage.'.'.$syllabus->semester);
                $students->push($mergedData);
            }
        }
        return view('lecturer::examination.exam')->with(['class' => $request->class, 'unit' => $unit, 'weights' => $weights, 'semester' => $request->semester, 'students' => $students, 'marks' => $examMarks]);
    }

    public function storeMarks(Request $request){
        $marks = $request->data;
        $semester = $request->unit;
        $workload = $request->workload;

            foreach ($marks as $mark){
                ExamMarks::where('student_number', $mark[0])->where('unit_code', $semester['unit_code'])->update([
                    'cat' => $mark[2] ?? 0,
                    'assignment' => $mark[3] ?? 0,
                    'practical' => $mark[4] ?? 0,
                    'exam' => $mark[5] === null ? 'ABSENT' : round(intval($mark[5]), 0),
                    'total_cat' => $mark[6],
                    'total_exam' => $mark[5] === null || $mark[5] === 'NaN' || $mark[7] === 'NaN' || $mark[7] === 'ABSENT' ? 'ABSENT' : round($mark[7], 0),
                    'total_mark' => $mark[5] === null || $mark[5] === 'NaN' || $mark[7] === 'NaN' || $mark[7] === 'ABSENT' ? 'ABSENT' : round($mark[8], 0),
                    ]);
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



