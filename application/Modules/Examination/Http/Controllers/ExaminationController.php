<?php

namespace Modules\Examination\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Crypt;
use Modules\Examination\Entities\Exam;
use Modules\Examination\Entities\ExamMarks;
use Modules\Registrar\Entities\Student;
use Modules\Student\Entities\ExamResults;

class ExaminationController extends Controller
{
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
