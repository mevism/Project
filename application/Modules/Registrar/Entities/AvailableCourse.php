<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Application\Entities\Application;


class AvailableCourse extends Model
{
    use HasFactory;

    protected $fillable = [];

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

    public function mainXCourse(){

        return $this->belongsTo(Courses::class, 'id');
    }

    public function courseXCampus(){

        return $this->belongsTo(Campus::class, 'campus_id');
    }

    public function applicationXAvailableCourses(){

        return $this->hasMany(Application::class, 'course_id');
    }

    protected static function newFactory()
    {
        return \Modules\Courses\Database\factories\AvailableCourseFactory::new();
    }

}
