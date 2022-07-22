<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Courses extends Model
{
    use HasFactory;

//    protected $fillable = ['campus_id'];
//    protected $guared = [];
//
//    protected $table = 'courses';
    protected $fillable = ['campus_id'];
    protected $guared = [];

    protected $table = 'courses';


    public function newCourses(){

        return $this->belongsToMany(Intake::class, 'available_courses', 'course_id', 'intake_id');

    }

//    available courses vs courses

    public function onOffer(){

        return $this->hasMany(AvailableCourse::class, 'id');

    }
    public function availablecourse(){

        return $this->hasOne(AvailableCourse::class, 'id');
    }

//    relationship between a course and an application

    public function apps(){

        return $this->hasMany(Application::class, 'id');

    }

    protected static function newFactory()
    {
        return \Modules\Courses\Database\factories\CoursesFactory::new();
    }

//    public function intakes(){
//        $this->belongsTo(Intake::class, 'id');
//    }
}
