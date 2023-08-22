<?php

namespace Modules\Student\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Application\Entities\ApplicantInfo;
use Modules\Application\Entities\Application;
use Modules\Registrar\Entities\Courses;
use Modules\Registrar\Entities\Department;
use Modules\Registrar\Entities\Intake;

class StudentCourse extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = ['student_id', 'application_id', 'student_number', 'course_id', 'campus_id', 'student_type', 'intake_id', 'current_class', 'entry_class', 'status'];

    public function StudentsCourse(){
        return $this->belongsTo(Courses::class, 'course_id', 'course_id');
    }

    public function StudentIntake(){
        return $this->belongsTo(Intake::class, 'intake_id', 'intake_id');
    }

    public function StudentsDepartment(){
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    public function StudentApplication(){
        return $this->belongsTo(Application::class, 'application_id', 'application_id');
    }
    protected static function newFactory()
    {
        return \Modules\Student\Database\factories\StudentCourseFactory::new();
    }
}
