<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnitProgramms extends Model
{
    use HasFactory;

    protected $fillable = ['course_code','unit_name','course_unit_code','stage','semester','type'];

    public function courseLevel(){

        return $this->belongsTo(Courses::class, 'course_code', 'course_code');
    }


    protected static function newFactory()
    {
        return \Modules\Registrar\Database\factories\UnitProgrammsFactory::new();
    }
}
