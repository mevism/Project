<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SchoolDepartment extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function deptSchoolDepartment(){

        return $this->hasOne(Department::class, 'department_id', 'id');
    }

    public function schoolProcessed(){
        return $this->hasMany(School::class, 'id');
    }
    
    protected static function newFactory()
    {
        return \Modules\Registrar\Database\factories\SchoolDepartmentFactory::new();
    }
}
