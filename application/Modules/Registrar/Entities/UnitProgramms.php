<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Lecturer\Entities\TeachingArea;

class UnitProgramms extends Model
{
    use HasFactory;

    protected $fillable = ['course_code','unit_name','course_unit_code','stage','semester','type'];

    public function courseLevel(){

        return $this->belongsTo(Courses::class, 'course_code', 'course_code');
    }

    public function lecturerAreas(){

        return $this->hasOne(TeachingArea::class, 'unit_code', 'course_unit_code');
    }

    protected static function newFactory()
    {
        return \Modules\Registrar\Database\factories\UnitProgrammsFactory::new();
    }
}
