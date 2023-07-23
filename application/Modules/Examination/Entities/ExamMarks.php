<?php

namespace Modules\Examination\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\COD\Entities\CourseSyllabus;
use Modules\COD\Entities\Unit;
use Modules\Registrar\Entities\Student;
use Modules\Registrar\Entities\Department;
use Modules\Registrar\Entities\UnitProgramms;
use Modules\Examination\Entities\ExamWorkflow;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Student\Entities\StudentCourse;

class ExamMarks extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function unit(){

        return $this->belongsTo(Unit::class, 'unit_code', 'unit_code');
    }

    public function UnitSyllabus(){
        return $this->belongsTo(CourseSyllabus::class, 'unit_code', 'unit_code');
    }

    public function studentMark(){

        return $this->belongsTo(StudentCourse::class, 'student_number', 'student_number');
    }

     public function ExamMarksApproval(){
        return $this->belongsTo(ExamWorkflow::class, 'exam_approval_id', 'exam_approval_id');
    }


    public function examDept(){

        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    protected static function newFactory()
    {
        return \Modules\Examination\Database\factories\ExamMarksFactory::new();
    }
}
