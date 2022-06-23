<?php

namespace Modules\Courses\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AvailableCourse extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Courses\Database\factories\AvailableCourseFactory::new();
    }

//    public function intake(){
//
//        return $this->belongsTo(\Modules\Courses\Entities\Intake::class, 'id');
//    }
}
