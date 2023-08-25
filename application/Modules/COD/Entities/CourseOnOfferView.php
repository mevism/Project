<?php

namespace Modules\COD\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Registrar\Entities\Courses;
use Modules\Registrar\Entities\Department;
use Modules\Registrar\Entities\School;

class CourseOnOfferView extends Model
{
    use HasFactory;

    protected $table = 'coursesonofferview';
    protected $fillable = [];

    public function OnofferCourse(){
        return $this->belongsTo(Courses::class, 'course_id', 'course_id');
    }

    protected static function newFactory()
    {
        return \Modules\COD\Database\factories\CourseOnOfferViewFactory::new();
    }
}
