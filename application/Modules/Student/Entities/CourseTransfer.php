<?php

namespace Modules\Student\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Registrar\Entities\Classes;
use Modules\Registrar\Entities\Courses;
use Modules\Registrar\Entities\Department;
use Modules\Student\Entities\StudentLogin;
class CourseTransfer extends Model
{
    use HasFactory;

    protected $fillable = ['status'];

    public function courseTransfer(){
        return $this->belongsTo(Courses::class, 'course_id', 'course_id');
    }

    public function deptTransfer(){
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    public function classTransfer(){
        return $this->belongsTo(Classes::class, 'class_id', 'class_id');
    }

    public function studentTransfer(){
        return $this->belongsTo(StudentLogin::class, 'student_id', 'student_id');
    }
    public function approveTransfer(){

        return $this->hasOne(CourseTransferApproval::class, 'id');

    }

    public function approvedTransfer(){
        return $this->hasOne(CourseTransferApproval::class, 'course_transfer_id', 'course_transfer_id');
    }

    protected static function newFactory()
    {
        return \Modules\Student\Database\factories\CourseTransferFactory::new();
    }
}
