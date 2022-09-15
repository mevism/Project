<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Application\Entities\Application;
use Modules\COD\Entities\Nominalroll;

class StudentCourse extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function student(){

        return $this->belongsTo(Student::class);
    }

    protected static function newFactory()
    {
        return \Modules\Registrar\Database\factories\StudentCourseFactory::new();
    }
}
