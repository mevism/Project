<?php

namespace Modules\Examination\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\COD\Entities\Unit;
use Modules\Student\Entities\StudentCourse;
use Modules\Student\Entities\StudentInfo;

class ModeratedResults extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function studentModeratedResults(){
        return $this->hasOneThrough(StudentInfo::class, StudentCourse::class, 'student_number', 'student_id', 'student_number', 'student_id');
    }

    public function ModeratedUnits(){
        return $this->belongsTo(Unit::class, 'unit_code', 'unit_code');
    }

    protected static function newFactory()
    {
        return \Modules\Examination\Database\factories\ModeratedResultsFactory::new();
    }
}
