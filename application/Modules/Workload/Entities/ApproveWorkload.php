<?php

namespace Modules\Workload\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApproveWorkload extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function approveWorkload(){

        return $this->belongsTo(Workload::class,   'id');
    }

    public function WorkloadsApproval(){
        return $this->hasMany(Workload::class, 'workload_approval_id', 'workload_approval_id');
    }
    protected static function newFactory()
    {
        return \Modules\Workload\Database\factories\ApproveWorkloadFactory::new();
    }
}
