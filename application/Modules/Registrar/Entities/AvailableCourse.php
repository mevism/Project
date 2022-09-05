<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class AvailableCourse extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function newintake(){

        return $this->belongsTo(AvailableCourse::class, 'id');
    }

//        availablecourse vs intake

    public function openCourse(){

        return $this->belongsTo(Intake::class, 'intake_id');
    }

    // available course and department
    public function courseDept(){

        return $this->belongsTo(Department::class);

    }
    
//    available course vs courses

    public function mainCourses(){

        return $this->belongsTo(Courses::class, 'course_id');

    }
    protected static function newFactory()
    {
        return \Modules\Courses\Database\factories\AvailableCourseFactory::new();
    }

}
