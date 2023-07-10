<?php

namespace Modules\Student\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\COD\Entities\ReadmissionClass;
use Modules\Registrar\Entities\Student;

class Readmission extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function readmissionApproval(){

        return $this->hasOne(ReadmissionApproval::class, 'readmission_id');
    }

    public function leaves(){

        return $this->belongsTo(AcademicLeave::class, 'leave_id', 'leave_id');
    }

    public function studentReadmission(){

        return $this->belongsTo(Student::class, 'student_id');
    }

    public function readmissionsReadmitClass(){
        return $this->hasOne(ReadmissionClass::class, 'readmission_id');
    }

    protected static function newFactory()
    {
        return \Modules\Student\Database\factories\ReadmissionFactory::new();
    }


}
