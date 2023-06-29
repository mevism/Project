<?php

namespace Modules\COD\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Registrar\Entities\Department;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = ['unit_id', 'unit_code', 'unit_name', 'type', 'department_id', 'total_exam', 'total_cat', 'cat', 'assignment', 'practical'];

    public function DepartmentUnit(){
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    protected static function newFactory()
    {
        return \Modules\COD\Database\factories\UnitFactory::new();
    }
}
