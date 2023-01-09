<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function semestermodeofstudy(){
        return $this->hasMany(SemesterFee::class, 'id');
    }

    public function studentType(){
        return $this->hasMany(StudentCourse::class, 'id');
    }

    protected static function newFactory()
    {
        return \Modules\Registrar\Database\factories\AttendanceFactory::new();
    }
}
