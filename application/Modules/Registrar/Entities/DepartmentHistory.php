<?php

namespace Modules\Registrar\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DepartmentHistory extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function schoolsDeptHist(){

        return $this->belongsTo(School::class, 'school_id');
    }

    public function historydepartments(){

        return $this->hasMany(Department::class, 'department_id');
    }
    
    protected static function newFactory()
    {
        return \Modules\Registrar\Database\factories\DepartmentHistoryFactory::new();
    }
}
