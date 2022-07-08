<?php

namespace Modules\Courses\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Courses\Entities\Courses;

class Intake extends Model
{
    use HasFactory;

    protected $fillable = [
        'intake_from', 'intake_to', 'status'
    ];


    public function openIntake(){

        return $this->hasMany(AvailableCourse::class, 'id');
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
//        return $this->hasMany(\Modules\Courses\Entities\AvailableCourse::class, 'intake_id');
//    }
//    public function available()
//    {
//        return $this->hasMany('\Modules\Courses\Entities\AvailableCourse', 'intake_id');
//    }
//
//    public function courses(){
//        $this->hasOne(Courses::class, 'id');
//    }

}
