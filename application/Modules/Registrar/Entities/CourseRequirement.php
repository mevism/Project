<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseRequirement extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'fee'
    ];

    protected $dates = ['deleted_at'];

    public function coursesReq(){
        return $this->belongsTo(Courses::class, 'course_id', 'course_id');
    }

    protected static function newFactory()
    {
        return \Modules\Registrar\Database\factories\CourseRequirementFactory::new();
    }
}
