<?php

namespace Modules\Application\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Registrar\Entities\AvailableCourse;
use Modules\Registrar\Entities\Courses;
use Modules\COD\Entities\CODLog;
use Modules\Registrar\Entities\Intake;
use Modules\Dean\Entities\DeanLog;
use Modules\Finance\Entities\FinanceLog;
use Modules\Registrar\Entities\Student;

class Application extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['application_id', 'applicant_id', 'ref_number', 'intake_id', 'student_type', 'campus_id', 'school_id', 'department_id', 'course_id', 'declaration', 'status'];

//    relationship between an applicant and a course

    public function applicant(){

       return $this->belongsTo(Applicant::class);

    }

    public function applicationSubject(){
        return $this->hasOne(ApplicationSubject::class, 'application_id', 'application_id');
    }
    public function applicationApproval(){
        return $this->hasOne(ApplicationApproval::class, 'application_id', 'application_id');
    }

//    relationship between an application and course

    public function courses(){

        return $this->belongsTo(Courses::class, 'course_id', 'course_id');

    }

//    application/intake relationship

        public function app_intake(){

            return $this->belongsTo(Intake::class, 'intake_id');

        }

//        application-admission relationship

    public function approveAdm(){

        return $this->hasOne(AdmissionApproval::class);
    }

    public function admissionDoc(){
        return $this->hasOne(AdmissionDocument::class, 'application_id', 'application_id');
    }

    public function myNotification(){

        return $this->hasMany(Notification::class);
    }

    public function availableCourseXApplication(){

        return $this->belongsTo(AvailableCourse::class, 'course_id');
    }

    protected static function newFactory()
    {
        return \database\factories\ApplicationFactory::new();
    }
}
