<?php

namespace Modules\COD\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Modules\Lecturer\Entities\TeachingArea;
use Modules\Registrar\Entities\Department;
use Modules\Workload\Entities\Workload;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = ['unit_id','department_id', 'unit_code', 'unit_name', 'type', 'total_exam', 'total_cat', 'cat', 'assignment', 'practical'];

    public function DepartmentUnit(){
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    public function UnitsLectures(): HasManyThrough {
        return $this->hasManyThrough(User::class, TeachingArea::class, 'unit_code','user_id',  'unit_code', 'user_id', );
    }

    public function LoadedUnits(): HasManyThrough {
        return  $this->hasManyThrough(User::class, Workload::class, 'unit_id', 'user_id', 'unit_id', 'user_id');
    }

    protected static function newFactory()
    {
        return \Modules\COD\Database\factories\UnitFactory::new();
    }
}
