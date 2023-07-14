<?php

namespace Modules\Workload\Entities;

use App\Models\User;
use Modules\COD\Entities\SemesterUnit;
use Illuminate\Database\Eloquent\Model;
use Modules\COD\Entities\Unit;
use Modules\Registrar\Entities\Classes;
use Modules\Registrar\Entities\Department;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Registrar\Entities\StudentCourse;

class Workload extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function WorkloadsUnit(){
        return $this->belongsTo(Unit::class, 'unit_id', 'unit_id');
    }

    public function userAllocation(){

        return $this->belongsTo(User::class, 'user_id');
    }

    public function workloadUnit(){
        return $this->belongsTo(Unit::class, 'unit_id', 'unit_id');
    }

    public function workloadApproval(){
        return $this->hasOne(ApproveWorkload::class, 'workload_approval_id', 'workload_approval_id');
    }

    public function workloadDept(){

        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function processWorkload(){

        return $this->belongsTo(ApproveWorkload::class, 'id');
    }

    public function classWorkload(){
        return $this->belongsTo(Classes::class, 'class_code', 'name');
    }

    protected static function newFactory()
    {
        return \Modules\Workload\Database\factories\WorkloadFactory::new();
    }
}
