<?php

namespace Modules\Student\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Registrar\Entities\Courses;

class OldStudentCourse extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function OldCourse(){
        return $this->belongsTo(Courses::class, 'course_id', 'course_id');
    }

    protected static function newFactory()
    {
        return \Modules\Student\Database\factories\OldStudentCourseFactory::new();
    }
}
