<?php

namespace Modules\COD\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Registrar\Entities\Campus;
use Modules\Registrar\Entities\Courses;
use Modules\Registrar\Entities\Intake;

class ApplicationsView extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected $table = 'APPLICATIONSVIEW';

    public function DepartmentCourse(){

        return $this->belongsTo(Courses::class, 'course_id', 'course_id');
    }

    public function ApplicationIntake(){
        return $this->belongsTo(Intake::class, 'intake_id', 'intake_id');
    }

    public function ApplcationCampus(){
        return $this->belongsTo(Campus::class, 'campus_id', 'campus_id');
    }

    protected static function newFactory()
    {
        return \Modules\COD\Database\factories\AllApplicationFactory::new();
    }
}
