<?php

namespace Modules\Workload\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\COD\Entities\Unit;
use Modules\Registrar\Entities\Classes;
use Modules\Registrar\Entities\SchoolDepartment;

class WorkloadView extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'workloadsview';

    public function WorkloadApprovalView(){
        return $this->belongsTo(Workload::class, 'workload_id', 'workload_id');
    }

    public function classWorkloadView(){
        return $this->belongsTo(Classes::class, 'class_code', 'name');
    }

    public function workloadUnitView(){
        return $this->belongsTo(Unit::class, 'unit_code', 'unit_code');
    }

    public function WorkApprovalView(){
        return $this->hasOne(ApproveWorkload::class, 'workload_approval_id', 'workload_approval_id');
    }

    public function schoolDepartment(){
        return $this->belongsTo(SchoolDepartment::class, 'department_id', 'department_id');
    }

    protected static function newFactory()
    {
        return \Modules\Workload\Database\factories\WorkloadViewFactory::new();
    }
}
