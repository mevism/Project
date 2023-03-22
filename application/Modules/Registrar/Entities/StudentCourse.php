<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Application\Entities\Application;
use Modules\COD\Entities\Nominalroll;

class StudentCourse extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [];

    public function student(){

        return $this->belongsTo(Student::class)->withTrashed();
    }

    public function studentCourse(){

        return $this->belongsTo(Courses::class, 'course_id')->withTrashed();
    }

    public function deptStudCourse(){

        return $this->belongsTo(Department::class, 'department_id');
    }

    public function courseEntry(){

        return $this->belongsTo(AcademicYear::class, 'academic_year_id');

    }

    public function coursesIntake(){
        return $this->belongsTo(Intake::class, 'intake_id');
    }

    public function typeStudent(){
        return $this->belongsTo(Attendance::class, 'student_type');
    }

    protected static function newFactory()
    {
        return \Modules\Registrar\Database\factories\StudentCourseFactory::new();
    }
}
