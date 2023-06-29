<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\COD\Entities\CourseCluster;
use Modules\COD\Entities\CourseOptions;
use Modules\Student\Entities\CourseTransfer;

class Courses extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = ['department_id', 'course_code', 'course_name','level'];
    protected $guared = [];

    protected $table = 'courses';

    protected $dates = ['deleted_at'];


    public function newCourses(){

        return $this->belongsToMany(Intake::class, 'available_courses', 'course_id', 'intake_id');

    }

//    available courses vs courses

    public function onOffer(){
        return $this->hasMany(AvailableCourse::class, 'id');
    }

    public function courseXAvailable(){
        return $this->hasOne(AvailableCourse::class, 'course_id');
    }

//    relationship between a course and an application

    public function apps(){
        return $this->hasMany(Application::class, 'id');
    }

    public function courseRequirements(){

        return $this->hasOne(CourseRequirement::class, 'course_id', 'course_id');
    }

    public function getCourseDept(){

        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    public function useDept(){
        return $this->belongsTo(Department::class);
    }

    public function studentCrs(){
        return $this->hasOne(StudentCourse::class, 'id');
    }


    public function transferCourse(){
        return $this->hasMany(CourseTransfer::class, 'id');
    }

    public function courseCluster(){
        return $this->hasOne(CourseCluster::class, 'course_id', 'course_id');
    }

    protected static function newFactory()
    {
        return \Modules\Courses\Database\factories\CoursesFactory::new();
    }

    public function Classes(){
        return $this->hasOne(Classes::class, 'id');
    }

    public function courselevelmode(){
        return $this->hasOne(CourseLevelMode::class, 'id');
    }

    //relationship between a course and a fee structure
    public function fee(){

        return $this->hasOne(FeeStructure::class);
    }


    public function courseRequirement(){
        return $this->hasOne(CourseRequirement::class, 'course_id', 'course_id');
    }

    public function CourseOptions(){
        return $this->hasMany(CourseOptions::class, 'course_id', 'course_id');
    }

    public function CourseClusters(){
        return $this->hasOne(CourseCluster::class, 'course_id', 'course_id');
    }
}
