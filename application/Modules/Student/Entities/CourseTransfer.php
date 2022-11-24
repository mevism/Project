<?php

namespace Modules\Student\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Registrar\Entities\Classes;
use Modules\Registrar\Entities\Courses;
use Modules\Registrar\Entities\Department;

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

    protected static function newFactory()
    {
        return \Modules\Student\Database\factories\CourseTransferFactory::new();
    }
}
