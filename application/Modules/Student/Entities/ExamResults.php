<?php

namespace Modules\Student\Entities;

use Modules\Registrar\Entities\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamResults extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function studentResults(){
        return $this->belongsTo(Student::class, 'student_id');
    }

    protected static function newFactory()
    {
        return \Modules\Student\Database\factories\ExamResultsFactory::new();
    }
}
