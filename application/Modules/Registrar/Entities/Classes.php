<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\COD\Entities\Progression;
use Modules\Student\Entities\CourseTransfer;

class Classes extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [];

    protected $dates = ['deleted_at'];

    public function classCourse(){
        return $this->belongsTo(Courses::class, 'course_id');
    }

    public function progress(){
        return $this->hasOne(Progression::class, 'class_code');
    }

    public function transferClass(){
        return $this->hasMany(CourseTransfer::class, 'id');
    }

    protected static function newFactory()
    {
        return \Modules\Courses\Database\factories\ClassesFactory::new();
    }

}
