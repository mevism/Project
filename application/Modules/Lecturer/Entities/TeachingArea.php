<?php

namespace Modules\Lecturer\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Registrar\Entities\UnitProgramms;

class TeachingArea extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function teachingArea(){

        return $this->belongsTo(UnitProgramms::class, 'unit_code', 'course_unit_code');
    }

    public function userAreas(){

        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    protected static function newFactory()
    {
        return \Modules\Lecturer\Database\factories\TeachingAreaFactory::new();
    }
}
