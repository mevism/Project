<?php

namespace Modules\Examination\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Registrar\Entities\Student;
use Modules\Registrar\Entities\UnitProgramms;

class ExamMarks extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function unit(){

        return $this->belongsTo(UnitProgramms::class, 'unit_code', 'course_unit_code');
    }

    public function studentMark(){

        return $this->belongsTo(Student::class, 'reg_number', 'reg_number');
    }

    protected static function newFactory()
    {
        return \Modules\Examination\Database\factories\ExamMarksFactory::new();
    }
}
