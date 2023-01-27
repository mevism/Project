<?php

namespace Modules\Student\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Registrar\Entities\Student;

class AcademicLeave extends Model
{
    use HasFactory;

    protected $fillable = ['status'];

    public function studentLeave(){

        return $this->belongsTo(Student::class, 'student_id')->withTrashed();
    }

    public function approveLeave(){

        return $this->hasOne(AcademicLeaveApproval::class, 'academic_leave_id');
    }

    public function deferredClass(){
        return $this->hasOne(DeferredClass::class, 'id');
    }

    public function readmissions(){

        return $this->hasMany(Readmission::class, 'leave_id');
    }

    protected static function newFactory()
    {
        return \Modules\Student\Database\factories\AcademicLeaveFactory::new();
    }
}
