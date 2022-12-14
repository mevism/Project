<?php

namespace Modules\Student\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Registrar\Entities\Classes;
use Modules\Registrar\Entities\Courses;
use Modules\Registrar\Entities\Department;
use Modules\Registrar\Entities\Student;

class CourseTransfer extends Model
{
    use HasFactory, softDeletes;

    protected $dates = ['delete_at'];

    protected $fillable = ['status'];

    public function courseTransfer(){
        return $this->belongsTo(Courses::class, 'course_id');
    }

    public function deptTransfer(){
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function classTransfer(){
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function studentTransfer(){
        return $this->belongsTo(Student::class, 'student_id')->withTrashed();
    }
    public function approveTransfer(){

        return $this->hasOne(CourseTransferApproval::class, 'id');
        
    }

    public function approvedTransfer(){

        return $this->hasOne(CourseTransferApproval::class, 'course_transfer_id');
    }

    protected static function newFactory()
    {
        return \Modules\Student\Database\factories\CourseTransferFactory::new();
    }
}
