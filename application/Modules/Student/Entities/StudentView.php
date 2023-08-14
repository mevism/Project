<?php

namespace Modules\Student\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\COD\Entities\Nominalroll;
use Modules\Registrar\Entities\Courses;

class StudentView extends Model
{
    use HasFactory;

    protected $table = 'studentview';

    protected $fillable = [];

    public function studentRegistration(){
        return $this->hasMany(Nominalroll::class, 'student_id', 'student_id');
    }

    public function EnrolledStudentCourse(){
        return $this->belongsTo(Courses::class, 'course_id', 'course_id');
    }

    protected static function newFactory()
    {
        return \Modules\Student\Database\factories\StudentViewFactory::new();
    }
}
