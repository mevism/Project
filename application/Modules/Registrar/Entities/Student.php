<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\COD\Entities\Nominalroll;
use Modules\Examination\Entities\Exam;
use Modules\Student\Entities\AcademicLeave;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function courseStudent(){

        return $this->hasOne(StudentCourse::class);
    }

    public function signNominal(){

        return $this->hasMany(Nominalroll::class);

    }
    public function exams(){
        return $this->hasMany(Exam::class);
    }

    public function nominalRoll(){

        return $this->hasOne(Nominalroll::class);

    }

    public function loginStudent(){

        return $this->hasOne(StudentLogin::class, 'student_id');

    }

    public function leaveStudent(){

        return $this->hasMany(AcademicLeave::class, 'id');
    }


    protected static function newFactory()
    {
        return \Modules\Registrar\Database\factories\StudentFactory::new();
    }
}
