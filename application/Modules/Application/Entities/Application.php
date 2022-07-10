<?php

namespace Modules\Application\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Courses\Entities\Courses;
use Modules\COD\Entities\CODLog;
use Modules\Courses\Entities\Intake;
use Modules\Dean\Entities\DeanLog;
use Modules\Finance\Entities\FinanceLog;

class Application extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [];

//    relationship between an applicant and a course

    public function applicant(){

       return $this->belongsTo(Applicant::class, 'user_id');
    }

//    relationship between an application and course

    public function courses(){

        return $this->belongsTo(Courses::class, 'course_id');

    }

//    application/intake relationship

        public function app_intake(){

            return $this->belongsTo(Intake::class, 'intake_id');

        }

//        application and logs relationship

//        public function Clogs(){
//            return $this->hasMany(CODLog::class, 'app_id');
//        }
//
//        public function Flogs(){
//            return $this->hasMany(FinanceLog::class, 'app_id');
//        }
//
//        public function Dlogs(){
//            return $this->hasMany(DeanLog::class, 'app_id');
//        }

    protected static function newFactory()
    {
        return \database\factories\ApplicationFactory::new();
    }
}
