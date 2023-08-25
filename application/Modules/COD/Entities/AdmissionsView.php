<?php

namespace Modules\COD\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Registrar\Entities\Courses;
use Modules\Registrar\Entities\Intake;

class AdmissionsView extends Model
{
    use HasFactory;

    protected $table = 'admissionsview';

    protected $fillable = [];

    public function admissionCourse(){
        return $this->belongsTo(Courses::class, 'course_id', 'course_id');
    }

    public function admissionIntake(){
        return $this->belongsTo(Intake::class, 'intake_id', 'intake_id');
    }

    protected static function newFactory()
    {
        return \Modules\COD\Database\factories\AdmissionsViewFactory::new();
    }
}
