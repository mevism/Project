<?php

namespace Modules\COD\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Registrar\Entities\Courses;

class CourseOptions extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function CourseOption(){
        return $this->belongsTo(Courses::class, 'course_id', 'course_id');
    }

    protected static function newFactory()
    {
        return \Modules\COD\Database\factories\CourseOptionsFactory::new();
    }
}
