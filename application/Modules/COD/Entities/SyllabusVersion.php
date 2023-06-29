<?php

namespace Modules\COD\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Registrar\Entities\Courses;

class SyllabusVersion extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function CourseSyllabusVersion(){
        return $this->belongsTo(Courses::class, 'course_id', 'course_id');
    }

    protected static function newFactory()
    {
        return \Modules\COD\Database\factories\SyllabusVersionFactory::new();
    }
}
