<?php

namespace Modules\Registrar\Entities;

use App\Models\User;
use App\Models\UserEmployment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Examination\Entities\ExamMarks;
use Modules\Student\Entities\CourseTransfer;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function getUser(){
        return $this->hasMany(User::class, 'id');
    }

    public function deptUser(){
        return $this->hasMany(UserEmployment::class, 'id');
    }

    public function division(){

        return $this->belongsTo(Division::class);
    }

    public function schools(){

        return $this->belongsToMany(School::class, 'school_departments', 'department_id', 'school_id');
    }
   
    public function course(){

        return $this->hasMany(Courses::class,'id');
    }

    public function historycourse(){

        return $this->hasMany(Courses::class,'id');
    }

    public function getDeptCourse(){

        return $this->hasMany(Courses::class, 'id');
    }

    public function Sch(){

        return $this->belongsTo(School::class, 'school_id');
    }

    public function useCourse(){
        return $this->hasMany(Courses::class);
    }

    public function exams(){
        return $this->hasMany(ExamMarks::class);
    }

    public function transferDept(){
        return $this->hasMany(CourseTransfer::class, 'id');
    }

    public function studCourseDept(){
        return $this->hasMany(StudentCourse::class, 'id');
    }
    protected static function newFactory()
    {
        return \Modules\Courses\Database\factories\DepartmentFactory::new();
    }
}
