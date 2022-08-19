<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseRequirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'fee'
        
    //     'course_id`, `course_duration`,
    // `course_requirements`,
    // `subject1`,
    // `subject2`,
    // `subject3`,
    // `subject4`
    ];
    
    protected static function newFactory()
    {
        return \Modules\Registrar\Database\factories\CourseRequirementFactory::new();
    }
}
