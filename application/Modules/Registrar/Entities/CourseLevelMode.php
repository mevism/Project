<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseLevelMode extends Model
{
    use HasFactory;

    public function modeofstudy(){
        return $this->belongsTo(Attendance::class, 'attendance_id');
    }
    public function levelclm(){
        return $this->belongsTo(Level::class, 'level_id');
    }
    public function courseclm(){
        return $this->belongsTo(Courses::class, 'course_id', 'course_id');
    }

    public function invoiceProforma(){

        return $this->hasMany(SemesterFee::class, 'course_level_mode_id', 'course_level_mode_id');
    }

    protected $fillable = ['course_id','level_id','attendance_id'];

    protected static function newFactory()
    {
        return \Modules\Registrar\Database\factories\CourseLevelModeFactory::new();
    }
}
