<?php

namespace Modules\Workload\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\COD\Entities\SemesterUnit;

class Workload extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function allocatedUnit(){

        return $this->belongsTo(SemesterUnit::class, 'id', 'unit_id');
    }

    public function userAllocation(){

        return $this->belongsTo(User::class, 'user_id');
    }

    public function workloadUnit(){

        return $this->belongsTo(SemesterUnit::class, 'unit_id', 'id');
    }

    protected static function newFactory()
    {
        return \Modules\Workload\Database\factories\WorkloadFactory::new();
    }
}
