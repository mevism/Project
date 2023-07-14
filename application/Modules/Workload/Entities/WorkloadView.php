<?php

namespace Modules\Workload\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkloadView extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'workloadview';

    public function WorkloadApprovalView(){
        return $this->belongsTo(Workload::class, 'workload_id', 'workload_id');
    }

    public function WorkApprovalView(){
        return $this->hasOne(ApproveWorkload::class, 'workload_approval_id', 'workload_approval_id');
    }

    protected static function newFactory()
    {
        return \Modules\Workload\Database\factories\WorkloadViewFactory::new();
    }
}
