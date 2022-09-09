<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Registrar\Entities\Courses;

class Intake extends Model
{
    use HasFactory;

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

    protected static function newFactory()
    {
        return \Modules\Courses\Database\factories\IntakeFactory::new();
    }

    public function newcourse(){

        return $this->hasMany(AvailableCourse::class, 'intake_id');
    }

//        public function newapps(){
//
//            return $this->hasMany(Application::class, 'id');
//
//        }

//    public function available()
//    {
//        return $this->hasMany(\Modules\Registrar\Entities\AvailableCourse::class, 'intake_id');
//    }
//    public function available()
//    {
//        return $this->hasMany('\Modules\Registrar\Entities\AvailableCourse', 'intake_id');
//    }
//
//    public function courses(){
//        $this->hasOne(Registrar::class, 'id');
//    }

}
