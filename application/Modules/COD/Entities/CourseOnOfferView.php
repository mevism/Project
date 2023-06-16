<?php

namespace Modules\COD\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Registrar\Entities\Department;
use Modules\Registrar\Entities\School;

class CourseOnOfferView extends Model
{
    use HasFactory;

    protected $table = 'COURESONOFFERVIEW';
    protected $fillable = [];

    public function OnofferDepartment(){
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }
    public function onOfferSchool(){
        return $this->belongsTo(School::class, 'school_id', 'school_id');
    }

    protected static function newFactory()
    {
        return \Modules\COD\Database\factories\CourseOnOfferViewFactory::new();
    }
}
