<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Registrar\Entities\Courses;

class Intake extends Model
{
    use HasFactory;

    protected $dates = [ 'intake_from'];

    protected $fillable = [
        'intake_from', 'intake_to', 'status'
    ];

    public function openIntake(){

        return $this->hasMany(AvailableCourse::class, 'id');
    }

    public function kuccpsApp(){

        return $this->hasOne(KuccpsApplication::class, 'id');
    }

    //rlship between an intake and academic year
    public function academicYear(){

        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }

    public function IntakeEvents(){
        return $this->hasMany(CalenderOfEvents::class, 'id');
    }

    protected static function newFactory()
    {
        return \Modules\Courses\Database\factories\IntakeFactory::new();
    }

    public function newcourse(){

        return $this->hasMany(AvailableCourse::class, 'intake_id');
    }

}
